<?php 

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }


    if (!isset($_SESSION['rol'])) {
        header('Location: index.php?ruta=login');
        exit;
    }


    $rol = strtolower($_SESSION['rol']);
    $estado = false;

    if ($rol === 'admin') {
        $cedula = $_SESSION['cedula'] ?? '';
        $estado = 'admin';
    } elseif ($rol === 'usuario') {
        $cedula = $_SESSION['cedula'] ?? '';
        $estado = 'usuario';
    } else {
        header('Location: index.php?ruta=login');
        exit;
    }







?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="assets/css/filtrar.css">
    <title>Filtro de Préstamos</title>
    
</head>
<body>
    <div class="container">
        <h1>Filtro de <?= $estado === 'usuario' ? 'mis ' : '' ?>Préstamos</h1>

            <div style="display:flex;justify-content:center;margin-bottom:18px;">
            <button onclick="window.location.href='index.php?ruta=dashboard_<?=$rol?>'" style="padding:8px 18px;background:#007bff;color:#fff;border:none;border-radius:6px;cursor:pointer;font-weight:bold;">Regresar al Dashboard</button>
            </div>
        <form method="POST" action="index.php?ruta=buscar_prestamo">
            
            <?php
            
                if($estado === 'admin') {
                    echo '<input type="text" name="usuario" placeholder="Nombre Usuario">';
                    echo '<input type="number" name="usuarioCedula" placeholder="Cedula Usuario">';
                } elseif ($estado === 'usuario') {
                    echo '<input type="hidden" name="usuarioCedula" value="' . htmlspecialchars($cedula) . '">';
                    echo  '<input type="hidden" name="rol" value="' . htmlspecialchars($estado) . '">';

                }
            
            
            
            ?>



            




            <select name="herramienta">
                <option value="">Todas las herramientas</option>
                <?php foreach ($herramientas as $herramienta): ?>
                    <option value="<?= htmlspecialchars($herramienta['Herramienta_id']) ?>"><?= htmlspecialchars($herramienta['Herramienta_Nombre']) ?></option>
                <?php endforeach; ?>
            </select>
            
            <select name="estado">
                <option value="">Todos los estados</option>
                <option value="Activo">Activo</option>
                <option value="Devuelto">Devuelto</option>
            </select>
            <input type="number" name="cantidadPrestada" placeholder="Cantidad Prestada">
            <label for="fecha_prestamo" style="align-self:center;">Préstamo:</label>
            <input type="date" name="fecha_prestamo" id="fecha_prestamo" placeholder="Fecha Préstamo">
            <label for="fecha_devolucion" style="align-self:center;">Devolución:</label>
            <input type="date" name="fecha_devolucion" id="fecha_devolucion" placeholder="Fecha Devolución">
            
            <button type="submit">Buscar</button>
        </form>

        <?php if (isset($prestamos) && is_array($prestamos) && count($prestamos) > 0): ?>
        <table>
            <tr>
                
                <th>Usuario</th>
                <th>Herramienta</th>
                <th>Cantidad Prestada</th>
                <th>Fecha Préstamo</th>
                <th>Fecha Devolución</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($prestamos as $prestamo): ?>
                <tr>
                    
                    <td><?= htmlspecialchars($prestamo['Usuario_Nombre'] . ' ' . $prestamo['Usuario_Apellido']) ?></td>
                    <td><?= htmlspecialchars($prestamo['Herramienta_Nombre']) ?></td>
                    <td><?= htmlspecialchars($prestamo['Cantidad']) ?></td>
                    <td><?= htmlspecialchars($prestamo['Prestamo_FechaPres']) ?></td>
                    <?php if(isset($prestamo['Prestamo_FechaDev'])):?>
                    <td><?= htmlspecialchars($prestamo['Prestamo_FechaDev']) ?></td>
                    <?php else:  ?>
                        <td class="action-cell">sin devolucion</td>
                    <?php endif; ?>
                    <td><?= htmlspecialchars($prestamo['Prestamo_Estado']) ?></td>
                    <?php if ($estado === 'admin'): ?>
                        <td class="action-cell">
                            <a href="index.php?ruta=actualizar_prestamo&id=<?= htmlspecialchars($prestamo['Prestamos_Id']) ?>" class="action-btn">&#9998; Actualizar</a>
                        </td>
                    <?php elseif ($estado === 'usuario' && $prestamo['Cantidad'] > 0 ): ?>
                    
                        <td class="action-cell">    
                            <a href="index.php?ruta=actualizar_prestamo_usuario&id=<?= htmlspecialchars($prestamo['Prestamos_Id']) ?>" class="action-btn">&#9998; Actualizar</a>
                            <a href="index.php?ruta=devolver_prestamo&id=<?= htmlspecialchars($prestamo['Prestamos_Id']) ?>" class="action-btn">&#128190; Devolver</a>
                        </td>
                    <?php else: ?>
                        <td class="action-cell">Sin Acciones Disponibles</td>

                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php elseif (!empty($mensaje) ): ?>
            <p style="text-align:center;color:#d9534f;"><?= htmlspecialchars($mensaje); ?></p>
        <?php endif; ?>
        
    </div>
</body>
</html>
