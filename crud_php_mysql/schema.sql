-- Esquema SQL para CRUD PHP + MySQL
-- Crea la base de datos y la tabla de ejemplo

CREATE DATABASE IF NOT EXISTS `examen` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `examen`;

CREATE TABLE IF NOT EXISTS `personas` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(10) NOT NULL,
  `cedula` VARCHAR(13) DEFAULT NULL,
  `fecha_nacimiento` DATE DEFAULT NULL,
  `edad` INT(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Inserta algunos datos de ejemplo
INSERT INTO `personas` (`nombre`, `cedula`, `fecha_nacimiento`, `edad`) VALUES
('Juan Pérez', 'V-12736128731', '1985-04-12', 40),
('María López', 'V-20987654321', '1990-09-30', 34);
