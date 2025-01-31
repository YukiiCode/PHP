-- Eliminamos tabla si existe
DROP TABLE IF EXISTS tarea;
DROP TABLE IF EXISTS empleados;
DROP TABLE IF EXISTS clientes;

-- Creamos las tablas
CREATE TABLE clientes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL
);

CREATE TABLE empleados (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    tipo ENUM('operario', 'administrador') NOT NULL
);

CREATE TABLE tareas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    estado ENUM('F', 'T', 'C', 'A', 'E'), -- Finalizada, En curso, Cancelada, Esperando ser aprobada, Esperando ser asignada
    operario_encargado INT,
    fecha_creacion DATE,
    fecha_finalizacion DATE,
    anotaciones TEXT,
    id_cliente INT,
    fichero_resumen VARCHAR(255), -- Campo para PDF
    fotos_trabajo JSON, -- Campo para fotos en JSON
    FOREIGN KEY (id_cliente) REFERENCES clientes(id),
    FOREIGN KEY (operario_encargado) REFERENCES empleados(id)
);

-- Insertamos datos de ejemplo
INSERT INTO clientes (nombre) VALUES 
('Cliente 1'),
('Cliente 2'),
('Cliente 3');

INSERT INTO empleados (nombre, tipo) VALUES
('Admin 1', 'administrador'),
('Operario 1', 'operario'),
('Operario 2', 'operario');

INSERT INTO tarea (
    estado,
    operario_encargado,
    fecha_creacion,
    fecha_finalizacion,
    anotaciones,
    id_cliente,
    fichero_resumen,
    fotos_trabajo
)
VALUES
(
    'E',
    2,
    '2023-01-01',
    '2023-01-05',
    'Tarea pendiente de revisión',
    1,
    'resumenes/tarea1.pdf',
    '["fotos/tarea1_foto1.jpg", "fotos/tarea1_foto2.jpg"]'
),
(
    'T',
    3,
    '2023-02-01',
    '2023-02-10',
    'Tarea en proceso',
    2,
    'resumenes/tarea2.pdf',
    '["fotos/tarea2_foto1.jpg"]'
),
(
    'F',
    2,
    '2023-03-01',
    '2023-03-15',
    'Tarea completada',
    3,
    'resumenes/tarea3.pdf',
    '["fotos/tarea3_foto1.jpg", "fotos/tarea3_foto2.jpg", "fotos/tarea3_foto3.jpg"]'
);