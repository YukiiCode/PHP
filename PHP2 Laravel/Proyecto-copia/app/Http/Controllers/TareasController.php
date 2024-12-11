<?php

namespace App\Http\Controllers;

use App\Models\Utiles;
use App\Models\bbdd;

class TareasController extends BaseController
{
    // Clase usada para mostrar, editar, eliminar tareas y paginación

    // Método para mostrar las tareas con paginación
    public function mostrarTareas()
    {
        $bbdd = BBDD::getInstance();
        $tareas = [];

        // Parámetros de ordenación
        $ordenarPor = isset($_GET['ordenar_por']) ? $_GET['ordenar_por'] : 'fecha_realizacion';
        $orden = isset($_GET['orden']) && strtolower($_GET['orden']) === 'asc' ? 'ASC' : 'DESC';

        // Obtener tareas ordenadas
        $tareas = $bbdd->getTareas($ordenarPor, $orden);

        // Paginación
        $totalTareas = count($tareas);
        $tareasPorPagina = 10;
        $paginaActual = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $inicio = ($paginaActual - 1) * $tareasPorPagina;
        $tareasPaginadas = array_slice($tareas, $inicio, $tareasPorPagina);

        return view('ver_tareas', [
            'tareas' => $tareasPaginadas,
            'totalTareas' => $totalTareas,
            'tareasPorPagina' => $tareasPorPagina,
            'paginaActual' => $paginaActual,
            'ordenarPor' => $ordenarPor,
            'orden' => $orden
        ]);
    }

    // Método para editar una tarea
    public function editarTarea($id)
    {
        $bbdd = BBDD::getInstance();
        $tarea = $bbdd->getTarea($id);
        $encargado = $bbdd->getOperarioIdByTareaId($id) ?? 3;
        $selectedProvincia = $bbdd->getProvinciabyIdTarea($id) ?? '';
        $selectedEstado = $bbdd->getEstadobyIdTarea($id) ?? '';
        return view('nueva_tarea', [
            'tarea' => $tarea ?: ['error' => 'No se ha encontrado la tarea'],
            'selectedOperario' => $encargado,
            'operarios' => $bbdd->getOperarios() ?: ['error' => 'No se han encontrado operarios'],
            'provincias' => $bbdd->getProvincias() ?: ['error' => 'No se han encontrado provincias'],
            'estados' => $bbdd->getEstados() ?: ['error' => 'No se han encontrado estados'],
            'selectedProvincia' => $selectedProvincia,
            'selectedEstado' => $selectedEstado
        ]);
    }

    public function confirmarEliminarTarea($id)
    {
        $bbdd = BBDD::getInstance();
        $tarea = $bbdd->getTarea($id);

        return view('confirmar_eliminar', [
            'tarea' => $tarea
        ]);
    }

    // Método para eliminar una tarea
    public function eliminarTarea($id)
    {
        $bbdd = BBDD::getInstance();
        $tarea = $bbdd->getTarea($id);
        // Si no existe la tarea
        if (!$tarea) {
            return view('error', ['mensaje' => 'La tarea no existe']);
        }

        // Si es POST, eliminar la tarea
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $bbdd->eliminarTarea($id);
            header("Location: " . Utiles::getInstance()->myUrl('ver-tareas'));
            exit();
        }

        // Si es GET, mostrar confirmación
        return view('confirmar_eliminar', [
            'tarea' => $tarea
        ]);
    }
}
