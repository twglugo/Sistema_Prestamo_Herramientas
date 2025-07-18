<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="assets/css/filtrar.css">
    <title>Filtro de Usuarios</title>
    
</head>
<body>
    <div class="container">
        <h1>Filtro de Usuarios </h1>
        <div style="display:flex;justify-content:center;margin-bottom:18px;">
            <button onclick="window.location.href='index.php?ruta=dashboard_admin'" style="padding:8px 18px;background:#007bff;color:#fff;border:none;border-radius:6px;cursor:pointer;font-weight:bold;">Regresar al Dashboard</button>
        </div>
        <form method="POST" action="index.php?ruta=buscar_usuario">
            <input type="text" name="cedula" placeholder="Cédula">
            <input type="text" name="nombre" placeholder="Nombre">
            <input type="text" name="apellido" placeholder="Apellido">
            <input type="text" name="email" placeholder="Email">
            <select name="rol">
                <option value="">Todos los roles</option>
                <option value="admin">Admin</option>
                <option value="usuario">Usuario</option>
            </select>
            <button type="submit">Buscar</button>
        </form>

        <?php if (isset($usuarios) && is_array($usuarios) && count($usuarios) > 0): ?>
        <table>
            <tr>
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= htmlspecialchars($usuario['Usuario_Cedula']) ?></td>
                    <td><?= htmlspecialchars($usuario['Usuario_Nombre']) ?></td>
                    <td><?= htmlspecialchars($usuario['Usuario_Apellido']) ?></td>
                    <td><?= htmlspecialchars($usuario['Usuario_Email']) ?></td>
                    <td><?= htmlspecialchars($usuario['Usuario_Rol']) ?></td>
                    <td class="action-cell"><a href="index.php?ruta=actualizar_usuario&cedula=<?= htmlspecialchars($usuario['Usuario_Cedula']) ?>" class="action-btn">&#9998; Actualizar</a></td>

                </tr>
            <?php endforeach; ?>
        </table>
        <?php elseif (isset($usuarios)): ?>
            <p style="text-align:center;color:#d9534f;"><?= htmlspecialchars($mensaje) ?></p>
        <?php endif; ?>
        
    </div>
</body>
</html>
