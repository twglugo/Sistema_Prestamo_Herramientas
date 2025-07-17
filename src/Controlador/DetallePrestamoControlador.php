<?php 
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../Modelos/DetallePrestamo.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


function listarDetallePrestamo() {
    global $pdo;
    $detalle = new DetallePrestamo(null, null, null, null);
    $detalles = $detalle->consultarDetalles($pdo);
    require_once __DIR__ . '/../Views/DetallePrestamo/listar.php';
}
