<?php // Las variables $usuario y $prestamos ya vienen preparadas por el controlador dashboardUsuario ?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Usuario</title>
    <style>
        body { background: #f4f4f4; font-family: Arial, sans-serif; }
        .container {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            padding: 32px 36px;
            border-radius: 10px;
            box-shadow: 0 2px 12px #bbb;
        }
        h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 28px;
        }
        .user-info {
            background: #eaf4ff;
            border-radius: 8px;
            padding: 18px 22px;
            margin-bottom: 28px;
            font-size: 17px;
        }
        .user-info b { color: #007bff; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px 8px;
            text-align: center;
        }
        th {
            background: #007bff;
            color: #fff;
        }
        tr:nth-child(even) { background: #f9f9f9; }
        .no-data {
            text-align: center;
            color: #888;
            font-size: 16px;
            margin: 18px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        
        <h1>Bienvenido, <?= htmlspecialchars($usuario['Usuario_Nombre'] ?? '') ?> 👋🏻!</h1>
        <div style="display:flex; gap:16px; margin-bottom:24px; justify-content:center;">
            <button onclick="window.location.href='index.php?ruta=actualizar_usuario'" type="button" style="background:#ffc107;color:#333;border:none;border-radius:6px;padding:10px 22px;font-size:15px;font-weight:bold;cursor:pointer;box-shadow:0 1px 4px #ffc10733;">Modificar perfil</button>
            <button onclick="window.location.href='index.php?ruta=crear_prestamo'" type="button" style="background:#007bff;color:#fff;border:none;border-radius:6px;padding:10px 22px;font-size:15px;font-weight:bold;cursor:pointer;box-shadow:0 1px 4px #007bff33;">Pedir prestado</button>
            <button onclick="window.location.href='index.php?ruta=logout'" type="button" style="background:#dc3545;color:#fff;border:none;border-radius:6px;padding:10px 22px;font-size:15px;font-weight:bold;cursor:pointer;box-shadow:0 1px 4px #dc354533;">Cerrar sesión</button>
        </div>
        <div class="user-info">
            <div><b>Cédula:</b> <?= htmlspecialchars($usuario['Usuario_Cedula'] ?? '') ?></div>
            <div><b>Nombre:</b> <?= htmlspecialchars($usuario['Usuario_Nombre'] ?? '') ?></div>
            <div><b>Apellido:</b> <?= htmlspecialchars($usuario['Usuario_Apellido'] ?? '') ?></div>
            <div><b>Email:</b> <?= htmlspecialchars($usuario['Usuario_Email'] ?? '') ?></div>
            <div><b>Rol:</b> <?= htmlspecialchars($usuario['Usuario_Rol'] ?? $_SESSION['rol']) ?></div>
        </div>
        <h2 style="color:#0056b3;">Mis Préstamos</h2>
        <?php if ($prestamos && count($prestamos) > 0): ?>
            <table>
                <tr>
                    
                    <th>Herramienta</th>
                    <th>Fecha Préstamo</th>
                    <th>Fecha Devolución</th>
                    <th>Estado</th>
                    <th>Cantidad</th>
                    <th>Acciones</th>
                </tr>
                <?php foreach ($prestamos as $prestamo): ?>
                    <tr>
                        
                        <td><?= htmlspecialchars($prestamo['Herramienta_Nombre']) ?></td>
                        <td><?= htmlspecialchars($prestamo['Prestamo_FechaPres']) ?></td>
                        <td><?= htmlspecialchars($prestamo['Prestamo_FechaDev'] ?? 'Pendiente') ?></td>
                        <td><?= htmlspecialchars($prestamo['Prestamo_Estado']) ?></td>
                        <td><?= htmlspecialchars($prestamo['Cantidad']) ?></td>
                        <td style="display:flex; gap:10px; justify-content:center;">
                        <?php if ($prestamo['Prestamo_Estado'] === 'Devuelto'): ?>
                            <span style="color:#28a745;font-weight:bold;">Ya devuelto</span>
                        <?php else: ?>
                            <button onclick="window.location.href='index.php?ruta=actualizar_prestamo_usuario&id=<?= htmlspecialchars($prestamo['Prestamos_Id']) ?>'" type="button" style="background:#17a2b8;color:#fff;border:none;border-radius:5px;padding:6px 14px;font-size:14px;cursor:pointer;">Modificar</button>
                            <button onclick="window.location.href='index.php?ruta=devolver_todo&id=<?= htmlspecialchars($prestamo['Prestamos_Id']) ?>'" type="button" style="background:#dc3545;color:#fff;border:none;border-radius:5px;padding:6px 14px;font-size:14px;cursor:pointer;">Devolver todo</button>
                        <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <div class="no-data">No tienes préstamos registrados.</div>
        <?php endif; ?>
    </div>
</body>
</html>
