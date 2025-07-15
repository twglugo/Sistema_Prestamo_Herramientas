<?php $hoy = date('Y-m-d')?>
<!DOCTYPE html>
<html>
    

<head>
    <title>Modificar Prestamo []</title>
</head>
<body>
    <h1>Modificar Prestamo de Cliente <?= htmlspecialchars($prestamo->getUsuarioCedula())?> </h1>
    <form id="formHerramienta" method="POST" action="index.php?ruta=crear_herramienta">
        

        <label>Fecha Prestamo</label>
        <input type="date" value="<?=$prestamo->getFechaPrestamo()?>" max="<?=$hoy?>"name="fechaPrestamo" required><br><br>

        <label>Estado</label>
        <select name="estado" id="estado" required onchange="toggleFechaDevolucion()">
            <option value="Activo" <?= $prestamo->getEstado() === 'Activo' ? 'selected' : '' ?>>Activo</option>
            <option value="Devuelto" <?= $prestamo->getEstado() === 'Devuelto' ? 'selected' : '' ?>>Devuelto</option>
        </select><br><br>

        <div id="campoFechaDevolucion" style="display: <?= $prestamo->getEstado() === 'Devuelto' ? 'block' : 'none' ?>;">
            <label>Fecha de Devolución:</label>
            <input type="date" name="fechaDevolucion" value="<?= $prestamo->getFechaDevolucion() ?? '' ?>"><br><br>
        </div>

        
        <button type="submit">Guardar</button>
    </form>
    <script src="assets/js/Prestamos.js"></script>
</body>
</html>
