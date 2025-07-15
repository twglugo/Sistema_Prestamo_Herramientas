<?php

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../modelos/prestamo.php';
require_once __DIR__ . '/../modelos/herramienta.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function listarPrestamos()
{
    global $pdo;

    try {
        $prestamo = new Prestamo(null, null, null, null, null);
        $prestamos = $prestamo->consultarTodosPrestamos($pdo);
        require_once __DIR__ . '/../views/Prestamos/listar.php';
    } catch (Exception $e) {
        throw $e;
    }
}

//Creacion de prestamo insert -> detalles , validacion stock -> insert prestamo 
function crearPrestamo()
{
    global $pdo;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Procesar el formulario
        try {
            $prestamo = new Prestamo(
                null,
                $_POST['usuarioCedula'],
                $_POST['fechaPrestamo'],
                $_POST['fechaDevolucion'],
                'Activo'
            );
            $prestamo->crearPrestamo($pdo);

            

            header('Location: index.php?ruta=prestamos');
            exit;
        } catch (Exception $e) {
            echo "Error al crear el préstamo: " . $e->getMessage();
        }

    } else {
        
        try {
            $herramientaModel = new Herramienta(null, null, null, null, null);
            $herramientas = $herramientaModel->consultarTodasHerramientas($pdo);

            require_once __DIR__ . '/../Views/Prestamos/CrearPrestamos.php';
        } catch (Exception $e) {
            echo "Error al cargar herramientas: " . $e->getMessage();
        }
    }
}


function actualizarPrestamo()
{
    global $pdo;

    if (isset($_GET['id'])) {
        try {
            $prestamo = new Prestamo($_GET['id'], null, null, null, null);
            $resultado = $prestamo->consultarPrestamoPorId($pdo);

            if ($resultado) {
                $prestamo = new Prestamo(
                    $resultado['Prestamos_Id'],
                    $resultado['Usuario_Cedula'],
                    $resultado['Prestamo_FechaPres'],
                    $resultado['Prestamo_FechaDev'],
                    $resultado['Prestamo_Estado']
                );

                require_once __DIR__ . '/../views/Prestamos/actualizarPrestamo.php';
            } else {
                header('Location: index.php?ruta=prestamos');
                exit;
            }
        } catch (Exception $e) {
            throw $e;
        }
    } else {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            try {
                $prestamo = new Prestamo(
                    $_POST['id'],
                    $_POST['usuarioCedula'],
                    $_POST['fechaPrestamo'],
                    $_POST['fechaDevolucion'],
                    $_POST['estado']
                );
                $prestamo->modificarPrestamo($pdo);
                header('Location: index.php?ruta=prestamos');
                exit;
            } catch (Exception $e) {
                throw $e;
            }
        } else {
            header('Location: index.php?ruta=prestamos');
            exit;
        }
    }
}


function devolverPrestamo()
{
    global $pdo;

    if (isset($_GET['id']) && isset($_GET['estado']) && $_GET['estado'] === 'Activo') {
        try {
            $prestamo = new Prestamo($_GET['id'], null, null, null, $_GET['estado']);
            $prestamo->devolverPrestamo($pdo);
            header('Location: index.php?ruta=prestamos');
            exit;
        } catch (Exception $e) {
            throw $e;
        }
    } else {
        header('Location: index.php?ruta=prestamos');
        exit;
    }
}

