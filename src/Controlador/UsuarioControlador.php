<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../modelos/Usuario.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


function listarUsuarios() {
    global $pdo;

    
    $usuario = new Usuario(null, null, null,null, null);
    $usuarios = $usuario->consultarTodosUsuario($pdo);

    
    require_once __DIR__ . '/../views/Usuarios/Listar.php';
}


function crearUsuarios() {
    global $pdo;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $cedula = $_POST['cedula'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $rol = $_POST['rol'];

        $usuario = new Usuario($cedula, $nombre, $apellido, $email, $rol);
        $usuario->setRol($rol);

        $resultado = $usuario->crearUsuario($pdo);
        if ($resultado) {
        echo "Usuario creado exitosamente.";
        Header("Location: index.php?ruta=usuarios");
        } else {
            echo "Error al crear el usuario.";
        
        }
    }else {
        require_once __DIR__ . '/../views/usuarios/crearUsuario.php';
    }

    
}

function actualizarUsuarios() {
    global $pdo;
    try {

        // Si es una solicitud GET, mostrar el formulario de actualización
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['cedula'])) {
            
            $cedula = $_GET['cedula'];
            $usuario = new Usuario($cedula, null, null, null,null);
            $resultado = $usuario->consultarUsuarioPorCedula($pdo);
            if ($resultado) {
                $usuario = new Usuario(
                    $resultado['Usuario_Cedula'],
                    $resultado['Usuario_Nombre'],
                    $resultado['Usuario_Apellido'],
                    $resultado['Usuario_Email'],
                    $resultado['Usuario_Rol']
                    
                );
                
                require_once __DIR__ . '/../views/usuarios/actualizarUsuario.php';

            }else {
                throw $th;
                Header("Location: index.php?ruta=usuarios");
            }
        }
        // Si es una solicitud POST, actualizar el usuario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $cedula = $_POST['cedula'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $rol = $_POST['rol'];

        $usuario = new Usuario($cedula, $nombre, $apellido, $email, $rol);
        

        $resultado = $usuario->modificarUsuario($pdo);
        if ($resultado) {
            echo "Usuario actualizado exitosamente.";
            Header("Location: index.php?ruta=usuarios");
        } else {
            throw $th;
            echo "Error al actualizar el usuario.";
        }
        } else {
            require_once __DIR__ . '/../views/usuarios/actualizarUsuario.php';
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
