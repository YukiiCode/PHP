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
            // Solo puede ver sus tareas
            $tareas = Tarea::where('operario_id', Auth::user()->empleado->id)->paginate(10);
        } else
            $tareas = Tarea::with(['cliente', 'empleado'])->paginate(10);
        return view('ver_tareas', compact('tareas'));
    }

    public function edit(\App\Models\Tarea $tarea)
    {
        $clientes = Cliente::all();
        $operarios = Empleado::where('tipo', 'operario')->get();
        return view('editar_tarea', compact('tarea', 'clientes', 'operarios'));
    }

    public function destroy($id)
    {
        $tarea = Tarea::findOrFail($id);
        $tarea->delete();

        return redirect()->route('tareas.index')
            ->with('success', 'Tarea eliminada correctamente');
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'operario_id' => 'required|exists:empleados,id',
            'estado' => 'required|in:F,T,C,A,E',
            'anotaciones' => 'required',
            'fecha_realizacion' => 'required|date'
        ]);

        // Set creation date
        $validated['fecha_creacion'] = now();

        $validated['fecha_finalizacion'] = \Carbon\Carbon::parse($validated['fecha_realizacion'])->format('Y-m-d');

        // Handle file uploads if present
        if ($request->hasFile('fichero_resumen')) {
            $path = $request->file('fichero_resumen')->store('uploads/resumenes');
            $validated['fichero_resumen'] = $path;
        }

        if ($request->hasFile('fotos_trabajo')) {
            $fotos = [];
            foreach ($request->file('fotos_trabajo') as $foto) {
                $path = $foto->store('uploads/fotos');
                $fotos[] = $path;
            }
            $validated['fotos_trabajo'] = json_encode($fotos);
        }

        // Set creation date
        $validated['fecha_creacion'] = now();

        Tarea::create($validated);
        return redirect()->route('tareas.index')->with('success', 'Tarea guardada con éxito.');
    }

    public function update(Request $request, Tarea $tarea)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'operario_id' => 'required|exists:empleados,id',
            'fecha_realizacion' => 'required|date',
            'estado' => 'required|in:F,T,C,E,A',
            'anotaciones' => 'required',
            'fichero_resumen' => 'nullable|file',
            'fotos_trabajo' => 'nullable|array'
        ]);

        $tareaData = $request->all();
        $tareaData['fecha_finalizacion'] = \Carbon\Carbon::parse($request->fecha_realizacion)->format('Y-m-d H:i:s');
        // Map fecha_realizacion to fecha_finalizacion
        $validated['fecha_finalizacion'] = $validated['fecha_realizacion'];
        unset($validated['fecha_realizacion']);

        // Handle file uploads if present
        // Handle file updates without losing existing files
        $validated['fichero_resumen'] = $request->hasFile('fichero_resumen')
            ? $request->file('fichero_resumen')->store('resumenes')
            : $tarea->fichero_resumen;

        $validated['fotos_trabajo'] = $tarea->fotos_trabajo;
        if ($request->hasFile('fotos_trabajo')) {
            $fotos = [];
            foreach ($request->file('fotos_trabajo') as $foto) {
                $path = $foto->store('fotos_trabajo');
                $fotos[] = $path;
            }
            $validated['fotos_trabajo'] = json_encode($fotos);
        }

        $tarea->update($validated);
        return redirect()->route('tareas.index')->with('success', 'Tarea actualizada correctamente.');
    }

    public function borrarTarea($id)
    {
        $tarea = Tarea::find($id);
        $tarea->delete();
        return redirect()->route('tareas.index');
    }

    public function create()
    {
        if (!Auth::user()->can('admin')) {
            return redirect()->route('tareas.index')->with('error', 'No tienes permisos para crear tareas');
        }

        $clientes = Cliente::all();
        $operarios = Empleado::where('tipo', 'operario')->get();
        return view('nueva_tarea', compact('clientes', 'operarios'));
    }

    public function form()
    {
        if (!Auth::user()->can('admin')) {
            return redirect()->route('tareas.index')->with('error', 'No tienes permisos para crear tareas');
        }

        $clientes = Cliente::all();
        $operarios = Empleado::all();
        return view('nueva_tarea', compact('clientes', 'operarios'));
    }

    public function indexClienteView()
    {
        return view('acceso_cliente');
    }

    public function storeClienteTask(Request $request)
    {
        $validated = $request->validate([
            'cif' => 'required',
            'telefono' => 'required|digits:9',
            'titulo' => 'required',
            'descripcion' => 'required'
        ]);

        // Verify client credentials
        $cliente = Cliente::where('cif', $validated['cif'])
            ->where('telefono', $validated['telefono'])
            ->first();

        if (!$cliente) {
            return redirect()->back()
                ->withErrors(['credentials' => 'CIF o teléfono no válidos'])
                ->withInput();
        }

        // Create task with pending approval status
        Tarea::create([
            'cliente_id' => $cliente->id,
            'estado' => 'A',
            'fecha_creacion' => now(),
            'anotaciones' => $validated['descripcion']
        ]);

        return redirect()->route('tareas.cliente-access')
            ->with('success', 'Incidencia registrada correctamente. Pendiente de aprobación.');
    }
}
