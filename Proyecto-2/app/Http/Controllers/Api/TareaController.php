<?php

namespace App\Http\Controllers\Api;

use App\Models\Tarea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="Task Management API",
 *         description="API for managing tasks"
 *     ),
 *     @OA\Components(
 *         @OA\Schema(
 *             schema="TareaStoreRequest",
 *             type="object",
 *             required={"estado","operario_id","cliente_id","fecha_creacion"},
 *             @OA\Property(property="estado", type="string", enum={"F","T","C","A","E"}),
 *             @OA\Property(property="operario_id", type="integer"),
 *             @OA\Property(property="cliente_id", type="integer"),
 *             @OA\Property(property="fecha_creacion", type="string", format="date-time")
 *         ),
 *         @OA\Schema(
 *             schema="TareaUpdateRequest",
 *             type="object",
 *             @OA\Property(property="estado", type="string", enum={"F","T","C","A","E"}),
 *             @OA\Property(property="operario_id", type="integer"),
 *             @OA\Property(property="cliente_id", type="integer"),
 *             @OA\Property(property="fecha_finalizacion", type="string", format="date-time", nullable=true)
 *         ),
 *         @OA\Schema(
 *             schema="TareaResource",
 *             allOf={
 *                 @OA\Schema(ref="#/components/schemas/Tarea"),
 *                 @OA\Schema(
 *                     type="object",
 *                     @OA\Property(property="success", type="boolean")
 *                 )
 *             }
 *         )
 *     )
 * )
 */

class TareaController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/tareas",
     *     summary="List all tasks",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Tarea"))
     *         )
     *     )
     * )
     */
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

        /**
     * @OA\Post(
     *     path="/api/tareas",
     *     summary="Create new task",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TareaStoreRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Task created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/TareaResource")
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
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

        /**
     * @OA\Get(
     *     path="/api/tareas/{id}",
     *     summary="Get specific task",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Task ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/TareaResource")
     *     ),
     *     @OA\Response(response=404, description="Task not found")
     * )
     */
    public function show($id)
    {
        try {
            $tarea = Tarea::findOrFail($id);
            return response()->json(['success' => true, 'data' => $tarea]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Task not found'], 404);
        }
    }

        /**
     * @OA\Put(
     *     path="/api/tareas/{id}",
     *     summary="Update existing task",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Task ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TareaUpdateRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/TareaResource")
     *     ),
     *     @OA\Response(response=404, description="Task not found"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
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

        /**
     * @OA\Delete(
     *     path="/api/tareas/{id}",
     *     summary="Delete a task",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Task ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Task not found")
     * )
     */
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


