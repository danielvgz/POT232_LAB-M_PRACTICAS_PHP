<?php

declare(strict_types=1);

class InscripcionesController extends Controller
{
    private InscripcionModel $model;
    private AlumnoModel $alumnoModel;
    private AsignacionDocenteModel $asigDocModel;

    public function __construct()
    {
        $this->model = new InscripcionModel();
        $this->alumnoModel = new AlumnoModel();
        $this->asigDocModel = new AsignacionDocenteModel();
    }

    public function index(): void
    {
        Auth::requireLogin();
        $user = Auth::user();

        if ($user['rol'] === 'alumno') {
            $this->myEnrollments();
            return;
        }

        if ($user['rol'] === 'docente') {
            $rows = $user['docente_id'] ? $this->asigDocModel->enrolledByDocente((int)$user['docente_id']) : [];
            $this->render('inscripciones/docente', ['rows' => $rows]);
            return;
        }

        Auth::requireRole(['admin']);
        $this->render('inscripciones/index', ['rows' => $this->model->all()]);
    }

    public function create(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['admin']);
        $this->render('inscripciones/form', ['item' => null, 'alumnos' => $this->alumnoModel->all(), 'asignacionesDocente' => $this->asigDocModel->all()]);
    }

    public function store(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['admin']);
        $this->model->create([
            'id_alumno' => (int)$_POST['id_alumno'],
            'id_asignacion_docente' => (int)$_POST['id_asignacion_docente'],
            'fecha_inscripcion' => $_POST['fecha_inscripcion'] ?: date('Y-m-d'),
        ]);
        $this->setFlash('success', 'Inscripción creada correctamente.');
        $this->redirect('Inscripciones', 'index');
    }

    public function edit(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['admin']);
        $item = $this->model->find((int)($_GET['id'] ?? 0));
        if (!$item) {
            $this->setFlash('danger', 'Inscripción no encontrada.');
            $this->redirect('Inscripciones', 'index');
        }
        $this->render('inscripciones/form', ['item' => $item, 'alumnos' => $this->alumnoModel->all(), 'asignacionesDocente' => $this->asigDocModel->all()]);
    }

    public function update(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['admin']);
        $this->model->update((int)$_POST['id'], [
            'id_alumno' => (int)$_POST['id_alumno'],
            'id_asignacion_docente' => (int)$_POST['id_asignacion_docente'],
            'fecha_inscripcion' => $_POST['fecha_inscripcion'] ?: date('Y-m-d'),
        ]);
        $this->setFlash('success', 'Inscripción actualizada correctamente.');
        $this->redirect('Inscripciones', 'index');
    }

    public function delete(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['admin']);
        $this->model->delete((int)($_GET['id'] ?? 0));
        $this->setFlash('success', 'Inscripción eliminada.');
        $this->redirect('Inscripciones', 'index');
    }

    public function available(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['alumno']);
        $user = Auth::user();
        $rows = $user['alumno_id'] ? $this->model->availableForAlumno((int)$user['alumno_id']) : [];
        $this->render('inscripciones/available', ['rows' => $rows]);
    }

    public function selfEnroll(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['alumno']);
        $user = Auth::user();

        if (!$user['alumno_id']) {
            $this->setFlash('danger', 'Tu cuenta no está asociada a un alumno.');
            $this->redirect('Inscripciones', 'available');
        }

        $this->model->create([
            'id_alumno' => (int)$user['alumno_id'],
            'id_asignacion_docente' => (int)($_GET['id_asignacion_docente'] ?? 0),
            'fecha_inscripcion' => date('Y-m-d'),
        ]);

        $this->setFlash('success', 'Inscripción realizada correctamente.');
        $this->redirect('Inscripciones', 'myEnrollments');
    }

    public function myEnrollments(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['alumno']);
        $user = Auth::user();
        $rows = $user['alumno_id'] ? $this->model->byAlumno((int)$user['alumno_id']) : [];
        $this->render('inscripciones/my', ['rows' => $rows]);
    }
}
