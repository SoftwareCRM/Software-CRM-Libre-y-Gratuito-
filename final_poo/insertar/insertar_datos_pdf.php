<?php 
    require_once("/xampp/htdocs/final_poo/plantillas/bd.php");
    require_once("/xampp/htdocs/final_poo/insertar/insertar_inicio_sesion_usuario.php");
   
    class Configuracion extends Conexion{
        private $conexion;

        public function __construct(){
            $this->conexion = new Conexion();
            $this->conexion = $this->conexion->conexion();
        }

        public function modificarPDFDatos(string $tit_pdf, $ide_pdf, $dir_pdf, $num_pdf, $pie_pdf){ //Datos de la factura PDF

            $this->tit_pdf = $tit_pdf;
            $this->ide_pdf = $ide_pdf;
            $this->dir_pdf = $dir_pdf;
            $this->num_pdf = $num_pdf;
            $this->pie_pdf = $pie_pdf;

            if (strlen($this->tit_pdf) >= 3){
                if (strlen($this->dir_pdf) >= 3){
                    if (strlen($this->pie_pdf) >= 3){
                        $sql = "UPDATE configuracion_pdf SET tit_pdf=?, ide_pdf=?, dir_pdf=?, num_pdf=?, pie_pdf=?";
                        $insertar = $this->conexion->prepare($sql);
                        $arrData = array($this->tit_pdf, $this->ide_pdf, $this->dir_pdf, $this->num_pdf, $this->pie_pdf );
                        $resInsertar = $insertar->execute($arrData);
                        echo "<script>alert('¡Se ha modificado los datos con éxito!');window.location='../paginas/configuracion_pagina.php'</script>"; 
                    } else {
                        echo "<script>alert('El pie de página debe tener más de 3 carácteres');window.location='../paginas/configuracion_pagina.php';</script>";
                    }
                } else {
                    echo "<script>alert('La dirección debe tener más de 3 carácteres');window.location='../paginas/configuracion_pagina.php';</script>";
                }
            } else {
                echo "<script>alert('El título debe tener más de 3 carácteres');window.location='../paginas/configuracion_pagina.php';</script>";
            }

            
        }

        public function modificarIVADatos($iva){ //Datos de todos los productos como tal

            $this->iva = $iva;

            if ($this->iva > 0){
                
                $sql = "UPDATE configuracion_pdf SET iva=?";
                $insertar = $this->conexion->prepare($sql);
                $arrData = array($this->iva);
                $resInsertar = $insertar->execute($arrData);
    
                $sqlIVA = "UPDATE productos SET iva_prod=? WHERE iva_prod > 0";
                $insertarIVA = $this->conexion->prepare($sqlIVA);
                $arrDataIVA = array($this->iva);
                $resInsertarIVA = $insertarIVA->execute($arrDataIVA);
    
                echo "<script>alert('¡Se ha modificado el IVA con éxito!');window.location='../paginas/configuracion_pagina.php'</script>"; 
            } else {
                echo "<script>alert('El nuevo IVA debe ser mayor a cero (0)');window.location='../paginas/configuracion_pagina.php'</script>"; 
            }

            

        }

        public function cambiarDatos($usu_usu, $contrasenna,$rp_contrasenna){ //Nombre del usuario y contrasenna

            $id_usu = $_SESSION['id_usu'];
            $this->usu_usu = $usu_usu;
            $this->contrasenna = $contrasenna;
            $this->rp_contrasenna = $rp_contrasenna;

            $validar = "SELECT * FROM usuarios WHERE usu_usu = '$this->usu_usu'"; //Variable necesaria para el query
            $validando = $this->conexion->query($validar); // Guarda el id 

            $validar_nombre = "SELECT * FROM usuarios WHERE id_usu = '$id_usu'";
            $execute = $this->conexion->query($validar_nombre);

            if (strlen($this->usu_usu) >= 3){
                if (strlen($this->contrasenna) >= 3 || strlen($this->rp_contrasenna) >= 3){
                    foreach ($this->conexion->query($validar_nombre) as $i){ //DATOS EMPRESA
                        $usu_viejo = $i['usu_usu'];
        
                        if ($usu_viejo == $this->usu_usu){
                            if($this->contrasenna == $this->rp_contrasenna){
        
                                $sql = "UPDATE usuarios SET usu_usu=?, contrasenna_usu=? WHERE id_usu=?";
                                $insertar = $this->conexion->prepare($sql);
                                $arrData = array($this->usu_usu, $this->contrasenna, $id_usu);
                                $resInsertar = $insertar->execute($arrData);
                                echo "<script>alert('Se ha modificado los datos del usuario con éxito');window.location='../paginas/configuracion_pagina.php';</script>"; 
                            }else{
                                echo "<script>alert('Las contraseñas no coinciden');window.location='../paginas/configuracion_pagina.php';</script>";
                            }
                        } else {
                            if ($validando->rowCount() > 0) { // En caso de que el id se repita saltara la alerta
                                echo "<script>alert('Este nombre de usuario no esta disponible');window.location='../paginas/configuracion_pagina.php';</script>"; 
                            } else { 
                                if($this->contrasenna == $this->rp_contrasenna){
                
                                    $sql = "UPDATE usuarios SET usu_usu=?, contrasenna_usu=? WHERE id_usu=?";
                                    $insertar = $this->conexion->prepare($sql);
                                    $arrData = array($this->usu_usu, $this->contrasenna, $id_usu);
                                    $resInsertar = $insertar->execute($arrData);
                                    echo "<script>alert('Se ha modificado los datos del usuario con éxito');window.location='../paginas/configuracion_pagina.php';</script>"; 
        
                                }else{
                                    echo "<script>alert('Las contraseñas no coinciden')</script>";
                                }
                            }  
                        }
                    }
                } else {
                    echo "<script>alert('La contraseña debe ser mayor a 3 carácteres');window.location='../paginas/configuracion_pagina.php';</script>"; 
                    
                }
                
            } else {
                echo "<script>alert('El nombre de usuario tiene que ser mayor a 3 carácteres');window.location='../paginas/configuracion_pagina.php';</script>"; 
            }
            
        }

        public function cambiarDatosAdmin($contrasenna,$rp_contrasenna){

            $id_usu = $_SESSION['id_usu'];
            $this->contrasenna = $contrasenna;
            $this->rp_contrasenna = $rp_contrasenna;

            if (strlen($this->contrasenna) >= 3 || strlen($this->rp_contrasenna) >= 3){
                if($this->contrasenna == $this->rp_contrasenna){

                    $sql = "UPDATE usuarios SET contrasenna_usu=? WHERE id_usu=?";
                    $insertar = $this->conexion->prepare($sql);
                    $arrData = array($this->contrasenna, $id_usu);
                    $resInsertar = $insertar->execute($arrData);
                    echo "<script>alert('Se ha modificado los datos del usuario con éxito');window.location='../paginas/configuracion_pagina.php';</script>"; 
                }else{
                    echo "<script>alert('Las contraseñas no coinciden')</script>";
                }
            } else {
                echo "<script>alert('La contraseña debe contener más de 3 carácteres');window.location='../paginas/configuracion_pagina.php';</script>"; 

            }
        }

    }
?>