SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS inscripciones;
DROP TABLE IF EXISTS asignaciones_docente;
DROP TABLE IF EXISTS usuarios;
DROP TABLE IF EXISTS asignaciones;
DROP TABLE IF EXISTS docentes;
DROP TABLE IF EXISTS alumnos;

SET FOREIGN_KEY_CHECKS=1;

CREATE TABLE alumnos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    sexo TINYINT NOT NULL,
    fecha_nacimiento DATE DEFAULT NULL,
    fecha_registro DATE DEFAULT NULL,
    foto VARCHAR(255) NOT NULL DEFAULT 'default.png',
    correo VARCHAR(100) NOT NULL,
    UNIQUE KEY uq_alumnos_correo (correo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE docentes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL,
    especialidad VARCHAR(100) DEFAULT NULL,
    UNIQUE KEY uq_docentes_correo (correo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE asignaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    correo VARCHAR(100) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    rol ENUM('alumno','docente','admin') NOT NULL DEFAULT 'alumno',
    alumno_id INT DEFAULT NULL,
    docente_id INT DEFAULT NULL,
    UNIQUE KEY uq_usuarios_username (username),
    UNIQUE KEY uq_usuarios_correo (correo),
    UNIQUE KEY uq_usuarios_alumno (alumno_id),
    UNIQUE KEY uq_usuarios_docente (docente_id),
    CONSTRAINT fk_usuarios_alumno FOREIGN KEY (alumno_id) REFERENCES alumnos(id) ON DELETE SET NULL,
    CONSTRAINT fk_usuarios_docente FOREIGN KEY (docente_id) REFERENCES docentes(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE asignaciones_docente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_asignacion INT NOT NULL,
    id_docente INT NOT NULL,
    UNIQUE KEY uq_asignacion_docente (id_asignacion, id_docente),
    CONSTRAINT fk_asigdoc_asignacion FOREIGN KEY (id_asignacion) REFERENCES asignaciones(id) ON DELETE CASCADE,
    CONSTRAINT fk_asigdoc_docente FOREIGN KEY (id_docente) REFERENCES docentes(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE inscripciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_alumno INT NOT NULL,
    id_asignacion_docente INT NOT NULL,
    fecha_inscripcion DATE NOT NULL DEFAULT (CURRENT_DATE),
    UNIQUE KEY uq_inscripcion_unica (id_alumno, id_asignacion_docente),
    CONSTRAINT fk_ins_alumno FOREIGN KEY (id_alumno) REFERENCES alumnos(id) ON DELETE CASCADE,
    CONSTRAINT fk_ins_asigdoc FOREIGN KEY (id_asignacion_docente) REFERENCES asignaciones_docente(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO alumnos (id, nombre, apellido, sexo, fecha_nacimiento, fecha_registro, foto, correo) VALUES
(1, 'Eduardo', 'Rodriguez Patiño', 1, '1989-02-11', '2014-05-26', 'default.png', 'hitogoroshi@outlook.com'),
(2, 'Pedro', 'Suarez Patiño', 1, '1991-08-17', '2014-05-26', 'default.png', 'esuarez@anexsoft.com');

INSERT INTO docentes (id, nombre, apellido, correo, especialidad) VALUES
(1, 'Juan', 'Perez', 'jperez@escuela.com', 'Matematicas'),
(2, 'Ana', 'Sanchez', 'asanchez@escuela.com', 'Fisica');

INSERT INTO asignaciones (id, nombre, descripcion) VALUES
(1, 'Matematicas 1', 'Primera materia de matematicas'),
(2, 'Fisica 1', 'Introducción a física');

INSERT INTO asignaciones_docente (id, id_asignacion, id_docente) VALUES
(1, 1, 1),
(2, 2, 2);

INSERT INTO usuarios (username, correo, password_hash, rol, alumno_id, docente_id) VALUES
('eduardo', 'hitogoroshi@outlook.com', '$2y$10$NVCzAmvzJS.g4ScmBfK3ZugekIKxsKd25Mx4gSSY7YC2wPQEttDbK', 'alumno', 1, NULL),
('jperez', 'jperez@escuela.com', '$2y$10$x8jkEeE8ru/Vamczz6/iBeWauTLGqRCR6G4xWhnRB9hnutUBfgkbG', 'docente', NULL, 1),
('admin', 'admin@escuela.com', '$2y$10$xQkJS9OE1wYG4FUZHaBg8eG8le7aBKwcXJh0XZECs1O5BG0jXIshq', 'admin', NULL, NULL);

INSERT INTO inscripciones (id_alumno, id_asignacion_docente, fecha_inscripcion) VALUES
(1, 1, CURRENT_DATE());
