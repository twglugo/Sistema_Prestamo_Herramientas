<!DOCTYPE html>
<html>
<head>
    <title>Listado de Detalles de Préstamo</title>
</head>
<body>
    <h1>Detalles de Préstamos Registrados</h1>
    <table border="1">
        <tr>
            <th>ID Detalle</th>
            <th>Cliente</th>
            <th>Herramienta</th>
            <th>Cantidad</th>
            <th>Fecha de Préstamo</th>
            <th>Estado</th>
        </tr>

        <?php foreach ($detalles as $detalle): ?>
            <tr>
                <td><?= htmlspecialchars($detalle['idDetallePrestamo']) ?></td>
                <td><?= htmlspecialchars($detalle['Usuario_Nombre'] . ' ' . $detalle['Usuario_Apellido']) ?></td>
                <td><?= htmlspecialchars($detalle['Herramienta_Nombre']) ?></td>
                <td><?= htmlspecialchars($detalle['Cantidad']) ?></td>
                <td><?= htmlspecialchars($detalle['Prestamo_FechaPres']) ?></td>
                <td><?= htmlspecialchars($detalle['Prestamo_Estado']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
