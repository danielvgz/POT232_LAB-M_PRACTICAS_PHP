<?php
class Docente
{
    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $especialidad;

    public function __construct($id = null, $nombre = null, $apellido = null, $email = null, $especialidad = null)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->especialidad = $especialidad;
    }
}
