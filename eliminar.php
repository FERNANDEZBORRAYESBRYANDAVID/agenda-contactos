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

// Si confirmaron la eliminación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Borrar foto del servidor
    if ($c['foto'] && file_exists("uploads/" . $c['foto'])) {
        unlink("uploads/" . $c['foto']);
    }

    // DELETE con sentencia preparada
    $stmt = $pdo->prepare("DELETE FROM contactos WHERE id = :id");
    $stmt->execute(['id' => $id]);

    header("Location: index.php?msg=eliminado");
    exit;
}
?>

<div class="container">
    <h1>Eliminar Contacto</h1>

    <div class="detalle-card">
        <?php if ($c['foto']): ?>
            <img src="uploads/<?php echo htmlspecialchars($c['foto']); ?>" alt="foto">
        <?php else: ?>
            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($c['nombre'].' '.$c['apellido']); ?>&size=120&background=2c3e50&color=fff" alt="avatar">
        <?php endif; ?>

        <h2><?php echo htmlspecialchars($c['nombre'] . ' ' . $c['apellido']); ?></h2>

        <p style="color:#e74c3c; margin:15px 0; font-size:15px;">
            ¿Estás seguro de que deseas eliminar este contacto? Esta acción no se puede deshacer.
        </p>

        <form method="POST" action="eliminar.php?id=<?php echo $c['id']; ?>">
            <div style="display:flex; gap:10px; justify-content:center;">
                <button type="submit" class="btn btn-danger">Sí, eliminar</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>