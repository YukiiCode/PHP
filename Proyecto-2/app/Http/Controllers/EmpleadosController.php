<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadosController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin');
    }

    public function index()
    {
        $empleados = Empleado::paginate(10);
        return view('ver_empleados', compact('empleados'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required',
            'apellidos' => 'required',
            'email' => 'required|email',
            'telefono' => 'required|digits:9',
            'direccion' => 'required',
            'cargo_id' => 'required|exists:cargos,id'
        ]);

        Empleado::create($validated);
        return redirect()->route('empleados.index')->with('success', 'Empleado guardado correctamente');
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
            'email' => 'required|email',
            'telefono' => 'required|digits:9',
            'direccion' => 'required',
            'cargo_id' => 'required|exists:cargos,id'
        ]);

        Empleado::findOrFail($id)->update($validated);
        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado');
    }

    public function borrarEmpleado($id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->delete();
        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado');
    }

    public function destroy($id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->delete();
        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado correctamente');
    }
}