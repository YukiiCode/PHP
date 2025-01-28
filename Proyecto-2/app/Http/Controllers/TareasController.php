<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Empleado;
use Illuminate\Http\Request;
use App\Models\Tarea;
use  Illuminate\Database\Eloquent\Collection;

class TareasController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();
        $operarios = Empleado::all()->filter(function ($empleado) {
            return $empleado->tipo === 'operario';
        });

        return view('nueva-tarea', compact('clientes', 'operarios'));
    }

    public function store(Request $request)
    {
        $tarea = new Tarea();
        $tarea->cliente_id = $request->cliente_id;
        $tarea->operario_id = $request->operario_id;
        $tarea->anotaciones = $request->anotaciones;
        $tarea->fecha_creacion = $request->fecha_creacion;
        $tarea->fecha_finalizacion = $request->fecha_finalizacion;
        if ($request->estado == null) {
            $tarea->estado = 'E';
        } else {
            $tarea->estado = 'finalizada';
        }
        $tarea->estado = $request->estado;
        $tarea->save();

        return redirect()->route('ver-tareas');
    }

    public function show($id)
    {
        $tarea = Tarea::find($id);
        return view('tarea', compact('tarea'));
    }

    public function verTareas()
    {
        $tareas = Tarea::paginate(10);
        $clientes = Cliente::all();
        $empleados = Empleado::all();
        return view('ver_tareas', compact('tareas', 'clientes', 'empleados'));
    }

    public function borrarTarea($id)
    {
        $tarea = Tarea::find($id);
        $tarea->delete();
        return redirect()->route('ver-tareas');
    }
}
