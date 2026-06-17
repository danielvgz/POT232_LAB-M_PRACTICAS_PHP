-- Esquema para inscribir alumnos, docentes y asignaciones

CREATE TABLE IF NOT EXISTS alumnos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    fecha_nacimiento DATE,
    activo BOOLEAN DEFAULT 1
);

CREATE TABLE IF NOT EXISTS docentes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    profesion VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS asignaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    creditos INT NOT NULL DEFAULT 1,
    descripcion TEXT
);

CREATE TABLE IF NOT EXISTS asignaciones_docente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_asignacion INT NOT NULL,
    id_docente INT NOT NULL,
    FOREIGN KEY (id_asignacion) REFERENCES asignaciones(id) ON DELETE CASCADE,
    FOREIGN KEY (id_docente) REFERENCES docentes(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS inscripciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_alumno INT NOT NULL,
    id_asignacion_docente INT NOT NULL,
    fecha_inscripcion DATE DEFAULT CURRENT_DATE,
    FOREIGN KEY (id_alumno) REFERENCES alumnos(id) ON DELETE CASCADE,
    FOREIGN KEY (id_asignacion_docente) REFERENCES asignaciones_docente(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS calificaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_inscripcion INT NOT NULL UNIQUE,
    evaluacion1 DECIMAL(5,2) NULL,
    evaluacion2 DECIMAL(5,2) NULL,
    evaluacion3 DECIMAL(5,2) NULL,
    evaluacion4 DECIMAL(5,2) NULL,
    FOREIGN KEY (id_inscripcion) REFERENCES inscripciones(id) ON DELETE CASCADE
);
