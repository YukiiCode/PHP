<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;

class EmpleadosController extends Controller
{
    public function index(Request $request)
    {
        $empleados = Empleado::paginate(10);
        return view('ver_empleados', compact('empleados'));
    }

    public function edit($id)
    {
        $empleado = Empleado::findOrFail($id);
        return view('editar_empleado', compact('empleado'));
    }

    public function update(Request $request, $id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->update($request->all());
        return redirect()->route('ver-empleados')->with('success', 'Empleado actualizado correctamente');
    }

    public function destroy($id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->delete();
        return redirect()->route('ver-empleados')->with('success', 'Empleado eliminado correctamente');
    }
}