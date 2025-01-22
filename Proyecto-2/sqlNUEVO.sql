CREATE TABLE
    empleados (
        id INT PRIMARY KEY AUTO_INCREMENT,
        dni VARCHAR(10),
        nombre VARCHAR(100),
        correo VARCHAR(100),
        telefono VARCHAR(15),
        direccion VARCHAR(100),
        fecha_alta DATE,
        tipo ENUM ('operario', 'administrativo'),
    );

CREATE TABLE
    clientes (
        id INT PRIMARY KEY AUTO_INCREMENT,
        cif VARCHAR(10),
        nombre VARCHAR(100),
        telefono VARCHAR(15),
        correo VARCHAR(100),
        cuenta_corriente VARCHAR(24),
        pais VARCHAR(100),
        moneda ENUM ('EUR', 'USD', 'GBP'),
        importe_mensual DECIMAL(10, 2),
    );

CREATE TABLE
    cargos (
        id INT PRIMARY KEY AUTO_INCREMENT,
        concepto VARCHAR(100),
        fecha_emision DATE,
        importe DECIMAL(10, 2),
        pagado BOOLEAN, --Puede que no se precise
        fecha_pago DATE,
        notas TEXT,
        id_cliente INT,
        id_empleado INT,
        FOREIGN KEY (id_empleado) REFERENCES empleados (id),
        FOREIGN KEY (id_cliente) REFERENCES clientes (id)
    );

CREATE TABLE
    tarea (
        id INT PRIMARY KEY AUTO_INCREMENT,
        estado ENUM ('F','C','C','A','E'), -- Add the possible values for the enum
        -- Finalizada , En curso, Cancelada, Esperando ser aprobada, Esperando ser asignada por un administrador
        operario_encargado INT,
        fecha_creacion DATE,
        fecha_finalizacion DATE,
        anotaciones TEXT,
        id_cliente INT,
        FOREIGN KEY (id_cliente) REFERENCES clientes (id),
        FOREIGN KEY (operario_encargado) REFERENCES empleados (id)
    );

INSERT INTO tareas (estado, operario_encargado, fecha_creacion, fecha_finalizacion, anotaciones, id_cliente) VALUES
('pendiente', 1, '2023-01-01', '2023-01-05', 'Anotación 1', 1),
('completado', 2, '2023-01-02', '2023-01-06', 'Anotación 2', 2),
('pendiente', 3, '2023-01-03', '2023-01-07', 'Anotación 3', 3),
('completado', 4, '2023-01-04', '2023-01-08', 'Anotación 4', 4),
('pendiente', 5, '2023-01-05', '2023-01-09', 'Anotación 5', 5),
('completado', 1, '2023-01-06', '2023-01-10', 'Anotación 6', 1),
('pendiente', 2, '2023-01-07', '2023-01-11', 'Anotación 7', 2),
('completado', 3, '2023-01-08', '2023-01-12', 'Anotación 8', 3),
('pendiente', 4, '2023-01-09', '2023-01-13', 'Anotación 9', 4),
('completado', 5, '2023-01-10', '2023-01-14', 'Anotación 10', 5),
('pendiente', 1, '2023-01-11', '2023-01-15', 'Anotación 11', 1),
('completado', 2, '2023-01-12', '2023-01-16', 'Anotación 12', 2),
('pendiente', 3, '2023-01-13', '2023-01-17', 'Anotación 13', 3),
('completado', 4, '2023-01-14', '2023-01-18', 'Anotación 14', 4),
('pendiente', 5, '2023-01-15', '2023-01-19', 'Anotación 15', 5),
('completado', 1, '2023-01-16', '2023-01-20', 'Anotación 16', 1),
('pendiente', 2, '2023-01-17', '2023-01-21', 'Anotación 17', 2),
('completado', 3, '2023-01-18', '2023-01-22', 'Anotación 18', 3),
('pendiente', 4, '2023-01-19', '2023-01-23', 'Anotación 19', 4),
('completado', 5, '2023-01-20', '2023-01-24', 'Anotación 20', 5),
('pendiente', 1, '2023-01-21', '2023-01-25', 'Anotación 21', 1),
('completado', 2, '2023-01-22', '2023-01-26', 'Anotación 22', 2),
('pendiente', 3, '2023-01-23', '2023-01-27', 'Anotación 23', 3),
('completado', 4, '2023-01-24', '2023-01-28', 'Anotación 24', 4),
('pendiente', 5, '2023-01-25', '2023-01-29', 'Anotación 25', 5),
('completado', 1, '2023-01-26', '2023-01-30', 'Anotación 26', 1),
('pendiente', 2, '2023-01-27', '2023-01-31', 'Anotación 27', 2),
('completado', 3, '2023-01-28', '2023-02-01', 'Anotación 28', 3),
('pendiente', 4, '2023-01-29', '2023-02-02', 'Anotación 29', 4),
('completado', 5, '2023-01-30', '2023-02-03', 'Anotación 30', 5),
('pendiente', 1, '2023-01-31', '2023-02-04', 'Anotación 31', 1),
('completado', 2, '2023-02-01', '2023-02-05', 'Anotación 32', 2),
('pendiente', 3, '2023-02-02', '2023-02-06', 'Anotación 33', 3),
('completado', 4, '2023-02-03', '2023-02-07', 'Anotación 34', 4),
('pendiente', 5, '2023-02-04', '2023-02-08', 'Anotación 35', 5),
('completado', 1, '2023-02-05', '2023-02-09', 'Anotación 36', 1),
('pendiente', 2, '2023-02-06', '2023-02-10', 'Anotación 37', 2),
('completado', 3, '2023-02-07', '2023-02-11', 'Anotación 38', 3),
('pendiente', 4, '2023-02-08', '2023-02-12', 'Anotación 39', 4),
('completado', 5, '2023-02-09', '2023-02-13', 'Anotación 40', 5),
('pendiente', 1, '2023-02-10', '2023-02-14', 'Anotación 41', 1),
('completado', 2, '2023-02-11', '2023-02-15', 'Anotación 42', 2),
('pendiente', 3, '2023-02-12', '2023-02-16', 'Anotación 43', 3),
('completado', 4, '2023-02-13', '2023-02-17', 'Anotación 44', 4),
('pendiente', 5, '2023-02-14', '2023-02-18', 'Anotación 45', 5),
('completado', 1, '2023-02-15', '2023-02-19', 'Anotación 46', 1),
('pendiente', 2, '2023-02-16', '2023-02-20', 'Anotación 47', 2),
('completado', 3, '2023-02-17', '2023-02-21', 'Anotación 48', 3),
('pendiente', 4, '2023-02-18', '2023-02-22', 'Anotación 49', 4),
('completado', 5, '2023-02-19', '2023-02-23', 'Anotación 50', 5);
