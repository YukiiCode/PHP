<?php

namespace App\Models;

class Utiles
{
    // Propiedad estática para almacenar la instancia única
    private static $instance = null;

    // Constructor privado para evitar la creación de instancias desde fuera de la clase
    private function __construct() {}

    // Método estático para obtener la instancia única
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Función para redirigir a una URL
    public static function myUrl($path)
    {
        // Obtener la ruta base de la aplicación
        $basePath = 'http://localhost/Proyecto-copia/public/';

        // Construir la URL completa
        return $basePath . ltrim($path, '/');
    }

    // Función para redirigir a una URL con parámetros
    public function myUrlParams($path, $params = [])
    {
        $url = $path;
        if (!empty($params)) {
            $queryString = http_build_query($params);
            $url .= '?' . $queryString;
        }
        return $url;
    }

    // Función para filtrar campos
    public function filtrar($campo, $expresionRegular, &$errores)
    {
        if (empty($_POST[$campo])) {
            $errores[$campo] = "El campo '$campo' está vacío.";
        } elseif ($expresionRegular && !preg_match($expresionRegular, $_POST[$campo])) {
            $errores[$campo] = "El formato del campo '$campo' no es válido.";
        }
    }

    // Función para mostrar errores
    public static function mostrarError($campo, $errores = [])
    {
        if (!empty($errores[$campo])) {
            return '<div class="text-danger">' . $errores[$campo] . '</div>';
        }
        return '';
    }

    // Funcion para cargar operarios en select
    public static function cargarOperarios($operarios, $selected)
    {
        $html = '';
        foreach ($operarios as $operario) {
            if ($operario['nombre_usuario'] == $selected) {
                $html .= '<option class="form-control" value="' . $operario['id'] . ' " selected>' . $operario['nombre_usuario'] . '</option>';
            } else {
                $html .= '<option class="form-control" value="' . $operario['id'] . '">' . $operario['nombre_usuario'] . '</option>';
            }
        }
        return $html;
    }

    // Función para cargar provincias en select
    public static function cargarProvincias($provincias, $selectedProvincia)
    {
        $html = '';
        foreach ($provincias as $provincia) {
            if ($provincia['id'] == $selectedProvincia) {
                $html .= '<option class="form-control" value="' . $provincia['id'] . ' " selected>' . $provincia['nombre'] . '</option>';
            } else {
                $html .= '<option class="form-control" value="' . $provincia['id'] . '">' . $provincia['nombre'] . '</option>';
            }
        }
        return $html;
    }

    // Función para cargar estados en select
    public static function cargarEstados($estados, $selectedEstado)
    {
        $html = '';
        foreach ($estados as $estado) {
            if ($estado['estado'] == $selectedEstado) {
                $html .= '<option class="form-control" value="' . $estado['estado'] . ' " selected>' . $estado['estado'] . '</option>';
            } else {
                $html .= '<option class="form-control" value="' . $estado['estado'] . '">' . $estado['estado'] . '</option>';
            }
        }
        return $html;
    }

    // Función para cargar errores, con campo de parametro
    public static function mostrarErrores($campo, $errores)
    {
        if (!empty($errores[$campo])) {
            return '<div class="text-danger">' . $errores[$campo] . '</div>';
        }
        return '';
    }

    // Función para cargar datos anteriores
    public static function mostrarDatosAnteriores($campo)
    {
        if (!empty($_POST[$campo])) {
            return $_POST[$campo];
        }
        return '';
    }


    public function filtrarPDF($campo, &$errores)
    {
        if (isset($_FILES[$campo]) && $_FILES[$campo]['error'] == UPLOAD_ERR_OK) {
            $fileType = mime_content_type($_FILES[$campo]['tmp_name']);
            if ($fileType != 'application/pdf') {
                $errores[$campo] = "El archivo debe ser un PDF.";
                return false;
            }
            return true;
        }
        return false;
    }

    public function filtrarImagen($campo, $key, &$errores)
    {
        if (isset($_FILES[$campo]) && $_FILES[$campo]['error'][$key] == UPLOAD_ERR_OK) {
            $fileType = mime_content_type($_FILES[$campo]['tmp_name'][$key]);
            if (!in_array($fileType, ['image/jpeg', 'image/png', 'image/gif'])) {
                $errores['fotos'] = "Solo se permiten archivos de imagen (JPEG, PNG, GIF).";
                return false;
            }
            return true;
        }
        return false;
    }


}
