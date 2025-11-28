-- Esquema SQL para CRUD PHP + MySQL
-- Crea la base de datos y la tabla de ejemplo

CREATE DATABASE IF NOT EXISTS `crud_php` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `crud_php`;

CREATE TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `telefono` VARCHAR(30) DEFAULT NULL,
  `cedula` VARCHAR(50) DEFAULT NULL,
  `fecha_nacimiento` DATE DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Inserta algunos datos de ejemplo
INSERT INTO `users` (`nombre`, `email`, `telefono`, `cedula`, `fecha_nacimiento`) VALUES
('Juan Pérez', 'juan@example.com', '555-1234', 'A1234567', '1985-04-12'),
('María López', 'maria@example.com', '555-5678', 'B9876543', '1990-09-30');
