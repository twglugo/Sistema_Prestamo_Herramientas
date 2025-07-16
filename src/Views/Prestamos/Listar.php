<!DOCTYPE html>

<html>
<head>
    <title>Listado de Préstamos</title>
</head>
<body>
    <h1>Préstamos Registrados</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre Cliente</th>
            <th>Fecha de Préstamo</th>
            <th>Fecha de Devolución</th>
            <th>Estado</th>
            <th>Actualizar</th>
            <th>Devolución</th>
        </tr>

        <?php foreach ($prestamos as $prestamo): ?>
            <tr>
                <?php
                $fechaPres = new DateTime($prestamo['Prestamo_FechaPres']);
                $fechaDev = $prestamo['Prestamo_FechaDev'];

                if ($fechaDev == null) {
                    $hoy = new DateTime();
                $diferencia = $fechaPres->diff($hoy);
                $textoDevolucion = 'Pendiente hace ' . $diferencia->days . ' días';

                } else {
                    $textoDevolucion = htmlspecialchars($fechaDev);
                }
                ?>


                <td><?= htmlspecialchars($prestamo['Prestamos_Id']) ?></td>
                <td><?= htmlspecialchars($prestamo['Usuario_Nombre'] .  " " . $prestamo['Usuario_Apellido']) ?></td>
                <td><?= htmlspecialchars($prestamo['Prestamo_FechaPres']) ?></td>
                <td><?= $textoDevolucion ?></td>
                <td><?= htmlspecialchars($prestamo['Prestamo_Estado']) ?></td>
                <td><a href="index.php?ruta=actualizar_prestamo&id=<?= htmlspecialchars($prestamo['Prestamos_Id']) ?>">Actualizar</a></td>
                <td><a href="index.php?ruta=devolver_todo&id=<?= htmlspecialchars($prestamo['Prestamos_Id']) ?>"&estado=<?= htmlspecialchars($prestamo['Prestamo_Estado'])?>>Cambiar estado</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
