<?php

declare(strict_types=1);

class AsignacionesController extends Controller
{
    private AsignacionModel $model;

    public function __construct()
    {
        $this->model = new AsignacionModel();
    }

    public function index(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['admin']);
        $this->render('asignaciones/index', ['rows' => $this->model->all()]);
    }

    public function create(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['admin']);
        $this->render('asignaciones/form', ['item' => null]);
    }

    public function store(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['admin']);
        $this->model->create(['nombre' => trim((string)$_POST['nombre']), 'descripcion' => trim((string)$_POST['descripcion'])]);
        $this->setFlash('success', 'Asignación creada correctamente.');
        $this->redirect('Asignaciones', 'index');
    }

    public function edit(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['admin']);
        $item = $this->model->find((int)($_GET['id'] ?? 0));
        if (!$item) {
            $this->setFlash('danger', 'Asignación no encontrada.');
            $this->redirect('Asignaciones', 'index');
        }
        $this->render('asignaciones/form', ['item' => $item]);
    }

    public function update(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['admin']);
        $this->model->update((int)$_POST['id'], ['nombre' => trim((string)$_POST['nombre']), 'descripcion' => trim((string)$_POST['descripcion'])]);
        $this->setFlash('success', 'Asignación actualizada correctamente.');
        $this->redirect('Asignaciones', 'index');
    }

    public function delete(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['admin']);
        $this->model->delete((int)($_GET['id'] ?? 0));
        $this->setFlash('success', 'Asignación eliminada.');
        $this->redirect('Asignaciones', 'index');
    }
}
