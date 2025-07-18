<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="assets/css/usuario.css">
    <title>Dashboard Usuario</title>
    
</head>
<body>
    <div class="container">
        
        <h1>Bienvenido, <?= htmlspecialchars($usuario['Usuario_Nombre'] ?? '') ?> </h1>
        <div class="botones-usuario">
            <button class="modificarPerfil" onclick="window.location.href='index.php?ruta=actualizar_usuario'" type="button">Modificar perfil</button>
            <button class="pedirPrestado" onclick="window.location.href='index.php?ruta=crear_prestamo'" type="button">Pedir prestado</button>
            <button class="cerrarSesion" onclick="window.location.href='index.php?ruta=logout'" type="button">Cerrar sesión</button>
        </div>
        <div class="user-info">
            <div><b>Cédula:</b> <?= htmlspecialchars($usuario['Usuario_Cedula'] ?? '') ?></div>
            <div><b>Nombre:</b> <?= htmlspecialchars($usuario['Usuario_Nombre'] ?? '') ?></div>
            <div><b>Apellido:</b> <?= htmlspecialchars($usuario['Usuario_Apellido'] ?? '') ?></div>
            <div><b>Email:</b> <?= htmlspecialchars($usuario['Usuario_Email'] ?? '') ?></div>
            <div><b>Rol:</b> <?= htmlspecialchars($usuario['Usuario_Rol'] ?? $_SESSION['rol']) ?></div>
        </div>
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:18px;">
            <span class="titulo-prestamos">Mis Préstamos</span>
            <button class="buscarHerramienta" onclick="window.location.href='index.php?ruta=buscar_herramienta'" type="button">Buscar herramienta</button>
            <button class="misPrestamos" onclick="window.location.href='index.php?ruta=buscar_prestamo'" type="button">Mis préstamos</button>
        </div>
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
                            <button class="modificar" onclick="window.location.href='index.php?ruta=actualizar_prestamo_usuario&id=<?= htmlspecialchars($prestamo['Prestamos_Id']) ?>'" type="button" >Modificar</button>
                            <button class="devolverTodo" onclick="window.location.href='index.php?ruta=devolver_todo&id=<?= htmlspecialchars($prestamo['Prestamos_Id']) ?>'" type="button" >Devolver todo</button>
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
