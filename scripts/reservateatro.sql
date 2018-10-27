-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 26-10-2018 a las 14:41:16
-- Versión del servidor: 5.7.24-0ubuntu0.18.04.1
-- Versión de PHP: 7.2.10-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `reservateatro`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservations`
--

CREATE TABLE `reservations` (
  `id` char(36) NOT NULL,
  `reservation_date` timestamp NULL DEFAULT NULL,
  `numbers_people` int(11) NOT NULL,
  `row` int(11) NOT NULL,
  `column` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `reservations`
--

INSERT INTO `reservations` (`id`, `reservation_date`, `numbers_people`, `row`, `column`, `created_at`, `updated_at`) VALUES
('cd600657-5e96-4b56-933c-cf408bc9e9d6', '2018-10-26 13:24:42', 500, 50, 10, '2018-10-26 17:13:19', '2018-10-26 17:24:42'),
('e3cc6b7c-f6a0-4f85-b5d4-a90b8a6c83c7', '2018-09-30 04:00:00', 100, 10, 10, '2018-10-26 17:10:23', '2018-10-26 17:10:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` char(36) NOT NULL,
  `role_name` varchar(250) NOT NULL,
  `role_description` varchar(250) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `role_description`, `created_at`, `updated_at`) VALUES
('c21ed25e-d940-11e8-85c8-8c16453f98ea', 'admin', 'Admin', '2018-10-26 04:00:00', '2018-10-26 04:00:00'),
('c21ed9eb-d940-11e8-85c8-8c16453f98ea', 'user', 'User', '2018-10-26 04:00:00', '2018-10-26 04:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_user`
--

CREATE TABLE `role_user` (
  `id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `role_id` char(36) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `role_user`
--

INSERT INTO `role_user` (`id`, `user_id`, `role_id`, `created_at`, `updated_at`) VALUES
('b13b925d-d943-11e8-85c8-8c16453f98ea', '3f32bbcc-1d7a-42dd-a958-f9a60372af60', 'c21ed25e-d940-11e8-85c8-8c16453f98ea', '2018-10-26 04:00:00', '2018-10-26 04:00:00'),
('cdbf60b0-d943-11e8-85c8-8c16453f98ea', 'b33a9027-e215-42df-b703-053f509abc98', 'c21ed9eb-d940-11e8-85c8-8c16453f98ea', '2018-10-26 04:00:00', '2018-10-26 04:00:00'),
('cdbf66c2-d943-11e8-85c8-8c16453f98ea', 'cb24f0d3-c2cb-4f8f-ad7f-893468a5e73a', 'c21ed9eb-d940-11e8-85c8-8c16453f98ea', '2018-10-26 04:00:00', '2018-10-26 04:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` char(36) NOT NULL,
  `name` varchar(50) NOT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `lastname`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
('3f32bbcc-1d7a-42dd-a958-f9a60372af60', 'Admin', 'Admin', 'admin@gmail.com', '$2y$10$Tm4gTQGcuyuBZRPTYg5D/.N.iBtbZReaEAUteDcJOsImLxbcxc4Zu', 'Tae4EzmEv5YFgLozPYgWwAxPB5J6YHBDLFn88u6FPUSci5pFQOsP1lEio48w', '2018-10-26 01:26:43', '2018-10-26 16:16:38'),
('b33a9027-e215-42df-b703-053f509abc98', 'dfh', 'df', 'ggg@gmail.com', '$2y$10$syuA8FRsQk.DyN1WiiK2Xu7ne/omV2v9RQhONuy7kQbR5hDyLr96K', NULL, '2018-10-26 15:49:53', '2018-10-26 15:49:53'),
('cb24f0d3-c2cb-4f8f-ad7f-893468a5e73a', 'pero', 'pero', 'per@gmail.com', '$2y$10$KpxMxape3keKNLRr.M.IDOVmRRDZigep4V/OlKqVFHHDp2aYgYnv.', 'hIfNlShLMTQjXBLZDTfa1dEGeSjti8LDSGKzIpvPsfeyr6Uuvj8t1FR0oLwd', '2018-10-26 15:50:17', '2018-10-26 15:50:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_reservations`
--

CREATE TABLE `user_reservations` (
  `id` char(36) NOT NULL,
  `users_id` char(36) NOT NULL,
  `reservations_id` char(36) NOT NULL,
  `row` int(11) NOT NULL,
  `column` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `user_reservations`
--

INSERT INTO `user_reservations` (`id`, `users_id`, `reservations_id`, `row`, `column`, `status`, `created_at`, `updated_at`) VALUES
('0205bc95-b883-4d09-bbfe-5da3a7c8fddb', '3f32bbcc-1d7a-42dd-a958-f9a60372af60', 'e3cc6b7c-f6a0-4f85-b5d4-a90b8a6c83c7', 4, 4, NULL, '2018-10-26 20:34:35', '2018-10-26 20:34:35'),
('05aadb0b-e82f-401e-864d-5080ab06acf3', '3f32bbcc-1d7a-42dd-a958-f9a60372af60', 'e3cc6b7c-f6a0-4f85-b5d4-a90b8a6c83c7', 5, 4, NULL, '2018-10-26 20:38:08', '2018-10-26 20:38:08'),
('1456b362-09a7-4ace-bbf4-8ce5b6e69681', '3f32bbcc-1d7a-42dd-a958-f9a60372af60', 'cd600657-5e96-4b56-933c-cf408bc9e9d6', 5, 2, NULL, '2018-10-26 20:26:11', '2018-10-26 20:26:11'),
('2dfb290d-6844-4863-ae9f-0a0678a21ffa', '3f32bbcc-1d7a-42dd-a958-f9a60372af60', 'e3cc6b7c-f6a0-4f85-b5d4-a90b8a6c83c7', 6, 4, NULL, '2018-10-26 20:38:52', '2018-10-26 20:38:52'),
('4f11cecc-d9e1-4288-be78-3777c750a251', '3f32bbcc-1d7a-42dd-a958-f9a60372af60', 'e3cc6b7c-f6a0-4f85-b5d4-a90b8a6c83c7', 8, 4, NULL, '2018-10-26 20:47:59', '2018-10-26 20:47:59'),
('51e2c875-0d02-443f-8a4f-ec22d0705935', '3f32bbcc-1d7a-42dd-a958-f9a60372af60', 'e3cc6b7c-f6a0-4f85-b5d4-a90b8a6c83c7', 5, 5, NULL, '2018-10-26 20:37:13', '2018-10-26 20:37:13'),
('563ef8b9-4e25-460a-9ebc-ab31acff756b', '3f32bbcc-1d7a-42dd-a958-f9a60372af60', 'e3cc6b7c-f6a0-4f85-b5d4-a90b8a6c83c7', 5, 2, NULL, '2018-10-26 20:09:14', '2018-10-26 20:09:14'),
('86a9b414-afb8-4844-b0db-719426629a2d', '3f32bbcc-1d7a-42dd-a958-f9a60372af60', 'e3cc6b7c-f6a0-4f85-b5d4-a90b8a6c83c7', 4, 2, NULL, '2018-10-26 20:25:02', '2018-10-26 20:25:02'),
('a1b00f41-1cef-47dc-bb8a-667a6cdb2a43', 'cb24f0d3-c2cb-4f8f-ad7f-893468a5e73a', 'cd600657-5e96-4b56-933c-cf408bc9e9d6', 3, 3, NULL, '2018-10-26 21:39:03', '2018-10-26 21:39:03'),
('b536e654-a981-4903-95d6-3a573949eb07', '3f32bbcc-1d7a-42dd-a958-f9a60372af60', 'e3cc6b7c-f6a0-4f85-b5d4-a90b8a6c83c7', 3, 2, NULL, '2018-10-26 20:24:40', '2018-10-26 20:24:40'),
('b7d0ade2-f810-47e0-9c19-c464ea3d0e66', '3f32bbcc-1d7a-42dd-a958-f9a60372af60', 'cd600657-5e96-4b56-933c-cf408bc9e9d6', 4, 4, NULL, '2018-10-26 20:52:47', '2018-10-26 20:52:47'),
('be7b98a7-c1ac-4ae2-a5ac-50945c825ca9', '3f32bbcc-1d7a-42dd-a958-f9a60372af60', 'e3cc6b7c-f6a0-4f85-b5d4-a90b8a6c83c7', 5, 2, NULL, '2018-10-26 20:12:19', '2018-10-26 20:12:19'),
('e23a6352-7b8d-4124-9f63-c61cf3df0885', '3f32bbcc-1d7a-42dd-a958-f9a60372af60', 'e3cc6b7c-f6a0-4f85-b5d4-a90b8a6c83c7', 1, 5, NULL, '2018-10-26 20:28:47', '2018-10-26 20:28:47'),
('e56cb53d-ac27-4f88-986b-d39d007638ae', '3f32bbcc-1d7a-42dd-a958-f9a60372af60', 'cd600657-5e96-4b56-933c-cf408bc9e9d6', 26, 2, NULL, '2018-10-26 20:26:21', '2018-10-26 20:26:21'),
('e9e42187-4a89-4799-b7c7-70d95c0e507d', 'cb24f0d3-c2cb-4f8f-ad7f-893468a5e73a', 'cd600657-5e96-4b56-933c-cf408bc9e9d6', 4, 3, NULL, '2018-10-26 21:39:14', '2018-10-26 21:39:14'),
('f3b19b3b-8772-425c-96cd-236fb746e232', '3f32bbcc-1d7a-42dd-a958-f9a60372af60', 'e3cc6b7c-f6a0-4f85-b5d4-a90b8a6c83c7', 5, 1, NULL, '2018-10-26 20:10:03', '2018-10-26 20:10:03');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user_reservations`
--
ALTER TABLE `user_reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_id` (`users_id`),
  ADD KEY `reservations_id` (`reservations_id`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `user_reservations`
--
ALTER TABLE `user_reservations`
  ADD CONSTRAINT `user_reservations_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_reservations_ibfk_2` FOREIGN KEY (`reservations_id`) REFERENCES `reservations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
