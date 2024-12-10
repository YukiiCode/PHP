-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-12-2024 a las 10:21:38
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestion_tareas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `id` int(11) NOT NULL,
  `nif_cif` varchar(20) NOT NULL,
  `persona_contacto` varchar(100) NOT NULL,
  `telefono_contacto` varchar(20) NOT NULL,
  `descripcion` text NOT NULL,
  `correo_contacto` varchar(100) NOT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `poblacion` varchar(100) DEFAULT NULL,
  `codigo_postal` varchar(5) DEFAULT NULL,
  `provincia` int(11) DEFAULT NULL,
  `estado` enum('B','P','R','C') DEFAULT 'B',
  `fecha_creacion` date DEFAULT curdate(),
  `operario_encargado` varchar(100) DEFAULT NULL,
  `fecha_realizacion` date DEFAULT NULL,
  `anotaciones_anteriores` text DEFAULT NULL,
  `anotaciones_posteriores` text DEFAULT NULL,
  `fichero_resumen` varchar(255) DEFAULT NULL,
  `fotos_trabajo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Estructura de tabla para la tabla `provincias`
--

CREATE TABLE `provincias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `tareas`
--

INSERT INTO `tareas` (`id`, `nif_cif`, `persona_contacto`, `telefono_contacto`, `descripcion`, `correo_contacto`, `direccion`, `poblacion`, `codigo_postal`, `provincia`, `estado`, `fecha_creacion`, `operario_encargado`, `fecha_realizacion`, `anotaciones_anteriores`, `anotaciones_posteriores`, `fichero_resumen`, `fotos_trabajo`) VALUES
(1, '12345678A', 'Juan Pérez', '600123456', 'Reparación de pared en oficina', 'juan.perez@example.com', 'Calle Mayor 1', 'Madrid', '28001', 28, 'P', '2024-11-12', 'Carlos Martínez', '2024-12-01', 'La pared tiene grietas visibles', 'Trabajo realizado sin incidencias', 'resumen_123.pdf', 'foto_123.jpg'),
(2, '87654321B', 'Ana García', '600654321', 'Instalación de aire acondicionado', 'ana.garcia@example.com', 'Avenida de la Luz 15', 'Sevilla', '41001', 41, 'B', '2024-11-12', 'Luis Gómez', '2024-12-10', 'Se necesita revisar el espacio para la unidad exterior', '', '', ''),
(3, '11223344C', 'Pedro López', '600987654', 'Pintura de fachada', 'pedro.lopez@example.com', 'Plaza del Sol 8', 'Valencia', '46001', 46, 'R', '2024-11-12', 'María Sánchez', '2024-11-15', 'Usar pintura resistente a la intemperie', 'Fachada pintada con éxito', 'resumen_456.pdf', 'foto_456.jpg'),
(4, '55667788D', 'Laura Morales', '612345678', 'Cambio de tuberías en cocina', 'laura.morales@example.com', 'Calle Luna 23', 'Barcelona', '08001', 8, 'P', '2024-11-12', 'Raúl Fernández', '2024-12-05', 'Reemplazar tuberías oxidadas', 'Tuberías reemplazadas correctamente', 'resumen_789.pdf', 'foto_789.jpg'),
(5, '99887766E', 'José Ramírez', '622987654', 'Instalación de sistema eléctrico', 'jose.ramirez@example.com', 'Calle Estrella 10', 'Bilbao', '48001', 48, 'B', '2024-11-12', 'Andrés Muñoz', '2024-12-12', 'Requiere revisión de cables antiguos', '', '', ''),
(6, '33445566F', 'Elena Rodríguez', '634123456', 'Impermeabilización de tejado', 'elena.rodriguez@example.com', 'Calle Río 45', 'Granada', '18001', 18, 'C', '2024-11-12', 'Pablo Ortega', '2024-11-30', 'Necesario revisar grietas previas', 'Trabajo cancelado por cliente', '', ''),
(7, '44556677G', 'Manuel Díaz', '641234567', 'Reforma de baño', 'manuel.diaz@example.com', 'Av. Central 102', 'Zaragoza', '50001', 50, 'R', '2024-11-12', 'Raúl Fernández', '2024-11-20', 'Cambiar azulejos y grifos', 'Reforma completada exitosamente', 'resumen_321.pdf', 'foto_321.jpg'),
(8, '22334455H', 'Clara Ruiz', '653456789', 'Mantenimiento de jardín', 'clara.ruiz@example.com', 'Paseo de la Alameda 5', 'Valencia', '46002', 46, 'P', '2024-11-12', 'Luis Gómez', '2024-12-15', 'Revisar sistema de riego', '', '', '');

--
-- Volcado de datos para la tabla `provincias`
--

INSERT INTO `provincias` (`id`, `nombre`) VALUES
(1, 'Álava'),
(2, 'Albacete'),
(3, 'Alicante'),
(4, 'Almería'),
(5, 'Asturias'),
(6, 'Ávila'),
(7, 'Badajoz'),
(8, 'Barcelona'),
(9, 'Burgos'),
(10, 'Cáceres'),
(11, 'Cádiz'),
(12, 'Cantabria'),
(13, 'Castellón'),
(14, 'Ciudad Real'),
(15, 'Córdoba'),
(16, 'Cuenca'),
(17, 'Girona'),
(18, 'Granada'),
(19, 'Guadalajara'),
(20, 'Guipúzcoa'),
(21, 'Huelva'),
(22, 'Huesca'),
(23, 'Islas Baleares'),
(24, 'Jaén'),
(25, 'La Coruña'),
(26, 'La Rioja'),
(27, 'Las Palmas'),
(28, 'León'),
(29, 'Lleida'),
(30, 'Lugo'),
(31, 'Madrid'),
(32, 'Málaga'),
(33, 'Murcia'),
(34, 'Navarra'),
(35, 'Ourense'),
(36, 'Palencia'),
(37, 'Pontevedra'),
(38, 'Salamanca'),
(39, 'Santa Cruz de Tenerife'),
(40, 'Segovia'),
(41, 'Sevilla'),
(42, 'Soria'),
(43, 'Tarragona'),
(44, 'Teruel'),
(45, 'Toledo'),
(46, 'Valencia'),
(47, 'Valladolid'),
(48, 'Vizcaya'),
(49, 'Zamora'),
(50, 'Zaragoza');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tareas`
--
ALTER TABLE `tareas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Claves foráneas para la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD CONSTRAINT `fk_provincia`
  FOREIGN KEY (`provincia`) REFERENCES `provincias`(`id`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



-- Tabla usuarios (esta query debe funcionar  $sql = "SELECT id,nombre_usuario FROM usuarios WHERE tipo_usuario = 'Operario'";)

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_usuario` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tipo_usuario` enum('Administrador','Operario') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcado de datos para la tabla `usuarios`
INSERT  INTO `usuarios`(`id`,`nombre_usuario`,`email`,`password`,`tipo_usuario`) VALUES
(1, 'admin', 'admin@example.com', 'password', 'Administrador'),
(2, 'operario1', 'operario1@example.com', 'password', 'Operario'),
(3, 'operario2', 'operario2@example.com', 'password', 'Operario'),

