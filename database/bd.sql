-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.40 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Volcando estructura para tabla sistemagestionprestamos.detalleprestamo
CREATE TABLE IF NOT EXISTS `detalleprestamo` (
  `idDetallePrestamo` int NOT NULL AUTO_INCREMENT,
  `Prestamo_Id` int NOT NULL,
  `Herramienta_Id` int NOT NULL,
  `Cantidad` int NOT NULL,
  PRIMARY KEY (`idDetallePrestamo`),
  KEY `Prestamos_Id_idx` (`Prestamo_Id`),
  KEY `Herramienta_Id_idx` (`Herramienta_Id`),
  CONSTRAINT `Herramienta_Id` FOREIGN KEY (`Herramienta_Id`) REFERENCES `herramientas` (`Herramienta_id`),
  CONSTRAINT `Prestamos_Id` FOREIGN KEY (`Prestamo_Id`) REFERENCES `prestamos` (`Prestamos_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla sistemagestionprestamos.detalleprestamo: ~12 rows (aproximadamente)
DELETE FROM `detalleprestamo`;
INSERT INTO `detalleprestamo` (`idDetallePrestamo`, `Prestamo_Id`, `Herramienta_Id`, `Cantidad`) VALUES
	

-- Volcando estructura para tabla sistemagestionprestamos.herramientas
CREATE TABLE IF NOT EXISTS `herramientas` (
  `Herramienta_id` int NOT NULL AUTO_INCREMENT,
  `Herramienta_Nombre` varchar(100) NOT NULL,
  `Herramienta_Descrip` text NOT NULL,
  `Herramienta_CantidadTotal` int NOT NULL,
  `Herramienta_CantidadDisponible` int NOT NULL,
  PRIMARY KEY (`Herramienta_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla sistemagestionprestamos.herramientas: ~3 rows (aproximadamente)
DELETE FROM `herramientas`;
INSERT INTO `herramientas` (`Herramienta_id`, `Herramienta_Nombre`, `Herramienta_Descrip`, `Herramienta_CantidadTotal`, `Herramienta_CantidadDisponible`) VALUES
	

-- Volcando estructura para tabla sistemagestionprestamos.prestamos
CREATE TABLE IF NOT EXISTS `prestamos` (
  `Prestamos_Id` int NOT NULL AUTO_INCREMENT,
  `Usuario_Cedula` bigint NOT NULL,
  `Prestamo_FechaPres` date NOT NULL,
  `Prestamo_FechaDev` date DEFAULT NULL,
  `Prestamo_Estado` enum('Activo','Devuelto') NOT NULL,
  PRIMARY KEY (`Prestamos_Id`),
  KEY `Usuarios_Cedula_idx` (`Usuario_Cedula`),
  CONSTRAINT `Usuarios_Cedula` FOREIGN KEY (`Usuario_Cedula`) REFERENCES `usuarios` (`Usuario_Cedula`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla sistemagestionprestamos.prestamos: ~12 rows (aproximadamente)
DELETE FROM `prestamos`;
INSERT INTO `prestamos` (`Prestamos_Id`, `Usuario_Cedula`, `Prestamo_FechaPres`, `Prestamo_FechaDev`, `Prestamo_Estado`) VALUES
	

-- Volcando estructura para tabla sistemagestionprestamos.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `Usuario_Cedula` bigint NOT NULL,
  `Usuario_Nombre` varchar(55) NOT NULL,
  `Usuario_Apellido` varchar(55) NOT NULL,
  `Usuario_Email` varchar(100) NOT NULL,
  `Usuario_Rol` enum('Usuario','Admin') DEFAULT NULL,
  PRIMARY KEY (`Usuario_Cedula`),
  UNIQUE KEY `Usuario_Cedula_UNIQUE` (`Usuario_Cedula`),
  UNIQUE KEY `Usuario_Email_UNIQUE` (`Usuario_Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla sistemagestionprestamos.usuarios: ~4 rows (aproximadamente)
DELETE FROM `usuarios`;
INSERT INTO `usuarios` (`Usuario_Cedula`, `Usuario_Nombre`, `Usuario_Apellido`, `Usuario_Email`, `Usuario_Rol`) VALUES
	(1000857460, 'miguel', 'lugo', 'miguellugo2020@gmail.com', 'Admin');


/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
