
<?php 

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../modelos/Usuario.php';
require_once __DIR__ . '/../modelos/Herramienta.php';
require_once __DIR__ . '/../modelos/prestamo.php';
require_once __DIR__ . '/../modelos/DetallePrestamo.php';


function dashboardAdmin() {
    session_start();
    if (!isset($_SESSION['usuario']) || strtolower($_SESSION['rol']) !== 'admin') {
        header('Location: index.php?ruta=login');
        exit;
    }

    global $pdo;
    
    $usuarioModel = new Usuario($usuarioCedula, null, null, null, null);
    $usuarios = $usuarioModel->consultarTodosUsuario($pdo);

    $herramientaModel = new Herramienta(null, null, null, null, null);
    $herramientas = $herramientaModel->consultarTodasHerramientas($pdo);


    $prestamoModel = new Prestamo(null, null, null, null, null);
    $prestamos = $prestamoModel->consultarPrestamosTotalizadosConDetalles($pdo);

    require_once __DIR__ . '/../Views/Dashboard/dashboardAdmin.php';
}

function dashboardUsuario() {
    session_start();
    if (!isset($_SESSION['cedula']) || !isset($_SESSION['rol']) || strtolower($_SESSION['rol']) !== 'usuario') {
        header('Location: index.php?ruta=login');
        exit;
    }

    global $pdo;
    $cedula = $_SESSION['cedula'];
    $usuarioModel = new Usuario($cedula, null, null, null, null);
    $usuario = $usuarioModel->consultarUsuarioPorCedula($pdo);

    $prestamoModel = new Prestamo(null, $cedula, null, null, null);
    $prestamos = $prestamoModel->consultarPrestamosPorUsuario($pdo);

    require_once __DIR__ . '/../Views/Dashboard/dashboardUsuario.php';
}