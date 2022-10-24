<?php  
    require_once("/xampp/htdocs/final_poo/plantillas/bd.php");

    class Sesion extends Conexion{
        private $usu_usu; // Usuario del usuario
        private $contrasenna_usu; // Contraseña que ingresa el usuario

        public function __construct(){
            $this->conexion = new Conexion();
            $this->conexion = $this->conexion->conexion();
        }

        public function validarSesionUsuario(string $usu_usu,string $contrasenna_usu){
            session_start();
            $this->usu_usu = $usu_usu;
            $this->contrasenna_usu = $contrasenna_usu;

            $consulta = "SELECT * FROM usuarios WHERE usu_usu = BINARY '$this->usu_usu' AND contrasenna_usu = '$this->contrasenna_usu'";
            $resultado = $this->conexion->query($consulta);
            $row = $resultado->rowCount();
            
            if($row > 0){             
                $sql = "SELECT * FROM usuarios WHERE usu_usu = '$this->usu_usu'";
                foreach ($this->conexion->query($sql) as $row){
                    $_SESSION['id_usu'] = $row['id_usu'];
                    $_SESSION['nom_usu'] = $row['nom_usu'];
                    $_SESSION['usu_usu'] = $row['usu_usu'];      
                    $_SESSION['acceso_usu'] = $row['acceso_usu'];     
                    $_SESSION['foto_perfil'] = $row['foto_perfil'];               
                                    }

                header("Location: ./paginas/portada_manual.php");
                
            }else{
                echo "<script>alert('Usuario o Contraseña no coinciden');window.location='index.php';</script>";
            }
        }

    }
    
    
?>