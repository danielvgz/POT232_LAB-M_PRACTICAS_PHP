<?php
require_once 'models/model.base.php';

class UsuarioModel extends ModelBase
{
    public function Login($correo, $password)
    {
        try {
            $stm = $this->pdo->prepare("SELECT * FROM usuarios WHERE correo = ? LIMIT 1");
            $stm->execute([$correo]);
            $r = $stm->fetch(PDO::FETCH_OBJ);
           if ($r && password_verify($password, $r->password_hash)) {
                $user = new Usuario();
                $user->__SET('id', $r->id);
                $user->__SET('correo', $r->correo);
                $user->__SET('password', $r->password_hash);
                return $user;
            }
            return false;
        } catch(Exception $e) {
            die($e->getMessage());
        }
    }
}
