<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::paginate(10);
        return view('ver_clientes', compact('clientes'));
    }

    public function create()
    {
        return view('nuevo-cliente');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cif' => 'required|string|max:10|unique:clientes',
            'nombre' => 'required|string|max:100',
            'telefono' => 'required|string|max:15|regex:/^[+]?[0-9]+$/',
            'correo' => 'nullable|email:rfc,dns|max:100',
            'cuenta_corriente' => 'string|max:24',
            'pais' => 'string|max:100',
            'moneda' => 'string',
            'importe_mensual' => 'required|numeric|between:0,9999999.99',
        ]);

        Cliente::create($validated);
        return redirect()->route('clientes.index')->with('success', 'Cliente creado correctamente');
    }

    public function edit(Cliente $cliente)
    {
        return view('editar-cliente', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'cif' => ['required', 'string', 'max:10', Rule::unique('clientes')->ignore($cliente->id)],
            'nombre' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:15|regex:/^[+]?[0-9]+$/',
            'correo' => 'nullable|email:rfc,dns|max:100',
            'cuenta_corriente' => 'nullable|string|max:24',
            'pais' => 'required|nullable|string|max:100',
            'moneda' => 'required|nullable|in:EUR,USD,GBP',
            'importe_mensual' => 'required|nullable|numeric|between:0,9999999.99'
        ], [
            'cif.unique' => 'El CIF ya existe en nuestro sistema',
            'telefono.regex' => 'Formato de teléfono inválido',
            'cuenta_corriente.iban' => 'La cuenta corriente debe ser un IBAN válido',
            'moneda.in' => 'Seleccione una moneda válida (EUR, USD, GBP)'
        ]);

        $cliente->update($validated);
        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado correctamente');
    }
}
