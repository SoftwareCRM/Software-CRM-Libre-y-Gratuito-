<?php 
    require_once("/xampp/htdocs/final_poo/plantillas/bd.php");
    require_once("/xampp/htdocs/final_poo/insertar/insertar_inicio_sesion_usuario.php");

    class Carrito extends Conexion{
        private $id_prod;
        private $cantidad_prod;
        private $cantidad_a_vender; 
        private $conexion;

        public function __construct(){
            $this->conexion = new Conexion();
            $this->conexion = $this->conexion->conexion();
        }

        public function insertarCarrito(int $id_prod, int $cantidad_prod, int $cantidad_a_vender, int $id_usu)
        {
            $id_usu = $_SESSION['id_usu'];//Variable global
            $this->id_prod = $id_prod; //ID del producto
            $this->cantidad_prod = $cantidad_prod; //Cantidad
            $this->cantidad_a_vender = $cantidad_a_vender; // Cosas a vender
            $this->id_usu = $id_usu;

            $validar = "SELECT * FROM carrito WHERE id_prod = '$this->id_prod' AND estado_carr = 1 AND id_usu = '$id_usu'"; //Variable necesario para el query
            $validando = $this->conexion->query($validar); // Guarda el id 

            if ($this->cantidad_a_vender > 0){
                if ($cantidad_a_vender > $cantidad_prod){ //Comprueba si la cantidad desea existe
                    echo "<script>alert('No hay suficientes productos');
                            window.history.back;  
                    </script>"; 
    
                } else {
    
                    if ($validando->rowCount() > 0) { // En caso de que el id se repita saltara la alerta
                    
                        echo "<script>alert('Ya has agregado este producto');
                            window.history.back;  
                        </script>"; 
                        
                    } else { //En caso que no se insertará en la base de datos
    
                        $sql = "INSERT INTO carrito (id_usu, id_prod, cantidad_vender_carr) VALUES (?,?,?)";
                        $insertar = $this->conexion->prepare($sql);
                        $arrData = array($this->id_usu, $this->id_prod, $this->cantidad_a_vender);
                        $resInsertar = $insertar->execute($arrData);
                        $idInsertar = $this->conexion->lastInsertId();
                    }
                }
            } else {
                echo "<script>alert('La cantidad a vender debe ser mayor a cero (0)');window.location='../paginas/carrito_productos.php';</script>";
            }
            
        }

        public function MostrarCarrito(){ // Muestra los productos que hay en el almacen *productos*
            
            $id_usu = $_SESSION['id_usu'];//Variable global // ((Prd.pre_prod * Carr.cantidad_vender_carr) * Prd.iva_prod / 100) + (Prd.pre_prod * Carr.cantidad_vender_carr)
            
            $sql = "SELECT Carr.id_prod, Carr.id_carr, Prd.iva_prod, Carr.cantidad_vender_carr, Prd.pre_prod, Prd.pre_prod * Carr.cantidad_vender_carr, Prd.cantidad_prod-Carr.cantidad_vender_carr, Prd.cantidad_prod, Prd.nom_prod, ((Prd.pre_prod * Carr.cantidad_vender_carr) * Prd.iva_prod / 100) + (Prd.pre_prod * Carr.cantidad_vender_carr) FROM carrito Carr INNER JOIN productos Prd ON Carr.id_prod = Prd.id_prod WHERE Carr.id_usu = '$id_usu' AND estado_carr = 1";
            $execute = $this->conexion->query($sql);
            $request = $execute->fetchall(PDO::FETCH_ASSOC);
            return $request;
        }

        public function EliminarCarrito(int $id_carr){
            $this->id_carr = $id_carr;
    
            $sql = "UPDATE carrito SET estado_carr = 0 WHERE id_carr =? ";
            $insertar = $this->conexion->prepare($sql);
            $arrData = array($this->id_carr);
            $resInsertar = $insertar->execute($arrData);
            
            echo "<script>window.location='../paginas/carrito_productos.php'</script>"; 
        }

    }
?>