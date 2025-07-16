


<?php

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../modelos/prestamo.php';
require_once __DIR__ . '/../modelos/herramienta.php';
require_once __DIR__ . '/../modelos/usuario.php';
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
            // Redirigir según el rol en sesión
            if (isset($_SESSION['Usuario_Rol']) && strtolower($_SESSION['Usuario_Rol']) === 'admin') {
                header('Location: index.php?ruta=dashboard_usuario');
            } else {
                header('Location: index.php?ruta=dashboard_admin');
            }
            exit;
        } catch (Exception $e) {
            $pdo->rollBack();
            throw new Exception( "Error al crear el préstamo: " . $e->getMessage());
        }

    } else {
        
        try {
            $herramientaModel = new Herramienta(null, null, null, null, null);
            $herramientas = $herramientaModel->consultarTodasHerramientas($pdo);

            $usuarioModel = new Usuario(null, null, null, null, null);
            $usuarios = $usuarioModel->consultarTodosUsuario($pdo);

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
                header('Location: index.php?ruta=dashboard_admin');
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



function devolverTodoPrestamo()
{
    global $pdo;
    if (isset($_GET['id'])) {
        $prestamoId = $_GET['id'];
        try {
            $pdo->beginTransaction();

            // Consultar todos los detalles del préstamo actual
            $detalleModel = new DetallePrestamo(null, $prestamoId, null, null);
            $detalles = $detalleModel->consultarDetallesPorPrestamoId($pdo);
            if (!$detalles) {
                throw new Exception('No hay detalles para este préstamo.');
            }

            // Devolver cada herramienta asociada al préstamo actual
            foreach ($detalles as $detalle) {
                $cantidadPrestada = $detalle['Cantidad']; // Cantidad prestada en este préstamo
                $cantidadStock = $detalle['Herramienta_CantidadTotal'];
                $cantidadDisponible = $detalle['Herramienta_CantidadDisponible']; // Disponible actual

                // Nueva cantidad disponible tras la devolución de este préstamo
                $nuevaCantidadDisponible = $cantidadDisponible + $cantidadPrestada;

                // Validación: no exceder el stock total
                if ($nuevaCantidadDisponible > $cantidadStock) {
                    throw new Exception("La cantidad disponible superaría el stock total.");
                }

                // Actualizar herramienta con la nueva cantidad disponible
                $herramientaObj = new Herramienta(
                    $detalle['Herramienta_Id'],
                    null,
                    null,
                    $cantidadStock,
                    $nuevaCantidadDisponible
                );
                $resultado = $herramientaObj->modificarStockYDisponibilidadHerramienta($pdo);
                if (!$resultado) {
                    throw new Exception("No se pudo modificar la herramienta.");
                }
            }

            // Actualizar el préstamo: estado = Devuelto y fecha de devolución
            $hoy = date('Y-m-d');
            $prestamoModel = new Prestamo(
                $prestamoId,
                null,
                null,
                $hoy,
                EstadoPrestamo::Devuelto
            );
            $resultado = $prestamoModel->actualizarEstadoYFechaDevolucion($pdo);
            if (!$resultado) {
                throw new Exception("Error al modificar el estado del préstamo.");
            }

            $pdo->commit();

            // Redirigir según el rol en sesión
            if (isset($_SESSION['Usuario_Rol']) && $_SESSION['Usuario_Rol'] === 'admin') {
                header('Location: index.php?ruta=dashboard_admin');
            } else {
                header('Location: index.php?ruta=dashboard_usuario');
            }
            exit;
        } catch (Exception $e) {
            $pdo->rollBack();
            echo 'Error al devolver todo el préstamo: ' . $e->getMessage();
        }
    } else {
        // Redirigir según el rol en sesión si no hay id de préstamo
        if (isset($_SESSION['Usuario_Rol']) && $_SESSION['Usuario_Rol'] === 'admin') {
            header('Location: index.php?ruta=dashboard_admin');
        } else {
            header('Location: index.php?ruta=dashboard_usuario');
        }
        exit;
    }
}


function actualizarPrestamoUsuario()
{
    global $pdo; 
    
    if (isset($_GET['id'])) 
    {
        try 
        {
            $prestamo = new Prestamo($_GET['id'], null, null, null, null);
            $resultados = $prestamo->consultarPrestamosConDetalles($pdo);
            if ($resultados && count($resultados) > 0) {
                $resultadoIndex = $resultados[0];
                // Validar estado antes de mostrar el form
                if ($resultadoIndex['Prestamo_Estado'] === 'Devuelto') {
                    header('Location: index.php?ruta=dashboard_usuario');
                    exit;
                }
                $prestamoConsulta = new Prestamo(
                    $resultadoIndex['Prestamos_Id'],
                    $resultadoIndex['Usuario_Cedula'],
                    $resultadoIndex['Prestamo_FechaPres'],
                    $resultadoIndex['Prestamo_FechaDev'],
                    $resultadoIndex['Prestamo_Estado']
                );
                // cantidad prestada actual = detalleprestamo.Cantidad
                $resultadoIndex['prestado'] = isset($resultadoIndex['Cantidad']) ? $resultadoIndex['Cantidad'] : 0;
                // cantidad disponible actual = herramienta.Herramienta_CantidadDisponible
                require_once __DIR__ . '/../views/Prestamos/actualizarPrestamoUsuario.php';
            } else {
                header('Location: index.php?ruta=dashboard_usuario');
                exit;
            }
        }catch (PDOExeception $e ) {
            throw new Exception ("Error al modificar ".e->getMessage());
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $pdo->beginTransaction();
            $prestamoId = $_POST['id'];
            $herramientaId = $_POST['herramientaId'];
            $cantidad = $_POST['cantidad'];
            $cantidadPrestada = $_POST['cantidadPrestadaFinal'];
            $cantidadDisponibleTotal = $_POST['cantidadDisponibleFinal'];
            // Consulta actual para validar estado antes de modificar
            $prestamo = new Prestamo($prestamoId, null, null, null, null);
            $resultados = $prestamo->consultarPrestamosConDetalles($pdo);
            if ($resultados && count($resultados) > 0) {
                $resultadoIndex = $resultados[0];
                if ($resultadoIndex['Prestamo_Estado'] === 'Devuelto') {
                    $pdo->rollBack();
                    header('Location: index.php?ruta=dashboard_usuario');
                    exit;
                }
                // Solo lógica de resta
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
                $idDetallePrestamo = isset($_POST['idDetallePrestamo']) ? $_POST['idDetallePrestamo'] : null;
                if ($idDetallePrestamo && $cantidadPrestada > 0) {
                    // Si la cantidad prestada final es mayor a cero, modificar detalleprestamo
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
                } else if ($cantidadPrestada == 0) {
                    // Si la cantidad prestada final es cero, cambiar estado del préstamo a Devuelto y actualizar fecha de devolución
                    $hoy = date('Y-m-d');
                    $prestamoDevuelto = new Prestamo(
                        $prestamoId,
                        null,
                        null,
                        $hoy,
                        'Devuelto'
                    );
                    $resultadoEstado = $prestamoDevuelto->actualizarEstadoYFechaDevolucion($pdo);
                    if (!$resultadoEstado) {
                        throw new Exception("Error al actualizar el estado del préstamo a Devuelto.");
                    }
                }
                $pdo->commit();
                header('Location: index.php?ruta=dashboard_usuario');
                exit;
            } else {
                $pdo->rollBack();
                header('Location: index.php?ruta=dashboard_usuario');
                exit;
            }
        } catch (Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
    }
}

