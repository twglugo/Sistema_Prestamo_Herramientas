<?php

    class Herramienta
    {

        private $id ;
        private $nombre ;
        private $descripcion ;
        private $cantidadTotal ;
        private $cantidadDisponible;
        
        public function __construct($id, $nombre, $descripcion, $cantidadTotal, $cantidadDisponible) {
            $this->id = $id;
            $this->nombre = $nombre;
            $this->descripcion = $descripcion;
            $this->cantidadTotal = $cantidadTotal;
            $this->cantidadDisponible = $cantidadDisponible;
        }
        public function getId() {
            return $this->id;
        }

        public function getNombre() {
            return $this->nombre;
        }
        public function getDescripcion() {
            return $this->descripcion;
        }
        public function getCantidadTotal() {
            return $this->cantidadTotal;
        }
        public function getCantidadDisponible() {
            return $this->cantidadDisponible;
        }
        public function setId($id) {
            $this->id = $id;
        }
        public function setNombre($nombre) {
            $this->nombre = $nombre;
        }
        public function setDescripcion($descripcion) {
            $this->descripcion = $descripcion;
        }
        public function setCantidadTotal($cantidadTotal) {
            $this->cantidadTotal = $cantidadTotal;
        }
        public function setCantidadDisponible($cantidadDisponible) {
            $this->cantidadDisponible = $cantidadDisponible;
        }
        //Metodos De Consulta Bd
    
        function consultarTodasHerramientas($pdo) {
            try {
                $sql = "SELECT * FROM herramientas order by Herramienta_CantidadDisponible DESC";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
               throw new Exception("Error al consultar las herramientas: " . $e->getMessage());
            }
        }
        
        //Consulta por ID 

        function consultarHerramientaPorId($pdo) {
            try {
                $sql = "SELECT * FROM herramientas WHERE herramienta_id = :id limit 1";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $this->id);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {

                throw new Exception("Error al consultar la herramienta por ID: " . $e->getMessage());
            }
        }
        //Consulta  Nombre por stock disponible 

        public function consultarHerramientasPorStock($pdo)
        {
            try {
                $sql = "SELECT 
                h.Herramienta_id,
                h.Herramienta_Nombre, 
                h.Herramienta_CantidadDisponible,
                h.Herramienta_CantidadTotal
            FROM 
                herramientas AS h 
            WHERE 
                h.Herramienta_CantidadDisponible > 0;";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {

                throw new Exception("Error al consultar las herramientas por stock: " . $e->getMessage());
            }
        }


        //Consulta de stock de herramienta validador 

        function consultarStockHerramienta($pdo)
        {
            try {
                $sql = "SELECT 
                Herramienta_CantidadTotal,
                Herramienta_CantidadDisponible
                FROM herramientas 
                WHERE Herramienta_id = :herramientaId";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':herramientaId', $this->id);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {

                throw new Exception("Error al consultar el stock de la herramienta: " . $e->getMessage());
            }
        }
        //Crear Herramienta

        function crearHerramienta($pdo) {
            try {
                $sql = "INSERT 
                INTO herramientas (Herramienta_nombre, 
                Herramienta_descrip, 
                Herramienta_cantidadTotal, 
                Herramienta_cantidadDisponible) 
                VALUES (:nombre, 
                :descripcion, 
                :cantidadTotal, 
                :cantidadDisponible)";

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':nombre', $this->nombre);
                $stmt->bindParam(':descripcion', $this->descripcion);
                $stmt->bindParam(':cantidadTotal', $this->cantidadTotal);
                $stmt->bindParam(':cantidadDisponible', $this->cantidadDisponible);
                return $stmt->execute();
            } catch (PDOException $e) {

                throw new Exception("Error al crear la herramienta: " . $e->getMessage());
            }
        }


        //Modificar al insertar detalle de prestamo -> actualizar stock herramienta
        function actualizarStockHerramienta($pdo) {
            try {
                $sql = "UPDATE herramientas 
                SET Herramienta_CantidadDisponible = Herramienta_CantidadDisponible - :cantidad 
                WHERE Herramienta_id = :herramientaId";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':cantidad', $this->cantidadDisponible);
                $stmt->bindParam(':herramientaId', $this->id);
                return $stmt->execute();
            } catch (PDOException $e) {

                throw new Exception("Error al actualizar el stock de la herramienta: " . $e->getMessage());
            }
        }
        //Modificar Herramienta

        function modificarHerramienta($pdo) {
            try {
                
                $sql = "UPDATE herramientas SET Herramienta_Nombre = :nombre, 
                Herramienta_Descrip = :descripcion, 
                Herramienta_CantidadTotal = :cantidadTotal, 
                Herramienta_CantidadDisponible = :cantidadDisponible 
                WHERE Herramienta_id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $this->id);
                $stmt->bindParam(':nombre', $this->nombre);
                $stmt->bindParam(':descripcion', $this->descripcion);
                $stmt->bindParam(':cantidadTotal', $this->cantidadTotal);
                $stmt->bindParam(':cantidadDisponible', $this->cantidadDisponible);
                return $stmt->execute();
            } catch (PDOException $e) {

                throw new Exception("Error al modificar la herramienta: " . $e->getMessage());
            }
        }
        //modificar stock herramienta por id 

        public function modificarStockHerramienta($pdo) {
            try {
                $sql = "UPDATE herramientas 
                SET Herramienta_CantidadDisponible = :cantidadDisponible 
                WHERE Herramienta_id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $this->id);
                $stmt->bindParam(':cantidadDisponible', $this->cantidadDisponible);
                return $stmt->execute();
            } catch (PDOException $e) {

                throw new Exception("Error al modificar el stock de la herramienta: " . $e->getMessage());
            }
        }

        //modificar stock y disponibilidad de herramienta por id

        public function modificarStockYDisponibilidadHerramienta($pdo) {
            try {
                $sql = "UPDATE herramientas 
                SET Herramienta_CantidadTotal = :cantidadTotal, 
                Herramienta_CantidadDisponible = :cantidadDisponible 
                WHERE Herramienta_id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $this->id);
                $stmt->bindParam(':cantidadTotal', $this->cantidadTotal);
                $stmt->bindParam(':cantidadDisponible', $this->cantidadDisponible);
                return $stmt->execute();
            } catch (PDOException $e) {

                throw new Exception("Error al modificar el stock y disponibilidad de la herramienta: " . $e->getMessage());
            }
        }

        //Eliminar Herramienta

        function eliminarHerramienta($pdo) {
            try {
                $sql = "DELETE FROM herramientas WHERE herramienta_id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id', $this->id);
                return $stmt->execute();
            } catch (PDOException $e) {

                throw new Exception("Error al eliminar la herramienta: " . $e->getMessage());
            }
        }
    
    
    
    
    
    
        //Consultar por nombre
        

        

        
    
    
    }

    



?>