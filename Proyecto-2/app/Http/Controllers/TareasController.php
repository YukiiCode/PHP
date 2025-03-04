<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Empleado;
use Illuminate\Http\Request;
use App\Models\Tarea;
use Illuminate\Support\Facades\Auth;

class TareasController extends Controller
{
    public function index()
    {
        if (!Auth::user()->can('admin')) {
            return redirect()->route('tareas.index')->with('error', 'No tienes permisos para acceder a esta sección');
        }

        $tareas = Tarea::with(['cliente', 'empleado'])->paginate(10);
        return view('ver_tareas', compact('tareas'));
    }

    public function edit($id)
    {
        if (!Auth::user()->can('admin')) {
            return redirect()->route('tareas.index')->with('error', 'No tienes permisos para editar tareas');
        }

        $tarea = Tarea::findOrFail($id);
        $clientes = Cliente::all();
        $empleados = Empleado::all();
        return view('editar_tarea', compact('tarea', 'clientes', 'empleados'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'empleado_id' => 'required|exists:empleados,id',
            'descripcion' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'estado' => 'required|in:pendiente,en_progreso,completada'
        ]);

        Tarea::create($validated);
        return redirect()->route('tareas.index')->with('success', 'Tarea guardada con éxito.');
    }

    public function update(Request $request, $id)
    {
        $tarea = Tarea::findOrFail($id);
        $tarea->update($request->all());
        return redirect()->route('tareas.index')->with('success', 'Tarea actualizada correctamente.');
    }

    public function borrarTarea($id)
    {
        $tarea = Tarea::find($id);
        $tarea->delete();
        return redirect()->route('tareas.index');
    }
}
