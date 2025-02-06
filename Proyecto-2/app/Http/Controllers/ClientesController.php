<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClientesController extends Controller
{

    public function index(Request $request)
    {
        $clientes = Cliente::paginate(10);
        return view('ver_clientes', compact('clientes'));
    }

    public function store(Request $request)
    {
        $cliente = new Cliente();
        $cliente->nombre = $request->nombre;
        $cliente->apellidos = $request->apellidos;
        $cliente->direccion = $request->direccion;
        $cliente->telefono = $request->telefono;
        $cliente->email = $request->email;
        $cliente->save();

        return redirect()->route('ver-clientes')->with('success', 'Cliente guardado correctamente');
    }

    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('editar_cliente', compact('cliente'));
    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->all());
        return redirect()->route('ver-clientes')->with('success', 'Cliente actualizado correctamente');
    }

    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();
        return redirect()->route('ver-clientes')->with('success', 'Cliente eliminado correctamente');
    }
}
