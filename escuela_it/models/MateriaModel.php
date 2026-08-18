<?php
require_once BASE_PATH . '/models/BaseModel.php';

class MateriaModel extends BaseModel
{
    public function all()
    {
        return $this->pdo->query('SELECT * FROM materias ORDER BY id DESC')->fetchAll();
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
            $sql = 'UPDATE materias SET nombre=?, descripcion=? WHERE id=?';
            $params = array($data['nombre'], $data['descripcion'], $data['id']);
        } else {
            $sql = 'INSERT INTO materias (nombre, descripcion) VALUES (?,?)';
            $params = array($data['nombre'], $data['descripcion']);
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM materias WHERE id = ?');
        $stmt->execute(array($id));
    }
}
