<!DOCTYPE html>
<html>
<head>
    <title >Listado de Usuarios</title>
</head>
<body>
    <h1>Usuarios Registrados</h1>
    <table border="1">
        <tr>
            <th>Cédula</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Actualizar</th>
            <th>Eliminar</th>
        </tr>
        <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?= htmlspecialchars($usuario['Usuario_Cedula']) ?></td>
                <td><?= $complejo = htmlspecialchars($usuario['Usuario_Nombre'] . ' ' . $usuario['Usuario_Apellido']) ?></td>
                <td><?= htmlspecialchars($usuario['Usuario_Email']) ?></td>
                <td><?= htmlspecialchars($usuario['Usuario_Rol']) ?></td>
                <td><a href="index.php?ruta=actualizar_usuario&cedula=<?= htmlspecialchars($usuario['Usuario_Cedula']) ?>">Actualizar</a></td>
                <td><a href="index.php?ruta=eliminar_usuario&cedula=<?= htmlspecialchars($usuario['Usuario_Cedula']) ?>">Eliminar</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
