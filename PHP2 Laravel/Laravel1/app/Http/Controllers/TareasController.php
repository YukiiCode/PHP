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

    // Método para mostrar el formulario de agregar una nueva tarea
    public function agregarTarea()
    {
        $bbdd = BBDD::getInstance();
        $provincias = $bbdd->getProvincias();
        $operarios = $bbdd->getOperarios();
        $estados = $bbdd->getEstados();

        return view('nueva_tarea', [
            'provincias' => $provincias,
            'operarios' => $operarios,
            'estados' => $estados
        ]);
    }

    // Método para guardar una nueva tarea
    public function guardarTarea()
    {
        $bbdd = BBDD::getInstance();
        $utiles = Utiles::getInstance();
        $errores = [];

        // Filtrar y validar los datos
        $tarea = [
            'nif_cif' => $_POST['nif_cif'] ?? '',
            'persona_contacto' => $_POST['nombre'] ?? '',
            'telefono_contacto' => $_POST['telefono'] ?? '',
            'descripcion' => $_POST['descripcion'] ?? '',
            'correo_contacto' => $_POST['email'] ?? '',
            'direccion' => $_POST['direccion'] ?? '',
            'poblacion' => $_POST['poblacion'] ?? '',
            'codigo_postal' => $_POST['codigo_postal'] ?? '',
            'provincia' => $_POST['provincia'] ?? '',
            'estado' => $_POST['estado'] ?? '',
            'fecha_realizacion' => $_POST['fecha_realizacion'] ?? '',
            'operario_encargado' => $_POST['operario'] ?? '',
            'anotaciones_anteriores' => $_POST['anotaciones_anteriores'] ?? '',
            'anotaciones_posteriores' => $_POST['anotaciones_posteriores'] ?? '',
            'fichero_resumen' => '',
            'fotos_trabajo' => ''
        ];

        // Validaciones
        $utiles->filtrar('nif_cif', "/^([0-9]{8}[A-Z]|[ABCDEFGHJNPQRSUVW][0-9]{7}[0-9A-J])$/", $errores);
        $utiles->filtrar('persona_contacto', "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $errores);
        $utiles->filtrar('telefono_contacto', "/^\+\d{1,3}[-\s]?\d{1,4}([-\s]?\d{3,4}){2,3}$/", $errores);
        $utiles->filtrar('correo_contacto', "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $errores);
        $utiles->filtrar('fecha_realizacion', "/^\d{4}-\d{2}-\d{2}$/", $errores);

        // Manejar subida de archivos
        if ($utiles->filtrarPDF('fichero_resumen', $errores)) {
            $tarea['fichero_resumen'] = basename($_FILES['fichero_resumen']['name']);
            move_uploaded_file($_FILES['fichero_resumen']['tmp_name'], 'uploads/resumenes/' . $tarea['fichero_resumen']);
        }

        if ($utiles->filtrarImagen('fotos_trabajo', 0, $errores)) {
            $tarea['fotos_trabajo'] = basename($_FILES['fotos_trabajo']['name'][0]);
            move_uploaded_file($_FILES['fotos_trabajo']['tmp_name'][0], 'uploads/fotos_trabajo/' . $tarea['fotos_trabajo']);
        }

        if (empty($errores)) {
            $idTarea = $bbdd->insertarTarea($tarea);
            if ($idTarea) {
                header("Location: " . Utiles::getInstance()->myUrl('ver-tareas'));
                exit();
            } else {
                $errores['general'] = "Error al guardar la tarea.";
            }
        }

        $provincias = $bbdd->getProvincias();
        $operarios = $bbdd->getOperarios();
        $estados = $bbdd->getEstados();

        return view('nueva_tarea', [
            'tarea' => $tarea,
            'errores' => $errores,
            'provincias' => $provincias,
            'operarios' => $operarios,
            'estados' => $estados
        ]);
    }

    // Método para editar una tarea
    public function editarTarea($id)
    {

        $bbdd = BBDD::getInstance();
        $tarea = $bbdd->getTarea($id);
        $encargado = $bbdd->getOperarioIdByTareaId($id);
        $selectedProvincia = $bbdd->getProvinciabyIdTarea($id);
        $selectedEstado = $bbdd->getEstadobyIdTarea($id);
        return view('nueva_tarea', [
            'tarea' => $tarea ?: ['error' => 'No se ha encontrado la tarea'],
            'selectedOperario' => $encargado,
            'operarios' => $bbdd->getOperarios() ?: ['error' => 'No se han encontrado operarios'],
            'provincias' => $bbdd->getProvincias() ?: ['error' => 'No se han encontrado provincias'],
            'estados' => $bbdd->getEstados() ?: ['error' => 'No se han encontrado estados']
        ]);
    }

    // Método para actualizar una tarea
    public function actualizarTarea($id)
    {
        $bbdd = BBDD::getInstance();
        $errores = [];
        $tarea = [
            'id' => $id,
            'nif_cif' => $_POST['nif_cif'] ?? '',
            'persona_contacto' => $_POST['persona_contacto'] ?? '',
            'telefono_contacto' => $_POST['telefono_contacto'] ?? '',
            'descripcion' => $_POST['descripcion'] ?? '',
            'correo_contacto' => $_POST['correo_contacto'] ?? '',
            'direccion' => $_POST['direccion'] ?? '',
            'poblacion' => $_POST['poblacion'] ?? '',
            'codigo_postal' => $_POST['codigo_postal'] ?? '',
            'provincia' => $_POST['provincia'] ?? '',
            'estado' => $_POST['estado'] ?? '',
            'fecha_realizacion' => $_POST['fecha_realizacion'] ?? '',
            'operario_encargado' => $_POST['operario'] ?? '',
            'anotaciones_anteriores' => $_POST['anotaciones_anteriores'] ?? '',
            'anotaciones_posteriores' => $_POST['anotaciones_posteriores'] ?? '',
            'fichero_resumen' => $_POST['fichero_resumen'] ?? '',
            'fotos_trabajo' => $_POST['fotos_trabajo'] ?? ''
        ];

        // Reglas de validación
        $utiles = Utiles::getInstance();
        $utiles->filtrar('nif_cif', "/^([0-9]{8}[A-Z]|[ABCDEFGHJNPQRSUVW][0-9]{7}[0-9A-J])$/", $errores);
        $utiles->filtrar('nombre', "/^[a-zA-Z]+$/", $errores);
        $utiles->filtrar('apellidos', "/^[a-zA-Z]+$/", $errores);
        $utiles->filtrar('telefono', "/^\+\d{1,3}[-\s]?\d{1,4}([-\s]?\d{3,4}){2,3}$/", $errores);
        $utiles->filtrar('provincia', "", $errores);
        $utiles->filtrar('poblacion', "", $errores);
        $utiles->filtrar('operarios', "", $errores);
        $utiles->filtrar('direccion', "", $errores);
        $utiles->filtrar('localidad', "/^[a-zA-Z\s]+$/", $errores);
        $utiles->filtrar('descripcion', "/^[a-zA-Z\s]+$/", $errores);
        $utiles->filtrar('email', "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $errores);
        $utiles->filtrar('codigo_postal', "/^(0[1-9]|[1-4][0-9]|5[0-2])\d{3}$/", $errores);
        $utiles->filtrar('fecha_realizacion', "/^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/(19|20)\d{2}$/", $errores);

        if (empty($errores)) {
            $bbdd->updateTarea($tarea);
            header("Location: " . Utiles::getInstance()->myUrl('ver-tareas'));
            exit();
        }

        return view('nueva_tarea', [
            'tarea' => $tarea,
            'errores' => $errores,
            'operarios' => $bbdd->getOperarios() ?: ['error' => 'No se han encontrado operarios'],
            'provincias' => $bbdd->getProvincias() ?: ['error' => 'No se han encontrado provincias'],
            'estados' => $bbdd->getEstados() ?: ['error' => 'No se han encontrado estados'],
            'selectedOperario' => $tarea['operario_encargado'],
            'selectedProvincia' => $tarea['provincia'],
            'selectedEstado' => $tarea['estado']
        ]);
    }

    public function confirmarEliminarTarea($id)
    {
        $bbdd = BBDD::getInstance();
        $tarea = $bbdd->getTarea($id);
        if (!$tarea) {
            return view('error', ['mensaje' => 'La tarea no existe']);
        }

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
