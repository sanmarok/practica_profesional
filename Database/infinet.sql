-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-11-2023 a las 07:54:14
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
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `document` varchar(20) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `state` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `clients`
--

INSERT INTO `clients` (`id`, `first_name`, `last_name`, `document`, `phone`, `email`, `state`) VALUES
(1, 'Nombre1', 'Apellido1', 'Documento1', '1234567891', 'cliente1@example.com', 1),
(2, 'Nombre2', 'Apellido2', 'Documento2', '1234567892', 'cliente2@example.com', 0),
(3, 'Nombre3', 'Apellido3', 'Documento3', '1234567893', 'cliente3@example.com', 1),
(4, 'Nombre4', 'Apellido4', 'Documento4', '1234567894', 'cliente4@example.com', 1),
(5, 'Nombre5', 'Apellido5', 'Documento5', '1234567895', 'cliente5@example.com', 0),
(6, 'Nombre6', 'Apellido6', 'Documento6', '1234567896', 'cliente6@example.com', 1),
(7, 'Nombre7', 'Apellido7', 'Documento7', '1234567897', 'cliente7@example.com', 0),
(8, 'Nombre8', 'Apellido8', 'Documento8', '1234567898', 'cliente8@example.com', 1),
(9, 'Nombre9', 'Apellido9', 'Documento9', '1234567899', 'cliente9@example.com', 1),
(10, 'Nombre10', 'Apellido10', 'Documento10', '12345678910', 'cliente10@example.com', 0),
(11, 'Nombre11', 'Apellido11', 'Documento11', '12345678911', 'cliente11@example.com', 0),
(12, 'Nombre12', 'Apellido12', 'Documento12', '12345678912', 'cliente12@example.com', 1),
(13, 'Nombre13', 'Apellido13', 'Documento13', '12345678913', 'cliente13@example.com', 0),
(14, 'Nombre14', 'Apellido14', 'Documento14', '12345678914', 'cliente14@example.com', 0),
(15, 'Nombre15', 'Apellido15', 'Documento15', '12345678915', 'cliente15@example.com', 1),
(16, 'Nombre16', 'Apellido16', 'Documento16', '12345678916', 'cliente16@example.com', 0),
(17, 'Nombre17', 'Apellido17', 'Documento17', '12345678917', 'cliente17@example.com', 0),
(18, 'Nombre18', 'Apellido18', 'Documento18', '12345678918', 'cliente18@example.com', 1),
(19, 'Nombre19', 'Apellido19', 'Documento19', '12345678919', 'cliente19@example.com', 1),
(20, 'Nombre20', 'Apellido20', 'Documento20', '12345678920', 'cliente20@example.com', 0),
(21, 'Nombre21', 'Apellido21', 'Documento21', '12345678921', 'cliente21@example.com', 1),
(22, 'Nombre22', 'Apellido22', 'Documento22', '12345678922', 'cliente22@example.com', 0),
(23, 'Nombre23', 'Apellido23', 'Documento23', '12345678923', 'cliente23@example.com', 1),
(24, 'Nombre24', 'Apellido24', 'Documento24', '12345678924', 'cliente24@example.com', 0),
(25, 'Nombre25', 'Apellido25', 'Documento25', '12345678925', 'cliente25@example.com', 0),
(26, 'Nombre26', 'Apellido26', 'Documento26', '12345678926', 'cliente26@example.com', 0),
(27, 'Nombre27', 'Apellido27', 'Documento27', '12345678927', 'cliente27@example.com', 0),
(28, 'Nombre28', 'Apellido28', 'Documento28', '12345678928', 'cliente28@example.com', 0),
(29, 'Nombre29', 'Apellido29', 'Documento29', '12345678929', 'cliente29@example.com', 0),
(30, 'Nombre30', 'Apellido30', 'Documento30', '12345678930', 'cliente30@example.com', 1),
(31, 'Nombre31', 'Apellido31', 'Documento31', '12345678931', 'cliente31@example.com', 1),
(32, 'Nombre32', 'Apellido32', 'Documento32', '12345678932', 'cliente32@example.com', 1),
(33, 'Nombre33', 'Apellido33', 'Documento33', '12345678933', 'cliente33@example.com', 1),
(34, 'Nombre34', 'Apellido34', 'Documento34', '12345678934', 'cliente34@example.com', 1),
(35, 'Nombre35', 'Apellido35', 'Documento35', '12345678935', 'cliente35@example.com', 0),
(36, 'Nombre36', 'Apellido36', 'Documento36', '12345678936', 'cliente36@example.com', 0),
(37, 'Nombre37', 'Apellido37', 'Documento37', '12345678937', 'cliente37@example.com', 1),
(38, 'Nombre38', 'Apellido38', 'Documento38', '12345678938', 'cliente38@example.com', 0),
(39, 'Nombre39', 'Apellido39', 'Documento39', '12345678939', 'cliente39@example.com', 0),
(40, 'Nombre40', 'Apellido40', 'Documento40', '12345678940', 'cliente40@example.com', 0),
(41, 'Nombre41', 'Apellido41', 'Documento41', '12345678941', 'cliente41@example.com', 0),
(42, 'Nombre42', 'Apellido42', 'Documento42', '12345678942', 'cliente42@example.com', 0),
(43, 'Nombre43', 'Apellido43', 'Documento43', '12345678943', 'cliente43@example.com', 1),
(44, 'Nombre44', 'Apellido44', 'Documento44', '12345678944', 'cliente44@example.com', 0),
(45, 'Nombre45', 'Apellido45', 'Documento45', '12345678945', 'cliente45@example.com', 0),
(46, 'Nombre46', 'Apellido46', 'Documento46', '12345678946', 'cliente46@example.com', 1),
(47, 'Nombre47', 'Apellido47', 'Documento47', '12345678947', 'cliente47@example.com', 1),
(48, 'Nombre48', 'Apellido48', 'Documento48', '12345678948', 'cliente48@example.com', 1),
(49, 'Nombre49', 'Apellido49', 'Documento49', '12345678949', 'cliente49@example.com', 1),
(50, 'Nombre50', 'Apellido50', 'Documento50', '12345678950', 'cliente50@example.com', 1),
(56, 'Santiago', 'Martinez', '4040404040', '+54 9 3456 26-8262', 'san.martinezok@gmail.com', 1),
(57, 'Santiago', 'Martinez', '4040404040', '+54 9 3456 26-8262', 'san.martinezok@gmail.com', 1),
(58, 'sadas', 'dasda', 'dasdas', 'dasdas', 'dasdas', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `client_services`
--

CREATE TABLE `client_services` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `state` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `client_services`
--

INSERT INTO `client_services` (`id`, `client_id`, `service_id`, `address`, `state`) VALUES
(1, 1, 1, 'Dirección del Servicio 1', 1),
(2, 1, 2, 'Dirección del Servicio 2', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `issue_date` date NOT NULL,
  `due_date` date NOT NULL,
  `client_service_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `price_service` decimal(10,2) NOT NULL,
  `price_installation` decimal(10,2) DEFAULT NULL,
  `surcharge` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `invoices`
--

INSERT INTO `invoices` (`id`, `issue_date`, `due_date`, `client_service_id`, `type`, `price_service`, `price_installation`, `surcharge`) VALUES
(3, '2023-11-07', '2023-12-07', 1, 1, '4999.99', '2490.99', '5.00');

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
  `type` varchar(255) DEFAULT NULL,
  `upload_speed` int(11) DEFAULT NULL,
  `download_speed` int(11) DEFAULT NULL,
  `monthly_fee` decimal(10,2) DEFAULT NULL,
  `installation_fee` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `services`
--

INSERT INTO `services` (`service_id`, `name`, `type`, `upload_speed`, `download_speed`, `monthly_fee`, `installation_fee`) VALUES
(1, 'Plan Residencial', 'Fibra Óptica', 100, 500, '4999.99', '2490.99'),
(2, 'Plan Básico', 'Cable', 50, 250, '2990.95', '1990.95'),
(3, 'Plan Satelital', 'Satélite', 20, 100, '3990.50', '1990.50'),
(4, 'Plan Premium', 'Fibra Óptica', 500, 1000, '6990.99', '2990.99'),
(5, 'Plan Empresarial', 'Fibra Óptica', 1000, 2000, '8990.95', '3990.95'),
(6, 'Plan Estándar', 'Cable', 100, 500, '3490.50', '2490.50'),
(7, 'Plan Telefónico', 'Teléfono', 10, 20, '1990.99', '990.99'),
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
(1, '000001', '$2y$10$b/ttxESXDW6kzy3TH8ttP.zi9450Txm71GvQtsnXI.AzNw/VFcpNu', 'Nombre1', 'Apellido1', 'usuario1@example.com', '1234567890', 1),
(2, '000002', '$2y$10$wN.YxAsGNcyi3nq9WTMGru0iAKa1sdkfRN2KC83Q6EjGtLqcY1HhC', 'Nombre2', 'Apellido2', 'usuario2@example.com', '2345678901', 2),
(3, '000003', '$2y$10$XxxEBmiJGC7cwx1pSUEBru1geXilta14U3nNohF9wGB2NXlrmfvmi', 'Nombre3', 'Apellido3', 'usuario3@example.com', '3456789012', 3),
(4, '000004', '$2y$10$8QiJw4mpRmLYZjHP.lh/CemdwS546zey1CRk0riCyEZ.gjj9M15.y', 'Nombre4', 'Apellido4', 'usuario4@example.com', '4567890123', 1),
(5, '000005', '$2y$10$phFgg5pV7J1ndBk4ft7Vw.ho2RvU/G6mFuhu7UD0SomhkGE2DG2k2', 'Nombre5', 'Apellido5', 'usuario5@example.com', '5678901234', 2),
(6, '000006', '$2y$10$6jB3JfDv0jemNFvnyQUb9.E2P1RMtf16L1rq7.PV3LI80Q.KY0N7O', 'Nombre6', 'Apellido6', 'usuario6@example.com', '6789012345', 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `fk_service_price` (`client_service_id`);

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
  ADD PRIMARY KEY (`service_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de la tabla `client_services`
--
ALTER TABLE `client_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  ADD CONSTRAINT `fk_service_price` FOREIGN KEY (`client_service_id`) REFERENCES `client_services` (`id`),
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
