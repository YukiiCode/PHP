<?php

namespace App\Http\Controllers\Api;

use App\Models\Tarea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class TareaController extends Controller
{
    public function __construct()
    {
        // Skip authentication middleware for API endpoints
    }

    public function index()
    {
        try {
            $tareas = Tarea::all();
            return response()->json(['success' => true, 'data' => $tareas]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error retrieving tasks'], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'estado' => 'required|in:F,T,C,A,E',
            'operario_id' => 'required|exists:empleados,id',
            'cliente_id' => 'required|exists:clientes,id',
            'fecha_creacion' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $tarea = Tarea::create($request->all());
            return response()->json(['success' => true, 'data' => $tarea], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error creating task'], 500);
        }
    }

    public function show($id)
    {
        try {
            $tarea = Tarea::findOrFail($id);
            return response()->json(['success' => true, 'data' => $tarea]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Task not found'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'estado' => 'sometimes|in:F,T,C,A,E',
            'operario_id' => 'sometimes|exists:empleados,id',
            'cliente_id' => 'sometimes|exists:clientes,id',
            'fecha_finalizacion' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $tarea = Tarea::findOrFail($id);
            $tarea->update($request->all());
            return response()->json(['success' => true, 'data' => $tarea]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Task not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error updating task: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $tarea = Tarea::findOrFail($id);
            $tarea->delete();
            return response()->json(['success' => true, 'message' => 'Task deleted']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Task not found'], 404);
        }
    }
}