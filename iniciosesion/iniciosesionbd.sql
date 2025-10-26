-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3307
-- Tiempo de generación: 26-10-2025 a las 03:23:34
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `iniciosesionbd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(10) NOT NULL,
  `Usuario` varchar(20) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Correo` varchar(50) NOT NULL,
  `Fecha_nacimiento` date NOT NULL,
  `Contraseña` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `Usuario`, `Nombre`, `Correo`, `Fecha_nacimiento`, `Contraseña`) VALUES
(1722402789, 'alexdavid', 'Alex Villacis', 'alex45da@gmail.com', '1993-06-21', '$2y$10$QvlNkb78r8M6t9DziLQuGO4eWK9piCfw5bpiYkuhrvq5CPrGEwZvi'),
(1722402794, 'marco', 'Marco Soto', 'marco@gmail.com', '1996-12-11', '$2y$10$0vbBBVJfav4K29vuAVL21eNbCxv.Lqc3PJibhG9uQ28C.vm6/vIxO'),
(1722402795, 'karen', 'Karen Vargas', 'Karen@gmail.com', '1995-12-18', '$2y$10$FRsoS8mP58ut7XZfk7rsLOYibs8gMuDxve8ew75qVNCTmclVlFGWu'),
(1722402796, 'mishell', 'Mishel Villacis', 'mishell@gmail.com', '1993-12-12', '$2y$10$mP3INtNl2hdRjm5CtsGSFOWIEeyxV66C9NiPjplvM4PNwvp/KOwHS'),
(1722402797, 'samantha', 'Samantha Villacis', 'samantha@gmail.com', '1996-11-12', '$2y$10$XdgtapCEKYjpMSeuplpr.uTLhtL.fnC0y7QStnKRysQHOjIkpgtS2');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1722402798;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
