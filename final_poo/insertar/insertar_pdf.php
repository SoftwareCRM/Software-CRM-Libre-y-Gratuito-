<?php 
    require_once("/xampp/htdocs/final_poo/plantillas/bd.php");
    require_once("/xampp/htdocs/final_poo/insertar/insertar_inicio_sesion_usuario.php");
    require_once("/xampp/htdocs/final_poo/insertar/insertar_inicio_sesion_usuario.php");

    class PDF_insertar extends Conexion{
        
        private $conexion;

        public function __construct(){
            $this->conexion = new Conexion();
            $this->conexion = $this->conexion->conexion();
        }

        public function insertarPDF(string $fecha, $id_compra)
        {

            $this->fecha = $fecha;
            $this->id_com = $id_compra;
            $id_usu = $_SESSION['id_usu'];            
       
            $sql_pdf = "SELECT * FROM configuracion_pdf WHERE id_usu = '$id_usu'";

            foreach ($this->conexion->query($sql_pdf) as $row){
                $id_pdf = $row['id_conf_pdf'];     
                 
            }

            $validar = "SELECT Com.fecha FROM compras Com INNER JOIN facturacion Fac ON Com.id_com = Fac.id_com WHERE fecha = '$this->fecha'";
            $validando = $this->conexion->query($validar);

            if ($validando->rowCount() > 0){
                // echo "<script>alert('NO SE REPITE EL DATO')</script>"; //
            } else {
                $sql = "INSERT INTO facturacion (id_com, id_conf_pdf) VALUES (?,?)";
                $insertar = $this->conexion->prepare($sql);
                $arrData = array($this->id_com, $id_pdf);
                $resInsertar = $insertar->execute($arrData);
                $idInsertar = $this->conexion->lastInsertId();
            }

            $datos_empresa = "SELECT Com.fecha, Usu.nom_usu, Usu.id_usu, Fac.id_com, Fac.id_fac, Cfg.tit_pdf, Cfg.ide_pdf, Cfg.dir_pdf, Cfg.num_pdf, Cfg.pie_pdf, Cfg.iva, Cli.nom_cliente, Com.id_com, Com.monto_total, Com.id_prod, Prd.id_prod, Prd.nom_prod, Prd.pre_prod, Prd.iva_prod, Cfg.id_usu FROM facturacion Fac INNER JOIN configuracion_pdf Cfg INNER JOIN compras Com INNER JOIN productos Prd ON Com.id_prod = Prd.id_prod INNER JOIN usuarios Usu ON Com.id_usu = Usu.id_usu INNER JOIN clientes Cli ON Cli.id_cliente = Com.id_cliente WHERE Cfg.id_usu = '$id_usu' AND Com.fecha = '$this->fecha' GROUP BY fecha";
            
            $execute = $this->conexion->query($datos_empresa);
            $request = $execute->fetchall(PDO::FETCH_ASSOC);

            foreach ($this->conexion->query($datos_empresa) as $emp){ //DATOS EMPRESA
                $id_compra = $emp['id_com'];    
                $id_fac = $emp['id_fac'];    
                $tit_pdf = $emp['tit_pdf'];    
                $ide_pdf = $emp['ide_pdf'];    
                $dir_pdf = $emp['dir_pdf'];    
                $num_pdf = $emp['num_pdf'];    
                $pie_pdf = $emp['pie_pdf'];    
                $nom_cliente = $emp['nom_cliente'];    
                $id_com = $emp['id_com'];    
                $fecha = $emp['fecha'];    
                $monto_total = $emp['monto_total'];    
                $id_prod = $emp['id_prod'];  
                $id_usu = $emp['id_usu'];  
                $nom_usu = $emp['nom_usu'];  
                $iva = $emp['iva'];

            }

            
            echo "<script>window.location='../paginas/pdf_pdf.php?nom_usu=$nom_usu&id_compra=$id_compra&id_fac=$id_fac&tit=$tit_pdf&ide_pdf=$ide_pdf&dir_pdf=$dir_pdf&num_pdf=$num_pdf&pie_pdf=$pie_pdf&nom_cliente=$nom_cliente&id_com=$id_com&fecha=$fecha&monto=$monto_total&id_prod=$id_prod&id_usu=$id_usu&iva=$iva'</script>";   

            return $request;
        }

        public function ProductosLista(){

            $this->fecha = $_GET['fecha'];

            $listas = "SELECT Com.fecha, Com.id_com, Com.id_prod, Prd.nom_prod, Prd.id_prod, Prd.pre_prod, Prd.iva_prod, (Prd.pre_prod * Prd.iva_prod)/100+Prd.pre_prod, Car.cantidad_vender_carr, Car.id_prod FROM compras Com INNER JOIN productos Prd ON Com.id_prod = Prd.id_prod INNER JOIN carrito Car ON Car.id_carr = Com.id_carr WHERE Com.fecha = '$this->fecha' ";


            $execute = $this->conexion->query($listas);
            $request = $execute->fetchall(PDO::FETCH_ASSOC);
            return $request;
        }

        // ADMIN //
        public function insertarPDFAdmin(string $fecha, $id_compra, $id_usu)
        {

            $this->fecha = $fecha;
            $this->id_com = $id_compra;
            $id_usu_ = $id_usu;            
       
            $sql_pdf = "SELECT * FROM configuracion_pdf WHERE id_usu = '$id_usu_'";

            foreach ($this->conexion->query($sql_pdf) as $row){
                $id_pdf = $row['id_conf_pdf'];     
            }

            $validar = "SELECT Com.fecha FROM compras Com INNER JOIN facturacion Fac ON Com.id_com = Fac.id_com WHERE fecha = '$this->fecha'";
            $validando = $this->conexion->query($validar);

            if ($validando->rowCount() > 0){
               // echo "<script>alert('NO SE REPITE EL DATO')</script>"; //
            } else {
                $sql = "INSERT INTO facturacion (id_com, id_conf_pdf) VALUES (?,?)";
                $insertar = $this->conexion->prepare($sql);
                $arrData = array($this->id_com, $id_pdf);
                $resInsertar = $insertar->execute($arrData);
                $idInsertar = $this->conexion->lastInsertId();
            }

            $datos_empresa = "SELECT Com.fecha, Usu.nom_usu, Usu.id_usu, Fac.id_com, Fac.id_fac, Cfg.tit_pdf, Cfg.ide_pdf, Cfg.dir_pdf, Cfg.num_pdf, Cfg.pie_pdf, Cfg.iva, Cli.nom_cliente, Com.id_com, Com.monto_total, Com.id_prod, Prd.id_prod, Prd.nom_prod, Prd.pre_prod, Prd.iva_prod, Cfg.id_usu FROM facturacion Fac INNER JOIN configuracion_pdf Cfg INNER JOIN compras Com INNER JOIN productos Prd ON Com.id_prod = Prd.id_prod INNER JOIN usuarios Usu ON Com.id_usu = Usu.id_usu INNER JOIN clientes Cli ON Cli.id_cliente = Com.id_cliente WHERE Cfg.id_usu = '$id_usu' AND Com.fecha = '$this->fecha' GROUP BY fecha";
            
            $execute = $this->conexion->query($datos_empresa);
            $request = $execute->fetchall(PDO::FETCH_ASSOC);

            foreach ($this->conexion->query($datos_empresa) as $emp){ //DATOS EMPRESA
                $id_compra = $emp['id_com'];    
                $id_fac = $emp['id_fac'];    
                $tit_pdf = $emp['tit_pdf'];    
                $ide_pdf = $emp['ide_pdf'];    
                $dir_pdf = $emp['dir_pdf'];    
                $num_pdf = $emp['num_pdf'];    
                $pie_pdf = $emp['pie_pdf'];    
                $nom_cliente = $emp['nom_cliente'];    
                $id_com = $emp['id_com'];    
                $fecha = $emp['fecha'];    
                $monto_total = $emp['monto_total'];    
                $id_prod = $emp['id_prod'];  
                $id_usu = $emp['id_usu'];  
                $nom_usu = $emp['nom_usu']; 
                $iva = $emp['iva'];


            }
            echo "<script>window.location='../paginas/pdf_pdf.php?nom_usu=$nom_usu&id_compra=$id_compra&id_fac=$id_fac&tit=$tit_pdf&ide_pdf=$ide_pdf&dir_pdf=$dir_pdf&num_pdf=$num_pdf&pie_pdf=$pie_pdf&nom_cliente=$nom_cliente&id_com=$id_com&fecha=$fecha&monto=$monto_total&id_prod=$id_prod&id_usu=$id_usu&iva=$iva'</script>";   
        }

        
    }
    
?>