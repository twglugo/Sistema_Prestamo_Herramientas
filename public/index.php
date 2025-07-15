
  <?php
    $ruta = $_GET['ruta'] ?? 'usuarios'; // Ruta por defecto


    ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


switch ($ruta) {
    case 'usuarios':
        require_once __DIR__ . '/../src/controlador/UsuarioControlador.php';
        listarUsuarios();
        break;
    case 'crear_usuario':
        require_once __DIR__ . '/../src/controlador/UsuarioControlador.php';
        crearUsuarios();
        break;
    case 'actualizar_usuario':
        require_once __DIR__ . '/../src/controlador/UsuarioControlador.php';
        actualizarUsuarios();
        break;
    case 'eliminar_usuario':
        require_once __DIR__ . '/../src/controlador/UsuarioControlador.php';
        eliminarUsuarios();
        break;    
    default:
        echo "Ruta no válida.";



   
    case 'herramientas':
        require_once __DIR__ . '/../src/controlador/HerramientasControlador.php';
        listarHerramientas();
        break;
    case 'crear_herramienta':
        require_once __DIR__ . '/../src/controlador/HerramientasControlador.php';
        crearHerramienta();
        break;

    case 'actualizar_herramienta':
        require_once __DIR__ . '/../src/controlador/HerramientasControlador.php';
        actualizarHerramienta();
        break;
    case 'eliminar_herramienta':
        require_once __DIR__ . '/../src/controlador/HerramientasControlador.php';
        eliminarHerramienta();
        break;
    




        case 'prestamos':
            require_once __DIR__ . '/../src/controlador/PrestamoControlador.php';
            listarPrestamos();
            break;
        case 'crear_prestamo':
            require_once __DIR__ . '/../src/controlador/PrestamoControlador.php';   
            crearPrestamo();
            break;
        case 'actualizar_prestamo':
            require_once __DIR__ . '/../src/controlador/PrestamoControlador.php';
            actualizarPrestamo();
            break;
        case 'devolver_prestamo':
            require_once __DIR__ . '/../src/controlador/PrestamoControlador.php';
            devolverPrestamo();
            break;
        case 'detalle_prestamo':
            require_once __DIR__ . '/../src/controlador/DetallePrestamoControlador.php';
            listarDetallePrestamo();
            break;
}
?>
