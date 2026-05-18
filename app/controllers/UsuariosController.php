<?php

declare(strict_types=1);

class UsuariosController extends Controller
{
    private UsuarioModel $model;
    private AlumnoModel $alumnoModel;
    private DocenteModel $docenteModel;

    public function __construct()
    {
        $this->model = new UsuarioModel();
        $this->alumnoModel = new AlumnoModel();
        $this->docenteModel = new DocenteModel();
    }

    public function index(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['admin']);
        $this->render('usuarios/index', ['rows' => $this->model->all()]);
    }

    public function create(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['admin']);
        $this->render('usuarios/form', ['item' => null, 'alumnos' => $this->alumnoModel->all(), 'docentes' => $this->docenteModel->all()]);
    }

    public function store(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['admin']);

        $this->model->create([
            'username' => trim((string)$_POST['username']),
            'correo' => trim((string)$_POST['correo']),
            'password_hash' => password_hash((string)$_POST['password'], PASSWORD_DEFAULT),
            'rol' => (string)$_POST['rol'],
            'alumno_id' => $_POST['alumno_id'] !== '' ? (int)$_POST['alumno_id'] : null,
            'docente_id' => $_POST['docente_id'] !== '' ? (int)$_POST['docente_id'] : null,
        ]);

        $this->setFlash('success', 'Usuario creado correctamente.');
        $this->redirect('Usuarios', 'index');
    }

    public function edit(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['admin']);
        $item = $this->model->find((int)($_GET['id'] ?? 0));
        if (!$item) {
            $this->setFlash('danger', 'Usuario no encontrado.');
            $this->redirect('Usuarios', 'index');
        }
        $this->render('usuarios/form', ['item' => $item, 'alumnos' => $this->alumnoModel->all(), 'docentes' => $this->docenteModel->all()]);
    }

    public function update(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['admin']);

        $passwordHash = trim((string)($_POST['password'] ?? ''));

        $this->model->update((int)$_POST['id'], [
            'username' => trim((string)$_POST['username']),
            'correo' => trim((string)$_POST['correo']),
            'rol' => (string)$_POST['rol'],
            'alumno_id' => $_POST['alumno_id'] !== '' ? (int)$_POST['alumno_id'] : null,
            'docente_id' => $_POST['docente_id'] !== '' ? (int)$_POST['docente_id'] : null,
            'password_hash' => $passwordHash !== '' ? password_hash($passwordHash, PASSWORD_DEFAULT) : null,
        ]);

        $this->setFlash('success', 'Usuario actualizado correctamente.');
        $this->redirect('Usuarios', 'index');
    }

    public function delete(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['admin']);
        $this->model->delete((int)($_GET['id'] ?? 0));
        $this->setFlash('success', 'Usuario eliminado.');
        $this->redirect('Usuarios', 'index');
    }
}
