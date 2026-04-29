<?php
require_once 'config/db.php';
require_once 'includes/header.php';
require_once 'includes/menu.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id === 0) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM contactos WHERE id = :id");
$stmt->execute(['id' => $id]);
$c = $stmt->fetch();

if (!$c) {
    header("Location: index.php");
    exit;
}
?>

<div class="container">
    <h1>Detalle del Contacto</h1>

    <div class="detalle-card">
        <?php if ($c['foto']): ?>
            <img src="uploads/<?php echo htmlspecialchars($c['foto']); ?>" alt="foto">
        <?php else: ?>
            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($c['nombre'].' '.$c['apellido']); ?>&size=120&background=2c3e50&color=fff" alt="avatar">
        <?php endif; ?>

        <h2><?php echo htmlspecialchars($c['nombre'] . ' ' . $c['apellido']); ?></h2>

        <div class="detalle-info">
            <p><span>Teléfono:</span> <?php echo htmlspecialchars($c['telefono']); ?></p>
            <p><span>Email:</span> <?php echo htmlspecialchars($c['email'] ?? '—'); ?></p>
            <p><span>Dirección:</span> <?php echo htmlspecialchars($c['direccion'] ?? '—'); ?></p>
            <p><span>Notas:</span> <?php echo htmlspecialchars($c['notas'] ?? '—'); ?></p>
            <p><span>Registrado:</span> <?php echo $c['created_at']; ?></p>
        </div>

        <div style="display:flex; gap:10px; margin-top:20px; justify-content:center;">
            <a href="editar.php?id=<?php echo $c['id']; ?>" class="btn btn-warning">Editar</a>
            <a href="eliminar.php?id=<?php echo $c['id']; ?>" class="btn btn-danger">Eliminar</a>
            <a href="index.php" class="btn btn-secondary">Volver</a>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>