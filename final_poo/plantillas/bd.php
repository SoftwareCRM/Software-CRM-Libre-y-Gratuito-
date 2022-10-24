<?php 
class Conexion{
    private $host="localhost";
    private $bd="bd"; //IMPORTANTE
    private $usuario="root";
    private $contrasenna="";
    private $conexion;

    public function __construct()
    {
        $cadenaConexion = "mysql:host={$this->host};dbname={$this->bd};chatset=utf8;";
        try { 
            $this->conexion = new PDO($cadenaConexion, $this->usuario, $this->contrasenna);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Conexion Exitosa";
        } catch (Exception $ex) {
            if($this->conexion->connect_errno)
            echo "Error de Conexión ($this->conexion->connect_errno)"; // El error esta aquí
            echo "Hubo un error al conectar al servidor: {$ex->getMessage()}";
        }

    }

    public function conexion()
    {
        return $this->conexion;
    }
}
?>
