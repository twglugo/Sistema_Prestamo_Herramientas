
<?php 
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../Modelos/Usuario.php';

function login() {
    
    global $pdo;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'] ?? '';
        $cedula = $_POST['cedula'] ?? '';
        

        $usuario = new Usuario($cedula, null, null, $email, null);
        $resultado = $usuario->loggear($pdo);

        if ($resultado && isset($resultado['Usuario_Cedula'])) {
            session_start();
            // Unificar nombres de variables de sesión
            $_SESSION['Usuario_Cedula'] = $resultado['Usuario_Cedula'];
            $_SESSION['Usuario_Rol'] = $resultado['Usuario_Rol'];
            // Para compatibilidad, puedes dejar las otras si algún otro archivo las usa
            $_SESSION['usuario'] = $resultado['Usuario_Cedula'];
            $_SESSION['cedula'] = $resultado['Usuario_Cedula'];
            $_SESSION['rol'] = $resultado['Usuario_Rol'];
            if (strtolower($resultado['Usuario_Rol']) === 'admin') {
                header('Location: index.php?ruta=dashboard_admin');
            } else {
                header('Location: index.php?ruta=dashboard_usuario');
            }
            exit;
        } else {
            $error = 'Credenciales incorrectas.';
            
        }
    }

    require_once __DIR__ . '/../Views/Login/login.php';
}


function logout() {
    session_start();
    session_unset();
    session_destroy();
    header('Location: index.php?ruta=login');
    exit;
}