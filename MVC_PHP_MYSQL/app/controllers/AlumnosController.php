<?php

declare(strict_types=1);

class AlumnosController extends Controller
{
    private AlumnoModel $model;

    public function __construct()
    {
        $this->model = new AlumnoModel();
    }

    public function index(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['admin']);
        $this->render('alumnos/index', ['rows' => $this->model->all()]);
    }

    public function create(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['admin']);
        $this->render('alumnos/form', ['item' => null]);
    }

    public function store(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['admin']);

        $foto = $this->handleFotoUpload(null);

        $this->model->create([
            'nombre' => trim((string)$_POST['nombre']),
            'apellido' => trim((string)$_POST['apellido']),
            'sexo' => (int)($_POST['sexo'] ?? 1),
            'fecha_nacimiento' => $_POST['fecha_nacimiento'] ?: null,
            'fecha_registro' => $_POST['fecha_registro'] ?: date('Y-m-d'),
            'foto' => $foto,
            'correo' => trim((string)$_POST['correo']),
        ]);

        $this->setFlash('success', 'Alumno creado correctamente.');
        $this->redirect('Alumnos', 'index');
    }

    public function edit(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['admin']);

        $item = $this->model->find((int)($_GET['id'] ?? 0));
        if (!$item) {
            $this->setFlash('danger', 'Alumno no encontrado.');
            $this->redirect('Alumnos', 'index');
        }

        $this->render('alumnos/form', ['item' => $item]);
    }

    public function update(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['admin']);

        $id = (int)($_POST['id'] ?? 0);
        $item = $this->model->find($id);
        if (!$item) {
            $this->setFlash('danger', 'Alumno no encontrado.');
            $this->redirect('Alumnos', 'index');
        }

        $foto = $this->handleFotoUpload($item['foto']);

        $this->model->update($id, [
            'nombre' => trim((string)$_POST['nombre']),
            'apellido' => trim((string)$_POST['apellido']),
            'sexo' => (int)($_POST['sexo'] ?? 1),
            'fecha_nacimiento' => $_POST['fecha_nacimiento'] ?: null,
            'fecha_registro' => $_POST['fecha_registro'] ?: null,
            'foto' => $foto,
            'correo' => trim((string)$_POST['correo']),
        ]);

        $this->setFlash('success', 'Alumno actualizado correctamente.');
        $this->redirect('Alumnos', 'index');
    }

    public function delete(): void
    {
        Auth::requireLogin();
        Auth::requireRole(['admin']);
        $this->model->delete((int)($_GET['id'] ?? 0));
        $this->setFlash('success', 'Alumno eliminado.');
        $this->redirect('Alumnos', 'index');
    }

    private function handleFotoUpload(?string $currentPhoto): string
    {
        $config = require ROOT_PATH . '/config/config.php';
        $uploadConfig = $config['upload'];

        if (!is_dir($uploadConfig['alumnos_dir'])) {
            mkdir($uploadConfig['alumnos_dir'], 0775, true);
        }

        if (empty($_FILES['foto']['name'])) {
            return $currentPhoto ?: 'default.png';
        }

        if ($_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
            throw new RuntimeException('Error al subir la imagen.');
        }

        if ((int)$_FILES['foto']['size'] > $uploadConfig['max_size']) {
            throw new RuntimeException('La imagen excede el límite de 2MB.');
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = (string)$finfo->file($_FILES['foto']['tmp_name']);
        if (!isset($uploadConfig['allowed_mime'][$mime])) {
            throw new RuntimeException('Formato de imagen no permitido.');
        }

        $ext = $uploadConfig['allowed_mime'][$mime];
        $filename = 'alumno_' . date('YmdHis') . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
        $target = $uploadConfig['alumnos_dir'] . '/' . $filename;

        if (!move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
            throw new RuntimeException('No se pudo guardar la imagen.');
        }

        if ($currentPhoto && $currentPhoto !== 'default.png') {
            $oldPath = $uploadConfig['alumnos_dir'] . '/' . $currentPhoto;
            if (is_file($oldPath)) {
                @unlink($oldPath);
            }
        }

        return $filename;
    }
}
