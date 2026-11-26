<?php
require_once BASE_PATH . '/models/BaseModel.php';

class AlumnoModel extends BaseModel
{
    public function all()
    {
        return $this->pdo->query('SELECT * FROM alumnos ORDER BY id DESC')->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM alumnos WHERE id = ?');
        $stmt->execute(array($id));
        return $stmt->fetch();
    }

    public function save($data)
    {
        if (!empty($data['id'])) {
            $sql = 'UPDATE alumnos SET nombre=?, apellido=?, sexo=?, fecha_nacimiento=?, fecha_registro=?, foto=?, correo=? WHERE id=?';
            $params = array($data['nombre'], $data['apellido'], $data['sexo'], $data['fecha_nacimiento'], $data['fecha_registro'], $data['foto'], $data['correo'], $data['id']);
        } else {
            $sql = 'INSERT INTO alumnos (nombre, apellido, sexo, fecha_nacimiento, fecha_registro, foto, correo) VALUES (?,?,?,?,?,?,?)';
            $params = array($data['nombre'], $data['apellido'], $data['sexo'], $data['fecha_nacimiento'], $data['fecha_registro'], $data['foto'], $data['correo']);
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM alumnos WHERE id = ?');
        $stmt->execute(array($id));
    }
}
