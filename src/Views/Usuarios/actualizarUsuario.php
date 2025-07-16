<!DOCTYPE html>
<html>

<head>
    <title>Modificar Usuario</title>
    <style>
        body { background: #f4f4f4; font-family: Arial, sans-serif; }
        .form-container {
            max-width: 420px;
            margin: 40px auto;
            background: #fff;
            padding: 28px 30px;
            border-radius: 10px;
            box-shadow: 0 2px 12px #bbb;
        }
        h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 22px;
        }
        label {
            font-weight: bold;
            color: #333;
            display: block;
            margin-bottom: 6px;
        }
        select, input[type="number"], input[type="text"], input[type="email"] {
            width: 100%;
            padding: 8px 10px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
            background: #f9f9f9;
            box-sizing: border-box;
        }
        input[readonly] {
            background: #e9ecef;
        }
        button[type="submit"] {
            width: 100%;
            background: linear-gradient(90deg, #007bff 0%, #0056b3 100%);
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 10px 0;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 1px 4px #007bff33;
            transition: background 0.2s, box-shadow 0.2s, transform 0.1s;
        }
        button[type="submit"]:hover:not(:disabled) {
            background: linear-gradient(90deg, #0056b3 0%, #007bff 100%);
            box-shadow: 0 2px 8px #007bff44;
            transform: scale(1.03);
        }
        button:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Actualizar Usuario: <?= htmlspecialchars($usuario->getNombre())?></h1>
        <?php
            
            $rutaDashboard = 'dashboard';
            if (isset($_SESSION['rol'])) {
                $rol = strtolower($_SESSION['rol']);
                if ($rol === 'admin') {
                    $rutaDashboard = 'dashboard_admin';
                } elseif ($rol === 'usuario') {
                    $rutaDashboard = 'dashboard_usuario';
                }
            }
        ?>
        <a href="index.php?ruta=<?= $rutaDashboard ?>" style="display:block;margin-bottom:18px;text-align:center;text-decoration:none;">
            <button type="button" 
            style="width:100%;background:linear-gradient(90deg,#28a745 0%,#218838 100%);color:#fff;border:none;border-radius:6px;padding:10px 0;font-size:16px;font-weight:bold;cursor:pointer;box-shadow:0 1px 4px
                #28a74533;transition:background 0.2s,box-shadow 0.2s,transform 0.1s;
                margin-bottom:10px;">&#8592; Volver al Dashboard</button>
        </a>
        <form method="POST" action="index.php?ruta=actualizar_usuario">

            <input type="hidden" name="sessionRol" value="<?= isset($_SESSION['rol']) ? htmlspecialchars($_SESSION['rol']) : '' ?>">
            <label for="cedula">Cédula</label>
            <input type="number" name="cedula" id="cedula" value="<?= htmlspecialchars($usuario->getCedula()) ?>" readonly>

            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($usuario->getNombre()) ?>" required>

            <label for="apellido">Apellido</label>
            <input type="text" name="apellido" id="apellido" value="<?= htmlspecialchars($usuario->getApellido()) ?>" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= htmlspecialchars($usuario->getEmail()) ?>" required>

            <label for="rol">Rol</label>
            <?php  ?>
            <?php if (isset($_SESSION['rol']) && strtolower($_SESSION['rol']) === 'admin'): ?>
                <select name="rol" id="rol" required data-admin="true">
                    <option value="Usuario" <?= $usuario->getRol() === 'Usuario' ? 'selected' : '' ?>>Usuario</option>
                    <option value="Admin" <?= $usuario->getRol() === 'Admin' ? 'selected' : '' ?>>Admin</option>
                </select>
            <?php else: ?>
                <select id="rol" disabled style="background:#e9ecef;">
                    <option value="Usuario" <?= $usuario->getRol() === 'Usuario' ? 'selected' : '' ?>>Usuario</option>
                    <option value="Admin" <?= $usuario->getRol() === 'Admin' ? 'selected' : '' ?>>Admin</option>
                </select>
                <input type="hidden" name="rol" value="<?= htmlspecialchars($usuario->getRol()) ?>">
            <?php endif; ?>

            <button type="submit" id="btnGuardar" disabled>Guardar Cambios</button>
        </form>
    <script src="assets/js/CrearUsuario.js"> </script>
    </div>
</body>
</html>
