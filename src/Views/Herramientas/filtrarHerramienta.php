<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['rol'])) {
    header('Location: index.php?ruta=login');
    exit;
}


$rol = strtolower($_SESSION['rol']);
$estado = false;

if ($rol === 'admin') {
    $cedula = $_SESSION['cedula'] ?? '';
    $estado = 'admin';
} elseif ($rol === 'usuario') {
    $cedula = $_SESSION['cedula'] ?? '';
    $estado = 'usuario';
} else {
    header('Location: index.php?ruta=login');
    exit;
}
?>


<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="assets/css/filtrar.css">
    <title>Filtro de Herramientas</title>
    
</head>
<body>
    <div class="container">
        <h1>Filtro de Herramientas</h1>
        <div style="display:flex;justify-content:center;margin-bottom:18px;">
            <button onclick="window.location.href='index.php?ruta=dashboard_<?=$rol?> '" style="padding:8px 18px;background:#007bff;color:#fff;border:none;border-radius:6px;cursor:pointer;font-weight:bold;">Regresar al Dashboard</button>
        </div>
        <form method="POST" action="index.php?ruta=buscar_herramienta">
            
            <input type="text" name="nombre" placeholder="Nombre">
            <input type="text" name="descripcion" placeholder="Descripción">
            <input type="number"name="cantidadStock" placeholder="Cantidad Stock">
            <input type="text" name="cantidadDisponible" placeholder="Cantidad Disponible">
            <button type="submit">Buscar</button>
        </form>

        <?php if (isset($herramientas) && is_array($herramientas) && count($herramientas) > 0): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Stock Total</th>
                <th>Disponibles</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($herramientas as $herramienta): ?>
                <tr>
                    <td><?= htmlspecialchars($herramienta['Herramienta_id']) ?></td>
                    <td><?= htmlspecialchars($herramienta['Herramienta_Nombre']) ?></td>
                    <td><?= htmlspecialchars($herramienta['Herramienta_Descrip']) ?></td>
                    <td><?= htmlspecialchars($herramienta['Herramienta_CantidadTotal']) ?></td>
                    <td><?= htmlspecialchars($herramienta['Herramienta_CantidadDisponible']) ?></td>
                    <?php if ($estado === 'admin'): ?>
                        <td class="action-cell">
                            <a href="index.php?ruta=actualizar_herramienta&id=<?= htmlspecialchars($herramienta['Herramienta_id']) ?>" class="action-btn"> Actualizar</a>
                        </td>
                    <?php elseif ($estado === 'usuario' && $herramienta['Herramienta_CantidadDisponible'] > 0): ?>
                        <td class="action-cell">
                            <a href="index.php?ruta=crear_prestamo&id=<?= htmlspecialchars($herramienta['Herramienta_id']) ?>" class="action-btn"> Pedir prestado</a>
                        </td>
                    <?php else: ?>
                        <td class="action-cell">Sin Existencias Disponibles</td>
                    <?php endif; ?>

                </tr>
            <?php endforeach; ?>
        </table>
        <?php elseif (isset($herramientas)): ?>
            <p style="text-align:center;color:#d9534f;"><?= htmlspecialchars($mensaje)?></p>
        <?php endif; ?>
        <?php if(!empty($mensaje)):?>
            <p style="text-align:center;color:#d9534f;"><?= htmlspecialchars($mensaje)?></p>
        <?php endif;?>
    </div>
</body>
</html>
