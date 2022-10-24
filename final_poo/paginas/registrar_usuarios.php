<?php session_start(); 
require_once("/xampp/htdocs/final_poo/plantillas/bd.php");
require_once("/xampp/htdocs/final_poo/insertar/insertar_registro_usuario.php");


$objUsuario = new Usuarios();

if(isset($_SESSION["id_usu"])){
  echo "<script>alert('Usted tiene la sesión activa, por favor cierra sesión para poder continuar');window.location='../paginas/portada_manual.php';</script>";
 }

if ($_POST){

  $insertar = $objUsuario->insertarUsuario($_POST['nombre'], $_POST['usuario'],$_POST['email'],$_POST['contrasenna'],$_POST['rp_contrasenna']);   
  
  $ID = $objUsuario->IDCliente();

  if ($ID){
    if ($_FILES['foto']['error'] > 0){
      echo "<script>alert('Hubo un error con la imagen')</script>";
    } else {
      $permitidos = array("image/png","image/jpeg");
      $limite_archivo = 200;
      
      if (in_array($_FILES['foto']['type'], $permitidos) && $_FILES['foto']['size'] <= $limite_archivo * 1024){
  
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


?>
    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <br>
  <!-- CONTACTO -->
  <section class="py-5 container-fluid">
      <div class="container">
          <div class="row container-fluid m-0">
              <div class="col-2 col-sm-0"></div>
              <div class="col-12 col-lg-8 p-3 m-3 mt-2 bg-light border border-light rounded-3 rounded rounded-bottom shadow">
                <h3 id="nav_contacto" class="text-center p-0 m-0 fw-bold pb-1">Registrarse</h3>
                  <form action="" method="post" class="needs-validation" enctype="multipart/form-data" novalidate>
                      <div class="input-group mb-3 position-relative">

                        <div class="col-12">
                          <label for="nombre" class="form-label m-0 p-0"><b>Nombre</b></label>
                          <input type="text" class="form-control" placeholder="Ingresar nombre"  aria-describedby="addon-wrapping" name="nombre" id="nombre" onkeypress="return SoloLetras(event);" onpaste="return false" minlength="3" maxlength="40" required>
                          <div class="invalid-tooltip">
                            Es necesario ingresar un nombre
                          </div>
                        </div>
                      </div>
                      <div class="input-group mb-3 position-relative">
                          <div class="col-12">
                            <label for="usuario" class="form-label m-0 p-0"><b>Usuario</b></label>
                              <input type="text" class="form-control" placeholder="Ingresar usuario"  aria-describedby="addon-wrapping" name="usuario" id="usuario" onkeypress="return Direccion(event);" onpaste="return false" minlength="3" maxlength="40" required>
                              <div class="invalid-tooltip">
                                Es necesario ingresar un nombre de usuario
                              </div>
                          </div>
                      </div>
                      <div class="input-group mb-3 position-relative">
                        <div class="col-12">
                            <label for="email" class="form-label m-0 p-0"><b>Correo Electrónico</b></label>
                            <input type="email" class="form-control" placeholder="Ingresar correo electrónico" aria-describedby="basic-addon1" name="email" id="email" onkeypress="return Correo(event);" onpaste="return false" minlength="1" maxlength="40" required>
                            <div class="invalid-tooltip">
                              Es necesario ingresar un correo electrónico
                            </div>
                        </div>
                      </div>
                      <div class="input-group mb-3 position-relative">
                        <div class="col-12">
                            <label for="foto" class="form-label m-0 p-0"><b>Foto de perfil</b></label>
                            <input type="file" class="form-control" placeholder="Ingresar una imagen" aria-describedby="basic-addon1" name="foto" id="foto" accept="image/*" required>
                            <div class="invalid-tooltip">
                              Es necesario ingresar una foto
                            </div>
                        </div>
                      </div>
                      <div class="input-group mb-3 position-relative">
                          <div class="col-12">
                            <label for="contrasenna" class="form-label m-0 p-0"><b>Contraseña</b></label>
                              <input type="password" class="form-control" placeholder="Ingresar contraseña" aria-describedby="basic-addon1" name="contrasenna" id="contrasenna" onkeypress="return Direccion(event);" onpaste="return false" minlength="3" maxlength="40" required>
                              <div class="invalid-tooltip">
                                Es necesario ingresar una contraseña
                              </div>
                          </div>
                      </div>
                      <div class="input-group mb-3 position-relative">
                        <div class="col-12">
                            <label for="rp_contrasenna" class="form-label m-0 p-0"><b>Repita Contraseña</b></label>
                            <input type="password" class="form-control" placeholder="Repetir contraseña" aria-label="Username" aria-describedby="basic-addon1" name="rp_contrasenna" id="rp_contrasenna" onkeypress="return Direccion(event);" onpaste="return false" minlength="3" maxlength="40" required>
                            <div class="invalid-tooltip">
                              Ambas contraseñas deben coincidir
                            </div>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-info btn-block input-group">Registrarse</button>
                      <h5 class="py-3 pb-0 text-center">¿Ya tienes una cuenta? <br> <a href="../index.php">Iniciar Sesion</a></h5>
                  </form>
              </div>
              <div class="col-2 col-sm-0"></div>
          </div>
      </div>
  </section>

<script src="../javascript/eliminacion_pagina.js"></script>
<script src="../javascript/validaciones_campos2.js"></script>
