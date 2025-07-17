
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        .container { max-width: 900px; margin: 40px auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px #ccc; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        td.action-cell { text-align: center; vertical-align: middle; }
        th { background: #007bff; color: #fff; }
        .logout { float: right; margin-top: -40px; }
        a.button { background: #007bff; color: #fff; padding: 6px 12px; border-radius: 4px; text-decoration: none; transition: background 0.2s, box-shadow 0.2s; }
        a.button:hover { background: #0056b3; box-shadow: 0 2px 8px #007bff44; }
        .action-btn {
            display: inline-block;
            background: linear-gradient(90deg, #28a745 0%, #218838 100%);
            color: #fff;
            padding: 6px 16px;
            border-radius: 20px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 1px 4px #28a74533;
            border: none;
            transition: background 0.2s, box-shadow 0.2s, transform 0.1s;
        }
        .action-btn:hover {
            background: linear-gradient(90deg, #218838 0%, #28a745 100%);
            box-shadow: 0 2px 8px #21883844;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Panel de Administración</h1>
        <div style="text-align:center; margin-bottom: 30px;">
            <a href="index.php?ruta=crear_usuario" class="action-btn" style="margin:0 10px;">&#43; Crear Usuario</a>
            <a href="index.php?ruta=crear_herramienta" class="action-btn" style="margin:0 10px;">&#43; Crear Herramienta</a>
            <a href="index.php?ruta=crear_prestamo" class="action-btn" style="margin:0 10px;">&#43; Crear Préstamo</a>
        </div>
        <a href="index.php?ruta=logout" class="action-btn logout">Cerrar sesión</a>
        
        <h2>Usuarios</h2>
        <table>
            <tr>
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Actualizar</th>

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

        <h2>Herramientas</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Stock Total</th>
                <th>Disponibles</th>
                <th>Actualizar</th>
            </tr>
            <?php foreach ($herramientas as $herramienta): ?>
                <tr>
                    <td><?= htmlspecialchars($herramienta['Herramienta_id']) ?></td>
                    <td><?= htmlspecialchars($herramienta['Herramienta_Nombre']) ?></td>
                    <td><?= htmlspecialchars($herramienta['Herramienta_Descrip']) ?></td>
                    <td><?= htmlspecialchars($herramienta['Herramienta_CantidadTotal']) ?></td>
                    <td><?= htmlspecialchars($herramienta['Herramienta_CantidadDisponible']) ?></td>
                    <td class="action-cell"><a href="index.php?ruta=actualizar_herramienta&id=<?= htmlspecialchars($herramienta['Herramienta_id']) ?>" class="action-btn">&#9998; Actualizar</a></td>
            <?php endforeach; ?>
        </table>


        <h2>Préstamos</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Herramienta</th>
                <th>Cantidad Prestada</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Actualizar</th>
            </tr>
            <?php foreach ($prestamos as $prestamo): ?>
                <?php 
                    if ($prestamo['Prestamo_Estado'] === 'Activo') {
                        $fechaLabel = 'Fecha Prestada';
                        $fechaValor = htmlspecialchars($prestamo['Prestamo_FechaPres']);
                    } else {
                        $fechaLabel = 'Fecha Devuelta';
                        $fechaValor = htmlspecialchars($prestamo['Prestamo_FechaDev']);
                    }
                ?>
                <tr>
                    <td><?= htmlspecialchars($prestamo['Prestamos_Id']) ?></td>
                    <td><?= htmlspecialchars($prestamo['Usuario_Nombre'] . ' ' . $prestamo['Usuario_Apellido']) ?></td>
                    <td><?= htmlspecialchars($prestamo['Herramienta_Nombre']) ?></td>
                    <td><?= htmlspecialchars($prestamo['Cantidad']) ?></td>
                    <td>
                        <strong><?= $fechaLabel ?>:</strong> <?= $fechaValor ?>
                    </td>
                    <td><?= htmlspecialchars($prestamo['Prestamo_Estado']) ?></td>
                    <td class="action-cell">
                        <?php if ($prestamo['Prestamo_Estado'] !== 'Devuelto'): ?>
                            <a href="index.php?ruta=actualizar_prestamo&id=<?= htmlspecialchars($prestamo['Prestamos_Id']) ?>" class="action-btn">&#9998; Actualizar</a>
                        <?php else: ?>
                            <span style="color:#888;font-weight:bold;">Ya devuelto</span>
                        <?php endif; ?>
                    </td>

                </tr>
            <?php endforeach; ?>
    </div>
</body>
</html>
