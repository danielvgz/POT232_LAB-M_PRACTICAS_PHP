-- ========================
-- ESQUEMA UNIFICADO CORREGIDO
-- ========================

-- ========== TABLA ALUMNOS ==========
DROP TABLE IF EXISTS alumnos;
CREATE TABLE alumnos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    sexo TINYINT NOT NULL,
    fecha_nacimiento DATE DEFAULT NULL,
    fecha_registro DATE DEFAULT NULL,
    foto VARCHAR(50) NOT NULL,
    correo VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Datos iniciales de alumnos
INSERT INTO alumnos (nombre, apellido, sexo, fecha_nacimiento, fecha_registro, foto, correo) VALUES
('Eduardo', 'Rodriguez Patiño', 1, '1989-02-11', '2014-05-26', '150211034428-logo.png', 'hitogoroshi@outlook.com'),
('Pedro', 'Suarez Patiño', 1, '1991-08-17', '2014-05-26', '150211035226-bryan-cranston-walter-white1.jpg', 'esuarez@anexsoft.com'),
('Raul', 'Perez', 1, '1989-03-15', '2014-05-26', '150211035306-richie-kotzen.jpg', 'rperez@hotmail.com'),
('Alberto', 'Diaz Villanueva', 1, '2015-02-12', NULL, '150211045806-0c2a341559c2e1e0dabceeb1b760740d.jpg', 'adiaz@hotmail.com'),
('Teresa', 'Rodriguez Sanchez', 2, '2015-02-12', NULL, '150211050101-a.jpg', 'jrodriguez@hotmail.com');

-- ========== TABLA DOCENTES ==========
DROP TABLE IF EXISTS docentes;
CREATE TABLE docentes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    especialidad VARCHAR(100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Datos iniciales de docentes
INSERT INTO docentes (nombre, apellido, correo, especialidad) VALUES
('Juan', 'Perez', 'jperez@escuela.com', 'Matematicas'),
('Ana', 'Sanchez', 'asanchez@escuela.com', 'Fisica');

-- ========== TABLA USUARIOS ==========
DROP TABLE IF EXISTS usuarios;
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    correo VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    rol ENUM('alumno','profesor','admin') NOT NULL DEFAULT 'alumno',
    alumno_id INT DEFAULT NULL,
    docente_id INT DEFAULT NULL,
    FOREIGN KEY (alumno_id) REFERENCES alumnos(id) ON DELETE SET NULL,
    FOREIGN KEY (docente_id) REFERENCES docentes(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Datos ejemplo para usuarios
-- Usuarios tipo alumno:
INSERT INTO usuarios (username, correo, password_hash, rol, alumno_id)
VALUES ('eduardo', 'hitogoroshi@outlook.com', '$2y$10$J21UXuiKec1lSfwbAjbPruQthKISWRWQ1lTwTGVhOA9L5D.snz5Su', 'alumno', 1);

-- Usuarios tipo profesor:
INSERT INTO usuarios (username, correo, password_hash, rol, docente_id)
VALUES ('jperez', 'jperez@escuela.com', '$2y$10$dlQLOOQUXBOn/uL5C/9YOeH1tr5EXPXzLt7cfX3f9C2z20WGbC2JW', 'profesor', 1);

-- Usuario tipo admin (sin alumno ni docente):
INSERT INTO usuarios (username, correo, password_hash, rol, alumno_id, docente_id)
VALUES ('admin', 'admin@escuela.com', '$2y$10$1RuxqrMSPEOsFTg5v5Fy.umdaeNgQDF4FGbC9ocAFm28INN.7dTby', 'admin', NULL, NULL);

-- ========== TABLA ASIGNACIONES ==========
DROP TABLE IF EXISTS asignaciones;
CREATE TABLE asignaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    creditos INT NOT NULL DEFAULT 1,
    descripcion TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO asignaciones (nombre, creditos, descripcion) VALUES
('Matemáticas', 5, 'Matrícula base de matemáticas'),
('Lenguaje', 4, 'Matrícula de comunicación y lenguaje'),
('Física', 6, 'Matrícula de ciencias físicas');

-- ========== TABLA ASIGNACIONES_DOCENTE ==========
DROP TABLE IF EXISTS asignaciones_docente;
CREATE TABLE asignaciones_docente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_asignacion INT NOT NULL,
    id_docente INT NOT NULL,
    FOREIGN KEY (id_asignacion) REFERENCES asignaciones(id) ON DELETE CASCADE,
    FOREIGN KEY (id_docente) REFERENCES docentes(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ========== TABLA INSCRIPCIONES ==========
DROP TABLE IF EXISTS inscripciones;
DROP TABLE IF EXISTS inscripciones;
CREATE TABLE inscripciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_alumno INT NOT NULL,
    id_asignacion_docente INT NOT NULL,
    fecha_inscripcion DATE, -- sin DEFAULT CURRENT_DATE
    FOREIGN KEY (id_alumno) REFERENCES alumnos(id) ON DELETE CASCADE,
    FOREIGN KEY (id_asignacion_docente) REFERENCES asignaciones_docente(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
