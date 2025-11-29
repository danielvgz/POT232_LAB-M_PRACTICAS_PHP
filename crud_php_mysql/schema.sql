-- Esquema SQL para CRUD PHP + MySQL
-- Crea la base de datos y la tabla de ejemplo

CREATE DATABASE IF NOT EXISTS `crud_php` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `crud_php`;

CREATE TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(10) NOT NULL,
  `cedula` CHAR(10) DEFAULT NULL,
  `fecha_nacimiento` DATE DEFAULT NULL,
  `edad` INT(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Inserta algunos datos de ejemplo
INSERT INTO `users` (`nombre`, `cedula`, `fecha_nacimiento`, `edad`) VALUES
('Juan Pérez', 'A1234567', '1985-04-12', 40),
('María López', 'B9876543', '1990-09-30', 34);
