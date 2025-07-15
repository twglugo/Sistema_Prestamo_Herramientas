<?php $hoy = date('Y-m-d'); ?>
<!DOCTYPE html>
<html>
    

<head>
    <title>Registrar Prestamo</title>
</head>
<body>
    <h1>Nueva Prestamo</h1>
    <form id="formPrestamo" method="POST" action="index.php?ruta=crear_prestamos">
        
        <label>Herramienta </label><br><br>

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

        </select><br><br>   
         
        <label >Cantidad</label><br><br>
        <input type="number" name="cantidad" id="cantidad" min="1" required>
        <span id="mensaje-error" style="color: red;"></span><br><br>
        
        <label>Fecha Prestamo</label><br><br>
        <input id="fechaPrestamo" type="date" name="fechaPrestamo" max="<?= $hoy ?>" required>
        <span id="error-fecha" style="color: red;"></span><br><br>
        

        
        

        <button type="submit">Guardar</button>
    </form>
    <script src="assets/js/Prestamos.js"></script>
</body>
</html>
