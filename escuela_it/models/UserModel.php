<?php
require_once BASE_PATH . '/models/BaseModel.php';

class UserModel extends BaseModel
{
    public function login($correo, $password)
    {
        $sql = 'SELECT id, correo, password, rol, alumno_id, docente_id FROM usuarios WHERE correo = ? LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array($correo));
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            unset($user['password']);
            return $user;
        }

        return false;
    }
}
