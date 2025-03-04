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
        $pdf = PDF::loadView('cuotas.invoice', compact('cuota'));
        return $pdf->download('factura-' . $cuota->id . '.pdf');
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
            $pdf = PDF::loadView('cuotas.invoice', compact('cuota'));
            $pdfContent = $pdf->output();
            
            Mail::send('emails', ['cuota' => $cuota], function ($message) use ($cuota, $pdfContent) {
                $message->to('fernandonieves180@gmail.com')
                    ->subject('Factura #' . $cuota->id)
                    ->attachData($pdfContent, 'factura-' . $cuota->id . '.pdf');
            });

            return redirect()->route('cuotas.index')
                ->with('success', 'Factura enviada por correo electrónico');
        } catch (\Exception $e) {
            return redirect()->route('cuotas.index')
                ->with('error', 'Error al enviar el correo electrónico');
        }
    }
}
