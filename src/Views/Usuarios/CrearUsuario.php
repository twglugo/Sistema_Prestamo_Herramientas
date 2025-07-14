<!DOCTYPE html>
<html>
<head>
    <title>Crear Usuario</title>
</head>
<body>
    <h1>Nuevo Usuario</h1>
    <form method="POST" action="index.php?ruta=crear_usuario">
        <label>Cédula:</label>
        <input type="number" name="cedula" required><br><br>

        <label>Nombre:</label>
        <input type="text" name="nombre" required><br><br>

        <label>Apellido:</label>
        <input type="text" name="apellido" required><br><br>

        <label>Email:</label>
        <input type="email" name="email" required><br><br>
        
        <label>Rol:</label>
        <select name="rol" required>
            <option value="Usuario">Usuario</option>
            <option value="Admin">Admin</option>
        </select><br><br>

        <button type="submit">Guardar</button>
    </form>
</body>
</html>
