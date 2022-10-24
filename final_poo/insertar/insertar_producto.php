<?php 
    require_once("/xampp/htdocs/final_poo/plantillas/bd.php");
    require_once("/xampp/htdocs/final_poo/insertar/insertar_inicio_sesion_usuario.php");

    class Productos extends Conexion{
        private $nom_prd; // Nombre del producto
        private $pre_prd; // Precio del producto
        private $can_prd; // Cantidad del producto
        private $iva_prd; // IVA del producto
        private $conexion;
        private $where;
        private $where1;

        public function __construct(){
            $this->conexion = new Conexion();
            $this->conexion = $this->conexion->conexion();
        }

        public function Buscador($buscar){

            $this->buscador = $buscar;

            $this->where = "AND nom_prod LIKE '%$this->buscador%' OR id_prod LIKE '%$this->buscador%' AND cantidad_prod > 0 AND estado_prod = 1";
            return $this->where;
        }

        public function MostrarProductos(){ // Muestra los productos que hay en el almacen *productos*
            
            $this->where;

            $sql = "SELECT Prd.id_prod, Prd.nom_prod, Prd.pre_prod, Prd.cantidad_prod, Prd.iva_prod, (Prd.pre_prod * Prd.iva_prod)/100+Prd.pre_prod FROM productos Prd WHERE estado_prod = 1 AND Prd.cantidad_prod > 0 $this->where ORDER BY Prd.id_prod DESC";
            $execute = $this->conexion->query($sql);
            $request = $execute->fetchall(PDO::FETCH_ASSOC);

            if ($this->where == true){
                if ($execute->rowCount() == 0){
                    echo "<script>alert('No se encontró ningún resultado');window.location='../paginas/almacen_productos.php';</script>";
                }
            } 
            return $request;

        } 

        public function IVAProductos(){

            $iva_producto = "SELECT iva FROM configuracion_pdf Cfg INNER JOIN usuarios Usu ON Usu.id_usu = Cfg.id_usu WHERE Usu.acceso_usu = 2";
            $execute = $this->conexion->query($iva_producto);
            

            foreach ($this->conexion->query($iva_producto) as $i){ //DATOS EMPRESA
                $iva_ = $i['iva'];
                return $iva_;
            }
        }

        // PAGINA DE LA FACTURACION (CARRITO)
        public function BuscadorCarrito($buscar){

            $id_usu = $_SESSION['id_usu'];//Variable global
            $this->buscador = $buscar;

            $this->where = "AND nom_prod LIKE '%$this->buscador%' OR id_prod LIKE '%$this->buscador%' AND cantidad_prod > 0 AND id_usu = '$id_usu' AND estado_prod = 1";
            return $this->where;
        }

        public function MostrarProductosCarrito(){ // Muestra los productos que hay en el almacen *productos*
            
            $id_usu = $_SESSION['id_usu'];//Variable global
            $this->where;

            $sql = "SELECT Prd.id_prod, Prd.nom_prod, Prd.pre_prod, Prd.cantidad_prod, Prd.iva_prod, (Prd.pre_prod * Prd.iva_prod)/100+Prd.pre_prod FROM productos Prd WHERE estado_prod = 1 AND Prd.cantidad_prod > 0 $this->where";
            $execute = $this->conexion->query($sql);
            $request = $execute->fetchall(PDO::FETCH_ASSOC);

            if ($this->where == true){
                if ($execute->rowCount() == 0){
                    echo "<script>alert('No se encontró ningún resultado');window.location='../paginas/carrito_productos.php';</script>";
                }
            } 

            return $request;

        }
        // TERMINADA AQUI


        public function SeleccionarProductos(){ // Muestra los productos que hay en el almacen *productos*
            
            $id = $_GET['id']; // Variable global
            
            $sql = "SELECT Prd.id_prod, Prd.nom_prod, Prd.iva_prod, Prd.pre_prod, (Prd.pre_prod * Prd.iva_prod)/100+Prd.pre_prod, Prd.cantidad_prod, Prd.iva_prod FROM productos Prd WHERE id_prod = '$id'";
            $execute = $this->conexion->query($sql);
            $request = $execute->fetchall(PDO::FETCH_ASSOC);
            return $request;
        }

        public function ModificarProductos(int $id_prod, string $nombre, $precio, $cantidad, $iva){
            
            $this->id_prod = $id_prod;
            $this->nom_prd = $nombre;
            $this->pre_prd = $precio;
            $this->can_prd = $cantidad;
            $this->iva_prd = $iva;

            if (strlen($this->nom_prd) >=3){
                if ($this->pre_prd > 0){
                    if ($this->can_prd > 0){
                        $sql = "UPDATE productos SET nom_prod=?, pre_prod=?, cantidad_prod=?, iva_prod=? WHERE id_prod=?";
                        $insertar = $this->conexion->prepare($sql);
                        $arrData = array($this->nom_prd, $this->pre_prd,$this->can_prd,$this->iva_prd,$this->id_prod);
                        $resInsertar = $insertar->execute($arrData);
                        echo "<script>alert('Se ha modificado el producto con éxito');window.location='../admin/admin_almacen_tienda.php';</script>"; 
                    } else if ($this->can_prd == 0){
                        echo "<script>alert('La cantidad del producto debe ser mayor a cero (0)');windows.history.go(-1);</script>";
                    }
                } else if ($this->pre_prd == 0){
                    echo "<script>alert('El precio del producto debe ser mayor a cero (0)');windows.history.go(-1);</script>";
                }
            } else if (strlen($this->nom_prd) < 3){
                echo "<script>alert('El nombre del producto debe ser mayor a 3 carácteres');windows.history.go(-1);</script>";
            }

            
        }

        public function EliminarProductos(int $id_prod, int $acceso_usu){

            $this->id_prod = $id_prod;
            $this->acceso_usu = $acceso_usu;

            $sql = "UPDATE productos SET estado_prod = 0 WHERE id_prod = ? ";
            $insertar = $this->conexion->prepare($sql);
            $arrData = array($this->id_prod);
            $resInsertar = $insertar->execute($arrData);

            echo "<script>alert('Se ha eliminado el producto con éxito');window.location='../admin/admin_productos.php'</script>"; 
        }


        //////// ADMINISTRADOR

        public function insertarProducto(string $nombre, $precio, int $cantidad, $iva)
        {
            $this->nom_prd = $nombre;
            $this->pre_prd = $precio;
            $this->can_prd = $cantidad;
            $this->iva_prd = $iva;
            $id_usu = $_SESSION['id_usu'];
            
            if (strlen($this->nom_prd) >= 3){

                if ($this->pre_prd > 0) {
                    if ($this->can_prd > 0){
                        $sql = "INSERT INTO productos(id_usu,nom_prod,pre_prod,cantidad_prod,iva_prod) VALUES (?,?,?,?,?)";
                        $insertar = $this->conexion->prepare($sql);
                        $arrData = array($id_usu, $this->nom_prd, $this->pre_prd, $this->can_prd, $this->iva_prd);
                        $resInsertar = $insertar->execute($arrData);
                        $idInsertar = $this->conexion->lastInsertId();
                        echo "<script>window.location='../admin/admin_productos.php';</script>";
                        return $idInsertar;
                    } else if ($this->can_prd == 0){
                        echo "<script>alert('La cantidad del producto debe ser mayor a cero (0)');window.location='../admin/admin_productos.php';</script>";
                    }

                } else if ($this->pre_prd == 0){
                    echo "<script>alert('El precio del producto debe ser mayor a cero (0)');window.location='../admin/admin_productos.php';</script>";
                }
                
            } else if (strlen($this->nom_prd) < 3){
                echo "<script>alert('El nombre del producto debe ser mayor a 3 carácteres');window.location='../admin/admin_productos.php';</script>";
            }
        }

        //ADMIN PARTE TIENDA
        public function BuscadorTienda($buscar){

            $this->buscador = $buscar;

            $this->where = "AND nom_prod LIKE '%$this->buscador%' OR id_prod LIKE '%$this->buscador%' AND cantidad_prod > 0 AND estado_prod = 1";
            return $this->where;
        }

        public function MostrarProductosTienda(){ // Muestra los productos que hay en el almacen *productos*
            
            $this->where;

            $sql = "SELECT Prd.id_prod, Prd.nom_prod, Prd.pre_prod, Prd.cantidad_prod, Prd.iva_prod, (Prd.pre_prod * Prd.iva_prod)/100+Prd.pre_prod FROM productos Prd WHERE estado_prod = 1 AND Prd.cantidad_prod > 0 $this->where ORDER BY Prd.id_prod DESC";
            $execute = $this->conexion->query($sql);
            $request = $execute->fetchall(PDO::FETCH_ASSOC);

            if ($this->where == true){
                if ($execute->rowCount() == 0){
                    echo "<script>alert('No se encontró ningún resultado');window.location='../admin/admin_almacen_tienda.php';</script>";
                }
            } 
            return $request;

        } 

        public function UltimoProducto(){ // Muestra los productos que hay en el almacen *productos*
                        
            $sql = "SELECT * FROM productos Prd WHERE estado_prod = 1 ORDER BY id_prod DESC LIMIT 1";
            $execute = $this->conexion->query($sql);
            $request = $execute->fetchall(PDO::FETCH_ASSOC);
            return $request;
        }

        public function BuscadorAdminSinStock($buscar){

            $this->buscador = $buscar;

            $this->where = "AND nom_prod LIKE '%$this->buscador%' OR id_prod LIKE '%$this->buscador%' AND cantidad_prod <= 0 AND estado_prod = 1";
            return $this->where;
        }

        public function MostrarProductosAdminSinStock(){ // Muestra los productos que hay en el almacen *productos*
                        
            $sql = "SELECT Prd.id_prod, Prd.nom_prod, Prd.iva_prod, Prd.pre_prod, (Prd.pre_prod * Prd.iva_prod)/100+Prd.pre_prod, Prd.cantidad_prod, Prd.iva_prod, Usu.nom_usu FROM productos Prd INNER JOIN usuarios Usu ON Usu.id_usu = Prd.id_usu WHERE cantidad_prod <= 0 $this->where";
            $execute = $this->conexion->query($sql);
            $request = $execute->fetchall(PDO::FETCH_ASSOC);

            if ($this->where == true){
                if ($execute->rowCount() == 0){
                    echo "<script>alert('No se encontró ningún resultado');window.location='../admin/admin_productos.php'</script>";
                }
            } 
            return $request;
        }

        public function ModificarProductosAdminSinStock(int $id_prod, string $nombre, $precio, int $cantidad, $iva){
            
            $this->id_prod = $id_prod;
            $this->nom_prd = $nombre;
            $this->pre_prd = $precio;
            $this->can_prd = $cantidad;
            $this->iva_prod = $iva;

            if (strlen($this->nom_prd) >= 3){
                if ($this->pre_prd > 0){

                    if($this->can_prd > 0){

                        $sql = "UPDATE productos SET nom_prod=?, pre_prod=?, cantidad_prod=?, iva_prod=? WHERE id_prod= $this->id_prod";
                        $insertar = $this->conexion->prepare($sql);
                        $arrData = array($this->nom_prd, $this->pre_prd, $this->can_prd, $this->iva_prod);
                        $resInsertar = $insertar->execute($arrData);
                        echo "<script>alert('Se ha modificado el producto con éxito');window.location='../admin/admin_productos.php'</script>";
                    } else if ($this->can_prd == 0){

                        echo "<script>alert('La cantidad del producto debe ser mayor a cero (0)');windows.history.go(-1);</script>";
                    }

                } else if ($this->pre_prd == 0){
                    echo "<script>alert('El precio del producto debe ser mayor a cero (0)');windows.history.go(-1);</script>";
                }
            } else if (strlen($this->nom_prd) < 3){
                echo "<script>alert('El nombre del producto debe ser mayor a 3 carácteres');windows.history.go(-1);</script>";
            }

                
            
        }


        public function BuscadorAdminEliminados($buscar1){

            $this->buscador1 = $buscar1;

            $this->where1 = "AND nom_prod LIKE '%$this->buscador1%' OR id_prod LIKE '%$this->buscador1%' AND estado_prod = 0 AND cantidad_prod > 0";
            return $this->where1;
        }

        public function MostrarProductosAdminEliminados(){ // Muestra los productos que hay en el almacen *productos*
                        
            $sql = "SELECT Prd.id_prod, Prd.nom_prod, Prd.iva_prod, Prd.pre_prod, (Prd.pre_prod * Prd.iva_prod)/100+Prd.pre_prod, Prd.cantidad_prod, Prd.iva_prod, Usu.nom_usu FROM productos Prd INNER JOIN usuarios Usu ON Usu.id_usu = Prd.id_usu WHERE estado_prod = 0 AND cantidad_prod > 0 $this->where1";
            $execute = $this->conexion->query($sql);
            $request = $execute->fetchall(PDO::FETCH_ASSOC);

            if ($this->where1 == true){
                if ($execute->rowCount() == 0){
                    echo "<script>alert('No se encontró ningún resultado');window.location='../admin/admin_productos.php'</script>";
                }
            } 
            return $request;
        }


        public function DeshacerProductoAdmin(int $id_prod){

            $this->id_prod = $id_prod;
    
            $sql = "UPDATE productos SET estado_prod = 1 WHERE id_prod = ?";
            $insertar = $this->conexion->prepare($sql);
            $arrData = array($this->id_prod);
            $resInsertar = $insertar->execute($arrData);
            
            echo "<script>alert('Se ha deshecho la eliminación con éxito');window.location='../admin/admin_productos.php'</script>"; 
        }

        public function EliminarProductoAdmin(int $id_prod){
            
            $this->id_prod = $id_prod;
    
            $sql = "DELETE FROM productos WHERE id_prod = ?";
            $insertar = $this->conexion->prepare($sql);
            $arrData = array($this->id_prod);
            $resInsertar = $insertar->execute($arrData);
            
            echo "<script>alert('Se ha eliminado con éxito');window.location='../admin/admin_productos.php'</script>"; 
        }
        
        public function EliminarProductosAdmin(int $id_prod){

            $this->id_prod = $id_prod;

            $sql = "UPDATE productos SET estado_prod = 0 WHERE id_prod = ? ";
            $insertar = $this->conexion->prepare($sql);
            $arrData = array($this->id_prod);
            $resInsertar = $insertar->execute($arrData);

            echo "<script>alert('Se ha eliminado el producto con éxito');window.location='../admin/admin_almacen_tienda.php'</script>"; 
        }


        //SUPER ADMIN

        public function BuscadorProductosSuperAdmin($buscar){

            $this->buscador = $buscar;

            $this->where = "AND Prd.nom_prod LIKE '%$this->buscador%' OR Prd.estado_prod LIKE '%$this->buscador%' OR Usu.nom_usu LIKE '%$this->buscador%'";
            return $this->where;
        }

        public function MostrarProductosSuperAdmin(){ // Muestra los productos que hay en el almacen *productos*
                        
            $sql = "SELECT * FROM productos Prd INNER JOIN usuarios Usu ON Usu.id_usu = Prd.id_usu WHERE cantidad_prod > 0 $this->where";
            $execute = $this->conexion->query($sql);
            $request = $execute->fetchall(PDO::FETCH_ASSOC);

            if ($this->where == true){
                if ($execute->rowCount() == 0){
                    echo "<script>alert('No se encontró ningún resultado');;windows.history.go(-1);</script>";
                }
            } 
            return $request;
        }

        public function EliminarProductoSuperAdmin(int $id_prod){
            
            $this->id_prod = $id_prod;
    
            $sql = "DELETE FROM productos WHERE id_prod = ?";
            $insertar = $this->conexion->prepare($sql);
            $arrData = array($this->id_prod);
            $resInsertar = $insertar->execute($arrData);
            
            echo "<script>alert('Se ha eliminado con éxito');;windows.history.go(-1);</script>"; 
        }

        public function ModificarProductosSuperAdmin(int $id_prod, string $nombre, $precio, int $cantidad, $iva){
            
            $this->id_prod = $id_prod;
            $this->nom_prd = $nombre;
            $this->pre_prd = $precio;
            $this->can_prd = $cantidad;
            $this->iva_prd = $iva;

            if (strlen($this->nom_prd) >= 3){

                if ($this->pre_prd > 0){
                    if ($this->can_prd > 0){
                        $sql = "UPDATE productos SET nom_prod=?, pre_prod=?, cantidad_prod=?, iva_prod=? WHERE id_prod= $this->id_prod";
                        $insertar = $this->conexion->prepare($sql);
                        $arrData = array($this->nom_prd, $this->pre_prd, $this->can_prd, $this->iva_prd);
                        $resInsertar = $insertar->execute($arrData);
                        echo "<script>alert('Se ha modificado el producto con éxito');window.location='../superadmin/superAdmin_productos.php'</script>"; 
                    } else if ($this->can_prd == 0){
                        echo "<script>alert('La cantidad del producto debe ser mayor a cero (0)');windows.history.go(-1);</script>";
                    }
                
                } else if ($this->pre_prd == 0){
                    echo "<script>alert('El precio del producto debe ser mayor a cero (0)');windows.history.go(-1);</script>";
                }
            } else if (strlen($this->nom_prd) < 3) {
                echo "<script>alert('El nombre del producto debe ser a 3 carácteres');windows.history.go(-1);</script>";
            }
                
            
        }
    }


?>