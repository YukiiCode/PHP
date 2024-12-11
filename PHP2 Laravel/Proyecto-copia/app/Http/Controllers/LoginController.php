<?php

namespace App\Http\Controllers;

use App\Models\Utiles;
use App\Models\BBDD;

class LoginController
{
    public function login()
    {
        $errores = [];

        // Obtener datos del POST
        $username = $_POST['user'] ?? '';
        $password = $_POST['psw'] ?? '';
        $remember = isset($_POST['remember']);

        // Instancia de Utiles
        $utiles = Utiles::getInstance();
        // Instancia de bbdd
        $bbdd = BBDD::getInstance();

        // Reglas de validación
        $utiles->filtrar('user', "/^[a-zA-Z0-9]+$/", $errores);
        $utiles->filtrar('psw', "/^[a-zA-Z0-9]+$/", $errores);

        // Verificar usuario y contraseña
        $usuario = $bbdd->login($username, $password);

        if (empty($errores))
            if (!$usuario)
                $errores['novalido'] = 'Usuario o contraseña incorrectos';


        if (empty($errores)) {
            // Iniciar sesión
            session_start();
            if (empty($errores)) {
                // Almacenar usuario y tipo en la sesión
                $_SESSION['usuario'] = [
                    'id' => $usuario['id'],
                    'nombre_usuario' => $usuario['nombre_usuario'],
                    'tipo_usuario' => $usuario['tipo_usuario']
                ];
                // Manejar la cookie solo si "Recordar Usuario" está marcado
                if ($remember) {
                    // Establecer la cookie (expira en 30 días)
                    setcookie('username', $username, time() + (30 * 24 * 60 * 60), "/");
                } else {
                    // Si no se marca, eliminar la cookie si existe
                    if (isset($_COOKIE['username'])) {
                        setcookie('username', '', time() - 3600, "/");
                    }
                }
                // Redirigir a la página de inicio
                header('Location: ' . $utiles::myUrl('home'));
                exit;
            }
        } else {
            // Mostrar la vista de login con errores
            return view('login', ['errores' => $errores]);
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: ' . Utiles::myUrl('login'));
        exit;
    }
}
