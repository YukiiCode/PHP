<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            'correo' => 'required|email|unique:empleados,correo|unique:users,email',
            'telefono' => 'required|string|max:15',
            'direccion' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'tipo' => 'required|in:operario,administrativo'
        ]);
        
        // Crear el usuario correspondiente primero
        $user = User::create([
            'name' => $validated['nombre'],
            'email' => $validated['correo'],
            'password' => Hash::make($validated['password'])
        ]);
        
        // Crear el empleado y asociarlo con el usuario
        // Excluir el campo password ya que no existe en la tabla empleados
        $empleadoData = collect($validated)->except(['password'])->toArray();
        $empleado = new Empleado($empleadoData);
        $empleado->user_id = $user->id;
        $empleado->fecha_alta = now(); // Establecer la fecha de alta
        $empleado->save();
        
        return redirect()->route('empleados.index')->with('success', 'Empleado creado correctamente. El usuario puede iniciar sesión con su correo y la contraseña proporcionada.');
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

    public function destroy($id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->delete();
        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado correctamente');
    }

    
}