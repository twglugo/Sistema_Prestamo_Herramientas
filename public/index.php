
  <?php
  
    $ruta = $_GET['ruta'] ?? 'login'; // Ruta por defecto


    ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


switch ($ruta) {
    case 'login' :
        require_once __DIR__ . '/../src/Controlador/LoginControlador.php';
        login();
        break;
    case 'logout':
        require_once __DIR__ . '/../src/Controlador/LoginControlador.php';
        logout();
        break;
    case 'dashboard_admin':
        require_once __DIR__ . '/../src/Controlador/DashboardControlador.php';
        dashboardAdmin();
        break;
    case 'dashboard_usuario':
        require_once __DIR__ . '/../src/Controlador/DashboardControlador.php';
        dashboardUsuario();
        break;
    
    case 'usuarios':
        require_once __DIR__ . '/../src/Controlador/UsuarioControlador.php';
        listarUsuarios();
        break;
    case 'crear_usuario':
        require_once __DIR__ . '/../src/Controlador/UsuarioControlador.php';
        crearUsuarios();
        break;
    case 'actualizar_usuario':
        require_once __DIR__ . '/../src/Controlador/UsuarioControlador.php';
        // Si el admin accede, debe pasar la cédula por GET 
        // Si el usuario accede, no hay parámetro y se usa $_SESSION['cedula'] en el controlador
        actualizarUsuarios();
        break;
    case 'eliminar_usuario':
        require_once __DIR__ . '/../src/Controlador/UsuarioControlador.php';
        eliminarUsuarios();
        break;    
    



   
    case 'herramientas':
        require_once __DIR__ . '/../src/Controlador/HerramientasControlador.php';
        listarHerramientas();
        break;
    case 'crear_herramienta':
        require_once __DIR__ . '/../src/Controlador/HerramientasControlador.php';
        crearHerramienta();
        break;

    case 'actualizar_herramienta':
        require_once __DIR__ . '/../src/Controlador/HerramientasControlador.php';
        actualizarHerramienta();
        break;
    case 'eliminar_herramienta':
        try {
            require_once __DIR__ . '/../src/Controlador/HerramientasControlador.php';
            eliminarHerramienta();
        } catch (Exception $e) {
            throw new Exception("Error al eliminar la herramienta: " . $e->getMessage());

        }
        
        break;
    




        case 'prestamos':
            require_once __DIR__ . '/../src/Controlador/PrestamoControlador.php';
            listarPrestamos();
            break;
        case 'crear_prestamo':
            require_once __DIR__ . '/../src/Controlador/PrestamoControlador.php';   
            crearPrestamo();
            break;
        case 'actualizar_prestamo':
            require_once __DIR__ . '/../src/Controlador/PrestamoControlador.php';
            actualizarPrestamo();
            break;
        case 'actualizar_prestamo_usuario':
            require_once __DIR__ . '/../src/Controlador/PrestamoControlador.php';
            actualizarPrestamoUsuario();
            break;

        case 'devolver_todo':
            require_once __DIR__ . '/../src/Controlador/PrestamoControlador.php';
            devolverTodoPrestamo();
            break;
        case 'detalle_prestamo':
            require_once __DIR__ . '/../src/Controlador/DetallePrestamoControlador.php';
            listarDetallePrestamo();
    
            break;

        
}
?>
