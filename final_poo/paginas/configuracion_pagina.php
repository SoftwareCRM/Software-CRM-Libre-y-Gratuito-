<?php session_start(); 
if (empty($_SESSION['id_usu'])){
  echo "<script>alert('¡Necesita ingresar sesión primero!');window.location='../index.php';</script>";
} else {

require_once("/xampp/htdocs/final_poo/plantillas/cabecera.php");
require_once("/xampp/htdocs/final_poo/insertar/insertar_a_caja_registradora_compras.php");
require_once("/xampp/htdocs/final_poo/insertar/insertar_datos_pdf.php");
require_once("/xampp/htdocs/final_poo/insertar/insertar_producto.php");
require_once("/xampp/htdocs/final_poo/insertar/insertar_registro_usuario.php");


$objProducto = new Productos();
$objConfiguracion = new Configuracion();
$objUsuario = new Usuarios();
$iva_ = $objProducto->IVAProductos(); 



if(isset($_POST['usuario'])){ // SI SE ENVIO UN FORMULARIO CON EL NICK USUARIO

  $ID = $_SESSION['id_usu']; 
  $insertar = $objConfiguracion->cambiarDatos($_POST['usuario'],$_POST['contrasenna'], $_POST['contrasenna_rp']); 
  // INSERTAR A LA BASE DE DATOS

  if ($ID){

    if ($_FILES['foto']['error'] > 0){ // FORMATO PARA ENVIAR UNA FOTO
      echo "<script>alert('Hubo un error con la imagen')</script>";
    } else {
      $permitidos = array("image/png","image/jpeg");
      $limite_archivo = 20000;
      
      if (in_array($_FILES['foto']['type'], $permitidos) && $_FILES['foto']['size'] <= $limite_archivo * 1024){
  
        


        $id = $_SESSION['id_usu'];
        $directory="../imagenes/perfiles/$id/";
        $dirint = dir($directory);
    
        while (($archivo = $dirint->read()) != false)
        {
            if (strpos($archivo,'jpg') || strpos($archivo,'jpeg') || strpos($archivo,'png')){
                $image = $directory. $archivo;
                unlink($image);
            }
        }
        $dirint->close();

        $ruta = '../imagenes/perfiles/'.$ID.'/';
        $archivo = $ruta.$_FILES['foto']['name'];
  
        if (!file_exists($ruta)){
          mkdir($ruta);
        }
  
        if (!file_exists($archivo)){
          $resultado = @move_uploaded_file($_FILES['foto']['tmp_name'], $archivo);
        }
  
      } else {
        echo "<script>alert('El formato de la foto o el tamaño del mismo no es permitido')</script>";
      }
    }
  }
}

if(isset($_GET['tit_negocio']) && isset($_GET['id_negocio'])){
    $insertar = $objConfiguracion->modificarPDFDatos($_GET['tit_negocio'],$_GET['id_negocio'],$_GET['dir_negocio'], $_GET['num_negocio'], $_GET['pie_negocio']); // MODIFICACION DE LOS DATOS DEL PDF
}

if (isset($_POST['contrasenna']) && isset($_POST['contrasenna_rp'])){
  $insertar = $objConfiguracion->cambiarDatosAdmin($_POST['contrasenna'], $_POST['contrasenna_rp']);
}

if (isset($_GET['iva'])){
  $insertar = $objConfiguracion->modificarIVADatos($_GET['iva']);
}

if ($_SESSION['acceso_usu'] == 1){
  $n = 'Administrador';
} else if($_SESSION['acceso_usu'] == 0){
  $n = 'Usuario';
} else if ($_SESSION['acceso_usu'] == 2){
  $n = 'Super Administrador';
} else {
  $n = 'Usuario';
}


?>



<div class="border pb-3">
        <div class="py-3">
          <h3 class="text-center py-1 pb-2 border border-dark">Configuración</h3>
        </div>

        <div>
          <div class="accordion" id="accordionExample">
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  <h5 class="text-danger">Configuración de <?php echo $n?> </h5>
                </button>
              </h2>

              <form action="./configuracion_pagina.php" method="post" class="needs-validation" enctype="multipart/form-data" onsubmit="return preguntaContrasenna()" novalidate>
                <div id="collapseOne" class="accordion-collapse collapse <?php if ($_SESSION['acceso_usu'] <= 1 ){ echo "show";}?>" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">

                      <?php if ($_SESSION['acceso_usu'] <= 1 ) {?>
                      <div class="row">
                        <div class="col-3">
                          <lavel> <h5 class="m-0">Cambiar nombre de usuario: </h5> </lavel>
                        </div>
                        <div class="col-5 position-relative"> 
                          <input class="p-1 form-control form-control-sm" placeholder="Ej: xXjuanito_perezXx" type="text" name="usuario" onkeypress="return Direccion(event);" onpaste="return false" minlength="3" maxlength="40" required>
                          <div class="invalid-tooltip">
                            Es necesario poner un nuevo nombre de usuario
                          </div>
                        </div>
                      </div>
                      <hr>
                      <?php } ?>
                    
                      <?php if ($_SESSION['acceso_usu'] < 3 ) {?>
                      <div class="row">
                        <div class="col-3">
                          <lavel> <h5 class="m-0">Cambiar foto de perfil: </h5> </lavel>
                        </div>
                        <div class="col-5 position-relative"> 
                          <input class="p-1 form-control form-control-sm" type="file" name="foto" id="foto" accept="image/*" required>
                          <div class="invalid-tooltip">
                            Es necesario poner una nueva foto de perfil
                          </div>
                        </div>
                      </div>
                      <hr>
                      <?php } ?>

                      <div class="row">
                        <div class="col-3">
                          <lavel> <h5 class="m-0">Cambiar contraseña: </h5> </lavel>
                        </div>
                        <div class="col-5 position-relative"> 
                          <input class="p-1 form-control form-control-sm" placeholder="Ej: 1999" type="password" name="contrasenna" onpaste="return false" minlength="3" maxlength="40" required>
                          <div class="invalid-tooltip">
                            Es necesario poner una nueva contraseña
                          </div>
                        </div>
                      </div>

                      <hr>

                      <div class="row pb-2">
                        <div class="col-3">
                          <lavel> <h5 class="m-0">Repetir contraseña: </h5> </lavel>
                        </div>
                        <div class="col-5 position-relative"> 
                          <input class="p-1 form-control form-control-sm" placeholder="Ej: 1999" type="password" name="contrasenna_rp" onpaste="return false" minlength="3" maxlength="40" required>
                          <div class="invalid-tooltip">
                            Es necesario que ambas contraseñas sean iguales
                          </div>
                        </div>
                      </div>

                      <div class="col-12 pt-1">
                        <input type="submit" class="w-100 btn btn-info configuracion_confirmacion"  value="Enviar">
                      </div>
                </div>
              </form>
            </div>

            <?php if ($_SESSION['acceso_usu'] == 2){  ?>

            <div class="accordion-item">
              <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  <h5 class="text-danger">Configuración de Facturacion PDF</h5>
                </button>
              </h2>
              <form method="get" class="needs-validation" enctype="multipart/form-data" onsubmit="return pregunta()" novalidate>

                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                  <div class="accordion-body">

                      <div class="row">
                        <div class="col-3">
                          <lavel> <h5 class="m-0 pe-4">Nombre del negocio: </h5> </lavel>
                        </div>
                        <div class="col-5 position-relative"> 
                          <input class="p-1 form-control form-control-sm" placeholder="Ej: Empresa Josue S.A" type="text" name="tit_negocio" onkeypress="return SoloLetras(event);" onpaste="return false" required>
                          <div class="invalid-tooltip">
                            Es necesario poner el nombre del negocio
                          </div>
                        </div>
                      </div>

                      <hr>

                      <div class="row">
                        <div class="col-3">
                          <lavel> <h5 class="m-0 pe-4">RIF del negocio: </h5> </lavel>
                        </div> <!-- HACER CAMBIO / HACER VALIDACION PROPIA -->
                        <div class="col-5 position-relative"> 
                          <input class="p-1 form-control form-control-sm" type="text" name="id_negocio" onkeypress="return RIF(event);" placeholder="Ej: J-00000000-0" onpaste="return false" required>
                          <div class="invalid-tooltip">
                            Es necesario poner el RIF del negocio
                          </div>
                        </div>
                      </div>

                      <hr>

                      <div class="row">
                        <div class="col-3">
                          <lavel> <h5 class="m-0 pe-4">Dirección del negocio: </h5> </lavel>
                        </div> <!-- HACER CAMBIO / HACER VALIDACION PROPIA -->
                        <div class="col-5 position-relative"> 
                          <input class="p-1 form-control form-control-sm" placeholder="Ej: San Manuel de Jasis" type="text" name="dir_negocio" onkeypress="return Direccion(event);" onpaste="return false" required>
                          <div class="invalid-tooltip">
                            Es necesario poner la dirección del negocio
                          </div>
                        </div>
                      </div>
  
                      <hr>  

                      <div class="row">
                        <div class="col-3">
                          <lavel> <h5 class="m-0 pe-4">Teléfono del negocio: </h5> </lavel>
                        </div> <!-- HACER CAMBIO / HACER VALIDACION PROPIA -->
                        <div class="col-5 position-relative"> 
                          <input class="p-1 form-control form-control-sm" placeholder="Ej: 0000-0000000" type="text" name="num_negocio" onkeypress="return Telefono(event);" onpaste="return false" required>
                          <div class="invalid-tooltip">
                            Es necesario poner el número de teléfono del negocio
                          </div>
                        </div>
                        
                      </div>

                      <hr>  

                      <div class="row">
                        <div class="col-3">
                          <lavel> <h5 class="m-0">Pie de pagina de la factura: </h5> </lavel>
                        </div> <!-- HACER CAMBIO / HACER VALIDACION PROPIA -->
                        <div class="col-5 position-relative"> 
                          <input class="p-1 form-control form-control-sm" placeholder="Ej: Gracias por la compra ¡Feliz día!" type="text" name="pie_negocio" onkeypress="return Pie(event);" onpaste="return false" required>
                          <div class="invalid-tooltip">
                            Es necesario poner la pie da página de la factura
                          </div>
                        </div>
                      </div>

                      <hr> 
                      <div class="col-12">

                        <input type="submit"  class="w-100 btn btn-info configuracion_confirmacion"  value="Enviar">
                      </div>
              </form>
              <?php  } ?>
            
              </div>
            </div>

            <?php if ($_SESSION['acceso_usu'] == 2){ ?>
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  <h5 class="text-danger">Configuración del IVA</h5>
                </button>
              </h2>

              <form method="get" class="needs-validation" enctype="multipart/form-data" novalidate>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                    <div class="accordion-body">

                      <div class="row">
                        <div class="col-3">
                          <lavel> <h5 class="m-0">Cambiar nombre de usuario: </h5> </lavel>
                        </div>
                        <div class="col-5 position-relative"> 
                          <input class="p-1 form-control form-control-sm" placeholder="IVA actual: <?php echo $iva_ ?>%" type="text" name="iva"  onkeypress="return SoloNumeros(event);" onpaste="return false" required>
                          <div class="invalid-tooltip">
                            Es necesario ingresar un número
                          </div>
                        </div>
                      </div>

                      <div class="col-12 pt-1">
                        <input type="submit" class="w-100 btn btn-info configuracion_confirmacion"  value="Enviar">
                      </div>
                </div>
              </form>
            </div>
            <?php } ?>
            
    </div>



<script src="../javascript/validaciones_campos1.js"></script>
<?php require_once("/xampp/htdocs/final_poo/plantillas/pie.php"); }?>
