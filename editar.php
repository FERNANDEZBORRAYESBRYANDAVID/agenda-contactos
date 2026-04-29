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
    <h1>Editar Contacto</h1>

    <div class="form-card">
        <form action="actualizar.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $c['id']; ?>">
            <input type="hidden" name="foto_actual" value="<?php echo htmlspecialchars($c['foto'] ?? ''); ?>">

            <div class="form-group">
                <label>Nombre *</label>
                <input type="text" name="nombre" required maxlength="100"
                       value="<?php echo htmlspecialchars($c['nombre']); ?>">
            </div>

            <div class="form-group">
                <label>Apellido *</label>
                <input type="text" name="apellido" required maxlength="100"
                       value="<?php echo htmlspecialchars($c['apellido']); ?>">
            </div>

            <div class="form-group">
                <label>Teléfono *</label>
                <input type="tel" name="telefono" required maxlength="20"
                       pattern="[0-9+\-\s]+" title="Solo números, +, - y espacios"
                       value="<?php echo htmlspecialchars($c['telefono']); ?>">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" maxlength="150"
                       value="<?php echo htmlspecialchars($c['email'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label>Dirección</label>
                <input type="text" name="direccion" maxlength="255"
                       value="<?php echo htmlspecialchars($c['direccion'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label>Notas</label>
                <textarea name="notas"><?php echo htmlspecialchars($c['notas'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label>Foto actual</label><br>
                <?php if ($c['foto']): ?>
                    <img src="uploads/<?php echo htmlspecialchars($c['foto']); ?>"
                         style="width:80px;height:80px;border-radius:50%;object-fit:cover;margin-bottom:10px;display:block;">
                <?php endif; ?>
                <label>Cambiar foto (opcional)</label>
                <input type="file" name="foto" accept="image/*">
            </div>

            <div style="display:flex; gap:10px; margin-top:10px;">
                <button type="submit" class="btn btn-warning">Actualizar Contacto</button>
                <a href="ver.php?id=<?php echo $c['id']; ?>" class="btn btn-secondary">Cancelar</a>
            </div>

        </form>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>