-- Usuario, tareas/incidencia

CREATE DATABASE gestion_tareas;
USE gestion_tareas;

CREATE TABLE tareas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nif_cif VARCHAR(20) NOT NULL,
    persona_contacto VARCHAR(100) NOT NULL,
    telefono_contacto VARCHAR(20) NOT NULL,
    descripcion TEXT NOT NULL,
    correo_contacto VARCHAR(100) NOT NULL,
    direccion VARCHAR(150),
    poblacion VARCHAR(100),
    codigo_postal VARCHAR(5),
    provincia INT,
    estado ENUM('B', 'P', 'R', 'C') DEFAULT 'B', -- Esperando, Pendiente, Realizada, Cancelada
    fecha_creacion DATE DEFAULT CURRENT_DATE,
    operario_encargado VARCHAR(100),
    fecha_realizacion DATE,
    anotaciones_anteriores TEXT,
    anotaciones_posteriores TEXT,
    fichero_resumen VARCHAR(255),
    fotos_trabajo TEXT
);

-- Tabla para los usuarios si se desea manejar permisos
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50) NOT NULL,
    clave_usuario VARCHAR(255) NOT NULL,
    tipo_usuario ENUM('Administrador', 'Operario') DEFAULT 'Operario'
);

-- Relaciones para simplificar la asignación de tareas a operarios específicos en el futuro
CREATE TABLE tareas_usuarios (
    tarea_id INT,
    usuario_id INT,
    FOREIGN KEY (tarea_id) REFERENCES tareas(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);
