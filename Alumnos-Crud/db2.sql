-- --------------------------------------------------------
-- Estructura y datos iniciales para la base de datos test
-- --------------------------------------------------------

DROP DATABASE IF EXISTS `test`;
CREATE DATABASE IF NOT EXISTS `test` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci */;
USE `test`;

-- --------------------------------------------------------
-- Tabla alumnos
-- --------------------------------------------------------
DROP TABLE IF EXISTS `alumnos`;
CREATE TABLE IF NOT EXISTS `alumnos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) NOT NULL DEFAULT '0',
  `Apellido` varchar(50) NOT NULL DEFAULT '0',
  `Sexo` tinyint(4) NOT NULL DEFAULT '0',
  `FechaNacimiento` varchar(20) DEFAULT NULL,
  `FechaRegistro` varchar(20) DEFAULT NULL,
  `Foto` varchar(50) NOT NULL,
  `Correo` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Datos de ejemplo para alumnos
INSERT INTO `alumnos` (`id`, `Nombre`, `Apellido`, `Sexo`, `FechaNacimiento`, `FechaRegistro`, `Foto`, `Correo`) VALUES
  (3, 'Eduardo', 'Rodriguez Patiño', 1, '1989-02-11', '2014-05-26', '150211034428-logo.png', 'hitogoroshi@outlook.com'),
  (4, 'Pedro', 'Suarez Patiño', 1, '1991-08-17', '2014-05-26', '150211035226-bryan-cranston-walter-white[1].jpg', 'esuarez@anexsoft.com'),
  (5, 'Raul', 'Perez', 1, '1989-03-15', '2014-05-26', '150211035306-richie-kotzen.jpg', 'rperez@hotmail.com'),
  (6, 'Alberto', 'Díaz Villanueva', 1, '2015-02-12', NULL, '150211045806-0c2a341559c2e1e0dabceeb1b760740d.jpg', 'adiaz@hotmail.com'),
  (7, 'Teresa', 'Rodriguez Sanchez', 2, '2015-02-12', NULL, '150211050101-a.jpg', 'jrodriguez@hotmail.com');

-- --------------------------------------------------------
-- Tabla usuarios (autenticación y relación uno a uno con alumnos)
-- --------------------------------------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `alumno_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unico_alumno` (`alumno_id`),
  CONSTRAINT `fk_usuario_alumno` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
-- Ejemplo de inserción de usuarios
-- Usuario vinculado al alumno de id=3
-- (RECUERDA: MD5 SOLO PARA EJEMPLO; USA bcrypt/SHA256 EN PRODUCCIÓN)
-- --------------------------------------------------------
INSERT INTO `usuarios` (username, password_hash, alumno_id)
VALUES ('eduardo', MD5('contraseñaSegura123'), 3);
