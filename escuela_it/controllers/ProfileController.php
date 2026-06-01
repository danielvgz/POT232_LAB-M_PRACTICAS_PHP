<?php
require_once BASE_PATH . '/controllers/BaseCrudController.php';
require_once BASE_PATH . '/models/UserModel.php';
require_once BASE_PATH . '/models/AlumnoModel.php';
require_once BASE_PATH . '/models/DocenteModel.php';

class ProfileController extends BaseCrudController
{
    public function index()
    {
        $this->requireAuth();
        $user = $this->currentUser();
        $profile = array(
            'nombre' => '',
            'apellido' => '',
            'sexo' => '1',
            'fecha_nacimiento' => '',
            'foto' => '',
            'correo' => isset($user['correo']) ? $user['correo'] : '',
            'password' => '',
        );

        if (!empty($user['alumno_id'])) {
            $profile = array_merge($profile, (new AlumnoModel())->find((int) $user['alumno_id']) ?: array());
        } elseif (!empty($user['docente_id'])) {
            $profile = array_merge($profile, (new DocenteModel())->find((int) $user['docente_id']) ?: array());
        }

        $this->view('profile/index', array('profile' => $profile));
    }

    public function save()
    {
        $this->requireAuth();
        $user = $this->currentUser();
        $userModel = new UserModel();
        $data = array(
            'correo' => $this->clean('correo'),
            'password' => $this->clean('password'),
        );

        if (!empty($user['alumno_id'])) {
            $existing = (new AlumnoModel())->find((int) $user['alumno_id']) ?: array();
            $alumnoModel = new AlumnoModel();
            $alumnoModel->save(array(
                'id' => $user['alumno_id'],
                'nombre' => $this->clean('nombre'),
                'apellido' => $this->clean('apellido'),
                'sexo' => (int) $this->clean('sexo', 1),
                'fecha_nacimiento' => $this->clean('fecha_nacimiento'),
                'fecha_registro' => !empty($existing['fecha_registro']) ? $existing['fecha_registro'] : date('Y-m-d'),
                'foto' => $this->clean('foto', !empty($existing['foto']) ? $existing['foto'] : 'sin-foto.png'),
                'correo' => $data['correo'],
            ));
        } elseif (!empty($user['docente_id'])) {
            $existing = (new DocenteModel())->find((int) $user['docente_id']) ?: array();
            $docenteModel = new DocenteModel();
            $docenteModel->save(array(
                'id' => $user['docente_id'],
                'nombre' => $this->clean('nombre'),
                'apellido' => $this->clean('apellido'),
                'sexo' => (int) $this->clean('sexo', 1),
                'fecha_nacimiento' => $this->clean('fecha_nacimiento'),
                'fecha_registro' => !empty($existing['fecha_registro']) ? $existing['fecha_registro'] : date('Y-m-d'),
                'foto' => $this->clean('foto', !empty($existing['foto']) ? $existing['foto'] : 'sin-foto.png'),
                'correo' => $data['correo'],
            ));
        }

        $userModel->updateProfile($user['id'], $data);
        $_SESSION['user'] = $userModel->find($user['id']) ?: $user;
        $this->logAction('update', 'perfil', 'actualizo su perfil');
        header('Location: index.php?controller=profile&action=index');
        exit;
    }
}
