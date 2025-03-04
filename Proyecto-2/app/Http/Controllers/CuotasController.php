<?php

namespace App\Http\Controllers;

use App\Models\Cuotas;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

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

        Cuotas::create($validated);
        return redirect()->route('cuotas.index')->with('success', 'Cuota creada');
    }

    public function batchCreate()
    {
        return view('cuotas.batch');
    }

    public function batchStore(Request $request)
    {
        $clientes = Cliente::all();
        $fecha = now()->format('Y-m-d');

        foreach ($clientes as $cliente) {
            Cuotas::create([
                'cliente_id' => $cliente->id,
                'monto' => $request->monto,
                'tipo' => 'mensual',
                'fecha_emision' => $fecha,
                'estado' => 'pendiente'
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

    public function update(Request $request, Cuotas $cuota)
    {
        $validated = $request->validate([
            'monto' => 'required|numeric',
            'estado' => 'required|in:pendiente,pagada'
        ]);

        $cuota->update($validated);
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
            $emailContent .= "Monto: €" . number_format($cuota->monto, 2) . "\n";
            $emailContent .= "Estado: {$cuota->estado}\n";

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
