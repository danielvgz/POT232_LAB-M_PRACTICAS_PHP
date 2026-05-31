<?php
require_once BASE_PATH . '/models/BaseModel.php';

class MatriculaModel extends BaseModel
{
    public function all()
    {
        $sql = 'SELECT m.id, m.fecha_matricula, a.nombre AS alumno_nombre, a.apellido AS alumno_apellido,
                       d.nombre AS docente_nombre, d.apellido AS docente_apellido, mt.nombre AS materia_nombre,
                       m.alumno_id, m.docente_id, m.materia_id
                FROM matriculas m
                INNER JOIN alumnos a ON a.id = m.alumno_id
                INNER JOIN docentes d ON d.id = m.docente_id
                INNER JOIN materias mt ON mt.id = m.materia_id
                ORDER BY m.id DESC';
        return $this->pdo->query($sql)->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM matriculas WHERE id = ?');
        $stmt->execute(array($id));
        return $stmt->fetch();
    }

    public function byAlumnoId($alumnoId)
    {
        $sql = 'SELECT m.id, m.fecha_matricula, a.nombre AS alumno_nombre, a.apellido AS alumno_apellido,
                       d.nombre AS docente_nombre, d.apellido AS docente_apellido, mt.nombre AS materia_nombre,
                       m.alumno_id, m.docente_id, m.materia_id
                FROM matriculas m
                INNER JOIN alumnos a ON a.id = m.alumno_id
                INNER JOIN docentes d ON d.id = m.docente_id
                INNER JOIN materias mt ON mt.id = m.materia_id
                WHERE m.alumno_id = ?
                ORDER BY m.id DESC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array((int) $alumnoId));
        return $stmt->fetchAll();
    }

    public function byDocenteId($docenteId)
    {
        $sql = 'SELECT m.id, m.fecha_matricula, a.nombre AS alumno_nombre, a.apellido AS alumno_apellido,
                       d.nombre AS docente_nombre, d.apellido AS docente_apellido, mt.nombre AS materia_nombre,
                       m.alumno_id, m.docente_id, m.materia_id
                FROM matriculas m
                INNER JOIN alumnos a ON a.id = m.alumno_id
                INNER JOIN docentes d ON d.id = m.docente_id
                INNER JOIN materias mt ON mt.id = m.materia_id
                WHERE m.docente_id = ?
                ORDER BY m.id DESC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array((int) $docenteId));
        return $stmt->fetchAll();
    }

    public function save($data)
    {
        if (!empty($data['id'])) {
            $sql = 'UPDATE matriculas SET alumno_id=?, docente_id=?, materia_id=?, fecha_matricula=? WHERE id=?';
            $params = array($data['alumno_id'], $data['docente_id'], $data['materia_id'], $data['fecha_matricula'], $data['id']);
        } else {
            $sql = 'INSERT INTO matriculas (alumno_id, docente_id, materia_id, fecha_matricula) VALUES (?,?,?,?)';
            $params = array($data['alumno_id'], $data['docente_id'], $data['materia_id'], $data['fecha_matricula']);
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM matriculas WHERE id = ?');
        $stmt->execute(array($id));
    }

    public function alumnos()
    {
        return $this->pdo->query('SELECT id, nombre, apellido FROM alumnos ORDER BY nombre ASC')->fetchAll();
    }

    public function docentes()
    {
        return $this->pdo->query('SELECT id, nombre, apellido FROM docentes ORDER BY nombre ASC')->fetchAll();
    }

    public function materias()
    {
        return $this->pdo->query('SELECT id, nombre FROM materias ORDER BY nombre ASC')->fetchAll();
    }
}
