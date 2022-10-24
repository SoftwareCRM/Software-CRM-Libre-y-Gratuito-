<?php 
    require_once("/xampp/htdocs/final_poo/plantillas/bd.php");
    require_once("/xampp/htdocs/final_poo/insertar/insertar_inicio_sesion_usuario.php");

    date_default_timezone_set('America/Caracas');

   
    class Operadores extends Conexion{
        private $conexion;
        private $where;

        public function __construct(){
            $this->conexion = new Conexion();
            $this->conexion = $this->conexion->conexion();
        }

        // ADMIN //

        public function Buscador($buscar){

            $this->buscador = $buscar;

            $this->where = "AND Usu.nom_usu LIKE '%$this->buscador%' OR Usu.usu_usu LIKE '%$this->buscador%' AND acceso_usu = 0";
        }

        public function MostrarOperadores(){ 
                        
            $sql = "SELECT Usu.id_usu, Usu.nom_usu, Usu.usu_usu, Usu.email_usu, Usu.contrasenna_usu, Per.nv_acceso_perm FROM usuarios Usu INNER JOIN permisos_acceso Per ON Per.id_perm = Usu.acceso_usu WHERE acceso_usu = 0 $this->where";
            $execute = $this->conexion->query($sql);
            $request = $execute->fetchall(PDO::FETCH_ASSOC);

            if ($this->where == true){
                if ($execute->rowCount() == 0){
                    echo "<script>alert('No se encontró ningún resultado');window.location='../admin/admin_operadores.php';</script>";
                }
            } 
            return $request;
        }

        // SUPER ADMIN //

        public function BuscadorSuperAdmin($buscar){

            $this->buscador = $buscar;

            $this->where = "AND Usu.nom_usu LIKE '%$this->buscador%' OR Usu.usu_usu LIKE '%$this->buscador%'";
        }

        public function MostrarOperadoresSuperAdmin(){ 
                        
            $sql = "SELECT Usu.id_usu, Usu.nom_usu, Usu.usu_usu, Usu.email_usu, Usu.contrasenna_usu, Per.id_perm, Per.nv_acceso_perm FROM usuarios Usu INNER JOIN permisos_acceso Per ON Per.id_perm = Usu.acceso_usu WHERE acceso_usu < 2 $this->where ORDER BY Usu.acceso_usu ASC";
            $execute = $this->conexion->query($sql);
            $request = $execute->fetchall(PDO::FETCH_ASSOC);

            if ($this->where == true){
                if ($execute->rowCount() == 0){
                    echo "<script>alert('No se encontró ningún resultado');window.location='../superadmin/superAdmin_operadores.php';</script>";
                }
            } 
            return $request;
        }

        public function EliminarUsuarioSuperAdmin($id_usu){
            
            $this->id_usu = $id_usu;
    
            $sql = "DELETE FROM usuarios WHERE id_usu = ?";
            $insertar = $this->conexion->prepare($sql);
            $arrData = array($this->id_usu);
            $resInsertar = $insertar->execute($arrData);
            
            echo "<script>alert('Se ha eliminado con éxito');window.location='../superadmin/superAdmin_operadores.php'</script>"; 
        }

        public function AscensoUsuarioSuperAdmin($id_usu_){
            $this->id_usu = $id_usu_;

            $sql = "UPDATE usuarios SET acceso_usu = 1 WHERE id_usu = ? ";
            $insertar = $this->conexion->prepare($sql);
            $arrData = array($this->id_usu);
            $resInsertar = $insertar->execute($arrData); 

            echo "<script>window.location='../superadmin/superAdmin_operadores.php'</script>"; 

        }

        public function DescensoUsuarioSuperAdmin($id_usu){
            $this->id_usu = $id_usu;

            $sql = "UPDATE usuarios SET acceso_usu = 0 WHERE id_usu = ? ";
            $insertar = $this->conexion->prepare($sql);
            $arrData = array($this->id_usu);
            $resInsertar = $insertar->execute($arrData); 

            echo "<script>window.location='../superadmin/superAdmin_operadores.php'</script>"; 

        }


    }
?>