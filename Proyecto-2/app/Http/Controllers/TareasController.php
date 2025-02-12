<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Empleado;
use Illuminate\Http\Request;
use App\Models\Tarea;
use Illuminate\Support\Facades\Validator;

class TareasController extends Controller
{
    
    public function index()
    {
        $clientes = Cliente::all();
        $operarios = Empleado::all()->filter(function ($empleado) {
            return $empleado->tipo === 'operario';
        });

        return view('nueva_tarea', compact('clientes', 'operarios'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cliente_id' => 'required',
            'operario_id' => 'required',
            'anotaciones' => 'required',
            'fichero_resumen' => 'required|file|mimes:pdf',
            'fotos_trabajo.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // No validation code here

        try {
            // Guardar el fichero resumen
            if ($request->hasFile('fichero_resumen')) {
                $ficheroResumenPath = $request->file('fichero_resumen')->store('resumenes', 'public');
            }

            // Guardar las fotos del trabajo
            $fotosTrabajoPaths = [];
            if ($request->hasFile('fotos_trabajo')) {
                foreach ($request->file('fotos_trabajo') as $foto) {
                    $fotosTrabajoPaths[] = $foto->store('fotos_trabajo', 'public');
                }
            }

            // Crear y guardar la tarea
            $tarea = new Tarea();
            $tarea->cliente_id = $request->cliente_id;
            $tarea->operario_id = $request->operario_id;
            $tarea->anotaciones = $request->anotaciones;
            $tarea->fecha_creacion = $request->fecha_creacion ?? date('Y-m-d');
            $tarea->fecha_finalizacion = $request->fecha_finalizacion;
            $tarea->estado = $request->estado ?? 'E';
            $tarea->fichero_resumen = $ficheroResumenPath ?? null;
            $tarea->fotos_trabajo = json_encode($fotosTrabajoPaths);
            $tarea->save();

            return redirect()->route('ver-tareas')->with('success', 'Tarea guardada con éxito.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Hubo un problema al guardar la tarea: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $tarea = Tarea::find($id);
        return view('tarea', compact('tarea'));
    }

    public function verTareas()
    {
        $tareas = Tarea::paginate(7);
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
