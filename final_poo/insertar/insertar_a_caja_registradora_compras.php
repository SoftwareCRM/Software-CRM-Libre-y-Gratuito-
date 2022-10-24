<?php 
    require_once("/xampp/htdocs/final_poo/plantillas/bd.php");
    require_once("/xampp/htdocs/final_poo/insertar/insertar_inicio_sesion_usuario.php");

    date_default_timezone_set('America/Caracas');

   
    class Compras extends Conexion{
        private $conexion;
        private $where;

        public function __construct(){
            $this->conexion = new Conexion();
            $this->conexion = $this->conexion->conexion();
        }

        public function insertarCaja(string $nom_cliente,  $monto_total,  $producto,  $id_carr,  $cantidad_vender, $cedula)
        { 
            $Fecha = new DateTime();  
            $FechaYHora = $Fecha->format("d-m-Y h:i:s");   

            $this->id_carr= $id_carr;
            $this->producto = $producto;
            $this->nom_cliente = $nom_cliente;
            $this->monto_total = $monto_total;
            $this->cantidad_vender = $cantidad_vender;
            $this->cedula = $cedula;
            $id_usu = $_SESSION['id_usu'];

            


            for($i = 0; $i < count($this->producto); $i++) { // FOR PARA LOGRAR USAR EL ARRAY DE LOS PRODUCTOS

                $producto = $this->producto[$i];

                // COMIENZA
                $validar = "SELECT * FROM clientes WHERE ced_cliente = BINARY '$this->cedula'"; //Variable necesaria para el query
                $validando = $this->conexion->query($validar); // Guarda el id 

                if ($validando->rowCount() > 0) { // En caso de que el id se repita saltara la alerta

                    $consulta = "SELECT * FROM clientes WHERE nom_cliente = BINARY '$this->nom_cliente' AND ced_cliente = '$this->cedula'";
                    $resultado = $this->conexion->query($consulta);
                    $row = $resultado->rowCount();

                    if($row > 0){
                        $sql = "SELECT * FROM clientes WHERE ced_cliente = '$this->cedula'";
                        foreach ($this->conexion->query($sql) as $row){
                            $ID_cliente = $row['id_cliente'];                  
        
                        }
                    } else {
                        echo "<script>alert('Los datos de este cliente ya registrado no coinciden');window.location='../paginas/carrito_productos.php'</script>";
                    }
                } else {
                    $sql = "INSERT INTO clientes(nom_cliente, ced_cliente, fecha) VALUES (?,?,?)";
                    $insertar = $this->conexion->prepare($sql);
                    $arrData = array($this->nom_cliente, $this->cedula, $FechaYHora);
                    $resInsertar = $insertar->execute($arrData);
                    $idInsertar = $this->conexion->lastInsertId();

                    $id_cliente = "SELECT * FROM clientes WHERE ced_cliente = '$this->cedula'";
                    foreach ($this->conexion->query($id_cliente) as $row){
                        $ID_cliente = $row['id_cliente'];                  
    
                    }
                }

                // TERMINA

                for ($h = 0; $h < count($this->cantidad_vender); $h++ ){ // FOR PARA LOGRAR USAR EL ARRAY DE LAS CANTIDADES A VENDER

                    $cantidad_vender = $this->cantidad_vender[$h];

                    
                    
                    if ($this->producto[$i] != $this->cantidad_vender[$h] && $i!=$h){
                        //NO SE HACE NADA
                    } else {

                        

                        $sql4 = "UPDATE productos SET cantidad_prod = cantidad_prod-? WHERE id_prod = ? ";
                        $insertar = $this->conexion->prepare($sql4);
                        $arrData = array($cantidad_vender, $producto);
                        $resInsertar = $insertar->execute($arrData); 

                        for ($j = 0; $j < count($this->id_carr); $j++){ // FOR PARA LOGRAR USAR EL ARRAY DE LOS ID DEL CARRITO

                            $id_carr = $this->id_carr[$j];
        
                            if($this->producto[$i] != $this->id_carr[$j] && $i!=$j){
                                //NO SE HACE NADA
                            } else{

                                

                                $sql2 = "INSERT INTO compras(id_prod, id_usu, id_carr, id_cliente, fecha, monto_total) VALUES (?,?,?,?,?,?)";
                                $insertar = $this->conexion->prepare($sql2);
                                $arrData = array($producto, $id_usu, $id_carr, $ID_cliente, $FechaYHora, $this->monto_total);
                                $resInsertar = $insertar->execute($arrData);
                                $idInsertar = $this->conexion->lastInsertId();
        
                                $sql3 = "UPDATE carrito SET estado_carr = 0 WHERE id_prod = ? ";
                                $insertar = $this->conexion->prepare($sql3);
                                $arrData = array($producto);
                                $resInsertar = $insertar->execute($arrData); 
            
                                
        
                                echo "<script>window.location='../paginas/carrito_productos.php'</script>"; 
        
                            }
                        }
                    }

                }
               

                
            }
        }

        public function Buscador( $buscar){

            $id_usu = $_SESSION['id_usu'];//Variable global
            $this->buscador = $buscar;

            $this->where = "AND Cli.nom_cliente LIKE '%$this->buscador%' OR Com.id_com LIKE '%$this->buscador%' AND Com.id_usu = '$id_usu'";
        }

        public function MostrarCaja(){ // Muestra los productos que hay en el almacen *productos*
            
            $id_usu = $_SESSION['id_usu'];//Variable global
            
            $sql = "SELECT Com.fecha, Cli.ced_cliente, Cli.nom_cliente, Com.monto_total, Com.id_com FROM compras Com INNER JOIN clientes Cli ON Com.id_cliente = Cli.id_cliente WHERE Com.id_usu = '$id_usu' $this->where GROUP BY Com.fecha ORDER BY Com.id_com DESC";
            $execute = $this->conexion->query($sql);
            $request = $execute->fetchall(PDO::FETCH_ASSOC);

            if ($this->where == true){
                if ($execute->rowCount() == 0){
                    echo "<script>alert('No se encontró ningún resultado');window.location='../paginas/caja_registradora_compras.php';</script>";
                }
            } 
            return $request;
        }

        public function EliminarCarrito(int $id_carr){
            $this->id_carr = $id_carr;
    
            $sql = "DELETE FROM carrito WHERE id_carr =? ";
            $insertar = $this->conexion->prepare($sql);
            $arrData = array($this->id_carr);
            $resInsertar = $insertar->execute($arrData);
            
            echo "<script>window.location='../paginas/carrito_productos.php'</script>"; 
        }


        // ADMIN //
        public function BuscadorAdmin($buscar){

            $this->buscador = $buscar;

            $this->where = "AND nom_cliente LIKE '%$this->buscador%' OR nom_usu LIKE '%$this->buscador%'";
        }

        public function MostrarCajaAdmin(){ // Muestra los productos que hay en el almacen *productos*
            
            
            $sql = "SELECT Com.fecha, Cli.nom_cliente, Com.monto_total, Com.id_com, Com.id_usu, Usu.id_usu, Usu.nom_usu FROM compras Com INNER JOIN usuarios Usu ON Com.id_usu = Usu.id_usu INNER JOIN clientes Cli ON Cli.id_cliente = Com.id_cliente WHERE Com.fecha $this->where GROUP BY fecha";
            $execute = $this->conexion->query($sql);
            $request = $execute->fetchall(PDO::FETCH_ASSOC);

            if ($this->where == true){
                if ($execute->rowCount() == 0){
                    echo "<script>alert('No se encontró ningún resultado');window.location='../admin/admin_ventas.php'</script>";
                }
            } 
            return $request;
        }


        // SUPER ADMIN
        
        public function BuscadorSuperAdmin($buscar){

            $this->buscador = $buscar;

            $this->where = "AND nom_cliente LIKE '%$this->buscador%' OR nom_usu LIKE '%$this->buscador%'";
        }

        public function MostrarCajaSuperAdmin(){ // Muestra los productos que hay en el almacen *productos*
            
            
            $sql = "SELECT Com.fecha, Cli.nom_cliente, Com.monto_total, Com.id_com, Com.id_usu, Usu.id_usu, Usu.nom_usu FROM compras Com INNER JOIN usuarios Usu ON Com.id_usu = Usu.id_usu INNER JOIN clientes Cli ON Cli.id_cliente = Com.id_cliente WHERE Com.fecha $this->where GROUP BY fecha ";
            $execute = $this->conexion->query($sql);
            $request = $execute->fetchall(PDO::FETCH_ASSOC);

            if ($this->where == true){
                if ($execute->rowCount() == 0){
                    echo "<script>alert('No se encontró ningún resultado');window.location='../superadmin/superAdmin_ventas.php'</script>";
                }
            } 
            return $request;
        }

        public function EliminarCompraSuperAdmin($fecha){
            
            $this->fecha = $fecha;
    
            $sql = "DELETE FROM compras WHERE fecha = ?";
            $insertar = $this->conexion->prepare($sql);
            $arrData = array($this->fecha);
            $resInsertar = $insertar->execute($arrData);
            
            echo "<script>alert('Se ha eliminado con éxito');window.location='../superadmin/superAdmin_ventas.php'</script>"; 
        }

    }
?>