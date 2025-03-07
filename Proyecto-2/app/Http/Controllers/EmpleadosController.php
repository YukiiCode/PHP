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

    public function create()
    {
        return view('nuevo_empleado');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'dni' => 'required|string|unique:empleados,dni',
            'correo' => 'required|email|unique:empleados,correo',
            'telefono' => 'required|string|max:15',
            'direccion' => 'required|string|max:255',
            'tipo' => 'required|in:operario,administrador'
        ]);

        Empleado::create($validated);
        return redirect()->route('empleados.index')->with('success', 'Empleado creado correctamente');
    }

    public function edit($id)
    {
        $empleado = Empleado::findOrFail($id);
        return view('editar_empleado', compact('empleado'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'dni' => 'required|string',
            'correo' => 'required|email',
            'telefono' => 'required|string|max:15',
            'direccion' => 'required|string|max:255',
            'tipo' => 'required|in:operario,administrador'
        ]);

        Empleado::findOrFail($id)->update($validated);
        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado correctamente');
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