<?php
require_once 'config/db.php';

// Validación servidor
$nombre   = trim($_POST['nombre'] ?? '');
$apellido = trim($_POST['apellido'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$email    = trim($_POST['email'] ?? '');
$direccion= trim($_POST['direccion'] ?? '');
$notas    = trim($_POST['notas'] ?? '');

if (empty($nombre) || empty($apellido) || empty($telefono)) {
    die("Error: nombre, apellido y teléfono son obligatorios.");
}

if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Error: el email no tiene un formato válido.");
}

// Subida de foto
$foto = null;
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
    $extensiones = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $extensiones)) {
        die("Error: solo se permiten imágenes JPG, PNG, GIF o WEBP.");
    }

    $foto = uniqid('foto_') . '.' . $ext;
    move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/" . $foto);
}

// INSERT con sentencia preparada
$stmt = $pdo->prepare("
    INSERT INTO contactos (nombre, apellido, telefono, email, direccion, notas, foto)
    VALUES (:nombre, :apellido, :telefono, :email, :direccion, :notas, :foto)
");

$stmt->execute([
    'nombre'    => $nombre,
    'apellido'  => $apellido,
    'telefono'  => $telefono,
    'email'     => $email ?: null,
    'direccion' => $direccion ?: null,
    'notas'     => $notas ?: null,
    'foto'      => $foto
]);

header("Location: index.php?msg=creado");
exit;