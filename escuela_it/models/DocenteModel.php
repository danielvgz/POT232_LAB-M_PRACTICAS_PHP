<?php
require_once BASE_PATH . '/models/BaseModel.php';

class DocenteModel extends BaseModel
{
    public function all()
    {
        return $this->pdo->query('SELECT * FROM docentes ORDER BY id DESC')->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM docentes WHERE id = ?');
        $stmt->execute(array($id));
        return $stmt->fetch();
    }

    public function save($data)
    {
        if (!empty($data['id'])) {
            $sql = 'UPDATE docentes SET nombre=?, apellido=?, sexo=?, fecha_nacimiento=?, fecha_registro=?, foto=?, correo=? WHERE id=?';
            $params = array($data['nombre'], $data['apellido'], $data['sexo'], $data['fecha_nacimiento'], $data['fecha_registro'], $data['foto'], $data['correo'], $data['id']);
        } else {
            $sql = 'INSERT INTO docentes (nombre, apellido, sexo, fecha_nacimiento, fecha_registro, foto, correo) VALUES (?,?,?,?,?,?,?)';
            $params = array($data['nombre'], $data['apellido'], $data['sexo'], $data['fecha_nacimiento'], $data['fecha_registro'], $data['foto'], $data['correo']);
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM docentes WHERE id = ?');
        $stmt->execute(array($id));
    }
}
