<?php
class Usuario {
    public $id;
    public $username;
    public $correo;
    public $password;
    public $rol;
    public $alumno_id;
    public $docente_id;

    public function __GET($k) {
        return $this->$k;
    }

    public function __SET($k, $v) {
        $this->$k = $v;
    }
}
