<!DOCTYPE html>
<html>
<head>
    <title>Listado de Herramientas</title>
</head>
<body>
    <h1>Herramientas Registradas</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Stock</th>
            <th>Disponibles</th>
            <th>Actualizar</th>
            <th>Eliminar</th>
        </tr>

        <?php foreach ($herramientas as $herramienta): ?>
            <tr>
                <td><?= htmlspecialchars($herramienta['Herramienta_id']) ?></td>
                <td><?= htmlspecialchars($herramienta['Herramienta_Nombre']) ?></td>
                <td><?= htmlspecialchars($herramienta['Herramienta_Descrip']) ?></td>
                <td><?= htmlspecialchars($herramienta['Herramienta_CantidadTotal']) ?></td>
                <td><?= htmlspecialchars($herramienta['Herramienta_CantidadDisponible']) ?></td>
                <td><a href="index.php?ruta=actualizar_herramienta&id=<?= htmlspecialchars($herramienta['Herramienta_id']) ?>">Actualizar</a></td>
                <td><a href="index.php?ruta=eliminar_herramienta&id=<?= htmlspecialchars($herramienta['Herramienta_id']) ?>">Eliminar</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
