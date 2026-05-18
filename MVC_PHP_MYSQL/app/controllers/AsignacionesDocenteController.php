<?php

declare(strict_types=1);

class AsignacionesDocenteController extends Controller
{
    private AsignacionDocenteModel $model;
    private AsignacionModel $asignacionModel;
    private DocenteModel $docenteModel;

    public function __construct()
    {
        $this->model = new AsignacionDocenteModel();
        $this->asignacionModel = new AsignacionModel();
        $this->docenteModel = new DocenteModel();
    }

    public function index(): void
    {
        Auth::requireLogin();
        $user = Auth::user();

        if ($user['rol'] === 'docente' && $user['docente_id']) {
            $this->render('asignaciones_docente/index', ['rows' => $this->model->byDocente((int)$user['docente_id']), 'isDocente' => true]);
            return;
        }

        Auth::requireRole(['admin']);
        $this->render('asignaciones_docente/index', ['rows' => $this->model->all(), 'isDocente' => false]);
    }

    public function create(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['admin']);
        $this->render('asignaciones_docente/form', ['item' => null, 'asignaciones' => $this->asignacionModel->all(), 'docentes' => $this->docenteModel->all()]);
    }

    public function store(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['admin']);
        $this->model->create(['id_asignacion' => (int)$_POST['id_asignacion'], 'id_docente' => (int)$_POST['id_docente']]);
        $this->setFlash('success', 'Asignación a docente creada correctamente.');
        $this->redirect('AsignacionesDocente', 'index');
    }

    public function edit(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['admin']);
        $item = $this->model->find((int)($_GET['id'] ?? 0));
        if (!$item) {
            $this->setFlash('danger', 'Registro no encontrado.');
            $this->redirect('AsignacionesDocente', 'index');
        }
        $this->render('asignaciones_docente/form', ['item' => $item, 'asignaciones' => $this->asignacionModel->all(), 'docentes' => $this->docenteModel->all()]);
    }

    public function update(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['admin']);
        $this->model->update((int)$_POST['id'], ['id_asignacion' => (int)$_POST['id_asignacion'], 'id_docente' => (int)$_POST['id_docente']]);
        $this->setFlash('success', 'Registro actualizado correctamente.');
        $this->redirect('AsignacionesDocente', 'index');
    }

    public function delete(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['admin']);
        $this->model->delete((int)($_GET['id'] ?? 0));
        $this->setFlash('success', 'Registro eliminado.');
        $this->redirect('AsignacionesDocente', 'index');
    }

    public function enrolled(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['docente']);
        $user = Auth::user();

        $rows = [];
        if ($user['docente_id']) {
            $rows = $this->model->enrolledByDocente((int)$user['docente_id']);
        }

        $this->render('asignaciones_docente/enrolled', ['rows' => $rows]);
    }
}
