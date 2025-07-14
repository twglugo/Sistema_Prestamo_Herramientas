
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
}

    
?>
