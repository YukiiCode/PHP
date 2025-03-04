<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadosController extends Controller
{
    public function index()
    {
        $empleados = Empleado::paginate(10);
        return view('ver_empleados', compact('empleados'));
    }

    public function create()
    {
        return view('nuevo_empleado');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required',
            'tipo' => 'required',
            'fecha_alta' => 'required|date'
        ]);

        $empleado = new Empleado();
        $empleado->nombre = $validated['nombre'];
        $empleado->tipo = $validated['tipo'];
        $empleado->fecha_alta = $validated['fecha_alta'];
        $empleado->save();

        return redirect()->route('ver-empleados')->with('success', 'Empleado guardado correctamente');
    }

    public function edit($id)
    {
        $empleado = Empleado::findOrFail($id);
        return view('editar_empleado', compact('empleado'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre' => 'required',
            'apellidos' => 'required',
            // ... other validation rules ...
        ]);

        $empleado = Empleado::findOrFail($id);
        $empleado->update($validated);

        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado');
    }

    public function destroy($id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->delete();

        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado');
    }
}