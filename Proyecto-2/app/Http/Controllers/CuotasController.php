<?php

namespace App\Http\Controllers;

use App\Models\Cuotas;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use PayPalCheckoutSdk\Core\PayPalEnvironment;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;

class CuotasController extends Controller
{
    private $paypalClient;

    public function __construct()
    {
        if (env('PAYPAL_MODE') === 'sandbox') {
            $environment = new SandboxEnvironment(
                env('PAYPAL_CLIENT_ID'),
                env('PAYPAL_CLIENT_SECRET')
            );
        } else {
            $environment = new ProductionEnvironment(
                env('PAYPAL_CLIENT_ID'),
                env('PAYPAL_CLIENT_SECRET')
            );
        }

        $this->paypalClient = new PayPalHttpClient($environment);
        \Log::info('PayPal Client initialized in ' . env('PAYPAL_MODE') . ' mode');
    }

    public function handlePayPalPayment(Cuotas $cuota)
    {
        try {
            \Log::debug('Iniciando pago PayPal', ['cuota_id' => $cuota->id, 'cliente' => $cuota->cliente_id]);

            if (!$cuota->cliente->moneda) {
                throw new \Exception('El cliente no tiene moneda configurada');
            }

            $request = new OrdersCreateRequest();
            $request->body = [
                'intent' => 'CAPTURE',
                'purchase_units' => [[
                    'reference_id' => $cuota->id,
                    'amount' => [
                        'currency_code' => strtoupper($cuota->cliente->moneda),
                        'value' => number_format($cuota->importe, 2, '.', '')
                    ],
                    'description' => $cuota->concepto
                ]],
                'application_context' => [
                    'return_url' => route('paypal.success'),
                    'cancel_url' => route('paypal.cancel'),
                    'brand_name' => 'Gestión de Tareas',
                    'locale' => 'es-ES',
                    'landing_page' => 'BILLING',
                    'user_action' => 'PAY_NOW',
                ]
            ];

            \Log::debug('Solicitud PayPal creada', ['body' => $request->body]);
            \Log::info('Credenciales PayPal usadas:', [
                'client_id' => env('PAYPAL_CLIENT_ID'),
                'mode' => env('PAYPAL_MODE')
            ]);
            \Log::debug('Moneda y monto enviados:', [
                'currency' => strtoupper($cuota->cliente->moneda),
                'amount' => number_format($cuota->importe, 2, '.', '')
            ]);

            $response = $this->paypalClient->execute($request);
            \Log::debug('Respuesta PayPal recibida', ['response' => (array)$response]);

            if (!isset($response->result->links)) {
                throw new \Exception('Estructura de respuesta inválida de PayPal');
            }

            $approvalUrl = collect($response->result->links)
                ->where('rel', 'approve')
                ->first()->href;

            // Check if this is an AJAX request
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['redirect_url' => $approvalUrl]);
            }
            
            return redirect()->away($approvalUrl);
        } catch (\PayPalHttp\HttpException $pe) {
            \Log::error('Error HTTP PayPal: ' . $pe->getMessage(), [
                'statusCode' => $pe->statusCode,
                'headers' => $pe->headers,
                'details' => $pe->getMessage()
            ]);
            return redirect()->back()->with('error', 'Error de comunicación con PayPal');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al procesar el pago: ' . $e->getMessage());
        }
    }



    public function paypalSuccess(Request $request)
    {
        $orderId = $request->input('token');
        try {
            $cuotaId = $this->capturePayment($orderId);
            $cuota = Cuotas::findOrFail($cuotaId);
            $cuota->update(['pagado' => true, 'fecha_pago' => now()]);

            return redirect()->route('cuotas.index')
                ->with('success', 'Pago realizado exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('cuotas.index')
                ->with('error', 'Error al confirmar el pago: ' . $e->getMessage());
        }
    }

    private function capturePayment($orderId)
    {
        try {
            \Log::debug('Capturando pago PayPal', ['order_id' => $orderId]);
            $request = new OrdersCaptureRequest($orderId);
            $response = $this->paypalClient->execute($request);
            \Log::debug('Respuesta captura PayPal', ['response' => $response]);

            if ($response->statusCode !== 201 || !isset($response->result->purchase_units[0]->reference_id)) {
                \Log::error('Respuesta inválida de PayPal', ['response' => (array)$response]);
                throw new \Exception('Error en la estructura de la respuesta de PayPal');
            }

            return $response->result->purchase_units[0]->reference_id;
        } catch (\Exception $e) {
            \Log::error('Error capturando pago: ' . $e->getMessage());
            throw $e;
        }
    }

    public function paypalCancel()
    {
        return redirect()->route('cuotas.index')
            ->with('warning', 'Pago cancelado por el usuario');
    }

    public function index(Request $request)
    {
        $query = Cuotas::with(['cliente', 'empleado']);

        if ($request->filled('search')) {
            $query->whereHas('cliente', function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('estado')) {
            $query->where('pagado', $request->estado === 'pagado' ? 1 : 0);
        }

        if ($request->filled('mes')) {
            $query->whereMonth('fecha_emision', '=', date('m', strtotime($request->mes)))
                ->whereYear('fecha_emision', '=', date('Y', strtotime($request->mes)));
        }

        $cuotas = $query->paginate(10);

        return view('cuotas.index', compact('cuotas'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        return view('cuotas.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'concepto' => 'required|string',
            'importe' => 'required|numeric',
            'tipo' => 'required|in:mensual,extraordinaria',
            'fecha_emision' => 'required|date',
            'estado' => 'required|in:pendiente,pagada'
        ]);

        $data = $validated;
        $data['pagado'] = ($validated['estado'] === 'pagada') ? 1 : 0;
        $data['importe'] = $validated['importe'];
        unset($data['estado']);

        Cuotas::create($data);
        return redirect()->route('cuotas.index')->with('success', 'Cuota creada');
    }

    public function batchCreate()
    {
        $clientes = Cliente::all();
        return view('cuotas.batch', compact('clientes'));
    }

    public function batchStore(Request $request)
    {
        $clientes = Cliente::all();
        $fecha = now()->format('Y-m-d');

        foreach ($clientes as $cliente) {
            Cuotas::create([
                'cliente_id' => $cliente->id,
                'concepto' => $request->concepto,
                'importe' => $request->importe,
                'tipo' => $request->tipo,
                'fecha_emision' => $fecha,
                'pagado' => $request->pagado
            ]);
        }

        return redirect()->route('cuotas.index')->with('success', 'Remesa mensual generada');
    }

    public function download(Cuotas $cuota)
    {
        try {
            $pdf = PDF::loadView('cuotas.invoice', compact('cuota'));
            return $pdf->download('factura-' . $cuota->id . '.pdf', [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="factura-' . $cuota->id . '.pdf"'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('cuotas.index')
                ->with('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
    }

    public function edit(Cuotas $cuota)
    {
        return view('cuotas.edit', compact('cuota'));
    }

    public function update(Request $request, Cuotas $cuota)
    {
        $validated = $request->validate([
            'concepto' => 'required|string',
            'tipo' => 'required|in:individual,mensual',
            'importe' => 'required|numeric',
            'fecha_emision' => 'required|date',
            'fecha_pago' => 'nullable|date',
            'pagado' => 'required|boolean'
        ]);

        $data = [
            'concepto' => $validated['concepto'],
            'tipo' => $validated['tipo'],
            'importe' => $validated['importe'],
            'fecha_emision' => $validated['fecha_emision'],
            'fecha_pago' => $validated['fecha_pago'],
            'pagado' => ($validated['pagado'])
        ];

        $cuota->update($data);
        return redirect()->route('cuotas.index')->with('success', 'Cuota actualizada');
    }

    public function destroy(Cuotas $cuota)
    {
        $cuota->delete();
        return redirect()->route('cuotas.index')->with('success', 'Cuota eliminada');
    }

    public function email(Cuotas $cuota)
    {
        try {
            // Generate PDF
            $pdf = PDF::loadView('cuotas.invoice', compact('cuota'));
            if (!$pdf) {
                throw new \Exception('Error generating PDF');
            }
            $pdfContent = $pdf->output();

            // Create email content
            $emailContent = "Factura #{$cuota->id}\n\n";
            $emailContent .= "Cliente: {$cuota->cliente->nombre}\n";
            $emailContent .= "Fecha de Emisión: {$cuota->fecha_emision->format('d/m/Y')}\n";
            $emailContent .= "Tipo: {$cuota->tipo}\n";
            $moneda = $cuota->cliente->moneda ?? 'EUR';
            $emailContent .= "Monto: " . number_format($cuota->importe, 2) . " {$moneda}\n";

            // Add euro conversion if needed
            if ($cuota->cliente && $cuota->cliente->moneda && $cuota->cliente->moneda !== 'EUR') {
                $emailContent .= "Monto en Euros: " . number_format($cuota->getImporteEnEuros(), 2) . "€\n";
            }

            $emailContent .= "Estado: " . ($cuota->pagado ? 'Pagada' : 'Pendiente') . "\n"; // Convert pagado to estado text

            // Send email
            Mail::raw($emailContent, function ($message) use ($cuota, $pdfContent) {
                $message->to('fernandonieves180@gmail.com')
                    ->subject('Factura #' . $cuota->id)
                    ->attachData($pdfContent, 'factura-' . $cuota->id . '.pdf');
            });

            return redirect()->route('cuotas.index')
                ->with('success', 'Factura enviada por correo electrónico');
        } catch (\Exception $e) {
            \Log::error('Error sending invoice email: ' . $e->getMessage());
            return redirect()->route('cuotas.index')
                ->with('error', 'Error al enviar el correo electrónico: ' . $e->getMessage());
        }
    }
}
