<?php session_start();  
if (empty($_SESSION['id_usu'])){
  echo "<script>alert('¡Necesita ingresar sesión primero!');window.location='../index.php';</script>";
} else if ($_SESSION['acceso_usu'] == 2) {

require_once("/xampp/htdocs/final_poo/plantillas/cabecera.php");
require_once("/xampp/htdocs/final_poo/plantillas/bd.php");
require_once("/xampp/htdocs/final_poo/insertar/insertar_producto.php");

$objProducto = new Productos();


if (isset($_GET['id_'])) {
  $insertar = $objProducto->EliminarProductoSuperAdmin($_GET['id_']);    
}

if (isset($_POST['buscar'])){
  if($_POST['busqueda']){
    $insertar = $objProducto->BuscadorProductosSuperAdmin($_POST['busqueda']);
  }
}

?>
      <div class="border"> 
        <div class="py-3">
          <h3 class="text-center py-1 pb-2 border border-dark">Productos Agregados</h3>
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
              <th scope="col">Estado</th>
              <th class="text-center" scope="col">Opciones</th>
            </tr>
          </thead>
          <tbody>
          <?php $productos = $objProducto->MostrarProductosSuperAdmin(); 
            foreach ($productos as $e){ 

              // $precio = (($e['pre_prod'] * $e['iva_prod'])/100+$e['pre_prod']);
              $estado = $e['estado_prod'];
              if ($estado == 1){
                $estado_ = "Activo";
              } else {
                $estado_ = "Inactivo";
              }
          ?>
            <tr>
                <th class="col-3"><?php echo $e['nom_usu']?></th>
                <td class="col-4"><?php echo $e['nom_prod']?></td>
                <td class="col-2"><?php echo $e['cantidad_prod']?></td>
                <td class="col-2"><?php echo number_format($e['pre_prod'],2, ".", "");?></td>
                <td class="col-1"><?php echo "<b>".$estado_."</b>";?></td>

                <td class="col-1">
                  <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                    <!-- Esqueleto del Modal de Modificar-->
                      <a href="superAdmin_modificar_productos.php?id=<?php echo $e['id_prod'];?>" type="button" class="btn btn-info me-1">Modificar</a>

                    <!-- Esqueleto del Modal de Eliminar-->
                      <a href="superAdmin_productos.php?id_=<?php echo $e['id_prod'];?>" class="btn btn-danger permanente_boton" type="button">Eliminar</a>
                  </div>
                </td>
              </tr>
          <?php  } ?>
          </tbody>
        </table>
      </div>

<script>



</script>

<script src="../javascript/eliminacion_pagina.js"></script>

<?php require_once("/xampp/htdocs/final_poo/plantillas/pie.php"); } 

  else{
    echo "<script>alert('¡No tiene los permisos necesarios para ingresar a esta sección!');window.history.back(-1);</script>";
  }

?>

