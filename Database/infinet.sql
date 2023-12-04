-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-12-2023 a las 08:02:29
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `infinet`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `document` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `state` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `clients`
--

INSERT INTO `clients` (`id`, `first_name`, `last_name`, `document`, `phone`, `email`, `state`) VALUES
(439, 'María Patricia', 'Gómez', '40608070', '551-5678', 'maria@example.com', '1'),
(440, 'Carlos', 'López', '10205090', '555-9876', 'carlos@example.com', '0'),
(441, 'Ana', 'Rodríguez', '4567898123', '555-4321', 'ana@example.com', '1'),
(442, 'Pedro', 'Sánchez', '5678901234', '555-8765', 'pedro@example.com', '0'),
(443, 'Laura', 'Torres', '80784563', '555-3210', 'laura@example.com', '0'),
(444, 'Miguel', 'Hernández', '45622511', '555-6543', 'miguel@example.com', '0'),
(445, 'Sofía', 'Díaz', '8101234567', '555-2109', 'sofia@example.com', '0'),
(446, 'Alejandro', 'Martínez', '40409897', '345606262', 'alejandro@example.com', '0'),
(447, 'Carmen', 'García', '0123426789', '555-8775', 'carmen@example.com', '1'),
(448, 'David', 'Ruiz', '1234509876', '555-9321', 'david@example.com', '1'),
(449, 'Elena', 'López', '2345670987', '555-7654', 'elena@example.com', '1'),
(450, 'Francisco', 'Gómez', '3456789012', '555-2345', 'francisco@example.com', '1'),
(451, 'Isabel', 'Martínez', '4567890123', '554-5678', 'isabel@example.com', '1'),
(452, 'Javier', 'Hernández', '1678901234', '555-8901', 'javier@example.com', '1'),
(453, 'Luisa', 'Sánchez', '6789012345', '555-1234', 'luisa@example.com', '1'),
(454, 'Manuel', 'Torres', '7890123456', '555-4567', 'manuel@example.com', '0'),
(455, 'Natalia', 'Díaz', '8901234567', '555-7890', 'natalia@example.com', '0'),
(456, 'Oscar', 'García', '9012345678', '535-2345', 'oscar@example.com', '0'),
(457, 'Patricia', 'Ruiz', '0123456789', '555-5678', 'patricia@example.com', '0'),
(474, 'Marcos', 'Azambuya', '23568947', '+54 3459656789', 'marcos.azambuya@gmail.com', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `client_services`
--

CREATE TABLE `client_services` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `state` enum('0','1','2','3') NOT NULL,
  `hire_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `installation` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `client_services`
--

INSERT INTO `client_services` (`id`, `client_id`, `service_id`, `address`, `state`, `hire_date`, `installation`) VALUES
(35, 443, 2, 'Corrientes, Mercedes, Salta 300', '1', '2023-11-01 03:11:00', '0'),
(36, 439, 2, 'Entre Rios, Concordia, Corrientes 205', '1', '2023-11-01 04:17:51', '1'),
(37, 439, 4, 'Entre Rios, Concordia, San Lorenzo 564', '1', '2023-11-01 06:11:02', '1'),
(38, 440, 1, 'Entre Rios, Paso de los Libres, Entre Rios 23', '0', '2023-10-01 06:19:29', '1'),
(39, 440, 12, 'Entre Rios, Concordia, Entre Rios 78', '0', '2023-10-10 06:20:02', '1'),
(40, 441, 1, 'Entre Rios, Concordia, Moulins 1460', '3', '2023-11-01 06:50:02', '1'),
(41, 441, 2, 'Entre Rios, Concordia, Santa Maria de Oro 75', '2', '2023-12-04 06:52:57', '0'),
(42, 441, 2, 'Entre Rios, Villaguay, Villaguay 200', '2', '2023-12-04 06:56:53', '0'),
(43, 447, 2, 'Entre Rios, Concordia, Chabrillon 230', '2', '2023-12-04 06:58:49', '0'),
(44, 474, 10, 'Entre Rios, Concordia, Feliciano 1584', '2', '2023-12-04 07:00:40', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `issue_date` date NOT NULL,
  `due_date` date NOT NULL,
  `client_service_id` int(11) NOT NULL,
  `type` int(11) NOT NULL CHECK (`type` between 0 and 4),
  `price_service` decimal(10,2) NOT NULL,
  `price_installation` decimal(10,2) DEFAULT NULL,
  `surcharge` decimal(10,2) DEFAULT NULL,
  `state` int(11) NOT NULL CHECK (`state` between 0 and 3)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `purchase_order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` decimal(11,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `stock` decimal(10,2) DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `id` int(11) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `description` text DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `upload_speed` int(11) NOT NULL,
  `download_speed` int(11) NOT NULL,
  `monthly_fee` decimal(10,2) NOT NULL,
  `installation_fee` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `services`
--

INSERT INTO `services` (`service_id`, `name`, `type`, `upload_speed`, `download_speed`, `monthly_fee`, `installation_fee`) VALUES
(1, 'Plan Residencial', 'Fibra Óptica', 100, 500, '4999.99', '2490.99'),
(2, 'Plan Básico', 'Cable', 50, 250, '2990.95', '1990.95'),
(4, 'Plan Premium', 'Fibra Óptica', 500, 1000, '6990.99', '2990.99'),
(5, 'Plan Empresarial', 'Fibra Óptica', 1000, 2000, '8990.95', '3990.95'),
(6, 'Plan Estándar', 'Cable', 100, 500, '3490.50', '2490.50'),
(8, 'Plan Velocidad Extrema', 'Fibra Óptica', 1000, 3000, '9990.95', '4990.95'),
(9, 'Plan Esencial', 'Cable', 25, 100, '1990.50', '1490.50'),
(10, 'Plan de Oficina', 'Fibra Óptica', 500, 1000, '7990.99', '3490.99'),
(11, 'Plan Avanzado', 'Fibra Óptica', 750, 1500, '5990.95', '2990.95'),
(12, 'Plan de Negocios', 'Cable', 200, 800, '4490.50', '1990.50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `technical_requests`
--

CREATE TABLE `technical_requests` (
  `id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `problem` text DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `type` int(11) DEFAULT NULL,
  `client_service_id` int(11) DEFAULT NULL,
  `technician_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `technical_requests`
--

INSERT INTO `technical_requests` (`id`, `description`, `problem`, `status`, `date_created`, `type`, `client_service_id`, `technician_id`) VALUES
(25, 'Instalacion de nuevo servicio', 'Instalacion pendiente', 1, '2023-12-04 04:17:51', 0, 36, 5),
(26, 'Instalacion de nuevo servicio', 'Instalacion pendiente', 1, '2023-12-04 06:11:02', 0, 37, 2),
(27, 'Problemas de conexion', 'Microcortes del servicio', 3, '2023-12-04 06:12:58', 1, 37, NULL),
(28, 'Instalacion de nuevo servicio', 'Instalacion pendiente', 1, '2023-12-04 06:19:29', 0, 38, 2),
(29, 'Instalacion de nuevo servicio', 'Instalacion pendiente', 1, '2023-12-04 06:20:02', 0, 39, 2),
(30, 'Instalacion de nuevo servicio', 'Instalacion pendiente', 1, '2023-12-04 06:50:02', 0, 40, 2),
(31, 'Instalacion de nuevo servicio', 'Instalacion pendiente', 3, '2023-12-04 06:52:57', 0, 41, NULL),
(32, 'Instalacion de nuevo servicio', 'Instalacion pendiente', 3, '2023-12-04 06:56:53', 0, 42, NULL),
(33, 'Instalacion de nuevo servicio', 'Instalacion pendiente', 3, '2023-12-04 06:58:49', 0, 43, NULL),
(34, 'Instalacion de nuevo servicio', 'Instalacion pendiente', 1, '2023-12-04 07:00:40', 0, 44, 5),
(35, 'Desperfecto en la instalacion', 'Cableado flojo', 3, '2023-12-04 07:01:50', 1, 44, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `technical_request_details`
--

CREATE TABLE `technical_request_details` (
  `id` int(11) NOT NULL,
  `technical_request_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity_used` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `employee_number` char(6) NOT NULL,
  `employee_password` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `role` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `employee_number`, `employee_password`, `first_name`, `last_name`, `email`, `phone`, `role`) VALUES
(1, '000001', '$2y$10$b/ttxESXDW6kzy3TH8ttP.zi9450Txm71GvQtsnXI.AzNw/VFcpNu', 'Juan', 'González', 'usuario1@example.com', '1234567890', 1),
(2, '000002', '$2y$10$wN.YxAsGNcyi3nq9WTMGru0iAKa1sdkfRN2KC83Q6EjGtLqcY1HhC', 'María', 'Martínez', 'usuario2@example.com', '2345678901', 2),
(3, '000003', '$2y$10$XxxEBmiJGC7cwx1pSUEBru1geXilta14U3nNohF9wGB2NXlrmfvmi', 'Carlos', 'López', 'usuario3@example.com', '3456789012', 3),
(4, '000004', '$2y$10$8QiJw4mpRmLYZjHP.lh/CemdwS546zey1CRk0riCyEZ.gjj9M15.y', 'Isabel', 'Rodríguez', 'usuario4@example.com', '4567890123', 1),
(5, '000005', '$2y$10$phFgg5pV7J1ndBk4ft7Vw.ho2RvU/G6mFuhu7UD0SomhkGE2DG2k2', 'Antonio', 'Sánchez', 'usuario5@example.com', '5678901234', 2),
(6, '000006', '$2y$10$6jB3JfDv0jemNFvnyQUb9.E2P1RMtf16L1rq7.PV3LI80Q.KY0N7O', 'Ana', 'Pérez', 'usuario6@example.com', '6789012345', 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `document` (`document`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `client_services`
--
ALTER TABLE `client_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indices de la tabla `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_service_id` (`client_service_id`);

--
-- Indices de la tabla `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_order_id` (`purchase_order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_purchase_orders_users` (`user_id`);

--
-- Indices de la tabla `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indices de la tabla `technical_requests`
--
ALTER TABLE `technical_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_service_id` (`client_service_id`),
  ADD KEY `technician_id` (`technician_id`);

--
-- Indices de la tabla `technical_request_details`
--
ALTER TABLE `technical_request_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `technical_request_id` (`technical_request_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=475;

--
-- AUTO_INCREMENT de la tabla `client_services`
--
ALTER TABLE `client_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT de la tabla `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `technical_requests`
--
ALTER TABLE `technical_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `technical_request_details`
--
ALTER TABLE `technical_request_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `client_services`
--
ALTER TABLE `client_services`
  ADD CONSTRAINT `client_services_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `client_services_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`);

--
-- Filtros para la tabla `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`client_service_id`) REFERENCES `client_services` (`id`);

--
-- Filtros para la tabla `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Filtros para la tabla `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD CONSTRAINT `fk_purchase_orders_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `technical_requests`
--
ALTER TABLE `technical_requests`
  ADD CONSTRAINT `technical_requests_ibfk_1` FOREIGN KEY (`client_service_id`) REFERENCES `client_services` (`id`),
  ADD CONSTRAINT `technical_requests_ibfk_2` FOREIGN KEY (`technician_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `technical_request_details`
--
ALTER TABLE `technical_request_details`
  ADD CONSTRAINT `technical_request_details_ibfk_1` FOREIGN KEY (`technical_request_id`) REFERENCES `technical_requests` (`id`),
  ADD CONSTRAINT `technical_request_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
