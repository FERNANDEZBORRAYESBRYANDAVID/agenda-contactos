<?php
require_once 'config/db.php';
require_once 'includes/header.php';
require_once 'includes/menu.php';
?>

<div class="container">
    <h1>Agenda de Contactos</h1>

    <!-- BUSCADOR -->
    <form class="buscador" method="GET" action="index.php">
        <input type="text" name="buscar" placeholder="Buscar por nombre, apellido o teléfono..."
               value="<?php echo isset($_GET['buscar']) ? htmlspecialchars($_GET['buscar']) : ''; ?>">
        <button type="submit" class="btn btn-primary">Buscar</button>
        <a href="index.php" class="btn btn-secondary">Limpiar</a>
    </form>

    <!-- MENSAJES -->
    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success">
            <?php
            $mensajes = [
                'creado'    => 'Contacto creado correctamente.',
                'editado'   => 'Contacto actualizado correctamente.',
                'eliminado' => 'Contacto eliminado correctamente.'
            ];
            echo htmlspecialchars($mensajes[$_GET['msg']] ?? '');
            ?>
        </div>
    <?php endif; ?>

    <a href="crear.php" class="btn btn-success" style="margin-bottom:20px; display:inline-block;">
        + Nuevo Contacto
    </a>

    <!-- TABLA DE CONTACTOS -->
    <table>
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $buscar = isset($_GET['buscar']) ? '%' . $_GET['buscar'] . '%' : '%';
        $stmt = $pdo->prepare("
            SELECT * FROM contactos
            WHERE nombre LIKE :buscar
               OR apellido LIKE :buscar
               OR telefono LIKE :buscar
            ORDER BY nombre ASC
        ");
        $stmt->execute(['buscar' => $buscar]);
        $contactos = $stmt->fetchAll();

        if (count($contactos) === 0): ?>
            <tr>
                <td colspan="5" style="text-align:center; padding:30px; color:#999;">
                    No se encontraron contactos.
                </td>
            </tr>
        <?php else: ?>
            <?php foreach ($contactos as $c): ?>
            <tr>
                <td>
                    <?php if ($c['foto']): ?>
                        <img src="uploads/<?php echo htmlspecialchars($c['foto']); ?>"
                             class="foto-mini" alt="foto">
                    <?php else: ?>
                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($c['nombre'].' '.$c['apellido']); ?>&size=45&background=2c3e50&color=fff"
                             class="foto-mini" alt="avatar">
                    <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($c['nombre'] . ' ' . $c['apellido']); ?></td>
                <td><?php echo htmlspecialchars($c['telefono']); ?></td>
                <td><?php echo htmlspecialchars($c['email'] ?? '—'); ?></td>
                <td style="display:flex; gap:6px; padding:12px 16px;">
                    <a href="ver.php?id=<?php echo $c['id']; ?>" class="btn btn-primary">Ver</a>
                    <a href="editar.php?id=<?php echo $c['id']; ?>" class="btn btn-warning">Editar</a>
                    <a href="eliminar.php?id=<?php echo $c['id']; ?>" class="btn btn-danger">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once 'includes/footer.php'; ?>