<?php session_start(); 
if (empty($_SESSION['id_usu'])){
  echo "<script>alert('¡Necesita ingresar sesión primero!');window.location='../index.php';</script>";
} else if ($_SESSION['acceso_usu'] == 2) {

require_once("/xampp/htdocs/final_poo/plantillas/cabecera.php");
require_once("/xampp/htdocs/final_poo/plantillas/bd.php");
require_once("/xampp/htdocs/final_poo/insertar/insertar_producto.php");

$objProducto = new Productos();
$iva = $objProducto->IVAProductos(); 

if (isset($_POST['nom_prd'])){ // MODIFICACION DE LOS DATOS -- SI HAY IVA ENTONCES -- SINO ENTONCES 0
  if ($_POST["iva_prd"] == 1) {
    $insertar = $objProducto->ModificarProductosSuperAdmin($_POST['id_prod'], $_POST['nom_prd'],$_POST['pre_prd'],$_POST['can_prd'], $iva);  
  } else {
    $insertar = $objProducto->ModificarProductosSuperAdmin($_POST['id_prod'], $_POST['nom_prd'],$_POST['pre_prd'],$_POST['can_prd'], 0);    
  }
}

?>
      <form action="" method="post" class="border needs-validation" enctype="multipart/form-data" novalidate> 
        <div class="py-3">
          <h3 class="text-center py-1 pb-2 border border-dark">Modificar Producto</h3>
        </div>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">Nombre del producto</th>
              <th scope="col">Cantidad</th>
              <th scope="col">Precio</th>
              <th scope="col">IVA</th>
            </tr>
          </thead>
          <tbody>
          <?php $productos = $objProducto->SeleccionarProductos(); //Modificar
            foreach ($productos as $e){ 
          ?>
            <tr>
              <input type="hidden" name="id_prod" value="<?php echo $e["id_prod"]?>">

              <td scope="row">
                <div class="position-relative">
                  <input class="form-control" type="text" name="nom_prd" value="<?php echo $e["nom_prod"]?>" onpaste="return false" onkeypress="return SoloLetras(event);" minlength="3" maxlength="40" required>
                  <div class="invalid-tooltip">
                    Es necesario poner el nombre del producto
                  </div>
                </div>
              </td>
              
              <td scope="row">
                <div class="position-relative">
                  <input class="form-control" type="text" name="can_prd" value="<?php echo $e["cantidad_prod"]?>" onkeypress="return SoloNumeros(event);" onpaste="return false" minlength="1" maxlength="40" required>
                  <div class="invalid-tooltip">
                    Es necesario poner la cantidad del producto
                  </div>
                </div>
              </td>
              

              <td scope="row">
                <div class="position-relative">
                  <input class="form-control" type="text" name="pre_prd" value="<?php echo number_format($e['pre_prod'],2, ".", "")?>" onpaste="return false" onkeypress="return SoloNumeros(event);" minlength="1" maxlength="40" required>
                  <div class="invalid-tooltip">
                    Es necesario poner el precio del producto
                  </div>
                </div>
              </td>

              <td scope="row">
                  <div class="btn-group col-12" role="group" aria-label="Basic mixed styles example">
                      <input class="form-control" placeholder="<?php echo $iva."%";?>" onkeypress="return SoloNumeros(event);" onpaste="return false" disabled>

                      <input type="hidden" name="iva_prd" value="0"/>
                      <input type="checkbox" class="btn-check" id="btn-check-outlined" name="iva_prd" autocomplete="off" value="1">

                      <label class="btn btn-outline-danger" for="btn-check-outlined">IVA</label>
                  </div>
              </td>

          <?php } ?> 

              <td><input type="submit" class="w-100 btn btn-info btn-lg" value="Modificar"></td>
            </tr>
          </tbody>
        </table>
      </form>

<?php require_once("/xampp/htdocs/final_poo/plantillas/pie.php"); }

  else{
    echo "<script>alert('¡No tiene los permisos necesarios para ingresar a esta sección!');window.history.back(-1);</script>";
  }

?>
