<?php

namespace App\Http\Controllers;

use App\Models\Utiles;
use Illuminate\Support\Facades\View;

class BaseController
{
    // Propiedad protegida para almacenar el usuario
    protected $usuario;

    public function __construct()
    {
        session_start();
        $this->usuario = $_SESSION['usuario'] ?? null;
        $this->autenticado();
    }

    // Verificar si el usuario está autenticado
    protected function autenticado()
    {
        if (!$this->usuario) {
            header('Location: ' . Utiles::getInstance()->myUrl('login'));
            exit();
        }
    }

    // Verificar si el usuario es Administrador
    protected function esAdministrador()
    {
        return $this->usuario && $this->usuario['tipo_usuario'] == 'Administrador';
    }

    // Verificar si el usuario es Operario
    protected function esOperario()
    {
        return $this->usuario && $this->usuario['tipo_usuario'] == 'Operario';
    }

    // Restringir acceso a Operarios
    protected function restringirToOperario()
    {
        if ($this->esOperario()) {
            header('Location: ' . Utiles::getInstance()->myUrl('no-autorizado'));
            exit();
        }
    }
}
