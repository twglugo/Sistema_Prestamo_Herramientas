<!DOCTYPE html>
<html>
    

<head>
    <title>Registrar Herramienta</title>
</head>
<body>
    <h1>Nueva Herramienta</h1>
    <form id="formHerramienta" method="POST" action="index.php?ruta=crear_herramienta">
        

        <label>Nombre:</label>
        <input type="text" name="nombre" required><br><br>

        <label>Descripcion:</label>
        <input type="text" name="descripcion" required><br><br>

        <label>Stock:</label>
        <input id = "cantidadTotal" type="number" name="stock" required>
         <span id="mensaje-error" style="color: red;"></span><br><br>

        
        <label>Cantidad Disponible:</label>
        <input id="cantidadDisponible" type="number" name="cantidadDisponible" readonly><br><br>
        

        <button type="submit">Guardar</button>
    </form>
    <script src="assets/js/Herramientas.js"></script>
</body>
</html>
