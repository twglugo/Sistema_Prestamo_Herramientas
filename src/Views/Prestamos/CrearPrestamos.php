<?php $hoy = date('Y-m-d'); 


?>
<!DOCTYPE html>
<html>
    


<head>
    <title>Registrar Préstamo</title>
    <style>
        body { background: #f4f4f4; font-family: Arial, sans-serif; }
        .form-container {
            max-width: 500px;
            margin: 40px auto;
            background: #fff;
            padding: 30px 32px;
            border-radius: 10px;
            box-shadow: 0 2px 12px #bbb;
        }
        h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 24px;
        }
        label {
            font-weight: bold;
            color: #333;
            display: block;
            margin-bottom: 6px;
        }
        select, input[type="number"], input[type="date"] {
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
        .error {
            color: #d9534f;
            font-size: 13px;
            margin-top: -12px;
            margin-bottom: 10px;
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
        <h1>Nuevo Préstamo</h1>
        <?php
            $rutaDashboard = (isset($_SESSION['Usuario_Rol']) && strtolower($_SESSION['Usuario_Rol']) === 'admin')
                ? 'dashboard_admin'
                : 'dashboard_usuario';
        ?>
        <a href="index.php?ruta=<?= $rutaDashboard ?>" style="display:block;margin-bottom:18px;text-align:center;text-decoration:none;">
            <button type="button" 
            style="width:100%;background:linear-gradient(90deg,#28a745 0%,#218838 100%);color:#fff;border:none;border-radius:6px;padding:10px 0;font-size:16px;font-weight:bold;cursor:pointer;box-shadow:0 1px 4px
                #28a74533;transition:background 0.2s,box-shadow 0.2s,transform 0.1s;
                margin-bottom:10px;">&#8592; Volver al Dashboard</button>
        </a>
        <form id="formPrestamo" method="POST" action="index.php?ruta=crear_prestamo">
            <?php if (isset($_SESSION['Usuario_Rol']) && strtolower($_SESSION['Usuario_Rol']) === 'admin'): ?>
                <label for="usuarioCedula">Usuario</label>
                <select name="usuarioCedula" id="usuarioCedula" required>
                    <option value="">Seleccione un usuario</option>
                    <?php foreach ($usuarios as $usuario): ?>
                        <option value="<?= htmlspecialchars($usuario['Usuario_Cedula']) ?>">
                            <?= htmlspecialchars($usuario['Usuario_Nombre'] . ' ' . $usuario['Usuario_Apellido']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            <?php else: ?>
                <input type="hidden" name="usuarioCedula" value="<?= htmlspecialchars($_SESSION['Usuario_Cedula'] ?? '') ?>">
            <?php endif; ?>

            <label for="herramienta">Herramienta</label>
            <select name="herramienta" id="herramienta" required>
                <option value="">Seleccione una herramienta</option>
                <?php foreach ($herramientas as $herramienta): ?>
                    <option 
                        value="<?= htmlspecialchars($herramienta['Herramienta_id']) ?>"
                        data-disponible="<?= htmlspecialchars($herramienta['Herramienta_CantidadDisponible']) ?>"
                        data-total="<?= htmlspecialchars($herramienta['Herramienta_CantidadTotal']) ?>">
                        <?= htmlspecialchars($herramienta['Herramienta_Nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="cantidadDisponible">Cantidad Disponible</label>
            <input type="number" id="cantidadDisponible" name="cantidadDisponible" value="" readonly>

            <label for="cantidad">Cantidad</label>
            <input type="number" name="cantidad" id="cantidad" min="1" required>
            <span id="mensaje-error" class="error"></span>

            <label for="fechaPrestamo">Fecha Préstamo</label>
            <input id="fechaPrestamo" type="date" name="fechaPrestamo" max="<?= $hoy ?>" required>
            <span id="error-fecha" class="error"></span>

            <button type="submit" id="btnGuardar" disabled>Guardar</button>
        </form>
    </div>
    <script src="assets/js/Prestamos.js"></script>
    <script src ="assets/js/CrearPrestamos.js"></script>
</body>
</html>
