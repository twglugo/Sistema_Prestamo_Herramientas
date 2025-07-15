<!DOCTYPE html>
<html>
    

<head>
    <title>Modificar Herramienta: []</title>
</head>
<body>
    <h1>Nueva Herramienta <?= htmlspecialchars($herramienta->getNombre())?> </h1>
    <form id="formHerramienta" method="POST" action="index.php?ruta=crear_herramienta">
        

        <label>Nombre:</label>
        <input type="text" value="<?=$herramienta->getNombre()?>" name="nombre" required><br><br>

        <label>Descripcion:</label>
        <input type="text" value="<?=$herramienta->getDescripcion()?>" name="descripcion" required><br><br>

        <label>Stock:</label>
        <input id = "cantidadTotal" type="number" value="<?=$herramienta->getCantidadTotal()?>" name="stock" required><br><br>
        
        <label>Cantidad Disponible:</label>
        <input id="cantidadDisponible" type="number" value="<?=$herramienta->getCantidadDisponible()?>" name="cantidadDisponible" required><br><br>
        

        <button type="submit">Guardar</button>
    </form>
    <script src="assets/js/herramientas.js"></script>
</body>
</html>
