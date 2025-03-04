<?php

namespace App\Http\Controllers;

use App\Models\Cuotas;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class CuotasController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin');
    }

    public function index()
    {
        $cuotas = Cuotas::with(['cliente', 'empleado'])->paginate(10);
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
            'monto' => 'required|numeric',
            'tipo' => 'required|in:mensual,extraordinaria',
            'fecha_emision' => 'required|date',
            'estado' => 'required|in:pendiente,pagada'
        ]);

        // Convert estado to pagado boolean value
        $data = $validated;
        $data['pagado'] = ($validated['estado'] === 'pagada') ? 1 : 0;
        $data['importe'] = $validated['monto']; // Map monto to importe
        unset($data['estado']);
        unset($data['monto']);

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
                'importe' => $request->importe,
                'tipo' => 'mensual',
                'fecha_emision' => $fecha,
                'pagado' => 0
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
            \Log::error('Error generating PDF: ' . $e->getMessage());
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
            'concepto' => 'nullable|string',
            'tipo' => 'required|in:individual,mensual',
            'importe' => 'required|numeric',
            'fecha_emision' => 'required|date',
            'fecha_pago' => 'nullable|date',
            'estado' => 'required|in:pendiente,pagada'
        ]);

        $data = [
            'concepto' => $validated['concepto'],
            'tipo' => $validated['tipo'],
            'importe' => $validated['importe'],
            'fecha_emision' => $validated['fecha_emision'],
            'fecha_pago' => $validated['fecha_pago'],
            'pagado' => ($validated['estado'] === 'pagada') ? 1 : 0
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
            $emailContent .= "Monto: €" . number_format($cuota->importe, 2) . "\n"; // Use importe instead of monto
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
