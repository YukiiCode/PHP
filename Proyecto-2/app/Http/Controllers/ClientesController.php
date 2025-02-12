<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Cuotas;
use Illuminate\Http\Request;

class ClientesController extends Controller
{
    // Método para mostrar la lista de clientes
    public function index(Request $request)
    {
        $clientes = Cliente::with('cuotas')->paginate(7);
        return view('ver_clientes', compact('clientes'));
    }

    // Método para mostrar detalles de un cliente específico
    public function show($id)
    {
        $cliente = Cliente::find($id);
        return view('cliente', compact('cliente'));
    }

    // Método para eliminar un cliente
    public function borrarCliente($id)
    {
        $cliente = Cliente::find($id);
        $cliente->delete();
        return redirect()->route('ver-clientes')->with('success', 'Cliente eliminado con éxito.');
    }
}
