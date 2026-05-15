<?php
class Alumno {
    // Declara tus atributos según tus necesidades, por ejemplo:
    public $id;
    public $Nombre;
    public $Apellido;
    public $Correo;
    public $Foto;
    public $Sexo;
    public $FechaNacimiento;

    public function __GET($k) {
        return $this->$k;
    }

    public function __SET($k, $v) {
        $this->$k = $v;
    }
}