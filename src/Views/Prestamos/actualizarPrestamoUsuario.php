<?php $hoy = date('Y-m-d') ;
    session_start();
    



?>
<!DOCTYPE html>
<html>

<head>
    <title>Modificar Prestamo</title>
    <style>
        body { background: #f4f4f4; font-family: Arial, sans-serif; }
        .form-container {
            max-width: 480px;
            margin: 40px auto;
            background: #fff;
            padding: 30px 32px;
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
        .info-label {
            font-size: 15px;
            color: #555;
            margin-bottom: 10px;
        }
        .info-destacada {
            font-size: 22px;
            color: #007bff;
            font-weight: bold;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .radio-group {
            display: flex;
            gap: 18px;
            margin-bottom: 18px;
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
        
        <?php
            $resultado = $resultados[0]; 
            $herramientaId = $resultado['Herramienta_id'];
            $herramientaNombre = $resultado['Herramienta_Nombre'];
            $cantidadTotal = $resultado['Herramienta_CantidadTotal'];
            $cantidadDisponible = $resultado['Herramienta_CantidadDisponible'];
            $cantidadPrestada = isset($resultado['Cantidad']) ? $resultado['Cantidad'] : $resultado['prestado'];
            $nombreUsuario = $resultado['Usuario_Nombre'] . " " . $resultado['Usuario_Apellido'];
        ?>

        <h1>Modificar Préstamo de Cliente <?= htmlspecialchars($nombreUsuario) ?> </h1>

        <a href="index.php?ruta=dashboard_usuario" style="display:block;margin-bottom:18px;text-align:center;text-decoration:none;">
            <button type="button" 
            style="width:100%;background:linear-gradient(90deg,#28a745 0%,#218838 100%);color:#fff;border:none;border-radius:6px;padding:10px 0;font-size:16px;font-weight:bold;cursor:pointer;box-shadow:0 1px 4px
                #28a74533;transition:background 0.2s,box-shadow 0.2s,transform 0.1s;
                margin-bottom:10px;">&#8592; Volver al Dashboard</button>
        </a>

        <form id="formHerramienta" method="POST" action="index.php?ruta=actualizar_prestamo_usuario">
            <input type="hidden" name="id" value="<?= $prestamoConsulta->getId() ?>">
            <input type="hidden" name="herramientaId" value="<?= $herramientaId ?>">
            <input type="hidden" name="usuarioCedula" value="<?= $prestamoConsulta->getUsuarioCedula()?>">
            <input type="hidden" name="cantidadPrestadaFinal" id="cantidadPrestadaFinal" value="">
            <input type="hidden" name="cantidadDisponibleFinal" id="cantidadDisponibleFinal" value="">
            <input type="hidden" name="idDetallePrestamo" value="<?= $resultado['idDetallePrestamo'] ?? '' ?>">

            <label for="fechaPrestamo">Fecha Préstamo</label>
            <input type="date" value="<?= $prestamoConsulta->getFechaPrestamo() ?>" name="fechaPrestamo" id="fechaPrestamo" readonly>

            <label for="estado">Estado</label>
            <select name="estado" id="estado" disabled>
                <option value="Activo" <?= $prestamoConsulta->getEstado() === 'Activo' ? 'selected' : '' ?>>Activo</option>
                <option value="Devuelto" <?= $prestamoConsulta->getEstado() === 'Devuelto' ? 'selected' : '' ?>>Devuelto</option>
            </select>

            <div id="campoFechaDevolucion" style="display: <?= $prestamoConsulta->getEstado() === 'Devuelto' ? 'block' : 'none' ?>;">
                <label for="fechaDevolucion">Fecha de Devolución</label>
                <input type="date" name="fechaDevolucion" id="fechaDevolucion" value="<?= $prestamoConsulta->getFechaDevolucion() ?: date('Y-m-d') ?>" readonly>
            </div>

            <div class="info-bloque" style="background:#eaf4ff; border-radius:8px; padding:16px 18px; margin-bottom:18px; display:flex; align-items:center; gap:14px;">
                <span style="font-size:28px; color:#007bff;">⚙️</span>
                <div style="font-size:18px; color:#0056b3;">
                    <div><b><?= htmlspecialchars($herramientaNombre) ?></b></div>
                    <div style="font-size:15px; color:#333;">Cliente: <b><?= htmlspecialchars($nombreUsuario) ?></b></div>
                </div>
            </div>
            <div class="info-destacada">
                <span>Cantidad prestada actual:</span>
                <span id="label-prestada"><?= $cantidadPrestada ?></span>
            </div>
            <div class="info-destacada">
                <span>Cantidad disponible actual:</span>
                <span id="label-disponible"><?= $cantidadDisponible ?></span>
            </div>

            <div class="radio-group">
                <label><input type="radio" name="logicaHerramienta" value="restar" checked> Restar</label>
            </div>

            <label for="cantidad">Digita la cantidad que vas a entregar </label>
            <input type="number" name="cantidad" id="cantidad"
                value="<?= $cantidadPrestada ?>"
                min="1"
                max="<?= $cantidadTotal ?>"
                required
                data-original="<?= $cantidadPrestada ?>"
                data-disponible="<?= $cantidadDisponible ?>"
                data-total="<?= $cantidadTotal ?>"
            >

            <span id="mensaje-info" style="display:none"></span>
            <span id="mensaje-error" class="error"></span>

            <button id="boton-submit" type="submit" onclick="probarValores()" >Guardar</button>
        </form>
    </div>
    <script src="assets/js/PrestamoUsuario.js"></script>
</body>
</html>
