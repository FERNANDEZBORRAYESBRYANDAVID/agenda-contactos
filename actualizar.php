<?php
require_once 'config/db.php';

$id        = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$nombre    = trim($_POST['nombre'] ?? '');
$apellido  = trim($_POST['apellido'] ?? '');
$telefono  = trim($_POST['telefono'] ?? '');
$email     = trim($_POST['email'] ?? '');
$direccion = trim($_POST['direccion'] ?? '');
$notas     = trim($_POST['notas'] ?? '');
$foto_actual = $_POST['foto_actual'] ?? null;

if ($id === 0 || empty($nombre) || empty($apellido) || empty($telefono)) {
    die("Error: datos incompletos.");
}

if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Error: el email no tiene un formato válido.");
}

// Si subió nueva foto
$foto = $foto_actual;
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
    $extensiones = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $extensiones)) {
        die("Error: solo se permiten imágenes JPG, PNG, GIF o WEBP.");
    }

    // Borrar foto anterior
    if ($foto_actual && file_exists("uploads/" . $foto_actual)) {
        unlink("uploads/" . $foto_actual);
    }

    $foto = uniqid('foto_') . '.' . $ext;
    move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/" . $foto);
}

// UPDATE con sentencia preparada
$stmt = $pdo->prepare("
    UPDATE contactos
    SET nombre=:nombre, apellido=:apellido, telefono=:telefono,
        email=:email, direccion=:direccion, notas=:notas, foto=:foto
    WHERE id=:id
");

$stmt->execute([
    'nombre'    => $nombre,
    'apellido'  => $apellido,
    'telefono'  => $telefono,
    'email'     => $email ?: null,
    'direccion' => $direccion ?: null,
    'notas'     => $notas ?: null,
    'foto'      => $foto,
    'id'        => $id
]);

header("Location: index.php?msg=editado");
exit;