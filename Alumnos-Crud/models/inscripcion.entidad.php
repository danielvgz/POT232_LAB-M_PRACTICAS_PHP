<?php
class Inscripcion
{
    public $id;
    public $id_alumno;
    public $id_asignacion_docente;
    public $fecha_inscripcion;

    public function __GET($k) { return $this->$k; }
    public function __SET($k, $v) { $this->$k = $v; }
}
