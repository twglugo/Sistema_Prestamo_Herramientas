<?php 

    class DetallePrestamo 
    {

        private $idDetallePrestamo;
        private $Prestamo_Id;
        private $Herramienta_Id;
        private $cantidad;

        public function __construct($idDetallePrestamo, $Prestamo_Id, $Herramienta_Id, $cantidad) {

            $this->idDetallePrestamo = $idDetallePrestamo;
            $this->Prestamo_Id = $Prestamo_Id;
            $this->Herramienta_Id = $Herramienta_Id;
            $this->cantidad = $cantidad;
        }

        public function getIdDetallePrestamo() {
            return $this->idDetallePrestamo;
        }

        public function getPrestamo_Id() {
            return $this->Prestamo_Id;
        }

        public function getHerramienta_Id() {
            return $this->Herramienta_Id;
        }
        public function getCantidad() {
            return $this->cantidad;
        }
        public function setIdDetallePrestamo($idDetallePrestamo) {
            $this->idDetallePrestamo = $idDetallePrestamo;
        }
        public function setPrestamo_Id($Prestamo_Id) {
            $this->Prestamo_Id = $Prestamo_Id;
        }
        public function setHerramienta_Id($Herramienta_Id) {
            $this->Herramienta_Id = $Herramienta_Id;
        }
        public function setCantidad($cantidad) {
            $this->cantidad = $cantidad;
        }
        //Metodos De Consulta Bd

        //Consultar todos los detalles de préstamo 
        public function consultarDetalles($pdo)
        {
            try {
                $sql = "SELECT 
                dp.idDetallePrestamo,
                u.Usuario_Nombre,
                u.Usuario_Apellido,
                h.Herramienta_Nombre,
                dp.Cantidad,
                p.Prestamo_FechaPres,
                p.Prestamo_Estado
                FROM detalleprestamo dp
                JOIN prestamos p ON dp.Prestamo_Id = p.Prestamos_Id
                JOIN usuarios u ON p.Usuario_Cedula = u.Usuario_Cedula
                JOIN herramientas h ON dp.Herramienta_Id = h.Herramienta_id
                ORDER BY dp.idDetallePrestamo DESC;";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {

                throw new Exception("Error al consultar los detalles del préstamo: " . $e->getMessage());
            }

        }

        //Consultar detalles de préstamo por ID
        public function consultarDetallePorId($pdo)
        {
            try {
                $sql = "SELECT * FROM detalleprestamo WHERE idDetallePrestamo = :idDetallePrestamo";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':idDetallePrestamo', $this->idDetallePrestamo);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                throw new Exception("Error al consultar el detalle del préstamo: " . $e->getMessage());
            }

        }

        //modificar detalle de préstamo
        public function modificarDetalle($pdo)
        {
            try {
                $sql = "UPDATE detalleprestamo 
                SET Prestamo_Id = :Prestamo_Id, 
                Herramienta_Id = 
                :Herramienta_Id, 
                Cantidad = :cantidad 
                WHERE idDetallePrestamo = :idDetallePrestamo";

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':idDetallePrestamo', $this->idDetallePrestamo);
                $stmt->bindParam(':Prestamo_Id', $this->Prestamo_Id);
                $stmt->bindParam(':Herramienta_Id', $this->Herramienta_Id);
                $stmt->bindParam(':cantidad', $this->cantidad);
                return $stmt->execute();
            } catch (PDOException $e) {
                throw new Exception("Error al modificar el detalle del préstamo: " . $e->getMessage());
            }

        }

        //Crear detalle de préstamo
        public function crearDetallePrestamo($pdo){
            try {
                $sql = "INSERT INTO detalleprestamo (Prestamo_Id, Herramienta_Id, Cantidad) 
                VALUES (:Prestamo_Id, :Herramienta_Id, :cantidad)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':Prestamo_Id', $this->Prestamo_Id);
                $stmt->bindParam(':Herramienta_Id', $this->Herramienta_Id);
                $stmt->bindParam(':cantidad', $this->cantidad);
                return $stmt->execute();
            } catch (PDOException $e) {
                throw new Exception("Error al crear el detalle del préstamo: " . $e->getMessage());
            }
        }
    
        // Consulta por prestamo

        public function consultarDetallesPorPrestamoId($pdo) {
            try {
                $sql = "SELECT dp.*, h.Herramienta_CantidadTotal,
                        h.Herramienta_CantidadDisponible
                 FROM detalleprestamo dp 
                 INNER JOIN herramientas h ON dp.Herramienta_Id = h.Herramienta_id 
                 INNER JOIN prestamos p ON dp.Prestamo_Id = p.Prestamos_Id
                 WHERE dp.Prestamo_Id = :prestamoId AND  p.Prestamo_Estado = 'Activo'";
                ;
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':prestamoId', $this->Prestamo_Id);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                throw new Exception("Error al consultar los detalles del préstamo: " . $e->getMessage());
            }
        }

        
    }

    




?>