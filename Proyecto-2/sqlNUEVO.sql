-- Eliminamos tabla si existe
DROP TABLE IF EXISTS tarea;

DROP TABLE IF EXISTS cargos;

DROP TABLE IF EXISTS empleados;

DROP TABLE IF EXISTS clientes;

CREATE TABLE
    empleados (
        id INT PRIMARY KEY AUTO_INCREMENT,
        dni VARCHAR(10),
        nombre VARCHAR(100),
        correo VARCHAR(100),
        telefono VARCHAR(15),
        direccion VARCHAR(100),
        fecha_alta DATE,
        tipo ENUM ('operario', 'administrativo')
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
        importe_mensual DECIMAL(10, 2)
    );

CREATE TABLE
    cargos (
        id INT PRIMARY KEY AUTO_INCREMENT,
        concepto VARCHAR(100),
        fecha_emision DATE,
        importe DECIMAL(10, 2),
        pagado BOOLEAN,
        fecha_pago DATE,
        notas TEXT,
        cliente_id INT,
        empleado_id INT,
        FOREIGN KEY (empleado_id) REFERENCES empleados (id),
        FOREIGN KEY (cliente_id) REFERENCES clientes (id)
    );

CREATE TABLE
    tareas (
        id INT PRIMARY KEY AUTO_INCREMENT,
        estado ENUM ('F', 'T', 'C', 'A', 'E'),
        operario_id INT,
        fecha_creacion DATE,
        fecha_finalizacion DATE,
        anotaciones TEXT,
        cliente_id INT,
        fichero_resumen VARCHAR(255), -- Para almacenar rutas de archivos
        fotos_trabajo JSON, -- Para múltiples rutas o JSON
        FOREIGN KEY (cliente_id) REFERENCES clientes (id),
        FOREIGN KEY (operario_id) REFERENCES empleados (id) -- Corregido el nombre de la columna
    );

CREATE TABLE
    users (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(255),
        email VARCHAR(255) UNIQUE,
        email_verified_at TIMESTAMP NULL,
        password VARCHAR(255),
        remember_token VARCHAR(100) NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );

INSERT INTO
    users (name, email, password, created_at, updated_at)
VALUES
    (
        'Juan Pérez',
        'juan.perez@example.com',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        NOW (),
        NOW ()
    ), -- password: password
    (
        'Ana Gómez',
        'ana.gomez@example.com',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        NOW (),
        NOW ()
    ), -- password: password
    (
        'Carlos Ruiz',
        'carlos.ruiz@example.com',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        NOW (),
        NOW ()
    );

-- password: password
-- Insertamos datos de prueba
INSERT INTO
    empleados (
        dni,
        nombre,
        correo,
        telefono,
        direccion,
        fecha_alta,
        tipo,
        user_id
    )
VALUES
    (
        '12345678A',
        'Juan Pérez',
        'juan.perez@example.com',
        '600123456',
        'Calle Falsa 123',
        '2023-01-15',
        'operario',
        1
    ),
    (
        '87654321B',
        'Ana Gómez',
        'ana.gomez@example.com',
        '600654321',
        'Avenida Real 456',
        '2023-02-20',
        'administrativo',
        2
    ),
    (
        '11223344C',
        'Carlos Ruiz',
        'carlos.ruiz@example.com',
        '600112233',
        'Plaza Mayor 789',
        '2023-03-25',
        'operario',
        3
    );

INSERT INTO
    clientes (
        cif,
        nombre,
        telefono,
        correo,
        cuenta_corriente,
        pais,
        moneda,
        importe_mensual
    )
VALUES
    (
        'A12345678',
        'Empresa A',
        '900123456',
        'empresaA@example.com',
        'ES9121000418450200051332',
        'España',
        'EUR',
        1500.00
    ),
    (
        'B87654321',
        'Empresa B',
        '900654321',
        'empresaB@example.com',
        'GB29NWBK60161331926819',
        'Reino Unido',
        'GBP',
        2500.00
    ),
    (
        'C11223344',
        'Empresa C',
        '900112233',
        'empresaC@example.com',
        'US021000021012312345678',
        'Estados Unidos',
        'USD',
        3500.00
    );

INSERT INTO
    cargos (
        concepto,
        fecha_emision,
        importe,
        pagado,
        fecha_pago,
        notas,
        cliente_id,
        empleado_id
    )
VALUES
    (
        'Servicio de mantenimiento',
        '2023-04-01',
        500.00,
        TRUE,
        '2023-04-10',
        'Mantenimiento mensual',
        1,
        1
    ),
    (
        'Instalación de software',
        '2023-04-05',
        1200.00,
        FALSE,
        NULL,
        'Instalación de ERP',
        2,
        2
    ),
    (
        'Reparación de equipo',
        '2023-04-10',
        300.00,
        TRUE,
        '2023-04-15',
        'Reparación de servidor',
        3,
        3
    );

INSERT INTO
    tareas (
        estado,
        operario_id,
        fecha_creacion,
        fecha_finalizacion,
        anotaciones,
        cliente_id,
        fichero_resumen,
        fotos_trabajo
    )
VALUES
    (
        'F',
        1,
        '2023-04-01',
        NULL,
        'Tarea pendiente de revisión',
        1,
        '/ruta/archivo1.pdf',
        '["/ruta/foto1.jpg", "/ruta/foto2.jpg"]'
    ),
    (
        'T',
        2,
        '2023-04-05',
        '2023-04-10',
        'Tarea completada con éxito',
        2,
        '/ruta/archivo2.pdf',
        '["/ruta/foto3.jpg"]'
    ),
    (
        'C',
        3,
        '2023-04-10',
        '2023-04-15',
        'Tarea cancelada por el cliente',
        3,
        '/ruta/archivo3.pdf',
        '[]'
    );