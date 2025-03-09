<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Models\Cuotas;

class ClientesController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin');
    }

    // Método para mostrar la lista de clientes
    public function index()
    {
        $clientes = Cliente::with('cuotas')->paginate(7);
        return view('ver_clientes', compact('clientes'));
    }

    // Método para mostrar el formulario de creación
    public function create()
    {
        return view('nuevo-cliente');
    }

    // Método para guardar un nuevo cliente
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required',
            'telefono' => 'required|digits:9',
            'correo' => 'required|email',
            'cif' => 'required',
            'cuenta_corriente' => 'required',
            'pais' => 'required',
            'moneda' => 'required',
            'importe_mensual' => 'required|numeric'
        ]);

        Cliente::create($validated);
        return redirect()->route('clientes.index')->with('success', 'Cliente creado con éxito.');
    }

    // Método para mostrar detalles de un cliente específico
    public function show($id)
    {
        $cliente = Cliente::find($id);
        return view('cliente', compact('cliente'));
    }

    // Método para mostrar el formulario de edición
    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('editar_cliente', compact('cliente'));
    }

    // Método para actualizar un cliente
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre' => 'required',
            'telefono' => 'required|digits:9',
            'cif' => 'required',
            'correo' => 'required|email',
            'cuenta_corriente' => 'required',
            'pais' => 'required',
            'moneda' => 'required',
            'importe_mensual' => 'required',

        ]);

        Cliente::findOrFail($id)->update($validated);
        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado con éxito');
    }

    // Método para eliminar un cliente
    public function destroy($id)
    {
        Cliente::findOrFail($id)->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado con éxito');
    }

    // Método alternativo para eliminar un cliente (usado en la ruta borrar-cliente)
    public function borrarCliente($id)
    {
        $cliente = Cliente::find($id);
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado con éxito.');
    }
}
