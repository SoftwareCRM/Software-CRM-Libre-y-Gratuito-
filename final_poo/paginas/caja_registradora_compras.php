<?php session_start(); 
if (empty($_SESSION['id_usu'])){
  echo "<script>alert('¡Necesita ingresar sesión primero!');window.location='../index.php';</script>";
} else if ($_SESSION['acceso_usu'] == 0){

require_once("/xampp/htdocs/final_poo/plantillas/cabecera.php");
require_once("/xampp/htdocs/final_poo/insertar/insertar_a_caja_registradora_compras.php");
require_once("/xampp/htdocs/final_poo/insertar/insertar_pdf.php");


$objCompras = new Compras(); 
$objPDF = new PDF_insertar();

// DATOS DE LA COMPRA
if(isset($_GET['fecha'])){
  $insertar = $objPDF->insertarPDF($_GET['fecha'], $_GET['id_com']);    
}

//BUSCADOR DE LAS COMPRAS HECHAS
if (isset($_POST['buscar'])){
  if($_POST['busqueda']){
    $insertar = $objCompras->Buscador($_POST['busqueda']);
  }
}

?>


<div class="border"> 
        <div class="py-3">
          <h3 class="text-center py-1 pb-2 border border-dark">Caja Registradora</h3>
        </div>
        <div class="pb-3">
          <form class="d-flex pe-1 " method="post"> <!-- BUSCADOR -->
            <div class="input-group mb-3">

                <input type="text" class="form-control" placeholder="Buscar por código o nombre del cliente" name="busqueda" aria-describedby="button-addon2" onkeypress="return Direccion(event);" onpaste="return false">
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
                <th scope="col">Nombre del cliente</th>
                <th scope="col">Cédula del cliente</th>
                <th scope="col">Fecha de la compra</th>
                <th scope="col">Monto total</th>
                <th scope="col">Factura</th>
            </tr>
          </thead>
          <tbody> 
          
            <?php $compras = $objCompras->MostrarCaja(); 
                foreach ($compras as $e){ 
                    $fecha = $e['fecha'];
            ?>

            <form action="" method="get"> <!-- FORMULARIO PDF -->

              <tr>
                <!--<th></th> Nombre-->
                <th class="col-2">
                    <input type="hidden" name="id_com" value="<?php echo $e["id_com"];?>">
                    <?php echo $e["id_com"];?>
                </th>

                <td class="col-3">
                    <input type="hidden" name="nom_cliente" value="<?php echo $e['nom_cliente']?>">
                    <?php echo $e['nom_cliente']?>
                </td> <!--Cantidad a Vender-->

                <td class="col-2">
                    <input type="hidden" name="ced_cliente" value="<?php echo $e['ced_cliente']?>">
                    <?php echo $e['ced_cliente']?>
                </td> <!--Cantidad a Vender-->

                <td class="col-3">
                    <input type="hidden" name="fecha" value="<?php echo $fecha?>">
                    <?php echo $fecha?>
                </td><!--Precio-->

                <td class="col-2">
                    <?php echo number_format($e['monto_total'], 2,'.','') ?>
                </td>

                <td class="col-1 px-3">
                    <div>
                        <button type="submit" class="btn btn-sm"><i class="fa-solid fa-eye fa-lg" style="color:black;"></i></button>
                    </div>
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


