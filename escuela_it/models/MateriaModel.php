<?php
require_once BASE_PATH . '/models/BaseModel.php';

class MateriaModel extends BaseModel
{
    public function all()
    {
        $sql = 'SELECT m.*, d.nombre AS docente_nombre, d.apellido AS docente_apellido
                FROM materias m
                LEFT JOIN docentes d ON d.id = m.docente_id
                ORDER BY m.id DESC';
        return $this->pdo->query($sql)->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM materias WHERE id = ?');
        $stmt->execute(array($id));
        return $stmt->fetch();
    }

    public function save($data)
    {
        if (!empty($data['id'])) {
            $sql = 'UPDATE materias SET nombre=?, descripcion=?, creditos=?, docente_id=? WHERE id=?';
            $params = array(
                $data['nombre'],
                $data['descripcion'],
                (int) $data['creditos'],
                !empty($data['docente_id']) ? (int) $data['docente_id'] : null,
                $data['id'],
            );
        } else {
            $sql = 'INSERT INTO materias (nombre, descripcion, creditos, docente_id) VALUES (?,?,?,?)';
            $params = array(
                $data['nombre'],
                $data['descripcion'],
                (int) $data['creditos'],
                !empty($data['docente_id']) ? (int) $data['docente_id'] : null,
            );
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM materias WHERE id = ?');
        $stmt->execute(array($id));
    }

    public function docentes()
    {
        return $this->pdo->query("SELECT id, CONCAT(nombre, ' ', apellido) AS nombre FROM docentes ORDER BY nombre ASC")->fetchAll();
    }

    public function byDocenteId($docenteId)
    {
        $stmt = $this->pdo->prepare('SELECT m.*, d.nombre AS docente_nombre, d.apellido AS docente_apellido FROM materias m LEFT JOIN docentes d ON d.id = m.docente_id WHERE m.docente_id = ? ORDER BY m.id DESC');
        $stmt->execute(array((int) $docenteId));
        return $stmt->fetchAll();
    }

    public function availableForAlumno($alumnoId)
    {
        $sql = 'SELECT m.*, d.nombre AS docente_nombre, d.apellido AS docente_apellido
                FROM materias m
                LEFT JOIN docentes d ON d.id = m.docente_id
                WHERE m.docente_id IS NOT NULL AND m.id NOT IN (SELECT materia_id FROM matriculas WHERE alumno_id = ?)
                ORDER BY m.id DESC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array((int) $alumnoId));
        return $stmt->fetchAll();
    }
}
