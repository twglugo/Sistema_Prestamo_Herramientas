<?php 

class Prestamo {
    private $id;
    private $usuarioCedula;
    private $fechaPrestamo;
    private $fechaDevolucion;
    private $estado;

    function __construct($id, $usuarioCedula, $fechaPrestamo, $fechaDevolucion, $estado) {
        $this->id = $id;
        $this->usuarioCedula = $usuarioCedula;
        $this->fechaPrestamo = $fechaPrestamo;
        $this->fechaDevolucion = $fechaDevolucion;
        $this->estado = $estado;
    }

    //Gettters and Setters

    function getId() {
        return $this->id;
    }

    function getUsuarioCedula() {
        return $this->usuarioCedula;
    }

    function getFechaPrestamo () {
        return $this->fechaPrestamo;
    }
    function getFechaDevolucion() {
        return $this->fechaDevolucion;
    }
    function getEstado() {
        return $this->estado;
    }
    function setId($id) {
        $this->id = $id;
    }
    function setUsuarioCedula($usuarioCedula) {
        $this->usuarioCedula = $usuarioCedula;
    }
    function setFechaPrestamo($fechaPrestamo) {
        $this->fechaPrestamo = $fechaPrestamo;
    }
    function setFechaDevolucion($fechaDevolucion) {
        $this->fechaDevolucion = $fechaDevolucion;
    }
    function setEstado($estado) {
        $this->estado = $estado;
    }

    // Consultar a la base de datos
    public function consultarTodosPrestamos($pdo) {
        try 
        {
            $sql = "SELECT * FROM prestamos";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);   

        } catch (PDOException $e) {

            throw new Exception("Error al consultar los préstamos: " . $e->getMessage());
        }

    }

    //Consultar un préstamo por ID
    public function consultarPrestamoPorId($pdo) {
        try 
        {
            $sql = "SELECT * FROM prestamos WHERE Prestamos_Id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al consultar el préstamo: " . $e->getMessage());
        }
    }

    // Modificar un préstamo
    public function modificarPrestamo($pdo) {
        try 
        {
            $sql = "UPDATE Prestamos 
            SET Usuario_Cedula = :usuarioCedula, 
            Prestamo_Fecha_Pres = :fechaPrestamo, 
            Prestamo_Fecha_Dev = :fechaDevolucion, 
            Prestamo_Estado = :estado
            WHERE Prestamos_Id = :id";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':usuarioCedula', $this->usuarioCedula);
            $stmt->bindParam(':fechaPrestamo', $this->fechaPrestamo);
            $stmt->bindParam(':fechaDevolucion', $this->fechaDevolucion);
            $stmt->bindParam(':estado', $this->estado);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error al modificar el préstamo: " . $e->getMessage());
        }
    }

    // Devolver un préstamo
    public function devolverPrestamo($pdo) {  
        $hoy = date('Y-m-d');
        if ($this->estado !== 'Activo') {
            throw new Exception("El préstamo no está activo y no puede ser devuelto.");
        }else
        {
            try {
                $sql = "UPDATE prestamos SET Prestamo_Estado = 'Devuelto', Prestamo_FechaDev = :fechaDev WHERE Prestamos_Id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':fechaDev', $hoy);
                $stmt->bindParam(':id', $this->id);
                return $stmt->execute();
            } catch (PDOException $e) {
                throw new Exception("Error al Devolver el préstamo: " . $e->getMessage());
            }
        }    
    
    }  

}