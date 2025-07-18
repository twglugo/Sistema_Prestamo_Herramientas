<?php
session_start();
if (!isset($_SESSION) ) {
    header('Location: index.php?ruta=login');
    exit;

}


?>

<!DOCTYPE html>
<html>
    


<head>
    <title>Registrar Herramienta</title>
    <link rel="stylesheet" href="assets/css/crear.css">
</head>
<body>
    <div class="form-container">
        <h1>Nueva Herramienta</h1>
        <a href="index.php?ruta=dashboard_admin" style="display:block;margin-bottom:18px;text-align:center;text-decoration:none;">
            <button type="button" 
            style="width:100%;background:linear-gradient(90deg,#28a745 0%,#218838 100%);color:#fff;border:none;border-radius:6px;padding:10px 0;font-size:16px;font-weight:bold;cursor:pointer;box-shadow:0 1px 4px
                #28a74533;transition:background 0.2s,box-shadow 0.2s,transform 0.1s;
                margin-bottom:10px;">&#8592; Volver al Dashboard</button>
        </a>
        <form id="formHerramienta" method="POST" action="index.php?ruta=crear_herramienta">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" required>

            <label for="descripcion">Descripción</label>
            <input type="text" name="descripcion" id="descripcion" required>

            <label for="cantidadTotal">Stock</label>
            <input id="cantidadTotal" type="number" name="stock" required>
            <span id="mensaje-error" class="error"></span>

            <label for="cantidadDisponible">Cantidad Disponible</label>
            <input id="cantidadDisponible" type="number" name="cantidadDisponible" readonly>

            <button type="submit">Guardar</button>
        </form>
    </div>
    <script src="assets/js/Herramientas.js"></script>
</body>
</html>
