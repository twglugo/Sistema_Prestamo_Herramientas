
<?php
session_start();
if (!isset($_SESSION['usuario']) || strtolower($_SESSION['rol']) !== 'admin') {
    header('Location: index.php?ruta=login');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Crear Usuario</title>
    <link rel="stylesheet" href="assets/css/crear.css">
</head>
<body>
    <div class="form-container">
        <h1>Nuevo Usuario</h1>
        <?php if (isset($mensaje) && $mensaje): ?>
            <div style="background:#d9534f;color:#fff;padding:10px 16px;border-radius:6px;margin-bottom:18px;text-align:center;font-weight:bold;">
                <?= htmlspecialchars($mensaje) ?>
            </div>
        <?php endif; ?>
        <a href="index.php?ruta=dashboard_admin" style="display:block;margin-bottom:18px;text-align:center;text-decoration:none;">
            <button type="button" 
            style="width:100%;background:linear-gradient(90deg,#28a745 0%,#218838 100%);color:#fff;border:none;border-radius:6px;padding:10px 0;font-size:16px;font-weight:bold;cursor:pointer;box-shadow:0 1px 4px
             #28a74533;transition:background 0.2s,box-shadow 0.2s,transform 0.1s;
             margin-bottom:10px;">&#8592; Volver al Dashboard</button>
        </a>
        <form method="POST" action="index.php?ruta=crear_usuario">
            <label for="cedula">Cédula</label>
            <input type="number" name="cedula" id="cedula" required>

            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" required>

            <label for="apellido">Apellido</label>
            <input type="text" name="apellido" id="apellido" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>

            <label for="rol">Rol</label>
            <?php if (isset($_SESSION['rol']) && strtolower($_SESSION['rol']) === 'admin'): ?>
                <select name="rol" id="rol" required data-admin="true">
                    <option value="Usuario">Usuario</option>
                    <option value="Admin">Admin</option>
                </select>
            <?php else: ?>
                <select name="rol" id="rol" required disabled style="background:#e9ecef;">
                    <option value="Usuario">Usuario</option>
                    <option value="Admin">Admin</option>
                </select>
            <?php endif; ?>

            <button type="submit" id="btnGuardar" disabled>Guardar</button>
        </form>
</form>
    <script src="assets/js/Usuario.js"></script>
    
    </script>
    </div>
</body>
</html>
