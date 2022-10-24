<?php session_start();   
if (empty($_SESSION['id_usu'])){
  echo "<script>alert('¡Necesita ingresar sesión primero!');window.location='../index.php';</script>";
} else if ($_SESSION['acceso_usu'] == 0) {
   
require_once("/xampp/htdocs/final_poo/plantillas/cabecera.php");
require_once("/xampp/htdocs/final_poo/plantillas/bd.php");
require_once("/xampp/htdocs/final_poo/insertar/insertar_producto.php");

$objProducto = new Productos();

$iva = $objProducto->IVAProductos(); 

if (isset($_POST['nom_prd'])){
    if ($_POST["iva_prd"] == 1) {
      $insertar = $objProducto->insertarProducto($_POST['nom_prd'],$_POST['pre_prd'],$_POST['can_prd'], $iva);  
    } else {
      $insertar = $objProducto->insertarProducto($_POST['nom_prd'],$_POST['pre_prd'],$_POST['can_prd'], 0);    
    }
}

if (isset($_GET['id'])) {
  $insertar = $objProducto->EliminarProductos($_GET['id'], $_SESSION['acceso_usu']);    
}

if (isset($_POST['buscar'])){
  if($_POST['busqueda']){
    $insertar = $objProducto->Buscador($_POST['busqueda']);
  }
}
  
?>
      <div class="border"> 
        <div class="py-3">
          <h3 class="text-center py-1 pb-2 border border-dark">Almacén</h3>
        </div>

        <form class="d-flex" method="post">

          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Buscar por nombre o código del producto" name="busqueda" aria-describedby="button-addon2" onkeypress="return Direccion(event);" onpaste="return false">
            <button class="btn btn-primary" type="submit" id="button-addon2" name="buscar">
              <i class="fa-solid fa-magnifying-glass fa-lg"></i>
            </button>
          </div>

        </form>


        <table class="table table-hover"> <!--Tabla de los productos agregados-->
          <thead>
            <tr>
              <th scope="col">Código</th>
              <th scope="col">Nombre del producto</th>
              <th scope="col">Cantidad</th>
              <th scope="col">Precio</th>
              <th scope="col">IVA</th>
            </tr>
          </thead>
          <tbody>

          <?php $productos = $objProducto->MostrarProductos(); 
            foreach ($productos as $e){ 

              if ($e['iva_prod'] == 0){
                $iva = "NO";
              } else {
                $iva = "SI";
              }
          ?>
            <tr>
                <th class="col-2">
                  <div>
                    <?php echo $e['id_prod']?>
                  </div>
                </th>
                <td class="col-5">
                  <div>
                    <?php echo $e['nom_prod']?>
                  </div>
                </td>
                <td class="col-2">
                  <div>
                    <?php echo $e['cantidad_prod']?>
                  </div>
                </td>
                <td class="col-2">
                  <div>
                    <?php echo number_format($e['pre_prod'],2, ".", "");?>
                  </div>
                </td>
                <td class="col-2">
                  <div>
                    <?php echo $iva;?>
                  </div>
                </td>
              </tr>
          <?php  } ?>
          </tbody>
        </table>
      </div>

<?php require_once("/xampp/htdocs/final_poo/plantillas/pie.php"); }

  else{
    echo "<script>alert('¡No tiene los permisos necesarios para ingresar a esta sección!');window.history.back(-1);</script>";
  }

?>



