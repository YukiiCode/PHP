<?php

namespace App\Models;

use PDO;
use PDOException;


class BBDD
{
    private static $instance = null;
    private $pdo;
    private $host;
    private $db;
    private $user;
    private $pass;
    private $charset;

    // Método estático para obtener la instancia única
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Constructor privado para evitar la creación de instancias desde fuera de la clase
    private function __construct()
    {
        $config = [
            'host' => 'localhost',
            'db' => 'gestion_tareas',
            'user' => 'root',
            'pass' => '',
            'charset' => 'utf8mb4'
        ];
        $this->host = $config['host'];
        $this->db = $config['db'];
        $this->user = $config['user'];
        $this->pass = $config['pass'];
        $this->charset = $config['charset'];

        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    // Método para ejecutar una consulta y obtener los resultados
    function query($sql, $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    // Login 
    function login($usuario, $password)
    {
        $sql = "SELECT * FROM usuarios WHERE nombre_usuario = ? AND password = ?";
        $result = $this->query($sql, [$usuario, $password]);
        return $result ? $result[0] : null;
    }

    // Método para obtener todas las tareas con ordenación
    public function getTareas($ordenarPor = 'fecha_realizacion', $orden = 'DESC')
    {
        // Definir los campos permitidos para ordenar
        $camposPermitidos = [
            'id',
            'nif_cif',
            'persona_contacto',
            'telefono_contacto',
            'descripcion',
            'correo_contacto',
            'direccion',
            'poblacion',
            'codigo_postal',
            'provincia',
            'estado',
            'fecha_realizacion',
            'operario_encargado',
            'fecha_creacion' // Asegúrate de que este campo existe en tu tabla
        ];

        // Validar el campo por el cual se desea ordenar
        if (!in_array($ordenarPor, $camposPermitidos)) {
            $ordenarPor = 'fecha_realizacion';
        }

        // Validar el orden (ASC o DESC)
        $orden = strtoupper($orden) === 'ASC' ? 'ASC' : 'DESC';

        // Construir la consulta SQL con ordenación
        $sql = "SELECT * FROM tareas ORDER BY {$ordenarPor} {$orden}";

        return $this->query($sql);
    }


    // Cargar Usuarios
    function cargarUsuarios()
    {
        $sql = "SELECT * FROM usuarios";
        return $this->query($sql);
    }

    // Cargar tareas por usuario
    function cargarTareasUsuario($id)
    {
        $sql = "SELECT * FROM tareas WHERE id_usuario = ?";
        return $this->query($sql, [$id]);
    }

    // Cargar tarea por id
    function getTarea($id)
    {
        $sql = "SELECT * FROM tareas WHERE id = ?";
        $result = $this->query($sql, [$id]);
        return $result ? $result[0] : null;
    }

    // Insertar tarea
    public function insertarTarea($tarea)
    {
        $sql = "INSERT INTO tareas (nif_cif, persona_contacto, telefono_contacto, descripcion, correo_contacto, direccion, poblacion, codigo_postal, provincia, estado, fecha_realizacion, operario_encargado, anotaciones_anteriores, anotaciones_posteriores, fichero_resumen, fotos_trabajo) 
                VALUES (:nif_cif, :persona_contacto, :telefono_contacto, :descripcion, :correo_contacto, :direccion, :poblacion, :codigo_postal, :provincia, :estado, :fecha_realizacion, :operario_encargado, :anotaciones_anteriores, :anotaciones_posteriores, :fichero_resumen, :fotos_trabajo)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':nif_cif', $tarea['nif_cif']);
        $stmt->bindParam(':persona_contacto', $tarea['persona_contacto']);
        $stmt->bindParam(':telefono_contacto', $tarea['telefono_contacto']);
        $stmt->bindParam(':descripcion', $tarea['descripcion']);
        $stmt->bindParam(':correo_contacto', $tarea['correo_contacto']);
        $stmt->bindParam(':direccion', $tarea['direccion']);
        $stmt->bindParam(':poblacion', $tarea['poblacion']);
        $stmt->bindParam(':codigo_postal', $tarea['codigo_postal']);
        $stmt->bindParam(':provincia', $tarea['provincia']);
        $stmt->bindParam(':estado', $tarea['estado']);
        $stmt->bindParam(':fecha_realizacion', $tarea['fecha_realizacion']);
        $stmt->bindParam(':operario_encargado', $tarea['operario_encargado']);
        $stmt->bindParam(':anotaciones_anteriores', $tarea['anotaciones_anteriores']);
        $stmt->bindParam(':anotaciones_posteriores', $tarea['anotaciones_posteriores']);
        $stmt->bindParam(':fichero_resumen', $tarea['fichero_resumen']);
        $stmt->bindParam(':fotos_trabajo', $tarea['fotos_trabajo']);
        $stmt->execute();
    }

    // Función para obtener el ID del operario según la ID de la tarea
    public function getOperarioIdByTareaId($tareaId)
    {
        $sql = "SELECT operario_encargado FROM tareas WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$tareaId]);
        $result = $stmt->fetch();
        return $result ? $result['operario_encargado'] : null;
    }

    // Función para encontrar id provincia por id tarea
    public function getProvinciabyIdTarea($id_tarea)
    {
        $sql = "SELECT provincia FROM tareas WHERE id = ?";
        $result = $this->query($sql, [$id_tarea]);
        return $result ? $result[0]['provincia'] : null;
    }

    // Función para encontrar estado por id tarea
    function getEstados()
    {
        $sql = "SELECT DISTINCT estado FROM tareas";
        return $this->query($sql);
    }

    // Función para encontrar estado de una tarea
    public function getEstadobyIdTarea($id_tarea)
    {
        $sql = "SELECT estado FROM tareas WHERE id = ?";
        $result = $this->query($sql, [$id_tarea]);
        return $result ? $result[0]['estado'] : null;
    }

    // Función para encontrar provincia de una tarea
    function getProvinciaTarea($id_tarea)
    {
        $sql = "SELECT provincias.nombre 
                FROM tareas 
                JOIN provincias ON tareas.provincia = provincias.id 
                WHERE tareas.id = ?";
        return $this->query($sql, [$id_tarea]);
    }


    // Eliminar tarea
    function eliminarTarea($id)
    {
        $sql = "DELETE FROM tareas WHERE id = ?";
        return $this->query($sql, [$id]);
    }

    // Solo operarios
    function getOperarios()
    {
        $sql = "SELECT id,nombre_usuario FROM usuarios WHERE tipo_usuario = 'Operario'";
        return $this->query($sql);
    }

    // Operario por id de tarea
    function getOperario($id)
    {
        $sql = "SELECT nombre_usuario FROM usuarios WHERE id = ?";
        return $this->query($sql, [$id]);
    }

    // Obtener nombre operario por id
    function getIdOperario($id)
    {
        $sql = "SELECT nombre_usuario FROM usuarios WHERE id = ?";
        return $this->query($sql, [$id]);
    }

    // Cargar provincias
    function getProvincias()
    {
        $sql = "SELECT * FROM provincias";
        return $this->query($sql);
    }

    public function updateTarea($tarea)
    {
        $sql = "UPDATE tareas SET 
                nif_cif = :nif_cif,
                persona_contacto = :persona_contacto,
                telefono_contacto = :telefono_contacto,
                descripcion = :descripcion,
                correo_contacto = :correo_contacto,
                direccion = :direccion,
                poblacion = :poblacion,
                codigo_postal = :codigo_postal,
                provincia = :provincia,
                estado = :estado,
                fecha_realizacion = :fecha_realizacion,
                operario_encargado = :operario_encargado,
                anotaciones_anteriores = :anotaciones_anteriores,
                anotaciones_posteriores = :anotaciones_posteriores,
                fichero_resumen = :fichero_resumen,
                fotos_trabajo = :fotos_trabajo
            WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':nif_cif', $tarea['nif_cif']);
        $stmt->bindParam(':persona_contacto', $tarea['persona_contacto']);
        $stmt->bindParam(':telefono_contacto', $tarea['telefono_contacto']);
        $stmt->bindParam(':descripcion', $tarea['descripcion']);
        $stmt->bindParam(':correo_contacto', $tarea['correo_contacto']);
        $stmt->bindParam(':direccion', $tarea['direccion']);
        $stmt->bindParam(':poblacion', $tarea['poblacion']);
        $stmt->bindParam(':codigo_postal', $tarea['codigo_postal']);
        $stmt->bindParam(':provincia', $tarea['provincia']);
        $stmt->bindParam(':estado', $tarea['estado']);
        $stmt->bindParam(':fecha_realizacion', $tarea['fecha_realizacion']);
        $stmt->bindParam(':operario_encargado', $tarea['operario_encargado']);
        $stmt->bindParam(':anotaciones_anteriores', $tarea['anotaciones_anteriores']);
        $stmt->bindParam(':anotaciones_posteriores', $tarea['anotaciones_posteriores']);
        $stmt->bindParam(':fichero_resumen', $tarea['fichero_resumen']);
        $stmt->bindParam(':fotos_trabajo', $tarea['fotos_trabajo']);
        $stmt->bindParam(':id', $tarea['id'], \PDO::PARAM_INT);

        $stmt->execute();
    }


    // Funcion que devuelve solo tareas finalizadas
    function getTareasFinalizadas()
    {
        $sql = "SELECT * FROM tareas WHERE estado = 'Finalizada' ORDER BY fecha_realizacion DESC";
        return $this->query($sql);
    }
}
