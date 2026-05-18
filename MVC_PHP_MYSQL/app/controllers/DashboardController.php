<?php

declare(strict_types=1);

class DashboardController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();
        $user = Auth::user();

        $data = ['user' => $user, 'items' => [], 'enrolled' => []];

        if ($user['rol'] === 'docente' && $user['docente_id']) {
            $asigDocModel = new AsignacionDocenteModel();
            $data['items'] = $asigDocModel->byDocente((int)$user['docente_id']);
            $data['enrolled'] = $asigDocModel->enrolledByDocente((int)$user['docente_id']);
        }

        if ($user['rol'] === 'alumno' && $user['alumno_id']) {
            $insModel = new InscripcionModel();
            $data['items'] = $insModel->availableForAlumno((int)$user['alumno_id']);
            $data['enrolled'] = $insModel->byAlumno((int)$user['alumno_id']);
        }

        $this->render('dashboard/index', $data);
    }
}
