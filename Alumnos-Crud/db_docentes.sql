-- --------------------------------------------------------
-- Estructura y datos iniciales para la gestión de docentes y usuarios
-- --------------------------------------------------------

-- Tabla docentes
DROP TABLE IF EXISTS `docentes`;
CREATE TABLE IF NOT EXISTS `docentes` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) NOT NULL,
  `apellido` VARCHAR(50) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `especialidad` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Datos de ejemplo para docentes
INSERT INTO `docentes` (`nombre`, `apellido`, `email`, `especialidad`) VALUES
  ('Juan', 'Pérez', 'jperez@escuela.com', 'Matemáticas'),
  ('Ana', 'Sánchez', 'asanchez@escuela.com', 'Física');

-- Tabla usuarios_docentes
DROP TABLE IF EXISTS `usuarios_docentes`;
CREATE TABLE IF NOT EXISTS `usuarios_docentes` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `rol` ENUM('docente', 'admin') NOT NULL DEFAULT 'docente',
  `docente_id` INT(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`docente_id`) REFERENCES `docentes`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Ejemplo de inserción de usuarios_docentes (contraseñas: docente123/admin123 con MD5, NO usar en producción)
INSERT INTO `usuarios_docentes` (`username`, `password_hash`, `email`, `rol`, `docente_id`) VALUES
('jperez', MD5('docente123'), 'jperez@escuela.com', 'docente', 1),
('admin', MD5('admin123'), 'admin@escuela.com', 'admin', NULL);
