<?php $hoy = date('Y-m-d') ?>
<!DOCTYPE html>
<html>
<head>
    <title>Modificar Prestamo</title>
</head>
<body>
<?php
    $resultado = $resultados[0]; 
    $herramientaId = $resultado['Herramienta_id'];
    $herramientaNombre = $resultado['Herramienta_Nombre'];
    $cantidadTotal = $resultado['Herramienta_CantidadTotal'];
    $cantidadDisponible = $resultado['Herramienta_CantidadDisponible'];
    $cantidadPrestada = isset($resultado['Cantidad']) ? $resultado['Cantidad'] : $resultado['prestado'];
    $nombreUsuario = $resultado['Usuario_Nombre'] . " " . $resultado['Usuario_Apellido'];
?>

<h1>Modificar Prestamo de Cliente <?= htmlspecialchars($nombreUsuario) ?> </h1>


<form id="formHerramienta" method="POST" action="index.php?ruta=actualizar_prestamo">
    <input type="hidden" name="id" value="<?= $prestamoConsulta->getId() ?>">
    <input type="hidden" name="herramientaId" value="<?= $herramientaId ?>">
    <input type="hidden" name="usuarioCedula" value="<?= $prestamoConsulta->getUsuarioCedula()?>">
    <input type="hidden" name="cantidadPrestadaFinal" id="cantidadPrestadaFinal" value="">
    <input type="hidden" name="cantidadDisponibleFinal" id="cantidadDisponibleFinal" value="">
    <input type="hidden" name="idDetallePrestamo" value="<?= $resultado['idDetallePrestamo'] ?? '' ?>">

    <label>Fecha Prestamo</label>
    <input type="date" value="<?= $prestamoConsulta->getFechaPrestamo() ?>" max="<?= $hoy ?>" name="fechaPrestamo" required><br><br>

    <label>Estado</label>
    <select name="estado" id="estado" required onchange="toggleFechaDevolucion()">
        <option value="Activo" <?= $prestamoConsulta->getEstado() === 'Activo' ? 'selected' : '' ?>>Activo</option>
        <option value="Devuelto" <?= $prestamoConsulta->getEstado() === 'Devuelto' ? 'selected' : '' ?>>Devuelto</option>
    </select><br><br>

    <div id="campoFechaDevolucion" style="display: <?= $prestamoConsulta->getEstado() === 'Devuelto' ? 'block' : 'none' ?>;">
        <label>Fecha de Devolución:</label>
        <input type="date" name="fechaDevolucion" value="<?= $prestamoConsulta->getFechaDevolucion() ?: date('Y-m-d') ?>" readonly><br><br>
    </div>

    <label>Cantidad prestada de la herramienta <?= htmlspecialchars($herramientaNombre) ?> para: <?= htmlspecialchars($nombreUsuario) ?></label> <br><br>
    <label>Cantidad prestada actual: <span id="label-prestada"><?= $cantidadPrestada ?></span></label><br><br>
    <label>Cantidad disponible actual: <span id="label-disponible"><?= $cantidadDisponible ?></span></label><br><br>

    <input type="radio" name="logicaHerramienta" value="restar" checked> Restar
    <input type="radio" name="logicaHerramienta" value="sumar"> Sumar<br><br>

    <label > Digita la cantidad que vas a <span id="mensaje-info"> </span></label>

    <input type="number" name="cantidad" id="cantidad"
        value="<?= $cantidadPrestada ?>"
        min="1"
        max="<?= $cantidadTotal ?>"
        required
        data-original="<?= $cantidadPrestada ?>"
        data-disponible="<?= $cantidadDisponible ?>"
        data-total="<?= $cantidadTotal ?>"
    >
    <span id="mensaje-error" style="color: red;"></span><br><br>

    <button id="boton-submit" type="submit" onclick="probarValores()" >Guardar</button>
</form>

<script src="assets/js/Prestamos.js"></script>
</body>
</html>
