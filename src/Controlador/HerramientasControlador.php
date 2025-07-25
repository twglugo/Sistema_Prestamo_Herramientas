<?php 

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../Modelos/Herramienta.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


function listarHerramientas() {
    global $pdo;
    try {
        $herramienta = new Herramienta(null, null, null, null, null);
        $herramientas = $herramienta->consultarTodasHerramientas($pdo);
        require_once __DIR__ . '/../Views/Herramientas/Listar.php';
    } catch (exception $e) {
        throw $e;    
    }
}

function crearHerramienta() {
   global $pdo;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $herramienta = new Herramienta(
                null,
                $_POST['nombre'],
                $_POST['descripcion'],
                $_POST['stock'],
                $_POST['cantidadDisponible']
            );
            $herramienta->crearHerramienta($pdo);
            header('Location: index.php?ruta=dashboard_admin');
        } catch (Exception $e) {
            throw $e;
        }
    } else {
        require_once __DIR__ . '/../Views/Herramientas/CrearHerramienta.php';
    }


}

function actualizarHerramienta() {
    global $pdo;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $herramienta = new Herramienta(
                $_POST['id'],
                $_POST['nombre'],
                $_POST['descripcion'],
                $_POST['stock'],
                $_POST['cantidadDisponible']
            );
            $herramienta->modificarHerramienta($pdo);
            header('Location: index.php?ruta=dashboard_admin');
            exit;
        } catch (Exception $e) {
            throw $e;
        }
    } else {
        if (isset($_GET['id'])) {
            $herramienta = new Herramienta($_GET['id'], null, null, null, null);
            $resultado = $herramienta->consultarHerramientaPorId($pdo);

            if ($resultado) {
                $herramienta = new Herramienta(
                    $resultado['Herramienta_id'],
                    $resultado['Herramienta_Nombre'],
                    $resultado['Herramienta_Descrip'],
                    $resultado['Herramienta_CantidadTotal'],
                    $resultado['Herramienta_CantidadDisponible']
                );

                require_once __DIR__ . '/../Views/Herramientas/actualizarHerramienta.php';
            } else {
                header('Location: index.php?ruta=herramientas');
                exit;
            }
        } else {
            header('Location: index.php?ruta=herramientas');
            exit;
        }
    }
}

function eliminarHerramienta() {
    global $pdo;

    if (isset($_GET['id'])) {
        try {
            $herramienta = new Herramienta($_GET['id'], null, null, null, null);
            $herramienta->eliminarHerramienta($pdo);
            header('Location: index.php?ruta=herramientas');
            exit;
        } catch (Exception $e) {
            throw new Exception ($e);
        }
    } else {
        header('Location: index.php?ruta=herramientas');
        exit;
    }
}


function buscarHerramienta() {
    global $pdo;
    
    $mensaje = null;
    try {
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $descripcion = $_POST['descripcion'] ?? '';
            $cantidadStock = $_POST['cantidadStock'] ?? '';
            $cantidadDisponible = $_POST['cantidadDisponible'] ?? '';

            $herramienta = new Herramienta(null, $nombre, $descripcion, $cantidadStock, $cantidadDisponible);
            $herramientas = $herramienta->buscarHerramienta($pdo);

            if ($herramientas) {
                require_once __DIR__ . '/../Views/Herramientas/filtrarHerramienta.php';
            } else {
                $mensaje = "No se encontraron herramientas con ese filtro.";
                require_once __DIR__ . '/../Views/Herramientas/filtrarHerramienta.php';
            }
        } else {
            require_once __DIR__ . '/../Views/Herramientas/filtrarHerramienta.php';
        }
    } catch (Throwable $e) {
           $mensaje = "Error al buscar herramientas: " . $e->getMessage();
           require_once __DIR__ . '/../Views/Herramientas/filtrarHerramienta.php';
        
      
        } 
}