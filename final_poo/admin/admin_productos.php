<?php session_start();  
if (empty($_SESSION['id_usu'])){
  echo "<script>alert('¡Necesita ingresar sesión primero!');window.location='../index.php';</script>";
} else if ($_SESSION['acceso_usu'] == 1) {

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
  $insertar = $objProducto->DeshacerProductoAdmin($_GET['id']);    
}

if (isset($_GET['id_'])) {
  $insertar = $objProducto->EliminarProductos($_GET['id_'], $_SESSION['acceso_usu']);    
}

if (isset($_POST['buscar'])){
  if($_POST['busqueda']){
    $insertar = $objProducto->BuscadorAdminSinStock($_POST['busqueda']);
  }
}

if (isset($_POST['buscar1'])){
  if($_POST['busqueda1']){
    $insertar = $objProducto->BuscadorAdminEliminados($_POST['busqueda1']);
  }
}

?>
<div class="border pb-3"> 
        <div class="py-3">
          <h3 class="text-center py-1 pb-2 border border-dark">Añadir producto</h3>
        </div>

        <!--FORMULARIO INFORMACION A LA BASE DE DATOS-->
        <form action="" method="post" class="needs-validation" enctype="multipart/form-data" novalidate>
          <div class="row g-3">
            <div class="col-sm-3 position-relative">
              <label for="nom_prd" class="form-label">Nombre del producto</label>
              <input type="text" class="form-control" id="nom_prd" name="nom_prd" placeholder="Ej: Arroz Maria" onkeypress="return SoloLetras(event);" onpaste="return false"  minlength="3" maxlength="40" required> <!-- ENVIAR INFORMACION -->
              <div class="invalid-tooltip">
                Es necesario poner el nombre del producto
              </div>
            </div>

            <div class="col-sm-3 position-relative">
              <label for="pre_prd" class="form-label">Precio del producto</label>
              <input type="text" step="0.001" class="form-control" id="pre_prd" name="pre_prd" placeholder="Ej: 100.00" onkeypress="return SoloNumeros(event);" onpaste="return false" minlength="1" maxlength="40" required> <!-- ENVIAR INFORMACION -->
              <div class="invalid-tooltip">
                Es necesario poner el precio del producto
              </div>
            </div>

            <div class="col-sm-3  position-relative">
              <label for="iva_prd" class="form-label">IVA del producto</label>
                <div class="btn-group col-12" role="group" aria-label="Basic mixed styles example">
                    <input class="form-control" placeholder="<?php echo $iva."%";?>" onkeypress="return SoloNumeros(event);" onpaste="return false" disabled>

                    <input type="hidden" name="iva_prd" value="0"/>
                    <input type="checkbox" class="btn-check" id="btn-check-outlined" name="iva_prd" autocomplete="off" value="1">

                    <label class="btn btn-outline-danger" for="btn-check-outlined">IVA</label>
                </div>
            </div>

            <div class="col-sm-3 position-relative">
              <label for="can_prd" class="form-label">Cantidad del producto</label>
              <input type="text" class="form-control" id="can_prd" name="can_prd" placeholder="Ej: 45" onkeypress="return SoloNumeros(event);" onpaste="return false" minlength="1" maxlength="40" required> <!-- ENVIAR INFORMACION -->
              <div class="invalid-tooltip">
                Es necesario poner la cantidad del producto
              </div>
            </div>
          <div class="col-12">
            <button type="submit" name="accion" class="w-100 btn btn-info btn-lg" >Añadir nuevo producto</button> 
          </div>
          <!-- ENVIAR INFORMACION -->
        </form>
        </div>
      </div>

      
      <div class="pb-4 text-center"><br>------------------------------------------------------------------------------------</div> <!--Separador de tablas-->

      <div class="border"> 
        <div class="py-3">
          <h3 class="text-center py-1 pb-2 border border-dark">Último producto agregado</h3>
        </div>
        <table class="table table-hover"> <!--Tabla del ultimo productos agregados-->
          <thead>
            <tr>
              <th scope="col">Nombre del Producto</th>
              <th scope="col">Cantidad</th>
              <th scope="col">Precio</th>
              <th scope="col">IVA</th>
              <th class="text-center" scope="col">Opciones</th>
            </tr>
          </thead>
          <tbody>
          <?php $productos = $objProducto->UltimoProducto(); 
            foreach ($productos as $e){ 

              if ($e['iva_prod'] == 0){
                $iva = "NO";
              } else {
                $iva = "SI";
              }
          ?>
            <tr>
                <td class="col-3">
                  <?php echo $e['nom_prod']?>
                </td>
                <td class="col-3">
                  <?php echo $e["cantidad_prod"]?>
                </td>
                <td class="col-3">
                  <?php echo number_format($e['pre_prod'],2, ".", "")?>
                </td>

                <td class="col-2">
                  <?php echo $iva?>
                </td>

                <td class="col-1">
                  <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                    <!-- Esqueleto del Modal de Modificar-->
                      <a href="./admin_productos_modificar.php?id=<?php echo $e['id_prod'];?>" type="button" class="btn btn-info me-1">Modificar</a>

                    <!-- Esqueleto del Modal de Eliminar-->
                      <a href="./admin_productos.php?id_=<?php echo $e['id_prod'];?>" class="btn btn-danger permanente_boton" type="button">Eliminar</a>
                  </div>
                </td>
              </tr>
          <?php  } ?>
          </tbody>
        </table>
      </div>

      <div class="pb-4 text-center"><br>------------------------------------------------------------------------------------</div> <!--Separador de tablas-->

      <div class="border"> 
        <div class="py-3">
          <h3 class="text-center py-1 pb-2 border border-dark">Productos Sin Stock</h3>
        </div>
        <div class="pb-3">
          <form class="d-flex pe-1 " method="post"> <!-- BUSCADOR -->
            <div class="input-group mb-3">

                <input type="text" class="form-control" placeholder="Buscar por nombre del producto" name="busqueda" aria-describedby="button-addon2" onkeypress="return Direccion(event);" onpaste="return false">
                <button class="btn btn-primary" type="submit" id="button-addon2" name="buscar">
                    <i class="fa-solid fa-magnifying-glass fa-lg"></i>
                </button>
            </div>
          </form>
        </div>
        <table class="table table-hover"> <!--Tabla de los productos agregados-->
          <thead>
            <tr>
              <th scope="col">Operador</th>
              <th scope="col">Nombre del Producto</th>
              <th scope="col">Cantidad</th>
              <th scope="col">Precio</th>
              <th class="text-center" scope="col">Opciones</th>
            </tr>
          </thead>
          <tbody>
          <?php $productos = $objProducto->MostrarProductosAdminSinStock(); 
            foreach ($productos as $e){ 
          ?>
            <tr>
                <th class="col-3">
                  <?php echo $e['nom_usu']?>
                </th>
                <td class="col-4">
                  <?php echo $e['nom_prod']?>
                </td>
                <td class="col-2">
                  <?php echo $e["cantidad_prod"]?>
                </td>
                <td class="col-2">
                  <?php echo number_format($e['pre_prod'],2, ".", "")?>
                </td>

                <td class="col-1">
                  <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                    <!-- Esqueleto del Modal de Modificar-->
                      <a href="./admin_productos_modificar.php?id=<?php echo $e['id_prod'];?>" type="button" class="btn btn-info me-1">Modificar</a>

                    <!-- Esqueleto del Modal de Eliminar-->
                      <a href="./admin_productos.php?id_=<?php echo $e['id_prod'];?>" class="btn btn-danger permanente_boton" type="button">Eliminar</a>
                  </div>
                </td>



              </tr>
          <?php  } ?>
          </tbody>
        </table>
      </div>

      <div class="pb-4 text-center"><br>------------------------------------------------------------------------------------</div> <!--Separador de tablas-->

      <div class="border"> 
        <div class="py-3">
          <h3 class="text-center py-1 pb-2 border border-dark">Productos Eliminados</h3>
        </div>
        <div class="pb-3">
          <form class="d-flex pe-1 " method="post"> <!-- BUSCADOR -->
            <div class="input-group mb-3">

                <input type="text" class="form-control" placeholder="Buscar por nombre del producto" name="busqueda1" aria-describedby="button-addon2" onkeypress="return Direccion(event);" onpaste="return false">
                <button class="btn btn-primary" type="submit" id="button-addon2" name="buscar1">
                    <i class="fa-solid fa-magnifying-glass fa-lg"></i>
                </button>
            </div>
          </form>
        </div>
        <table class="table table-hover"> <!--Tabla de los productos agregados-->
          <thead>
            <tr>
              <th scope="col">Operador</th>
              <th scope="col">Nombre del Producto</th>
              <th scope="col">Cantidad</th>
              <th scope="col">Precio</th>
              <th class="text-center" scope="col">Opciones</th>
            </tr>
          </thead>
          <tbody>
          <?php $productos = $objProducto->MostrarProductosAdminEliminados(); 
            foreach ($productos as $e){ 
          ?>
            <tr>
                <th class="col-3"><?php echo $e['nom_usu']?></th>
                <td class="col-4"><?php echo $e['nom_prod']?></td>
                <td class="col-2"><?php echo $e['cantidad_prod']?></td>
                <td class="col-2"><?php echo number_format($e['pre_prod'],2, ".", "");?></td>

                <td class="col-1">
                  <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                    <!-- Esqueleto del Modal de Modificar-->
                      <a href="admin_productos.php?id=<?php echo $e['id_prod'];?>" type="button" class="btn btn-info me-1">Deshacer</a>

                    <!-- Esqueleto del Modal de Eliminar-->
                      <a href="admin_productos.php?id_=<?php echo $e['id_prod'];?>" class="btn btn-danger permanente_boton" type="button">Eliminar</a>
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

