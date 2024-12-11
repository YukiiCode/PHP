<?php

namespace App\Http\Controllers;

use App\Models\Utiles;
use App\Models\bbdd;

class FormController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->restringirToOperario();
    }

    public function mostrarFormulario()
    {
        return view('nueva_tarea', [
            'operarios' => bbdd::getInstance()->getOperarios() ?: ['error' => 'No se han encontrado operarios'],
            'provincias' => bbdd::getInstance()->getProvincias() ?: ['error' => 'No se han encontrado provincias'],
            'estados' => bbdd::getInstance()->getEstados() ?: ['error' => 'No se han encontrado estados'],
            'selectedEstado' => null,
            'selectedProvincia' => null,
            'selectedOperario' => null,
            //si fecha realizacion no esta definida se le asigna la fecha actual
            $_POST['fecha_creacion'] = $_POST['fecha_creacion'] ?? date('Y-m-d'),
        ]);
    }

    public function validarFormulario()
    {
        $errores = [];

        // La función usada para filtrar campos está alojada en Models/Utiles
        $utiles = Utiles::getInstance();
        $utiles->filtrar('nif_cif', "/^([0-9]{8}[A-Z]|[ABCDEFGHJNPQRSUVW][0-9]{7}[0-9A-J])$/", $errores);
        $utiles->filtrar('nombre', "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $errores);
        $utiles->filtrar('apellidos', "/^[a-zA-Z]+$/", $errores);
        $utiles->filtrar('telefono', "/^\+\d{1,3}[-\s]?\d{1,4}([-\s]?\d{3,4}){2,3}$/", $errores);
        $utiles->filtrar('provincia', "", $errores);
        $utiles->filtrar('poblacion', "", $errores);
        $utiles->filtrar('operario', "", $errores);
        $utiles->filtrar('direccion', "", $errores);
        $utiles->filtrar('estado', "/^[B|P|R|C]$/", $errores);
        $utiles->filtrar('email', "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $errores);
        $utiles->filtrar('codigo_postal', "", $errores);
        // $utiles->filtrar('fecha_realizacion', "/^\d{4}-\d{2}-\d{2}$/", $errores);

        $bbdd = BBDD::getInstance();

        // Si no hay errores, procesar la tarea
        if (empty($errores)) {
            $tarea = [
                'nif_cif' => $_POST['nif_cif'],
                'nombre' => $_POST['nombre'],
                'telefono_contacto' => $_POST['telefono_contacto'],
                'descripcion' => $_POST['descripcion'],
                'email' => $_POST['email'],
                'direccion' => $_POST['direccion'],
                'poblacion' => $_POST['poblacion'],
                'codigo_postal' => $_POST['codigo_postal'],
                'provincia' => $_POST['provincia'],
                'estado' => $_POST['estado'],
                'fecha_creacion' => date('Y-m-d'),
                'fecha_realizacion' => $_POST['fecha_realizacion'],
                'operario_encargado' => $_POST['operario'],
                'anotaciones_anteriores' => $_POST['anotaciones_anteriores'],
                'anotaciones_posteriores' => $_POST['anotaciones_posteriores'],
                //'fichero_resumen' => $ficheroResumen,
                //'fotos_trabajo' => implode(',', $fotosTrabajos),
            ];

            // Determinar si es una actualización o inserción
            if (isset($_POST['id'])) {
                $tarea['id'] = $_POST['id'];
                try {
                    $bbdd->updateTarea($tarea);
                } catch (\Exception $e) {
                    // Manejar errores de actualización
                    $errores['general'] = 'Error al actualizar la tarea: ' . $e->getMessage();
                    return view('nueva_tarea', [
                        'errores' => $errores,
                        'tarea' => $_POST,
                        'operarios' => $bbdd->getOperarios(),
                        'provincias' => $bbdd->getProvincias(),
                        'estados' => $bbdd->getEstados(),
                        'selectedOperario' => $_POST['operario'] ?? '',
                        'selectedProvincia' => $_POST['provincia'] ?? '',
                        'selectedEstado' => $_POST['estado'] ?? '',
                    ]);
                }
            } else {
                try {
                    $bbdd->insertarTarea($tarea);
                } catch (\Exception $e) {
                    // Manejar errores de inserción
                    $errores['general'] = 'Error al insertar la tarea: ' . $e->getMessage();
                    return view('nueva_tarea', [
                        'errores' => $errores,
                        'tarea' => $_POST,
                        'operarios' => $bbdd->getOperarios(),
                        'provincias' => $bbdd->getProvincias(),
                        'estados' => $bbdd->getEstados(),
                        'selectedOperario' => $_POST['operario'] ?? '',
                        'selectedProvincia' => $_POST['provincia'] ?? '',
                        'selectedEstado' => $_POST['estado'] ?? '',
                    ]);
                }
            }
            // Redirigir a la lista de tareas
            header('Location: ' . $utiles->myUrl('ver-tareas'));
            exit();
        } else {
            // Mostrar formulario con errores
            return view('nueva_tarea', [
                'errores' => $errores,
                'tarea' => $_POST,
                'operarios' => $bbdd->getOperarios(),
                'provincias' => $bbdd->getProvincias(),
                'estados' => $bbdd->getEstados(),
                'selectedOperario' => $_POST['operario'] ?? '',
                'selectedProvincia' => $_POST['provincia'] ?? '',
                'selectedEstado' => $_POST['estado'] ?? '',
            ]);
        }
    }
}
