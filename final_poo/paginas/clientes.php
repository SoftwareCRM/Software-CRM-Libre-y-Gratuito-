<?php session_start(); 
if (empty($_SESSION['id_usu'])){
  echo "<script>alert('¡Necesita ingresar sesión primero!');window.location='../index.php';</script>";
} else {

require_once("/xampp/htdocs/final_poo/plantillas/cabecera.php");
require_once("/xampp/htdocs/final_poo/insertar/insertar_clientes.php");
require_once("/xampp/htdocs/final_poo/insertar/insertar_pdf.php");


$objCliente = new Clientes(); 
$objPDF = new PDF_insertar();

if (isset($_POST['buscar'])){
  if($_POST['busqueda']){
    $insertar = $objCliente->Buscador($_POST['busqueda']);
  }
}

if(isset($_GET['id_cliente'])){ //VER LAS COMPRAS QUE HIZO EL CLIENTE
  $insertar = $objCliente->ComprasCliente($_GET['id_cliente']);
}

if (isset($_GET['id'])) { //ELIMINACION PARA SIEMPRE DEL CLIENTE
  $insertar = $objCliente->EliminarClienteSuperAdmin($_GET['id']);    
}

if (isset($_GET['id_'])) { //DESHACER LA ELIMINACION DEL CLIENTE
  $insertar = $objCliente->DeshacerEliminacionCliente($_GET['id_']);    
}

if(isset($_GET['id_cliente_'])){ //VER LA CANTIDAD DE PRODUCTOS COMPRADOS
  $insertar = $objCliente->ProductosCliente($_GET['id_cliente_']);
}

if(isset($_GET['eliminar_cliente'])){ //ELIMINAR CLIENTE 'ELIMINACION LOGICA'
  $insertar = $objCliente->EliminarCliente($_GET['eliminar_cliente']);
}

?>


<div class="border"> 
        <div class="py-3">
          <h3 class="text-center py-1 pb-2 border border-dark">Clientes</h3>
        </div>
        <div class="pb-3">
          <form class="d-flex pe-1 " method="post"> <!-- BUSCADOR -->
            <div class="input-group mb-3">

                <input type="text" class="form-control" placeholder="Buscar por cédula o nombre del cliente" name="busqueda" aria-describedby="button-addon2" onkeypress="return Direccion(event);" onpaste="return false">
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
                <th scope="col">Productos comprados</th>
                <th scope="col text-align">Dinero gastado</th>
                <?php if ($_SESSION['acceso_usu'] != 0) {?>
                <th scope="col text-align">Opciones</th>
                <?php } ?>
            </tr>
          </thead>  
          <tbody> 
          
            <?php $compras = $objCliente->MostrarClientes();

                foreach ($compras as $e){ 
            ?>


            <tr>

              <?php if ($_SESSION['acceso_usu'] != 0){$col = 1; $col_ced = 2;}else{$col = 2; $col_ced = 3;} ?>

              <!--<th></th> Nombre-->
              <th class="col-<?php echo $col;?>">
                  <?php echo $e["id_cliente"];?>
              </th>


              <td class="col-<?php echo $col_ced;?>">
                  <?php echo $e['nom_cliente']?>
              </td> <!--Cantidad a Vender-->

              <td class="col-<?php echo $col_ced;?>">
                  <?php echo $e['ced_cliente']?>
              </td> <!--Cantidad a Vender-->

              <form action="" method="get"> <!-- FORMULARIO PDF -->

                <td class="col-2 px-5">
                    <div>
                        <input type="hidden" name="id_cliente_" value="<?php echo $e["id_cliente"];?>">
                        <button type="submit" class="btn btn-sm"><i class="fa-solid fa-eye fa-lg" style="color:black;"></i></button>
                    </div>
                </td>

              </form> <!-- FORMULARIO PDF -->

              <form action="" method="get"> <!-- FORMULARIO PDF -->

                <td class="col-1 px-5">
                    <div>
                        <input type="hidden" name="id_cliente" value="<?php echo $e["id_cliente"];?>">
                        <button type="submit" class="btn btn-sm"><i class="fa-solid fa-eye fa-lg" style="color:black;"></i></button>
                    </div>
                </td>

              </form> <!-- FORMULARIO PDF -->

              <?php if ($_SESSION['acceso_usu'] != 0) {?>
              <form action="" method="get"> <!-- FORMULARIO PDF -->

                <td class="col-1 px-4">
                    <div>
                        <input type="hidden" name="eliminar_cliente" value="<?php echo $e["id_cliente"];?>">
                        <button type="submit" class="btn btn-sm" onclick="return EliminarCliente()"><i class="fa-solid fa-trash-can fa-lg" style="color:red;"></i></button>
                    </div>
                </td>

              </form> <!-- FORMULARIO PDF -->
              <?php } ?>
            </tr>


            <?php } ?>
          </tbody>
        </table>
  </div>

      <?php if ($_SESSION['acceso_usu'] == 2) { ?>

      <div class="pb-4"><br></div> <!--Separador de tablas-->


      <div class="border"> 
        <div class="py-3">
          <h3 class="text-center py-1 pb-2 border border-dark">Clientes Eliminados</h3>
        </div>
        <div class="pb-3">
          <form class="d-flex pe-1 " method="post"> <!-- BUSCADOR -->
            <div class="input-group mb-3">

                <input type="text" class="form-control" placeholder="Buscar por nombre o cédula del cliente" name="busqueda_eliminado" aria-describedby="button-addon2" onkeypress="return Direccion(event);" onpaste="return false">
                <button class="btn btn-primary" type="submit" id="button-addon2" name="buscar_eliminado">
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
                <th scope="col">Productos comprados</th>
                <th class="text-center" scope="col text-align">Dinero gastado</th>
                <th class="text-center">Opciones</th>
            </tr>
          </thead>  
          <tbody> 
          
            <?php $compras = $objCliente->MostrarClientesEliminados();
                foreach ($compras as $e){ 
            ?>
            <tr>

              <!--<th></th> Nombre-->
              <th class="col-1">
                  <?php echo $e["id_cliente"];?>
              </th>

              <td class="col-2">
                  <?php echo $e['nom_cliente']?>
              </td> <!--Cantidad a Vender-->

              <td class="col-2">
                  <?php echo $e['ced_cliente']?>
              </td> <!--Cantidad a Vender-->

              <form action="" method="get"> <!-- FORMULARIO PDF -->

                <td class="col-2 px-5">
                    <div>
                        <input type="hidden" name="id_cliente_" value="<?php echo $e["id_cliente"];?>">
                        <button type="submit" class="btn btn-sm"><i class="fa-solid fa-eye fa-lg" style="color:black;"></i></button>
                    </div>
                </td>

              </form> <!-- FORMULARIO PDF -->

              <form action="" method="get"> <!-- FORMULARIO PDF -->

                <td class="col-1 px-5">
                    <div>
                        <input type="hidden" name="id_cliente" value="<?php echo $e["id_cliente"];?>">
                        <button type="submit" class="btn btn-sm"><i class="fa-solid fa-eye fa-lg" style="color:black;"></i></button>
                    </div>
                </td>

              </form> <!-- FORMULARIO PDF -->

              <form action="" method="get"> <!-- FORMULARIO PDF -->

                <td class="col-1 px-4">
                  <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                    <!-- Esqueleto del Modal de Modificar-->
                      <a href="./clientes.php?id_=<?php echo $e["id_cliente"];?>" type="button" class="btn btn-info me-1">Deshacer</a>

                    <!-- Esqueleto del Modal de Eliminar-->
                      <a href="./clientes.php?id=<?php echo $e["id_cliente"];?>" class="btn btn-danger permanente_cliente_boton" type="submit">Eliminar</a>
                  </div>
                </td>

              </form> <!-- FORMULARIO PDF -->
              <?php } ?>
            </tr>

          </tbody>
        </table>
      </div>
      <?php } ?>



<?php require_once("/xampp/htdocs/final_poo/plantillas/pie.php"); }?>
