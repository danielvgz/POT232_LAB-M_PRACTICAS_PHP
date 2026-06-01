<?php
require_once BASE_PATH . '/models/BaseModel.php';

class AccionModel extends BaseModel
{
    public function record($data)
    {
        $stmt = $this->pdo->prepare('INSERT INTO acciones (user_id, rol, accion, entidad, detalle, created_at) VALUES (?,?,?,?,?,NOW())');
        $stmt->execute(array(
            !empty($data['user_id']) ? (int) $data['user_id'] : null,
            isset($data['rol']) ? $data['rol'] : '',
            isset($data['accion']) ? $data['accion'] : '',
            isset($data['entidad']) ? $data['entidad'] : '',
            isset($data['detalle']) ? $data['detalle'] : '',
        ));
    }

    public function all()
    {
        $sql = 'SELECT a.*, u.correo AS user_correo
                FROM acciones a
                LEFT JOIN usuarios u ON u.id = a.user_id
                ORDER BY a.id DESC';
        return $this->pdo->query($sql)->fetchAll();
    }
}
