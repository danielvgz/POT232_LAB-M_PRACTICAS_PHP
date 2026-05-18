<?php

declare(strict_types=1);

class DocentesController extends Controller
{
    private DocenteModel $model;

    public function __construct()
    {
        $this->model = new DocenteModel();
    }

    public function index(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['admin']);
        $this->render('docentes/index', ['rows' => $this->model->all()]);
    }

    public function create(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['admin']);
        $this->render('docentes/form', ['item' => null]);
    }

    public function store(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['admin']);

        $this->model->create([
            'nombre' => trim((string)$_POST['nombre']),
            'apellido' => trim((string)$_POST['apellido']),
            'correo' => trim((string)$_POST['correo']),
            'especialidad' => trim((string)$_POST['especialidad']),
        ]);

        $this->setFlash('success', 'Docente creado correctamente.');
        $this->redirect('Docentes', 'index');
    }

    public function edit(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['admin']);
        $item = $this->model->find((int)($_GET['id'] ?? 0));
        if (!$item) {
            $this->setFlash('danger', 'Docente no encontrado.');
            $this->redirect('Docentes', 'index');
        }
        $this->render('docentes/form', ['item' => $item]);
    }

    public function update(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['admin']);
        $this->model->update((int)$_POST['id'], [
            'nombre' => trim((string)$_POST['nombre']),
            'apellido' => trim((string)$_POST['apellido']),
            'correo' => trim((string)$_POST['correo']),
            'especialidad' => trim((string)$_POST['especialidad']),
        ]);
        $this->setFlash('success', 'Docente actualizado correctamente.');
        $this->redirect('Docentes', 'index');
    }

    public function delete(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['admin']);
        $this->model->delete((int)($_GET['id'] ?? 0));
        $this->setFlash('success', 'Docente eliminado.');
        $this->redirect('Docentes', 'index');
    }
}
