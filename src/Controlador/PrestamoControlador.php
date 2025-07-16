


<?php

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../modelos/prestamo.php';
require_once __DIR__ . '/../modelos/herramienta.php';
require_once __DIR__ . '/../modelos/DetallePrestamo.php';
require_once __DIR__ . '/../Enums/EstadoPrestamo.php';

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
        
        try {
            $pdo-> beginTransaction();
            $herramientaId = $_POST['herramienta'];
            $cantidad = $_POST['cantidad'];
            $fechaPrestamo = $_POST['fechaPrestamo'];
            $usuarioCedula = $_POST['usuarioCedula'];


            $herramientas = new Herramienta($herramientaId, null, null, null, $cantidad);
            $disponible = $herramientas->consultarStockHerramienta($pdo);


            if ($disponible['Herramienta_CantidadDisponible'] < $cantidad) {
                throw new Exception("No hay suficiente stock disponible para la herramienta seleccionada.");
            }else{
                $resultado = $herramientas->actualizarStockHerramienta($pdo);
                if (!$resultado) {
                    throw new Exception("Error al actualizar el stock de la herramienta.");
                }else {
                    $prestamo = new Prestamo(
                        null,
                        $usuarioCedula,
                        $fechaPrestamo,
                        null,
                        EstadoPrestamo::Activo
                    );
                    $resultado = $prestamo->crearPrestamo($pdo);
                    if (!$resultado) {
                        throw new Exception("Error al crear el préstamo.");
                    }else{
                        $prestamoId = $pdo->lastInsertId();
                        $detalle = new DetallePrestamo(null,$prestamoId, $herramientaId, $cantidad);
                        $resultadoDetalle = $detalle->crearDetallePrestamo($pdo);
                        if (!$resultadoDetalle) {
                            throw new Exception("Error al insertar el detalle del préstamo.");
                        }
                    }

                }
            }
            $pdo->commit();
            header('Location: index.php?ruta=detalles_prestamos');
            exit;
        } catch (Exception $e) {
            $pdo->rollBack();
            throw new Exception( "Error al crear el préstamo: " . $e->getMessage());
        }

    } else {
        
        try {
            $herramientaModel = new Herramienta(null, null, null, null, null);
            $herramientas = $herramientaModel->consultarTodasHerramientas($pdo);

            //Futura cedula de rol ->.....................................

            require_once __DIR__ . '/../Views/Prestamos/CrearPrestamos.php';
        } catch (Exception $e) {
            throw new Exception  ("Error al cargar herramientas: " . $e->getMessage());
        }
    }
}


function actualizarPrestamo()
{
    global $pdo;

    if (isset($_GET['id'])) {
        try {
            
            $prestamo = new Prestamo($_GET['id'], null, null, null, null);
            $resultados = $prestamo->consultarPrestamosConDetalles($pdo);

            if ($resultados && count($resultados) > 0) {
                $resultadoIndex = $resultados[0];
                $prestamoConsulta = new Prestamo(
                    $resultadoIndex['Prestamos_Id'],
                    $resultadoIndex['Usuario_Cedula'],
                    $resultadoIndex['Prestamo_FechaPres'],
                    $resultadoIndex['Prestamo_FechaDev'],
                    $resultadoIndex['Prestamo_Estado']
                );

                // Obtener la cantidad prestada real desde el detalle del préstamo
                $resultadoIndex['prestado'] = isset($resultadoIndex['Cantidad']) ? $resultadoIndex['Cantidad'] : (isset($resultadoIndex['prestado']) ? $resultadoIndex['prestado'] : 0);

                require_once __DIR__ . '/../views/Prestamos/actualizarPrestamo.php';

                

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
                $pdo->beginTransaction();
                $prestamoId = $_POST['id'];
                $fechaPrestamo = $_POST['fechaPrestamo'];
                $estado = $_POST['estado'];
                $herramientaId = $_POST['herramientaId'];
                $cantidad = $_POST['cantidad'];
                $cantidadPrestada = $_POST['cantidadPrestadaFinal'];
                $cantidadDisponibleTotal = $_POST['cantidadDisponibleFinal'];
                $idDetallePrestamo = isset($_POST['idDetallePrestamo']) ? $_POST['idDetallePrestamo'] : null;

                if($estado === 'Activo'){
                    $fechaDevolucion = null;
                }else{
                    $fechaDevolucion = $_POST['fechaDevolucion'];
                }
                $usuarioCedula = $_POST['usuarioCedula'];

                $prestamo = new Prestamo(
                    $prestamoId,
                    $usuarioCedula,
                    $fechaPrestamo,
                    $fechaDevolucion,
                    $estado
                );

                $resultado = $prestamo->modificarPrestamo($pdo);
                if (!$resultado) {
                    throw new Exception("Error al modificar el préstamo.");
                }

                // Validar que la cantidad disponible no sea negativa
                if ($cantidadDisponibleTotal < 0) {
                    throw new Exception("La cantidad disponible no puede ser negativa.");
                }

                // Actualizar el stock de la herramienta usando el valor final
                $herramienta = new Herramienta(
                    $herramientaId,
                    null,
                    null,
                    null,
                    $cantidadDisponibleTotal
                );
                $resultadoHerramienta = $herramienta->modificarStockHerramienta($pdo);
                if (!$resultadoHerramienta) {
                    throw new Exception("Error al actualizar el stock de la herramienta.");
                }

                // Actualizar el detalle del préstamo con el id correcto y la cantidad final
                if ($idDetallePrestamo) {
                    $detalle = new DetallePrestamo(
                        $idDetallePrestamo,
                        $prestamoId,
                        $herramientaId,
                        $cantidadPrestada
                    );
                    $resultadoDetalle = $detalle->modificarDetalle($pdo);
                    if (!$resultadoDetalle) {
                        throw new Exception("Error al modificar el detalle del préstamo.");
                    }
                }

                $pdo->commit();
                header('Location: index.php?ruta=prestamos');
                exit;
            } catch (Exception $e) {
                $pdo->rollBack();
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



Function devolverTodoPrestamo()
{
    global $pdo;
    if (isset($_GET['id'])) {
        $prestamoId = $_GET['id'];
        try {
            $pdo->beginTransaction();
            // Consultar todos los detalles del préstamo
            $sql = "SELECT dp.*, h.Herramienta_CantidadTotal FROM detalleprestamo dp INNER JOIN herramientas h ON dp.Herramienta_Id = h.Herramienta_id WHERE dp.Prestamo_Id = :prestamoId";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':prestamoId', $prestamoId);
            $stmt->execute();
            $detalles = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!$detalles) {
                throw new Exception('No hay detalles para este préstamo.');
            }
            // Para cada herramienta asociada al préstamo, devolver todo
            foreach ($detalles as $detalle) {
                // Actualizar detalleprestamo: cantidad = 0
                $detalleObj = new DetallePrestamo($detalle['idDetallePrestamo'], $prestamoId, $detalle['Herramienta_Id'], 0);
                $detalleObj->modificarDetalle($pdo);
                // Actualizar herramienta: disponible = total
                $herramientaObj = new Herramienta($detalle['Herramienta_Id'], null, null, $detalle['Herramienta_CantidadTotal'], $detalle['Herramienta_CantidadTotal']);
                $herramientaObj->modificarStockYDisponibilidadHerramienta($pdo);
            }
            // Actualizar préstamo: estado = Devuelto
            $sql = "UPDATE prestamos SET Prestamo_Estado = 'Devuelto', Prestamo_FechaDev = :fechaDev WHERE Prestamos_Id = :prestamoId";
            $stmt = $pdo->prepare($sql);
            $fechaDev = date('Y-m-d');
            $stmt->bindParam(':fechaDev', $fechaDev);
            $stmt->bindParam(':prestamoId', $prestamoId);
            $stmt->execute();
            $pdo->commit();
            header('Location: index.php?ruta=prestamos');
            exit;
        } catch (Exception $e) {
            $pdo->rollBack();
            echo 'Error al devolver todo el préstamo: ' . $e->getMessage();
        }
    } else {
        header('Location: index.php?ruta=prestamos');
        exit;
    }
}

