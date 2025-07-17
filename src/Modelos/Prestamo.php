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
            $sql = "SELECT p.*, u.Usuario_Nombre, u.Usuario_Apellido
            FROM prestamos p 
            INNER JOIN usuarios u ON p.Usuario_Cedula = u.Usuario_Cedula;";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);   

        } catch (PDOException $e) {

            throw new Exception("Error al consultar los préstamos: " . $e->getMessage());
        }

    }
    // Consultar un préstamo por ID join usuario join herramienta join detalle

    public function consultarPrestamosConDetalles($pdo){
        try {
            $sql = "SELECT 
            p.*, 
            u.Usuario_Nombre, 
            u.Usuario_Apellido, 
            h.Herramienta_id, 
            h.Herramienta_Nombre,
            h.Herramienta_CantidadTotal,  
            h.Herramienta_CantidadDisponible,
            dp.Cantidad as prestado,
            dp.idDetallePrestamo,
            dp.Cantidad
            FROM prestamos p 
            INNER JOIN usuarios u ON p.Usuario_Cedula = u.Usuario_Cedula
            INNER JOIN detalleprestamo dp ON p.Prestamos_Id = dp.Prestamo_Id 
            INNER JOIN herramientas h ON h.Herramienta_id = dp.Herramienta_Id
            where p.Prestamos_Id = :id";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al consultar los préstamos con detalles: " . $e->getMessage());
        }
    }

    //Consulta totalizados con detalles -> usuario, herramienta, detalle
    public function consultarPrestamosTotalizadosConDetalles($pdo){
        try {
            $sql = "SELECT 
            p.*, 
            u.Usuario_Nombre, 
            u.Usuario_Apellido, 
            h.Herramienta_id, 
            h.Herramienta_Nombre,
            h.Herramienta_CantidadTotal,  
            h.Herramienta_CantidadDisponible,
            dp.Cantidad as prestado,
            dp.idDetallePrestamo,
            dp.Cantidad
            FROM prestamos p 
            INNER JOIN usuarios u ON p.Usuario_Cedula = u.Usuario_Cedula
            INNER JOIN detalleprestamo dp ON p.Prestamos_Id = dp.Prestamo_Id 
            INNER JOIN herramientas h ON h.Herramienta_id = dp.Herramienta_Id 
            ORDER BY p.Prestamo_Estado asc";

            $stmt = $pdo->prepare($sql);
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al consultar los préstamos con detalles: " . $e->getMessage());
        }
    }
    //consultar prestamos por usuario
    public function consultarPrestamosPorUsuario($pdo) {
        global $pdo;
        try {
            $sql = "SELECT p.*, u.Usuario_Nombre, u.Usuario_Apellido, 
            dp.Cantidad, 
            h.Herramienta_Nombre
            FROM prestamos p 
            INNER JOIN usuarios u ON p.Usuario_Cedula = u.Usuario_Cedula 
            INNER JOIN detalleprestamo dp ON p.Prestamos_Id = dp.Prestamo_Id 
            INNER JOIN herramientas h on h.Herramienta_id = dp.Herramienta_Id
            WHERE p.Usuario_Cedula = :cedula";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':cedula', $this->usuarioCedula);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al consultar los préstamos por usuario: " . $e->getMessage());
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
            $sql = "UPDATE prestamos 
            SET Usuario_Cedula = :usuarioCedula, 
            Prestamo_FechaPres = :fechaPrestamo, 
            Prestamo_FechaDev = :fechaDevolucion, 
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
    
    // Crear un nuevo préstamo
    public function crearPrestamo($pdo) {
        try {
            $sql = "INSERT INTO prestamos (Usuario_Cedula, Prestamo_FechaPres, Prestamo_Estado) 
            VALUES (:usuarioCedula, :fechaPrestamo, :estado)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':usuarioCedula', $this->usuarioCedula);
            $stmt->bindParam(':fechaPrestamo', $this->fechaPrestamo);
            $stmt->bindParam(':estado', $this->estado);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error al crear el préstamo: " . $e->getMessage());
        }   
    }

    //actualizar estado y fecha de devolución por id prestamo
    public function actualizarEstadoYFechaDevolucion($pdo) {
        try {
            $sql = "UPDATE prestamos 
            SET Prestamo_Estado = :estado, Prestamo_FechaDev = :fechaDev 
            WHERE Prestamos_Id = :prestamoId";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':estado', $this->estado);
            $stmt->bindParam(':fechaDev', $this->fechaDevolucion);
            $stmt->bindParam(':prestamoId', $this->id);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error al actualizar el estado y fecha de devolución del préstamo: " . $e->getMessage());
        }
    }
    


    

}