<?php
require_once 'models/docentes.entidad.php';
require_once 'models/docentes.model.php';

class DocenteController{

    private $model;

    public function __CONSTRUCT(){
        $this->model = new DocenteModel();
    }

    public function Index(){
        $docentes = $this->model->Listar();
        require_once 'views/header.php';
        require_once 'views/docentes/index.php';
        require_once 'views/footer.php';
    }

    public function Crud(){
        $docente = new Docente();

        if(isset($_REQUEST['id'])){
            $docente = $this->model->Obtener($_REQUEST['id']);
        }

        require_once 'views/header.php';
        require_once 'views/docentes/editar.php';
        require_once 'views/footer.php';
    }

    public function Guardar(){
        $docente = new Docente();

        $docente->id           = $_REQUEST['id'];
        $docente->nombre       = $_REQUEST['nombre'];
        $docente->apellido     = $_REQUEST['apellido'];
        $docente->email        = $_REQUEST['email'];
        $docente->especialidad = $_REQUEST['especialidad'];

        if($docente->id != '' ? 
            $this->model->Actualizar($docente) : 
            $this->model->Registrar($docente));

        header('Location: index.php?action=docente');
    }

    public function Eliminar(){
        $this->model->Eliminar($_REQUEST['id']);
        header('Location: index.php?action=docente');
    }
}
