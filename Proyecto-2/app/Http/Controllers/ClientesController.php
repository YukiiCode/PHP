<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Models\Cuotas;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ClientesController extends Controller
{
    public function store(Request $request)
    {
        if (Auth::user()->empleado->tipo === 'operario') {
            abort(403, 'No tienes permisos para esta acci\u00f3n');
        }

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|unique:clientes,email'
        ]);

        Cliente::create($validated);

        return redirect()->route('ver-clientes')
            ->with('success', 'Cliente creado exitosamente');
    }

    public function destroy($id)
    {
        if (Auth::user()->empleado->tipo === 'operario') {
            abort(403, 'No tienes permisos para esta acci\u00f3n');
        }

        $cliente = Cliente::findOrFail($id);
        $cliente->cuotas()->delete();
        $cliente->tareas()->delete();
        $cliente->delete();

        return redirect()->route('ver-clientes')
            ->with('success', 'Cliente eliminado correctamente');
    }

    public function __construct()
    {
        $this->middleware('can:admin');
    }

    public function index()
    {
        if (!auth()->user() || !auth()->user()->empleado || auth()->user()->empleado->tipo !== 'administrativo') {
            return redirect()->route('home')->with('error', 'Acceso no autorizado');
        }
        $clientes = Cliente::with(['usuario', 'cuotas'])->paginate(7);
        return view('ver_clientes', compact('clientes'));
    }

    public function create()
    {
        return view('nuevo_cliente');
    }

    public function show($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('cliente', compact('cliente'));
    }

    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('editar_cliente', compact('cliente'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre' => 'required',
            'apellidos' => 'required|string|max:255',
            'direccion' => 'required',
            'telefono' => 'required|digits:9',
            'email' => 'required|email'
        ]);

        Cliente::findOrFail($id)->update($validated);
        return redirect()->route('ver-clientes')->with('success', 'Cliente actualizado');
    }
}
