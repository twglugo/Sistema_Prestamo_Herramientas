
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
        .ref-btn {
            margin-left: 10px;
            vertical-align: middle;
            background: linear-gradient(90deg, #008cffff 0%, #0787ffd5 100%);
            color: #fff;
            border: none;
            border-radius: 16px;
            padding: 6px 18px;
            font-size: 15px;
            font-weight: bold;
            box-shadow: 0 1px 4px #ff980033;
            cursor: pointer;
            transition: background 0.2s, box-shadow 0.2s, transform 0.2s;
        }
        .ref-btn:hover {
            background: linear-gradient(90deg, #000000ff 0%, #0787ffa4 100%);
            box-shadow: 0 2px 8px #ffc10744;
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
        
        <h2 style="display:inline-block;">Usuarios</h2>
        <a href="index.php?ruta=buscar_usuario"> 
        <button class="ref-btn" id="btn-ref-usuarios">Buscar Usuario</button>
        </a>
        <table>
            <tr>
                <th>Cédula</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Actualizar</th>

            </tr>
            <?php $usuariosMostrados = 0; foreach ($usuarios as $usuario): ?>
                <?php if ($usuariosMostrados++ >= 15) break; ?>
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

        <h2 style="display:inline-block;">Herramientas</h2>
        <a href="index.php?ruta=buscar_herramienta">     
        <button class="ref-btn" id="btn-ref-herramientas">Buscar Herramientas</button>
        </a>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Stock Total</th>
                <th>Disponibles</th>
                <th>Actualizar</th>
            </tr>
            <?php $herramientasMostradas = 0; foreach ($herramientas as $herramienta): ?>
                <?php if ($herramientasMostradas++ >= 15) break; ?>
                <tr>
                    <td><?= htmlspecialchars($herramienta['Herramienta_id']) ?></td>
                    <td><?= htmlspecialchars($herramienta['Herramienta_Nombre']) ?></td>
                    <td><?= htmlspecialchars($herramienta['Herramienta_Descrip']) ?></td>
                    <td><?= htmlspecialchars($herramienta['Herramienta_CantidadTotal']) ?></td>
                    <td><?= htmlspecialchars($herramienta['Herramienta_CantidadDisponible']) ?></td>
                    <td class="action-cell"><a href="index.php?ruta=actualizar_herramienta&id=<?= htmlspecialchars($herramienta['Herramienta_id']) ?>" class="action-btn">&#9998; Actualizar</a></td>
            <?php endforeach; ?>
        </table>


        <h2 style="display:inline-block;">Préstamos</h2>
        <a href="index.php?ruta=buscar_prestamo">
        <button class="ref-btn" id="btn-ref-prestamos">Buscar Prestamos</button>
        </a>
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
            <?php $prestamosMostrados = 0; foreach ($prestamos as $prestamo): ?>
                <?php if ($prestamosMostrados++ >= 15) break; ?>
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
