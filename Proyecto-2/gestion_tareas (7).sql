-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: mysql
-- Tiempo de generación: 09-03-2025 a las 11:15:45
-- Versión del servidor: 8.0.41
-- Versión de PHP: 8.2.27

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
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_manuel.diaz@example.com|127.0.0.1', 'i:3;', 1741120661),
('laravel_cache_manuel.diaz@example.com|127.0.0.1:timer', 'i:1741120661;', 1741120661);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int NOT NULL,
  `cif` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `telefono` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `correo` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `cuenta_corriente` varchar(24) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `pais` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `moneda` enum('EUR','USD','GBP') CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `importe_mensual` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `cif`, `nombre`, `telefono`, `correo`, `cuenta_corriente`, `pais`, `moneda`, `importe_mensual`) VALUES
(1, 'A12345633', 'Empresa A', '900123456', 'empresaA@example.com', 'ES9121000418450200051332', 'España', 'EUR', 1533.00),
(2, 'B87654321', 'Empresa B', '900654321', 'empresaB@example.com', 'GB29NWBK60161331926819', 'Reino Unido', 'GBP', 2500.00),
(3, 'C11223344', 'Empresa C', '900112233', 'empresaC@example.com', 'US021000021012312345678', 'Estados Unidos', 'USD', 3500.00),
(5, 'B87654321', 'Empresa B', '900654321', 'empresaB@example.com', 'GB29NWBK60161331926819', 'Reino Unido', 'GBP', 2500.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuotas`
--

CREATE TABLE `cuotas` (
  `id` int NOT NULL,
  `concepto` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `fecha_emision` datetime DEFAULT NULL,
  `importe` decimal(10,2) DEFAULT NULL,
  `pagado` tinyint(1) DEFAULT NULL,
  `fecha_pago` datetime DEFAULT NULL,
  `notas` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `cliente_id` int DEFAULT NULL,
  `empleado_id` int DEFAULT NULL,
  `tipo` enum('mensual','ordinaria','individual','extraordinaria','otra') CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `cuotas`
--

INSERT INTO `cuotas` (`id`, `concepto`, `fecha_emision`, `importe`, `pagado`, `fecha_pago`, `notas`, `cliente_id`, `empleado_id`, `tipo`) VALUES
(22, 'Servicio de mantenimiento', '2023-04-01 00:00:00', 500.00, 1, '2023-04-10 00:00:00', 'Mantenimiento mensual', 1, 4, 'mensual'),
(23, 'Instalación de software', '2023-04-05 00:00:00', 1200.00, 0, NULL, 'Instalación de ERP', 2, 5, 'ordinaria'),
(24, 'Reparación de equipo', '2023-04-10 00:00:00', 300.00, 1, '2023-04-15 00:00:00', 'Reparación de servidor', 3, 6, 'otra'),
(25, 'Prueba1', '2025-03-04 00:00:00', 250.00, 0, NULL, NULL, 1, NULL, 'mensual'),
(26, 'Prueab2', '2025-03-04 00:00:00', 33.00, 0, NULL, NULL, 3, NULL, 'mensual'),
(27, NULL, '2025-03-04 00:00:00', NULL, 0, NULL, NULL, 1, NULL, 'mensual'),
(41, 'asdasdas', '2025-03-05 00:00:00', 22.00, 1, '2025-09-04 00:00:00', NULL, 2, NULL, 'individual'),
(42, 'asdasdas', '2025-03-07 00:00:00', 11.00, 0, NULL, NULL, 3, NULL, 'mensual');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` int NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `dni` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `correo` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `telefono` varchar(15) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `direccion` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `fecha_alta` date DEFAULT NULL,
  `tipo` enum('operario','administrativo','ban') CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `user_id`, `dni`, `nombre`, `correo`, `telefono`, `direccion`, `fecha_alta`, `tipo`) VALUES
(4, 1, '12345678A', 'Juan Pérez', 'juan.perez@example.com', '600123486', 'Calle Falsa 123', '2023-01-15', 'operario'),
(5, 2, '87654321B', 'Ana Gómez', 'ana.gomez@example.com', '600654321', 'Avenida Real 456', '2023-02-20', 'administrativo'),
(6, 3, '11223344C', 'Carlos Ruiz', 'carlos.ruiz@example.com', '600112233', 'Plaza Mayor 789', '2023-03-25', 'operario'),
(7, 1, '12345678A', 'Juan Pérez', 'juan.perez@example.com', '600123456', 'Calle Falsa 123', '2023-01-15', 'operario'),
(9, 3, '11223344X', 'Carlos Ruiz', 'carlos.ruiz@example.com', '600112233', 'Plaza Mayor 789', '2023-03-25', 'operario'),
(14, 6, '12345678B', 'Fernando Nieves', 'fernandonieves180@gmail.com', '666333333', 'asasdasdasd', '2025-03-09', 'administrativo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_01_31_082314_add_user_id_to_empleados_table', 1),
(5, '2025_03_03_232337_update_fecha_emision_type_in_cuotas_table', 2),
(6, '2025_03_03_232537_convert_existing_fecha_emision_to_datetime', 2),
(7, '2025_03_04_000000_add_tipo_to_cuotas_table', 2),
(8, '2025_03_05_000000_add_google_id_to_users_table', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `id` int NOT NULL,
  `estado` enum('F','T','C','A','E') CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `operario_id` int DEFAULT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `fecha_finalizacion` date DEFAULT NULL,
  `anotaciones` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `cliente_id` int DEFAULT NULL,
  `fichero_resumen` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `fotos_trabajo` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `tareas`
--

INSERT INTO `tareas` (`id`, `estado`, `operario_id`, `fecha_creacion`, `fecha_finalizacion`, `anotaciones`, `cliente_id`, `fichero_resumen`, `fotos_trabajo`) VALUES
(8, 'T', 7, '2023-04-05', '2023-04-11', 'Tarea completada con éxito', 2, '/ruta/archivo2.pdf', '[\"/ruta/foto3.jpg\"]'),
(9, 'C', 6, '2023-04-10', '2023-04-15', 'Tarea cancelada por el cliente', 3, '/ruta/archivo3.pdf', '[]'),
(10, 'T', 6, '2025-02-05', NULL, 'Prueba 33', 5, 'resumenes/UQt0Kl5C3feU9Ocb9NCyqhfXeyDOOGuuYUZif07j.pdf', '[\"fotos_trabajo/17qXKpvDNOoyc4BHcI97paGmNuX3Ybu19kxuU3WU.jpg\", \"fotos_trabajo/HFVXLhL96qgZDdUW93CTsZn9VAUmc7YYRO2bzhTA.jpg\"]'),
(13, 'C', 9, '2025-02-11', NULL, 'Rellenar', 3, NULL, NULL),
(14, 'C', 9, '2025-02-11', NULL, 'Rellenar', 3, NULL, NULL),
(15, 'T', 9, '2025-02-11', '2024-01-02', 'Rellenar', 3, NULL, NULL),
(16, 'C', 9, '2025-02-11', NULL, 'Rellenar', 3, NULL, NULL),
(17, 'C', 9, '2025-02-11', NULL, 'Rellenar', 3, NULL, NULL),
(18, 'C', 9, '2025-02-11', NULL, 'Rellenar', 3, NULL, NULL),
(23, 'E', 6, '2025-02-25', NULL, 'Prueba1111', 2, 'resumenes/9s8mXPc81qqybbZ8BHmCPP0SpcUufkiq1iNOQYMR.pdf', '\"[\\\"fotos_trabajo\\\\/908m3HTIAwj8VvkbMSylXlpnPUFulHZHtjPlpVaW.jpg\\\"]\"'),
(24, 'T', 4, '2025-03-07', '2025-01-01', 'iuhui', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `google_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Juan Pérez', 'juan.perez@example.com', NULL, '$2y$12$XquN8MUoiLj0i4oJy.0PzuV/lpkHOJ/GNNdZO3.8JehI8opuRR77G', NULL, 'DqK3gTApT9cWXy0SJlxIVPD4Om4w5G7ZnRPKOMujWSRqMswaIWiGJLkN6DfS', '2025-02-05 08:14:06', '2025-02-05 08:26:56'),
(2, 'Ana Gómez', 'ana.gomez@example.com', NULL, '$2y$12$N7Uekfs/45gS7w.QS8sTyeh4Atv3wVilU06DsLI8VaaEaEw8Oxxke', NULL, NULL, '2025-02-05 08:14:06', '2025-02-19 08:32:52'),
(3, 'Carlos Ruiz', 'carlos.ruiz@example.com', NULL, '$2y$12$MQ2cqEbtQ5aSwzQfFv5XXOpvFCi8QIeBuVMzVyiqsY0DqVxY4W16G', NULL, NULL, '2025-02-05 08:14:06', '2025-03-06 07:39:45'),
(6, 'Fernando Nieves', 'fernandonieves180@gmail.com', NULL, '$2y$12$FQ6z5iqecmm1mEJOEbJxceSowWXaYmjsj1iKtjPpfvOjso/fVc3xu', NULL, 'Wej8rpWMsHmJpfoD8DTktjCCyArwtAHRC8jLFrfo2O7mGFhw95wxjBUR1ftu', '2025-03-09 10:50:14', '2025-03-09 10:55:57');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cuotas`
--
ALTER TABLE `cuotas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `empleado_id` (`empleado_id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `empleados_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`),
  ADD KEY `operario_id` (`operario_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `cuotas`
--
ALTER TABLE `cuotas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tareas`
--
ALTER TABLE `tareas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cuotas`
--
ALTER TABLE `cuotas`
  ADD CONSTRAINT `cuotas_ibfk_1` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `cuotas_ibfk_2` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `empleados_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Filtros para la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD CONSTRAINT `tareas_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `tareas_ibfk_2` FOREIGN KEY (`operario_id`) REFERENCES `empleados` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
