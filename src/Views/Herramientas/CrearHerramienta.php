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
    <style>
        body { background: #f4f4f4; font-family: Arial, sans-serif; }
        .form-container {
            max-width: 420px;
            margin: 40px auto;
            background: #fff;
            padding: 28px 30px;
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
        select, input[type="number"], input[type="text"] {
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
