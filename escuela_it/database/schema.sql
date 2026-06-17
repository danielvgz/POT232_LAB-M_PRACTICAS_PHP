DROP TABLE IF EXISTS matriculas;
DROP TABLE IF EXISTS usuarios;
DROP TABLE IF EXISTS materias;
DROP TABLE IF EXISTS docentes;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO alumnos (nombre, apellido, sexo, fecha_nacimiento, fecha_registro, foto, correo) VALUES
('Eduardo', 'Rodriguez Patiño', 1, '1989-02-11', '2014-05-26', '150211034428-logo.png', 'hitogoroshi@outlook.com'),
('Pedro', 'Suarez Patiño', 1, '1991-08-17', '2014-05-26', '150211035226-bryan-cranston-walter-white1.jpg', 'esuarez@anexsoft.com'),
('Raul', 'Perez', 1, '1989-03-15', '2014-05-26', '150211035306-richie-kotzen.jpg', 'rperez@hotmail.com'),
('Alberto', 'Diaz Villanueva', 1, '2015-02-12', NULL, '150211045806-0c2a341559c2e1e0dabceeb1b760740d.jpg', 'adiaz@hotmail.com'),
('Teresa', 'Rodriguez Sanchez', 2, '2015-02-12', NULL, '150211050101-a.jpg', 'jrodriguez@hotmail.com');

CREATE TABLE docentes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    sexo TINYINT NOT NULL,
    fecha_nacimiento DATE DEFAULT NULL,
    fecha_registro DATE DEFAULT NULL,
    foto VARCHAR(50) NOT NULL,
    correo VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO docentes (nombre, apellido, sexo, fecha_nacimiento, fecha_registro, foto, correo) VALUES
('Juan', 'Perez', 1, '1985-01-10', '2024-01-10', 'docente1.png', 'juan.perez@escuela.it'),
('Maria', 'Lopez', 2, '1988-07-22', '2024-01-10', 'docente2.png', 'maria.lopez@escuela.it');

CREATE TABLE materias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO materias (nombre, descripcion) VALUES
('Matematicas', 'Algebra y aritmetica'),
('Programacion PHP', 'Fundamentos de desarrollo web en PHP');

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    correo VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('alumno', 'maestro') NOT NULL,
    alumno_id INT DEFAULT NULL,
    docente_id INT DEFAULT NULL,
    FOREIGN KEY (alumno_id) REFERENCES alumnos(id) ON DELETE SET NULL,
    FOREIGN KEY (docente_id) REFERENCES docentes(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO usuarios (correo, password, rol, alumno_id, docente_id) VALUES
('hitogoroshi@outlook.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'alumno', 1, NULL),
('juan.perez@escuela.it', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'maestro', NULL, 1);

CREATE TABLE matriculas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    alumno_id INT NOT NULL,
    docente_id INT NOT NULL,
    materia_id INT NOT NULL,
    fecha_matricula DATE DEFAULT NULL,
    FOREIGN KEY (alumno_id) REFERENCES alumnos(id) ON DELETE CASCADE,
    FOREIGN KEY (docente_id) REFERENCES docentes(id) ON DELETE CASCADE,
    FOREIGN KEY (materia_id) REFERENCES materias(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO matriculas (alumno_id, docente_id, materia_id, fecha_matricula) VALUES
(1, 1, 1, '2024-02-01'),
(2, 1, 2, '2024-02-05');
