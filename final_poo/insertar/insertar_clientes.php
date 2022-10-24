<?php 
    require_once("/xampp/htdocs/final_poo/plantillas/bd.php");
    require_once("/xampp/htdocs/final_poo/insertar/insertar_inicio_sesion_usuario.php");

    date_default_timezone_set('America/Caracas');

   
    class Clientes extends Conexion{
        private $conexion;
        private $where;
        public $id_cliente_;

        public function __construct(){
            $this->conexion = new Conexion();
            $this->conexion = $this->conexion->conexion();
        }

        public function Buscador($buscar){ 

            $this->buscador = $buscar;

            $this->where = "AND Cli.nom_cliente LIKE '%$this->buscador%' OR Cli.ced_cliente LIKE '%$this->buscador%' AND Cli.estado_cliente = 1";
        }

        public function MostrarClientes(){ // Muestra los CLIENTES que hay 

            $sql = "SELECT Cli.id_cliente, Cli.nom_cliente, Cli.ced_cliente FROM clientes Cli WHERE Cli.estado_cliente = 1 $this->where GROUP BY Cli.id_cliente ORDER BY Cli.id_cliente DESC";
            $execute = $this->conexion->query($sql);
            $request = $execute->fetchall(PDO::FETCH_ASSOC);

            if ($this->where == true){
                if ($execute->rowCount() == 0){
                    echo "<script>alert('No se encontró ningún resultado');window.location='../paginas/clientes.php';</script>";
                }
            } 

            return $request;
        }

        public function ComprasCliente($id){

            $this->id_cliente = $id;
            $sql = "SELECT Com.monto_total, Cli.id_cliente, Cli.nom_cliente, Cli.ced_cliente, Com.id_com, Com.fecha FROM compras Com  INNER JOIN clientes Cli ON Com.id_cliente = Cli.id_cliente WHERE Cli.id_cliente = '$this->id_cliente' GROUP BY Com.fecha";
            $execute = $this->conexion->query($sql);

            $suma_compras=0;

            foreach ($this->conexion->query($sql) as $e){

                $monto_total = $e['monto_total'];
                $suma_compras = $suma_compras+= $monto_total;
            }
            echo "<script>alert('El dinero gastado por el cliente es de: ".number_format($suma_compras,2,'.','')."$');window.location='../paginas/clientes.php';</script>";

        }

        public function ProductosCliente($id){

            $this->id_cliente = $id;
            $sql = "SELECT Car.cantidad_vender_carr FROM carrito Car INNER JOIN compras Com ON Com.id_carr = Car.id_carr WHERE Com.id_cliente = '$this->id_cliente'";
            $execute = $this->conexion->query($sql);

            $suma_compras=0;

            foreach ($this->conexion->query($sql) as $e){

                $monto_total = $e['cantidad_vender_carr'];
                $suma_compras = $suma_compras+= $monto_total;
            }
            echo "<script>alert('El total de productos comprados por el cliente es de: ".$suma_compras."');window.location='../paginas/clientes.php';</script>";

        }

        // ELIMINACIÓN LÓGICA
        public function EliminarCliente($id){
            $this->id = $id;

            $sql = "UPDATE clientes SET estado_cliente = 0 WHERE id_cliente = ? ";
            $insertar = $this->conexion->prepare($sql);
            $arrData = array($this->id);
            $resInsertar = $insertar->execute($arrData);
            
            echo "<script>window.location='../paginas/clientes.php'</script>"; 
        }


        //SUPERADMIN
        public function BuscadorClientesEliminados($buscar){ 

            $this->buscador = $buscar;

            $this->where = "AND nom_cliente LIKE '%$this->buscador%' OR ced_cliente LIKE '%$this->buscador%' AND estado_cliente = 0";
        }

        public function MostrarClientesEliminados(){ // Muestra los CLIENTES que hay 

            $sql = "SELECT id_cliente, nom_cliente, ced_cliente FROM clientes WHERE estado_cliente = 0 $this->where GROUP BY id_cliente ORDER BY id_cliente DESC";
            $execute = $this->conexion->query($sql);
            $request = $execute->fetchall(PDO::FETCH_ASSOC);

            if ($this->where == true){
                if ($execute->rowCount() == 0){
                    echo "<script>alert('No se encontró ningún resultado');window.location='../paginas/clientes.php';</script>";
                }
            } 

            return $request;
        }

        public function EliminarClienteSuperAdmin($id){
            $this->id = $id;

            $sql = "DELETE FROM clientes WHERE id_cliente = ? ";
            $insertar = $this->conexion->prepare($sql);
            $arrData = array($this->id);
            $resInsertar = $insertar->execute($arrData);
            
            echo "<script>alert('¡Se ha eliminado al cliente con éxito!');window.location='../paginas/clientes.php'</script>"; 
        }

        public function DeshacerEliminacionCliente($id){
            $this->id = $id;

            $sql = "UPDATE clientes SET estado_cliente = 1 WHERE id_cliente = ? ";
            $insertar = $this->conexion->prepare($sql);
            $arrData = array($this->id);
            $resInsertar = $insertar->execute($arrData);
            
            echo "<script>alert('¡Se ha deshecho la eliminación con éxito!');window.location='../paginas/clientes.php'</script>"; 
        }

    }
?>