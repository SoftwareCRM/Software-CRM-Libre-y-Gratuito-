<?php session_start(); 
if (empty($_SESSION['id_usu'])){
  echo "<script>alert('¡Necesita ingresar sesión primero!');window.location='../index.php';</script>";
} else if ($_SESSION['acceso_usu'] == 0) {

require_once("/xampp/htdocs/final_poo/plantillas/cabecera.php");
require_once("/xampp/htdocs/final_poo/plantillas/bd.php");
require_once("/xampp/htdocs/final_poo/insertar/insertar_producto.php");
require_once("/xampp/htdocs/final_poo/insertar/insertar_a_carrito.php");
require_once("/xampp/htdocs/final_poo/insertar/insertar_a_caja_registradora_compras.php");


$id_usu = $_SESSION['id_usu']; // 
$usu_usu = $_SESSION['usu_usu']; // Poner el if y demás
$objCarrito = new Carrito();
$objCompras = new Compras();
$objProducto = new Productos();

$iva_ = $objProducto->IVAProductos(); 

if (isset($_GET['id'])) {
    $insertar = $objCarrito->EliminarCarrito($_GET['id']);    
}

if(isset($_GET['nom_cliente']) && isset($_GET['monto_total'])){
    $insertar = $objCompras->insertarCaja($_GET['nom_cliente'], $_GET['monto_total'], $_GET['id_prod'], $_GET['id_carr'], $_GET['cantidad_vender'], $_GET['ced_cliente']);    
}

if (isset($_POST['buscar'])){
    if($_POST['busqueda']){
      $insertar = $objProducto->BuscadorCarrito($_POST['busqueda']);
    }
}

if (isset($_POST['cantidad_vender'])){
    $insertar = $objCarrito->insertarCarrito($_POST['id_prod'],$_POST['cantidad_prod'],$_POST['cantidad_vender'], $id_usu);    
}

?>
<div class="container col-12 border pb-4">
    <h3 class="text-center pt-1">Monto a Pagar</h3>
    <div class="container-fluid border">
        <table class="table">
            <thead>
                <tr>
                    <th scope='col'>Nombre</th>
                    <th scope='col'>Cantidad a Vender</th>
                    <th scope='col'>Cantidad Restante</th>
                    <th scope='col'>Precio Total</th>
                    <th scope='col'>Opciones</th>
                </tr>
            </thead>
            <tbody> <!--AQUI-->
            <?php 
                $subTotal=0;
                $productos = $objCarrito->MostrarCarrito(); 
                foreach ($productos as $e){ 
            ?>
            <tr>
    <!--FORMULARIO INFORMACION A LA BASE DE DATOS-->
    <form action="" method="get" class="needs-validation" enctype="multipart/form-data" novalidate>
        <div> 

                <td>
                    <?php if ($e['iva_prod'] == $iva_){
                        echo $e['nom_prod']." (G) ";
                    } else {
                        echo $e['nom_prod']." (E) ";
                    }
                    ?>
                </td> <!--Nombre-->

                <td><?php echo $e['cantidad_vender_carr']?></td> <!--Cantidad a Vender-->

                <td><?php echo $e['Prd.cantidad_prod-Carr.cantidad_vender_carr']?></td> <!--Cantidad Restante-->

                <td><?php  $iva = 0; $exento = 0;

                    if ($e['iva_prod'] == $iva_){ 
                        echo number_format($e['Prd.pre_prod * Carr.cantidad_vender_carr'],2, ".", "");
                        $iva +=$e['Prd.pre_prod * Carr.cantidad_vender_carr'];
                    } else {
                        echo number_format($e['Prd.pre_prod * Carr.cantidad_vender_carr'],2, ".", "");
                        $exento +=$e['Prd.pre_prod * Carr.cantidad_vender_carr'];
                    }

                    $iva = ($iva * $iva_) / 100 + $iva;

                    $total_ = $iva+=$exento;
                    ?>
                </td> <!--Precio-->
                
                <td>
                    <a href="./carrito_productos.php?id=<?php echo $e['id_carr'];?>" type="button" class="btn btn-danger btn-sm">Eliminar</a>
                </td> <!--Opcion para eliminar del carrito / tabla de base de datos-->


                <input type="hidden" name="id_prod[]" id="id_prod[]" value="<?php echo $e['id_prod'];?>">
                <input type="hidden" name="id_carr[]" id="id_carr[]" value="<?php echo $e['id_carr'];?>">
                <input type="hidden" name="cantidad_vender[]" id="cantidad_vender[]" value="<?php echo $e['cantidad_vender_carr'];?>">

            </tr>
    
            <?php $subTotal= $subTotal+=$total_; } //Operacion que va sumando los precios de las compras ?>

                <tr>
                    <th>Monto Neto:</th>
                    <th colspan='1'></th>
                    <th colspan='1'></th>
                    <th colspan='1'></th>
                    <th colspan='1'><input type="hidden" id="monto_total" name="monto_total" value="<?php echo "$subTotal";?>"> $<?php  echo number_format("$subTotal",2, ".", "");?></th>
                    </tr>
            </tbody>
            
        </table>

            <div class="row">
                <div class="col-6">
                    <label for="nom_cliente" class="form-label">Nombre del cliente</label>
                    <input class="form-control form-control-sm" type="text" id="nom_cliente" name="nom_cliente" placeholder="Ej: José Pérez Armando Palacios" onkeypress="return SoloLetras(event)" onpaste="return false" minlength="3" maxlength="40" required> <!-- ENVIAR INFORMACION -->
                    <div class="invalid-tooltip">
                        Es necesario ingresar el nombre del cliente
                    </div>
                </div>
                <div class="col-6">
                    <label for="nom_cliente" class="form-label">Cédula del cliente</label>
                    <input class="form-control form-control-sm" type="text" id="ced_cliente" name="ced_cliente" placeholder="Ej: 00.000.000" onkeypress="return SoloNumeros(event)" onpaste="return false"  minlength="5" maxlength="40" required> <!-- ENVIAR INFORMACION -->
                    <div class="invalid-tooltip">
                        Es necesario ingresar la cédula del cliente
                    </div>
                </div>
                <div class="col">
                    <!-- PONER ALGO AQUI -->
                </div>
            </div>

            <br>

            <div class="row pb-3">
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-info btn-sm col-12">Enviar</button>  <!-- ENVIAR INFORMACION -->  
                </div>
            </div>
        </div>
    </form>

</div>

<div class="p-3">
</div>


<div class="container-fluid border">
    <div class="">
        <table class="table table-hover" > <!-- Tabla que muestra los productos creados-->
            <thead>
                    <div class="col-12 text-center pt-2">
                        <h3><bold>Agregar Producto</bold></h3>
                    </div>
                    <form class="d-flex pe-1 " method="post"> <!-- BUSCADOR -->
                        <div class="input-group mb-3">

                            <input type="text" class="form-control" placeholder="Buscar por nombre del producto" name="busqueda" aria-describedby="button-addon2" onkeypress="return Direccion(event);" onpaste="return false">
                            <button class="btn btn-primary" type="submit" id="button-addon2" name="buscar">
                                <i class="fa-solid fa-magnifying-glass fa-lg"></i>
                            </button>
                        </div>
                    </form>
                <tr >
                    <th scope="col">Nombre del producto</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Precio</th>
                    <th scope="col">A vender</th>
                </tr>
            </thead>
            <tbody>
                <?php $productos = $objProducto->MostrarProductosCarrito(); 
                    foreach ($productos as $e){ 
                ?>

                <form action="" method="post" class="needs-validation" enctype="multipart/form-data" novalidate>
                    <tr>
                        <td class="col-3">
                            <input type="hidden" name="nom_prd"><?php echo $e["nom_prod"]?></input>
                        </td> 
                        <td id="cantidad_prod" name="cantidad_prod" class="col-2">
                            <?php echo $e['cantidad_prod'];?>
                        </td>
                        <td class="col-2">
                            <?php echo number_format($e['pre_prod'],2, ".", "");?>
                        </td>
                        <td class="col-5"> 
                            <input type="hidden" name="id_prod" value="<?php echo $e["id_prod"];?>">
                            <input type="hidden" name="cantidad_prod" value="<?php echo $e["cantidad_prod"];?>"> 
                            <div class="input-group p-0">
                                <input type="text" class="form-control form-control-sm me-2"  name="cantidad_vender" id="cantidad_vender" placeholder="Cantidad a Vender"  minlength="1" maxlength="10" onkeypress="return SoloNumeros(event);" onpaste="return false" required>
                                <span class="px-1" id="basic-addon2">
                                    <input type="submit" value="Agregar" class="btn btn-info btn-sm">
                                </span>
                            </div>
                        </td>
                    </tr>
                </form>

                <?php } ?>
            </tbody>
        </table>
    </div>
    </div>


<?php require_once("/xampp/htdocs/final_poo/plantillas/pie.php"); }

  else{
    echo "<script>alert('¡No tiene los permisos necesarios para ingresar a esta sección!');window.history.back(-1);</script>";
  }

?>
