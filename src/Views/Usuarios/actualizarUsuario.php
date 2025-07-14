<!DOCTYPE html>
<html>
<head>
    <title>Modificar Usuario</title>
</head>
<body>

    <h1>Actualizar Usuario: <?= htmlspecialchars($usuario->getNombre() . $usuario->getApellido()) ?></h1>

    <form method="POST" action="index.php?ruta=actualizar_usuario">
        <label>Cédula:</label>
        <input type="number" name="cedula" value="<?= htmlspecialchars($usuario->getCedula()) ?>" readonly><br><br>

        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($usuario->getNombre()) ?>" required><br><br>

        <label>Apellido:</label>
        <input type="text" name="apellido" value="<?= htmlspecialchars($usuario->getApellido()) ?>" required><br><br>

        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($usuario->getEmail()) ?>" required><br><br>
        
        <label>Rol:</label>
        <select name="rol" required>
            <option value="Usuario" <?= $usuario->getRol() === 'Usuario' ? 'selected' : '' ?>>Usuario</option>
            <option value="Admin" <?= $usuario->getRol() === 'Admin' ? 'selected' : '' ?>>Admin</option>
        </select><br><br>

        <button type="submit">Guardar Cambios</button>
    </form>

</body>
</html>
