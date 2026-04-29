<?php
require_once 'includes/header.php';
require_once 'includes/menu.php';
?>

<div class="container">
    <h1>Nuevo Contacto</h1>

    <div class="form-card">
        <form action="guardar.php" method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label>Nombre *</label>
                <input type="text" name="nombre" required maxlength="100">
            </div>

            <div class="form-group">
                <label>Apellido *</label>
                <input type="text" name="apellido" required maxlength="100">
            </div>

            <div class="form-group">
                <label>Teléfono *</label>
                <input type="tel" name="telefono" required maxlength="20"
                       pattern="[0-9+\-\s]+" title="Solo números, +, - y espacios">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" maxlength="150">
            </div>

            <div class="form-group">
                <label>Dirección</label>
                <input type="text" name="direccion" maxlength="255">
            </div>

            <div class="form-group">
                <label>Notas</label>
                <textarea name="notas"></textarea>
            </div>

            <div class="form-group">
                <label>Foto *</label>
                <input type="file" name="foto" accept="image/*" required>
            </div>

            <div style="display:flex; gap:10px; margin-top:10px;">
                <button type="submit" class="btn btn-success">Guardar Contacto</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </div>

        </form>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>