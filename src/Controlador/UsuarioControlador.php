
<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../Modelos/Usuario.php';

if (session_status() === PHP_SESSION_NONE) {
    
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


function listarUsuarios() {
    global $pdo;

    
    $usuario = new Usuario(null, null, null,null, null);
    $usuarios = $usuario->consultarTodosUsuario($pdo);

    
    require_once __DIR__ . '/../Views/Usuarios/Listar.php';
}


function crearUsuarios() {
    global $pdo;
    $mensaje = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $cedula = $_POST['cedula'];
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $email = $_POST['email'];
            $rol = $_POST['rol'];

            $usuario = new Usuario($cedula, $nombre, $apellido, $email, $rol);
            $usuario->setRol($rol);

            $resultado = $usuario->crearUsuario($pdo);
            if ($resultado) {
                $mensaje = "Usuario creado exitosamente.";
                Header("Location: index.php?ruta=dashboard_admin");
                exit;
            } else {
                $mensaje = "Error al crear el usuario.";
            }
        } catch (Exception $e) {
            $mensaje = "Error: Cedula ya registrada"  ;
            
        }
        require_once __DIR__ . '/../Views/Usuarios/CrearUsuario.php';
    } else {
        require_once __DIR__ . '/../Views/Usuarios/CrearUsuario.php';
    }
}

function actualizarUsuarios() {
    global $pdo;
    session_start();
    try {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cedula = $_POST['cedula'];
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $email = $_POST['email'];
            $rol = $_POST['rol'];

            $usuario = new Usuario($cedula, $nombre, $apellido, $email, $rol);
            $resultado = $usuario->modificarUsuario($pdo);
            if ($resultado) {
                $rolActual = $_POST['sessionRol'] ?? ($_SESSION['Usuario_Rol'] ?? '');
                if (strtolower($rolActual) === 'admin') {
                    Header("Location: index.php?ruta=dashboard_admin");
                    exit;
                } else {
                    Header("Location: index.php?ruta=dashboard_usuario");
                    exit;
                }
            } else {
                echo "Error al actualizar el usuario.";
            }
            return;
        }

        // GET o cualquier otro método: mostrar el formulario si hay cédula
        $cedula = $_GET['cedula'] ?? ($_SESSION['Usuario_Cedula'] ?? null);
        if ($cedula) {
            $usuario = new Usuario($cedula, null, null, null, null);
            $resultado = $usuario->consultarUsuarioPorCedula($pdo);
            if ($resultado) {
                $usuario = new Usuario(
                    $resultado['Usuario_Cedula'],
                    $resultado['Usuario_Nombre'],
                    $resultado['Usuario_Apellido'],
                    $resultado['Usuario_Email'],
                    $resultado['Usuario_Rol']
                );
                require_once __DIR__ . '/../Views/Usuarios/actualizarUsuario.php';
                return;
            }
        }
        // Si no hay cédula válida, redirigir según el rol
        
        if (isset($_SESSION['Usuario_Rol']) && strtolower($_SESSION['Usuario_Rol']) === 'usuario') {
            Header("Location: index.php?ruta=dashboard_usuario");
            exit;
        } else {
            Header("Location: index.php?ruta=dashboard_admin");
            exit;
        }
    } catch (\Throwable $th) {
        throw $th;
    }
}



function eliminarUsuarios()
{
    global $pdo;

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['cedula'])) {
        $cedula = $_GET['cedula'];
        $usuario = new Usuario($cedula, null, null, null,null);
        $resultado = $usuario->eliminarUsuario($pdo);
        if ($resultado) {
            echo "Usuario eliminado exitosamente.";
            Header("Location: index.php?ruta=usuarios");
        } else {
            echo "Error al eliminar el usuario.";
        }
    } else {
        Header("Location: index.php?ruta=usuarios");
    }

}



// busquedas - filtros 


function buscarUsuario() {
    global $pdo;
    $mensaje = null;
    try {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cedula = $_POST['cedula'] ?? '';
            $nombre = $_POST['nombre'] ?? '';
            $apellido = $_POST['apellido'] ?? '';
            $email = $_POST['email'] ?? '';
            $rol = $_POST['rol'] ?? '';

            $usuario = new Usuario($cedula, $nombre, $apellido, $email, $rol);
            $usuarios = $usuario->buscarUsuario($pdo);

            if ($usuarios) {
                require_once __DIR__ . '/../Views/Usuarios/filtroUsuario.php';
            } else {

                $mensaje = "No se encontraron usuarios con ese filtro.";
                require_once __DIR__ . '/../Views/Usuarios/filtroUsuario.php';
                

            }
        } else {
            require_once __DIR__ . '/../Views/Usuarios/filtroUsuario.php';
        }
    } catch (PDOException $e) {
        $mensaje = "Error al buscar usuarios: " . $e->getMessage();
        require_once __DIR__ . '/../Views/Usuarios/filtroUsuario.php';
    }
}