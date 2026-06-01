<?php
require_once BASE_PATH . '/models/BaseModel.php';

class MatriculaModel extends BaseModel
{
    public function all()
    {
        $sql = 'SELECT m.id, m.fecha_matricula, a.nombre AS alumno_nombre, a.apellido AS alumno_apellido,
                       d.nombre AS docente_nombre, d.apellido AS docente_apellido, mt.nombre AS materia_nombre,
                       mt.creditos, m.alumno_id, m.docente_id, m.materia_id, m.obj1, m.obj2, m.obj3, m.obj4
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
                       mt.creditos, m.alumno_id, m.docente_id, m.materia_id, m.obj1, m.obj2, m.obj3, m.obj4
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
                       mt.creditos, m.alumno_id, m.docente_id, m.materia_id, m.obj1, m.obj2, m.obj3, m.obj4
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
            $sql = 'UPDATE matriculas SET alumno_id=?, docente_id=?, materia_id=?, fecha_matricula=?, obj1=?, obj2=?, obj3=?, obj4=? WHERE id=?';
            $params = array($data['alumno_id'], $data['docente_id'], $data['materia_id'], $data['fecha_matricula'], $data['obj1'], $data['obj2'], $data['obj3'], $data['obj4'], $data['id']);
        } else {
            $sql = 'INSERT INTO matriculas (alumno_id, docente_id, materia_id, fecha_matricula, obj1, obj2, obj3, obj4) VALUES (?,?,?,?,?,?,?,?)';
            $params = array($data['alumno_id'], $data['docente_id'], $data['materia_id'], $data['fecha_matricula'], $data['obj1'], $data['obj2'], $data['obj3'], $data['obj4']);
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
        return $this->pdo->query('SELECT id, nombre, creditos, docente_id FROM materias ORDER BY nombre ASC')->fetchAll();
    }

    public function availableCredits($alumnoId)
    {
        $stmt = $this->pdo->prepare('SELECT COALESCE(SUM(mt.creditos), 0) AS total FROM matriculas m INNER JOIN materias mt ON mt.id = m.materia_id WHERE m.alumno_id = ?');
        $stmt->execute(array((int) $alumnoId));
        $row = $stmt->fetch();
        return $row ? (int) $row['total'] : 0;
    }

    public function enrolledMateriaIds($alumnoId)
    {
        $stmt = $this->pdo->prepare('SELECT materia_id FROM matriculas WHERE alumno_id = ?');
        $stmt->execute(array((int) $alumnoId));
        return array_map(function ($row) {
            return (int) $row['materia_id'];
        }, $stmt->fetchAll());
    }

    public function byMateriaAndDocente($docenteId, $materiaId = null)
    {
        $sql = 'SELECT m.id, m.fecha_matricula, a.nombre AS alumno_nombre, a.apellido AS alumno_apellido,
                       d.nombre AS docente_nombre, d.apellido AS docente_apellido, mt.nombre AS materia_nombre,
                       mt.creditos, m.alumno_id, m.docente_id, m.materia_id, m.obj1, m.obj2, m.obj3, m.obj4
                FROM matriculas m
                INNER JOIN alumnos a ON a.id = m.alumno_id
                INNER JOIN docentes d ON d.id = m.docente_id
                INNER JOIN materias mt ON mt.id = m.materia_id
                WHERE m.docente_id = ?';
        $params = array((int) $docenteId);
        if ($materiaId) {
            $sql .= ' AND m.materia_id = ?';
            $params[] = (int) $materiaId;
        }
        $sql .= ' ORDER BY m.id DESC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function docenteMaterias($docenteId)
    {
        $stmt = $this->pdo->prepare('SELECT id, nombre, creditos FROM materias WHERE docente_id = ? ORDER BY nombre ASC');
        $stmt->execute(array((int) $docenteId));
        return $stmt->fetchAll();
    }
}
