<?php
require_once 'models/Docente.php';

class DocenteController{

    private $model;

    public function __CONSTRUCT(){
        $this->model = new Docente();
    }

    public function Index(){
        $docentes = $this->model->Listar();
        require_once 'views/header.php';
        require_once 'views/docente/index.php';
        require_once 'views/footer.php';
    }

    public function Agregar(){
        $doc = new DocenteEntity();
        require_once 'views/header.php';
        require_once 'views/docente/agregar.php';
        require_once 'views/footer.php';
    }

    public function Editar(){
        $doc = new DocenteEntity();

        if(isset($_REQUEST['id'])){
            $doc = $this->model->Obtener($_REQUEST['id']);
        }

        require_once 'views/header.php';
        require_once 'views/docente/editar.php';
        require_once 'views/footer.php';
    }

    public function Guardar(){
        $doc = new DocenteEntity();

        $doc->__SET('Nombre',          $_REQUEST['Nombre']);
        $doc->__SET('Apellido',        $_REQUEST['Apellido']);
        $doc->__SET('Sexo',            $_REQUEST['Sexo']);
        $doc->__SET('FechaNacimiento', $_REQUEST['FechaNacimiento']);
        $doc->__SET('Correo',          $_REQUEST['Correo']);
        $doc->__SET('Foto',            $_REQUEST['Foto']);

        if( !empty( $_FILES['Foto']['name'] ) ){
            $foto = date('ymdhis') . '-' . strtolower($_FILES['Foto']['name']);
            move_uploaded_file ($_FILES['Foto']['tmp_name'], 'uploads/' . $foto);

            $doc->__SET('Foto', $foto);
        }

        $this->model->Registrar($doc);
        header('Location: index.php?c=Docente');
    }

    public function Actualizar(){
        $doc = new DocenteEntity();

        $doc->__SET('id',              $_REQUEST['id']);
        $doc->__SET('Nombre',          $_REQUEST['Nombre']);
        $doc->__SET('Apellido',        $_REQUEST['Apellido']);
        $doc->__SET('Sexo',            $_REQUEST['Sexo']);
        $doc->__SET('FechaNacimiento', $_REQUEST['FechaNacimiento']);
        $doc->__SET('Correo',          $_REQUEST['Correo']);
        $doc->__SET('Foto',            $_REQUEST['Foto']);

        if( !empty( $_FILES['Foto']['name'] ) ){
            $foto = date('ymdhis') . '-' . strtolower($_FILES['Foto']['name']);
            move_uploaded_file ($_FILES['Foto']['tmp_name'], 'uploads/' . $foto);

            $doc->__SET('Foto', $foto);
        }

        $this->model->Actualizar($doc);
        header('Location: index.php?c=Docente');
    }

    public function Eliminar(){
        $doc = new DocenteEntity();

        if(isset($_REQUEST['id'])){
            $doc = $this->model->Obtener($_REQUEST['id']);
        }

        require_once 'views/header.php';
        require_once 'views/docente/eliminar.php';
        require_once 'views/footer.php';
    }

    public function ConfirmarEliminar(){
        if(isset($_REQUEST['id'])){
            $this->model->Eliminar($_REQUEST['id']);
        }
        header('Location: index.php?c=Docente');
    }
}
