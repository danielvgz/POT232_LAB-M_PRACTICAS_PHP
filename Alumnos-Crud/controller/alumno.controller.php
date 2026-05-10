<?php
require_once 'model/alumno.entidad.php';
require_once 'model/alumno.model.php';

class AlumnoController{
    
    private $model;
    
    public function __CONSTRUCT(){
        $this->model = new AlumnoModel();
    }
    
    public function Index(){
        require_once 'view/header.php';
        require_once 'view/alumno/alumno.php';
        require_once 'view/footer.php';
    }
    
    public function Crud(){
        $alm = new Alumno();
        
        if(isset($_REQUEST['id'])){
            $alm = $this->model->Obtener($_REQUEST['id']);
        }
        
        require_once 'view/header.php';
        require_once 'view/alumno/alumno-editar.php';
        require_once 'view/footer.php';
    }
    
    public function Guardar(){
        $alm = new Alumno();
        
        $alm->__SET('id',              $_REQUEST['id']);
        $alm->__SET('Nombre',          $_REQUEST['Nombre']);
        $alm->__SET('Apellido',        $_REQUEST['Apellido']);
        $alm->__SET('Sexo',            $_REQUEST['Sexo']);
        $alm->__SET('FechaNacimiento', $_REQUEST['FechaNacimiento']);
        $alm->__SET('Correo',          $_REQUEST['Correo']);
        $alm->__SET('Foto',            $_REQUEST['Foto']);
        
        if( !empty( $_FILES['Foto']['name'] ) ){
            $foto = date('ymdhis') . '-' . strtolower($_FILES['Foto']['name']);
            move_uploaded_file ($_FILES['Foto']['tmp_name'], 'uploads/' . $foto);
            
            $alm->__SET('Foto', $foto);
        }

        if($alm->__GET('id') != '' ? 
           $this->model->Actualizar($alm) : 
           $this->model->Registrar($alm));
        
        header('Location: index.php');
    }
    
    public function Excel(){
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=mi_archivo.xls");
        header("Pragma: no-cache");
        header("Expires: 0");    
        
        require_once 'view/alumno/alumno-excel.php';
    }
    
    public function Eliminar(){
        $this->model->Eliminar($_REQUEST['id']);
        header('Location: index.php');
    }
}