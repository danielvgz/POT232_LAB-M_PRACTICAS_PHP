<?php
class Usuario
{
    private $id;
    private $correo;
    private $password;

    public function __GET($k) { return $this->$k; }
    public function __SET($k, $v) { return $this->$k = $v; }
}
