<?php session_start();  
if (empty($_SESSION['id_usu'])){
  echo "<script>alert('¡Necesita ingresar sesión primero!');window.location='../index.php';</script>";
} else if ($_SESSION['acceso_usu'] == 1){
  
require_once("/xampp/htdocs/final_poo/plantillas/cabecera.php");
require_once("/xampp/htdocs/final_poo/insertar/insertar_operadores.php");
require_once("/xampp/htdocs/final_poo/insertar/insertar_pdf.php");

$objCompras = new Operadores(); 
$objPDF = new PDF_insertar();

if (isset($_POST['buscar'])){
  if($_POST['busqueda']){
    $insertar = $objCompras->Buscador($_POST['busqueda']);
  }
}
?>


<div class="border"> 
        <div class="py-3">
          <h3 class="text-center py-1 pb-2 border border-dark">Operadores/Usuarios</h3>
        </div>
        <div class="pb-3">
          <form class="d-flex pe-1 " method="post"> <!-- BUSCADOR -->
            <div class="input-group mb-3">

                <input type="text" class="form-control" placeholder="Buscar por correo o nombre del operador/usuario" name="busqueda" aria-describedby="button-addon2" onkeypress="return Direccion(event);" onpaste="return false">
                <button class="btn btn-primary" type="submit" id="button-addon2" name="buscar">
                    <i class="fa-solid fa-magnifying-glass fa-lg"></i>
                </button>
            </div>
          </form>
        </div>
        <table class="table table-hover">
          <thead>
            <tr>
                <th scope="col">Código</th>
                <th scope="col">Nombre</th>
                <th scope="col">Usuario</th>
                <th scope="col">Correo Eléctronico</th>
                <th scope="col">Nivel de Acceso</th>
            </tr>
          </thead>
          <tbody> 
          
            <?php $compras = $objCompras->MostrarOperadores(); 
                foreach ($compras as $e){ 
            ?>

            <form action="" method="get"> <!-- FORMULARIO PDF -->

              <tr>
                <td class="col-2">
                    <?php echo $e['id_usu'] ?>
                </td>
                <!--<th></th> Nombre-->
                <td class="col-3">
                    <?php echo $e["nom_usu"];?>
                </td>

                <td class="col-2">
                    <?php echo $e['usu_usu']?>
                </td> <!--Cantidad a Vender-->

                <td class="col-2">
                    <?php echo $e['email_usu']?>
                </td><!--Precio-->

                <td class="col-2">
                    <?php echo $e['nv_acceso_perm'] ?>
                </td>

                
              </tr> 

            </form> <!-- FORMULARIO PDF -->

            <?php } ?>
          </tbody>
        </table>
      </div>


<?php require_once("/xampp/htdocs/final_poo/plantillas/pie.php"); }

  else{
    echo "<script>alert('¡No tiene los permisos necesarios para ingresar a esta sección!');window.history.back(-1);</script>";
  }


?>

