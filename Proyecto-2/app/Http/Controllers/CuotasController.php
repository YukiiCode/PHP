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
        $this->middleware('auth');
      
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
            'concepto' => 'required|string|max:100',
            'importe' => 'required|numeric|min:0',
            'fecha_emision' => 'required|date'
        ]);

        Cuotas::create([
            'cliente_id' => $validated['cliente_id'],
            'empleado_id' => auth()->id(),
            'concepto' => $validated['concepto'],
            'importe' => $validated['importe'],
            'tipo' => 'individual',
            'fecha_emision' => $validated['fecha_emision'],
            'pagado' => false,
            'estado' => 'pendiente'
        ]);
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

        $validated = $request->validate([
            'importe' => 'required|numeric|min:0',
            'mes' => 'required|date_format:Y-m',
            'clientes' => 'required|array|min:1',
            'clientes.*' => 'exists:clientes,id'
        ]);

        $fechaEmision = \Carbon\Carbon::createFromFormat('Y-m', $validated['mes'])->startOfMonth();

        foreach ($validated['clientes'] as $clienteId) {
            Cuotas::create([
                'cliente_id' => $clienteId,
                'empleado_id' => auth()->id(),
                'concepto' => 'Cuota mensual',
                'importe' => $validated['importe'],
                'tipo' => 'mensual',
                'fecha_emision' => $fechaEmision,
                'fecha_pago' => null,
                'estado' => 'pendiente'
            ]);
        }

        return redirect()->route('cuotas.index')->with('success', 'Remesa mensual generada');
    }

    public function generatePdf(Cuotas $cuota)
    {
        $pdf = app('dompdf.wrapper')->loadView('cuotas.invoice', compact('cuota'));
        return $pdf->download('factura-'.$cuota->id.'.pdf');
    }

    public function sendEmail(Cuotas $cuota)
    {
        $pdf = app('dompdf.wrapper')->loadView('cuotas.invoice', compact('cuota'));
        
        Mail::send('emails.invoice', ['cuota' => $cuota], function($message) use ($cuota, $pdf) {
            $message->to($cuota->cliente->email)
                    ->subject('Factura #'.$cuota->id)
                    ->attachData($pdf->output(), 'factura.pdf');
        });

        return redirect()->back()->with('success', 'Factura enviada');
    }

    public function edit(Cuotas $cuota)
    {
        $this->authorize('update', $cuota);
        return view('cuotas.edit', compact('cuota'));
    }

    public function update(Request $request, Cuotas $cuota)
    {
        $this->authorize('update', $cuota);
        $validated = $request->validate([
            'importe' => 'required|numeric|min:0',
            'estado' => 'required|in:pendiente,pagado',
            'tipo' => 'required|in:individual,mensual'
        ]);

        $cuota->update([
            'importe' => $validated['importe'],
            'estado' => $validated['estado'],
            'tipo' => $validated['tipo']
        ]);

        return redirect()->route('cuotas.index')->with('success', 'Cuota actualizada');
    }

    public function destroy(Cuotas $cuota)
    {
        $cuota->delete();
        return redirect()->route('cuotas.index')->with('success', 'Cuota eliminada');
    }
}