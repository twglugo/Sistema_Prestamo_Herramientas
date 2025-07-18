<!DOCTYPE html>
<html>
    


<head>
    <title>Modificar Herramienta</title>
    <link rel="stylesheet" href="assets/css/actualizar.css">
</head>
<body>
    <div class="form-container">
        <h1>Modificar Herramienta:  <?= htmlspecialchars($herramienta->getNombre())?> </h1>
        <a href="index.php?ruta=dashboard_admin" style="display:block;margin-bottom:18px;text-align:center;text-decoration:none;">
            <button type="button" 
            style="width:100%;background:linear-gradient(90deg,#28a745 0%,#218838 100%);color:#fff;border:none;border-radius:6px;padding:10px 0;font-size:16px;font-weight:bold;cursor:pointer;box-shadow:0 1px 4px
                #28a74533;transition:background 0.2s,box-shadow 0.2s,transform 0.1s;
                margin-bottom:10px;">&#8592; Volver al Dashboard</button>
        </a>
        <form id="formHerramienta" method="POST" action="index.php?ruta=actualizar_herramienta">


            <input type="hidden" name="id" value="<?=$herramienta->getId()?>">

            <label for="nombre">Nombre</label>
            <input type="text" value="<?=$herramienta->getNombre()?>" name="nombre" id="nombre" required>

            <label for="descripcion">Descripción</label>
            <input type="text" value="<?=$herramienta->getDescripcion() ?>" name="descripcion" id="descripcion" required>

            <label for="cantidadTotal">Stock</label>
            <input id="cantidadTotal" type="number" value="<?=$herramienta->getCantidadTotal()?>" name="stock" required>
            <span id="mensaje-error" class="error"></span>

            <label for="cantidadDisponible">Cantidad Disponible</label>
            <input id="cantidadDisponible" type="number" value="<?=$herramienta->getCantidadDisponible()?>" name="cantidadDisponible" readonly>

            <button type="submit" id="btnGuardar" disabled>Guardar</button>
        </form>
    </div>
    <script src="assets/js/herramientasModificar.js"></script>
</body>
</html>
