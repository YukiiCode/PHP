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
}
