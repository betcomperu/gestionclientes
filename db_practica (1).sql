-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 31, 2025 at 02:31 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clientesdemo`
--

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `apellido` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `usuario` varchar(200) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `correo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `ciudad` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `clave` varchar(200) COLLATE utf8mb4_spanish_ci NOT NULL,
  `foto` varchar(200) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `apellido`, `usuario`, `correo`, `ciudad`, `fecha_nacimiento`, `clave`, `foto`) VALUES
(5, 'Luis', 'Sanchez', 'luchoni', 'luis@ejemplo.com', 'Bilbao', '2000-05-30', '$2y$10$8z638x.LCxAZfK8Bu/47IuBWUPGLU9gHtgT8JkI0esVO1PkmPXDN2', 'uploader/1743384104_Bebeto.jpg'),
(6, 'Maria Andrea', 'Dolores Alcides', 'marialanda', 'mariganda@gmail.com', 'Lima', '1985-04-14', '$2y$10$wgNgB9jVhcfg0mTmw6Fg/etqVJt9xyn5WRZFJCKZdh5BKhdZGibh2', 'uploader/1743373743_Betcom2024.jpg'),
(7, 'Juan', 'Perez', 'juanpe', 'juanpe@gmail.com', 'Lima', '1987-09-12', '$2y$10$aM1pLx.XTRt3DgNgH.OukezOjj4OoIQNz2WSO6cQaQ98UhE6kB9Le', 'uploader/AvatarTodalapc.jpg'),
(8, 'Enzo', 'Pinto Q', 'enzopinto', 'enzopinto@gmail.com', 'Arequipa', '1985-01-14', '$2y$10$5YePyBgPQrCnhhlSPZVLF.jErPCwfHMFoFAtKs9h5WgzUfBQOlke2', 'uploader/1743373743_Betcom2024.jpg'),
(9, 'Jose', 'Sosa Ortiz', 'josejose', 'josesosa@gmail.com', 'Mexico', '1948-02-17', '$2y$10$5WNQsAe.MJzIRCfX6VP6K.qyHZESvrNldoahvjwzIRbP7yY3zJqTO', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
