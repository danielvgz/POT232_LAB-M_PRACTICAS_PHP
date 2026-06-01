<?php
require_once BASE_PATH . '/controllers/BaseCrudController.php';
require_once BASE_PATH . '/models/MatriculaModel.php';
require_once BASE_PATH . '/models/MateriaModel.php';

class MatriculasController extends BaseCrudController
{
    private $model;
    private $materiaModel;

    public function __construct()
    {
        $this->model = new MatriculaModel();
        $this->materiaModel = new MateriaModel();
    }

    public function index()
    {
        $this->requireAuth();
        $user = $this->currentUser();
        $role = $this->currentRole();
        $materiaId = isset($_GET['materia_id']) ? (int) $_GET['materia_id'] : 0;
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        if ($role === 'alumno' && !empty($user['alumno_id'])) {
            $rows = $this->model->byAlumnoId((int) $user['alumno_id']);
            $availableMaterias = $this->materiaModel->availableForAlumno((int) $user['alumno_id']);
            $canEnroll = true;
            $title = 'Mis matriculas y calificaciones';
        } elseif ($this->isProfesor() || $this->isAdmin()) {
            $docenteId = $this->isAdmin() ? (!empty($_GET['docente_id']) ? (int) $_GET['docente_id'] : 0) : (int) $user['docente_id'];
            $rows = $docenteId ? $this->model->byMateriaAndDocente($docenteId, $materiaId ?: null) : $this->model->all();
            if (!$docenteId && $materiaId) {
                $rows = array_values(array_filter($rows, function ($row) use ($materiaId) {
                    return (int) $row['materia_id'] === (int) $materiaId;
                }));
            }
            $availableMaterias = $docenteId ? $this->model->docenteMaterias($docenteId) : $this->materiaModel->all();
            $canManage = true;
            $title = 'Alumnos inscritos';
        } else {
            $rows = array();
            $availableMaterias = array();
            $canEnroll = false;
            $title = 'Matriculas';
        }

        $rowsData = $this->paginateRows($rows, $page, 10);
        $viewData = $rowsData + array(
            'title' => $title,
            'role' => $role,
            'materiaId' => $materiaId,
            'materias' => $availableMaterias,
            'canManage' => isset($canManage) ? $canManage : false,
            'canEnroll' => isset($canEnroll) ? $canEnroll : false,
            'maxCreditos' => 12,
        );

        $this->view('matriculas/index', $viewData);
    }

    public function form()
    {
        $this->requireRole(array('maestro', 'profesor', 'admin'));
        $user = $this->currentUser();
        $row = array(
            'id' => '',
            'alumno_id' => '',
            'docente_id' => !empty($user['docente_id']) ? (int) $user['docente_id'] : '',
            'materia_id' => '',
            'fecha_matricula' => date('Y-m-d'),
            'obj1' => '',
            'obj2' => '',
            'obj3' => '',
            'obj4' => '',
        );
        if (!empty($_GET['id'])) {
            $found = $this->model->find((int) $_GET['id']);
            if ($found && ($this->isAdmin() || (int) $found['docente_id'] === (int) $user['docente_id'])) {
                $row = $found;
            } else {
                header('Location: index.php?controller=matriculas&action=index');
                exit;
            }
        }

        $materias = $this->isAdmin() ? $this->materiaModel->all() : $this->model->docenteMaterias((int) $user['docente_id']);

        $this->view('matriculas/form', array(
            'row' => $row,
            'alumnos' => $this->model->alumnos(),
            'materias' => $materias,
            'docentes' => $this->materiaModel->docentes(),
            'canEditDocente' => $this->isAdmin(),
            'showGrades' => true,
        ));
    }

    public function save()
    {
        $this->requireRole(array('maestro', 'profesor', 'admin'));
        $user = $this->currentUser();
        $data = array(
            'id' => $this->clean('id'),
            'alumno_id' => (int) $this->clean('alumno_id'),
            'docente_id' => $this->isAdmin() ? (int) $this->clean('docente_id') : (int) $user['docente_id'],
            'materia_id' => (int) $this->clean('materia_id'),
            'fecha_matricula' => $this->clean('fecha_matricula', date('Y-m-d')),
            'obj1' => $this->clean('obj1'),
            'obj2' => $this->clean('obj2'),
            'obj3' => $this->clean('obj3'),
            'obj4' => $this->clean('obj4'),
        );

        $this->model->save($data);
        $this->logAction('update', 'matriculas', 'actualizo una matricula');
        header('Location: index.php?controller=matriculas&action=index');
        exit;
    }

    public function inscribir()
    {
        $this->requireRole(array('alumno'));
        $user = $this->currentUser();
        $materiaId = (int) $this->clean('materia_id');
        $materia = null;
        foreach ($this->materiaModel->availableForAlumno((int) $user['alumno_id']) as $row) {
            if ((int) $row['id'] === $materiaId) {
                $materia = $row;
                break;
            }
        }

        if (!$materia || empty($materia['docente_id'])) {
            header('Location: index.php?controller=matriculas&action=index&error=inscripcion');
            exit;
        }

        $totalCreditos = $this->model->availableCredits((int) $user['alumno_id']);
        if (($totalCreditos + (int) $materia['creditos']) > 12) {
            header('Location: index.php?controller=matriculas&action=index&error=creditos');
            exit;
        }

        $this->model->save(array(
            'id' => '',
            'alumno_id' => (int) $user['alumno_id'],
            'docente_id' => (int) $materia['docente_id'],
            'materia_id' => $materiaId,
            'fecha_matricula' => date('Y-m-d'),
            'obj1' => '',
            'obj2' => '',
            'obj3' => '',
            'obj4' => '',
        ));
        $this->logAction('create', 'matriculas', 'alumno se inscribio');
        header('Location: index.php?controller=matriculas&action=index');
        exit;
    }

    public function exportar()
    {
        $this->requireRole(array('maestro', 'profesor', 'admin'));
        $user = $this->currentUser();
        $docenteId = $this->isAdmin() ? (!empty($_GET['docente_id']) ? (int) $_GET['docente_id'] : 0) : (int) $user['docente_id'];
        $materiaId = isset($_GET['materia_id']) ? (int) $_GET['materia_id'] : 0;
        $rows = $docenteId ? $this->model->byMateriaAndDocente($docenteId, $materiaId ?: null) : $this->model->all();
        if (!$docenteId && $materiaId) {
            $rows = array_values(array_filter($rows, function ($row) use ($materiaId) {
                return (int) $row['materia_id'] === (int) $materiaId;
            }));
        }

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=alumnos_inscritos.csv');
        $output = fopen('php://output', 'w');
        fputcsv($output, array('ID', 'Alumno', 'Materia', 'Docente', 'Obj1', 'Obj2', 'Obj3', 'Obj4'));
        foreach ($rows as $row) {
            fputcsv($output, array(
                $row['id'],
                $row['alumno_nombre'] . ' ' . $row['alumno_apellido'],
                $row['materia_nombre'],
                $row['docente_nombre'] . ' ' . $row['docente_apellido'],
                $row['obj1'],
                $row['obj2'],
                $row['obj3'],
                $row['obj4'],
            ));
        }
        fclose($output);
        $this->logAction('export', 'matriculas', 'exporto lista de alumnos');
        exit;
    }

    public function delete()
    {
        $this->requireRole(array('maestro', 'profesor', 'admin'));
        if (!empty($_GET['id'])) {
            $found = $this->model->find((int) $_GET['id']);
            $user = $this->currentUser();
            if ($found && ($this->isAdmin() || (int) $found['docente_id'] === (int) $user['docente_id'])) {
                $this->model->delete((int) $_GET['id']);
                $this->logAction('delete', 'matriculas', 'elimino una matricula');
            }
        }
        header('Location: index.php?controller=matriculas&action=index');
        exit;
    }
}
