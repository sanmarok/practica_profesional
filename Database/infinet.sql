CREATE DATABASE infinet;

USE infinet;

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
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
