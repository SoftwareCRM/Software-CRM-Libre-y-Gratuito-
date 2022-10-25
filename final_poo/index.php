<?php session_start();
require_once("/xampp/htdocs/final_poo/plantillas/bd.php");
require_once("/xampp/htdocs/final_poo/insertar/insertar_inicio_sesion_usuario.php");

error_reporting(0);

$objSesion = new Sesion();

if ($_POST){
    $insertar = $objSesion->validarSesionUsuario($_POST['usuario'], $_POST['contrasenna']);    
}
?>

        <link rel="stylesheet" href="./css/bootstrap.min.css">
        <link rel="stylesheet" href="./css/css_alm.css">

        <br> <br> <br>
            <!-- CONTACTO -->
            <section class="py-5 container-fluid">
                <div class="container">
                    <div class="row container-fluid m-0">
                        <div class="col-2 col-sm-0"></div>
                        <div class="col-12 col-lg-8 p-3 m-3 bg-light border border-light rounded-3 rounded rounded-bottom">
                            <h3 id="nav_contacto" class="text-center p-0 m-0 fw-bold pb-0">Iniciar Sesión</h3>
                            <form action="" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate> <!--method="POST"-->
                                <div class="input-group mb-3 position-relative">
                                    <div class="col-12">
                                    <label for="usuario" class="form-label m-0 p-0"><b>Usuario</b></label>
                                        <input type="text" class="form-control" placeholder="Nombre de usuario" aria-describedby="addon-wrapping" id="usuario" name="usuario" onkeypress="return Direccion(event);" onpaste="return false" required>
                                        <div class="invalid-tooltip">
                                            Es necesario poner el nombre del usuario
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-3 position-relative">
                                    <div class="col-12">
                                    <label for="contrasenna" class="form-label m-0 p-0"><b>Contraseña</b></label>
                                        <input type="password" class="form-control" placeholder="Contraseña" aria-describedby="basic-addon1" name="contrasenna" id="contrasenna" onkeypress="return Direccion(event);" onpaste="return false" required>
                                        <div class="invalid-tooltip">
                                            Es necesario poner la contraseña del usuario
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-info btn-block input-group">Iniciar Sesion</button>
                                <h5 class="py-3 pb-0 text-center">¿No tienes una cuenta?<br><a href="./paginas/registrar_usuarios.php">Crear cuenta</a></h5>
                            </form>
                        </div>
                        <div class="col-2 col-sm-0"></div>
                    </div>
                </div>
            </section>


<script src="./javascript/validaciones_campos1.js"></script>
<script src="./javascript/eliminacion_pagina.js"></script>
            

