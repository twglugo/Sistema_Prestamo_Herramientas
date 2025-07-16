<?php 

    class Usuario {
        private $cedula;
        private $nombre;
        private $apellido;
        private $email;
        private $rol;

        public function __construct($cedula, $nombre, $apellido, $email, $rol) {
            $this->cedula = $cedula;
            $this->nombre = $nombre;
            $this->apellido = $apellido;
            $this->email = $email;
            $this->rol = $rol; 
        }

        public function getCedula() {
            return $this->cedula;
        }

        public function getNombre() {
            return $this->nombre;
        }
        public function getApellido() {
            return $this->apellido;
        }

        public function getEmail() {
            return $this->email;
        }
        public function getRol() {
            return $this->rol;
        }

        public function setCedula($cedula) {
            $this->cedula = $cedula;
        }   

        public function setNombre($nombre) {
            $this->nombre = $nombre;
        }

        public function setApellido($apellido) {
            $this->apellido = $apellido;
        }

        public function setEmail($email) {
            $this->email = $email;
        }

        public function setRol($rol) {
            $this->rol = $rol;
        }
    
        //Metodos De Consulta Bd

        public function consultarTodosUsuario($pdo){
            try {
                $sql = "SELECT * FROM usuarios";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $th) {

                throw new Exception("Error al crear el usuario: " . $th->getMessage());
            }
            
        }

    

        /// Consulta por cedula

        public function consultarUsuarioPorCedula($pdo) {
            try {
                $sql = "SELECT * FROM usuarios WHERE Usuario_Cedula = :cedula limit 1";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':cedula', $this->cedula);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException  $th) {
                
                throw new Exception("Error al consultar el usuario por esa Cedula: " . $th->getMessage());
            }
            
        }
            
        //Creacion de usuario bd

        public function crearUsuario($pdo) {
            try {
                $sql = "INSERT INTO usuarios (Usuario_Cedula, Usuario_Nombre, Usuario_Apellido, Usuario_Email, Usuario_Rol) VALUES 
                (:cedula, :nombre, :apellido, :email, :rol)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':cedula', $this->cedula);
                $stmt->bindParam(':nombre', $this->nombre);
                $stmt->bindParam(':apellido', $this->apellido);
                $stmt->bindParam(':email', $this->email);
                $stmt->bindParam(':rol', $this->rol);
                return $stmt->execute();
            } catch (PDOException  $th) {
                
                throw new Exception("Error al crear el usuario: " . $th->getMessage());
            }
            
        }

        //Modificar usuario bd

        public function modificarUsuario($pdo) {
            try {
                $sql = "UPDATE usuarios SET 
                Usuario_Nombre = :nombre, Usuario_Apellido = :apellido, Usuario_Email = :email, Usuario_Rol = :rol 
                WHERE Usuario_Cedula = :cedula";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':cedula', $this->cedula);
                $stmt->bindParam(':nombre', $this->nombre);
                $stmt->bindParam(':apellido', $this->apellido);
                $stmt->bindParam(':email', $this->email);
                $stmt->bindParam(':rol', $this->rol);
                return $stmt->execute();
            } catch (PDOException  $th) {
                
                throw new Exception("Error al modificar el usuario: " . $th->getMessage());
            }
            
        }

        //Eliminar usuario bd

        public function eliminarUsuario($pdo) {
            try {
                $sql = "DELETE FROM usuarios WHERE Usuario_Cedula = :cedula";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':cedula', $this->cedula);
                return $stmt->execute();
            } catch (PDOException  $th) {
                
                throw new Exception("Error al eliminar el usuario: " . $th->getMessage());
            }
            
        }


        //loggear

        function loggear($pdo) {
            try {
                
                $sql = "SELECT u.Usuario_Cedula, u.Usuario_Rol FROM usuarios u  WHERE u.Usuario_Cedula = :cedula AND u.Usuario_Email = :email";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':cedula', $this->cedula);
                $stmt->bindParam(':email', $this->email);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException  $th) {
                
                throw new Exception("Error al loggear el usuario: " . $th->getMessage());
            }
            
        }
    
    
    
    }















?>