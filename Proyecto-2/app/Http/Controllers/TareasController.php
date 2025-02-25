<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Empleado;
use Illuminate\Http\Request;
use App\Models\Tarea;

class TareasController extends Controller
{
    public function index()
    {
        $tareas = Tarea::with(['cliente', 'empleado'])->paginate(7);
        return view('ver_tareas', compact('tareas'));
    }

    public function form()
    {
        $clientes = Cliente::all();
        $operarios = Empleado::where('tipo', 'operario')->get();
        return view('nueva_tarea', compact('clientes', 'operarios'));
    }

    public function edit($id)
    {
        $tarea = Tarea::with(['cliente', 'empleado'])->find($id);
        $operarios = Empleado::where('tipo', 'operario')->get();
        $clientes = Cliente::all();
        return view('editar_tarea', compact(['tarea', 'operarios', 'clientes']));
    }

    public function store(Request $request)
    {
        // Add validation rules
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'operario_id' => 'required|exists:empleados,id',
            'anotaciones' => 'nullable|string',
            'fecha_creacion' => 'nullable|date',
            'fecha_finalizacion' => 'nullable|date',
            'estado' => 'required|in:F,T,C,A,E',
            'fichero_resumen' => 'nullable|file|mimes:pdf,doc,docx',
            'fotos_trabajo.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

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
            $tarea->fecha_creacion =  date('d-m-y');
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

    public function actualizar(Request $request, $id)
    {
        $tarea = Tarea::findOrFail($id);

        // Validación
        $request->validate([
            'operario_id' => 'required|exists:operarios,id',
            'fecha_realizacion' => 'nullable|date',
            'cliente_id' => 'required|exists:clientes,id',
            'estado' => 'required|in:F,T,C,E',
            'anotaciones' => 'nullable|string',
            'fichero_resumen' => 'nullable|file|mimes:pdf',
            'fotos_trabajo' => 'nullable|array',
            'fotos_trabajo.*' => 'nullable|image',
        ]);

        // Actualizar campos
        $tarea->update([
            'operario_id' => $request->operario_id,
            'fecha_realizacion' => $request->fecha_realizacion,
            'cliente_id' => $request->cliente_id,
            'estado' => $request->estado,
            'anotaciones' => $request->anotaciones,
        ]);

        // Manejar archivos adjuntos
        if ($request->hasFile('fichero_resumen')) {
            $tarea->fichero_resumen = $request->file('fichero_resumen')->store('resumenes');
            $tarea->save();
        }

        if ($request->hasFile('fotos_trabajo')) {
            foreach ($request->file('fotos_trabajo') as $foto) {
                $ruta = $foto->store('fotos');
                $tarea->fotos()->create(['ruta' => $ruta]);
            }
        }

        return redirect()->route('listado-tareas')->with('success', 'Tarea actualizada correctamente.');
    }

    public function show($id)
    {
        $tarea = Tarea::find($id);
        return view('tarea', compact('tarea'));
    }

    public function borrarTarea($id)
    {
        $tarea = Tarea::find($id);
        $tarea->delete();
        return redirect()->route('ver-tareas');
    }

    public function indexClienteView()
    {
        $clientes = Cliente::all();
        $operarios = Empleado::where('tipo', 'operario')->get();
        return view('acceso_cliente', compact('clientes', 'operarios'));
    }
}
