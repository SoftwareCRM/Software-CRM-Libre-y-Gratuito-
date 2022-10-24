<?php  
    require_once("/xampp/htdocs/final_poo/plantillas/bd.php");

    class Usuarios extends Conexion{
        private $nom_usu; 
        private $usu_usu; 
        private $email_usu; 
        private $contrasenna_usu; 
        private $rp_contrasenna; 
        private $conexion;
        private $tit_pdf;
        private $ide_pdf;
        private $dir_pdf;
        private $num_pdf;
        private $pie_pdf;

        public function __construct(){
            $this->conexion = new Conexion();
            $this->conexion = $this->conexion->conexion();
        }

        public function insertarUsuario(string $nom_usu, string $usu_usu, string $email_usu, string $contrasenna_usu, string $rp_contrasenna_usu)
        {
            require_once("/xampp/htdocs/final_poo/insertar/insertar_producto.php");
            $objProducto = new Productos();
            $iva_ = $objProducto->IVAProductos(); 

            $this->nom_usu = $nom_usu;
            $this->usu_usu = $usu_usu;
            $this->email_usu = $email_usu;
            $this->contrasenna_usu = $contrasenna_usu;
            $this->rp_contrasenna = $rp_contrasenna_usu;
            
            
            $this->tit_pdf = "Empresa Josue S.A";
            $this->ide_pdf = "00000000-0";
            $this->dir_pdf = "San Manuel de Jasis";
            $this->num_pdf = "0276-0000000";
            $this->pie_pdf = "Gracias por la compra, ¡Feliz día!";
            $this->iva = $iva_; 

            $validar = "SELECT * FROM usuarios WHERE usu_usu = BINARY '$this->usu_usu' || email_usu = BINARY '$this->email_usu'"; //Variable necesaria para el query
            $validando = $this->conexion->query($validar); // Guarda el id 

            if (strlen($this->nom_usu) >= 3){
                if (strlen($this->usu_usu) >= 3){

                    if ($validando->rowCount() > 0) { // En caso de que el id se repita saltara la alerta
                        echo "<script>alert('El usuario o el correo electrónico ya se encuentran registrados');window.location='../paginas/registrar_usuarios.php';</script>"; 
                    } else { 
    
                        if (strlen($this->contrasenna_usu) >= 3 || strlen($this->rp_contrasenna) >= 3){
                            if($this->contrasenna_usu == $this->rp_contrasenna){
        
                                $sql = "INSERT INTO usuarios(nom_usu,usu_usu,email_usu,contrasenna_usu) VALUES (?,?,?,?)";
                                $insertar = $this->conexion->prepare($sql);
                                $arrData = array($this->nom_usu, $this->usu_usu, $this->email_usu, $this->contrasenna_usu);
                                $resInsertar = $insertar->execute($arrData);
                                $idInsertar = $this->conexion->lastInsertId();
            
                                if($insertar){
            
                                    $pdf = "INSERT INTO configuracion_pdf(tit_pdf, ide_pdf, dir_pdf, num_pdf, pie_pdf,id_usu, iva)VALUES (?,?,?,?,?,?,?) ";
                                    $insertarPDF = $this->conexion->prepare($pdf);
                                    $arrDataPDF = array ($this->tit_pdf, $this->ide_pdf, $this->dir_pdf, $this->num_pdf, $this->pie_pdf,$idInsertar,$this->iva);
                                    $resInsertarPDF = $insertarPDF->execute($arrDataPDF);
                                    echo "<script>alert('Se ha registrado la cuenta con éxito');window.location='../index.php';</script>";
                                }
            
                            } else {
                                echo "<script>alert('Las contraseñas no coinciden');window.location='../paginas/registrar_usuarios.php';</script>";
                            }
                        } else {
                            echo "<script>alert('La contraseña es muy corta');window.location='../paginas/registrar_usuarios.php';</script>";
                        }
    
                        
                    }
                    return $idInsertar;
                } else {
                    echo "<script>alert('El nombre de usuario es muy corto');window.location='../paginas/registrar_usuarios.php';</script>";
    
                }
            } else {
                echo "<script>alert('El nombre del usuario es muy corto');window.location='../paginas/registrar_usuarios.php';</script>"; 
            }

        }

        public function IDCliente(){


            $sql = "SELECT id_usu FROM usuarios ORDER BY id_usu DESC LIMIT 1";
            $execute = $this->conexion->query($sql);
    
            foreach ($this->conexion->query($sql) as $i){
                $id = $i['id_usu'];
                return $id;
            }

        }

    }
?>