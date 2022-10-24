<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Página Principal</title> 
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/css_alm.css">
        <!-- FONT AWESOME -->
        <link rel="stylesheet" href="../font_awesome/css_font_awesone/all.min.css">

    </head>
    <body>

        <header> 
            <!--Cabecera-->
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="../paginas/portada_manual.php">| Inicio |</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarColor01">
                            <ul class="navbar-nav me-auto">

                                <?php if ($_SESSION['acceso_usu'] == 0) {  ?>
                                    <li class="nav-item">
                                    <a class="nav-link" href="../paginas/carrito_productos.php">| Carrito |
                                        <span class="visually-hidden">(current)</span> <!--CAMBIAR-->
                                    </a>
                                    </li>
                                <?php } else if ($_SESSION['acceso_usu'] == 1){  ?>
                                    <li class="nav-item">
                                    <a class="nav-link" href="../admin/admin_productos.php">| Almacén/Funciones |
                                        <span class="visually-hidden">(current)</span> <!--CAMBIAR-->
                                    </a>
                                    </li>
                                <?php } else if ($_SESSION['acceso_usu'] == 2){ ?>
                                    <li class="nav-item">
                                    <a class="nav-link" href="../superadmin/superAdmin_productos.php">| Productos/Almacén |
                                        <span class="visually-hidden">(current)</span> <!--CAMBIAR-->
                                    </a>
                                    </li>
                                <?php } ?>

                                <?php if ($_SESSION['acceso_usu'] == 1){  ?>
                                    <li class="nav-item">
                                    <a class="nav-link" href="../admin/admin_almacen_tienda.php">| Almacén/Tienda |
                                        <span class="visually-hidden">(current)</span> <!--CAMBIAR-->
                                    </a>
                                    </li>
                                <?php } ?>

                                <?php if ($_SESSION['acceso_usu'] == 0) {  ?>
                                    <li class="nav-item">
                                    <a class="nav-link" href="../paginas/almacen_productos.php">| Almacén |</a>
                                    </li>
                                <?php } else if ($_SESSION['acceso_usu'] == 1) { ?>
                                    <li class="nav-item">
                                    <a class="nav-link" href="../admin/admin_ventas.php">| Ventas |</a>
                                    </li>
                                <?php } else if ($_SESSION['acceso_usu'] == 2) {?>
                                    <li class="nav-item">
                                    <a class="nav-link" href="../superadmin/superAdmin_ventas.php">| Ventas |</a>
                                    </li>
                                <?php } ?>

                                <?php if ($_SESSION['acceso_usu'] == 0) {  ?>
                                    <li class="nav-item">
                                    <a class="nav-link" href="../paginas/caja_registradora_compras.php">| Caja Registradora |</a>
                                    </li>
                                <?php } else if ($_SESSION['acceso_usu'] == 1) { ?>
                                    <li class="nav-item">
                                    <a class="nav-link" href="../admin/admin_operadores.php">| Usuarios/Operadores |</a>
                                    </li>
                                <?php } else if ($_SESSION['acceso_usu'] == 2) { ?>
                                    <li class="nav-item">
                                    <a class="nav-link" href="../superadmin/superAdmin_operadores.php">| Usuarios/Operadores |</a>
                                    </li>
                                <?php } ?>

                                <?php if ($_SESSION['acceso_usu'] == 0) {  ?>
                                    <li class="nav-item">
                                    <a class="nav-link" href="../paginas/clientes.php">| Clientes |</a>
                                    </li>
                                <?php } else if ($_SESSION['acceso_usu'] == 1) { ?>
                                    <li class="nav-item">
                                    <a class="nav-link" href="../paginas/clientes.php">| Clientes |</a>
                                    </li>
                                <?php } else if ($_SESSION['acceso_usu'] == 2) { ?>
                                    <li class="nav-item">
                                    <a class="nav-link" href="../paginas/clientes.php">| Clientes |</a>
                                    </li>
                                <?php } ?>

                                <?php if ($_SESSION['acceso_usu'] == 0) {  ?>
                                    <li class="nav-item">
                                    <a class="nav-link" href="../paginas/configuracion_pagina.php">| Configuración |</a>
                                    </li>
                                <?php } else if ($_SESSION['acceso_usu'] == 1) { ?>
                                    <li class="nav-item">
                                    <a class="nav-link" href="../paginas/configuracion_pagina.php">| Configuración |</a>
                                    </li>
                                <?php } else if ($_SESSION['acceso_usu'] == 2) { ?>
                                    <li class="nav-item">
                                    <a class="nav-link" href="../paginas/configuracion_pagina.php">| Configuración |</a>
                                    </li>
                                <?php } ?>
                                
                            </ul>
                            <div class="d-flex">
                                <ul class="navbar-nav me-auto">
                                    <li class="nav-link">


                                    <?php

                                    $id = $_SESSION['id_usu'];
                                    
                                    $directory="../imagenes/perfiles/$id/";
                                    if (file_exists($directory)){ 
                                        $dirint = dir($directory);

                                        while (($archivo = $dirint->read()) != false)
                                        {
                                            if (strpos($archivo,'jpg') || strpos($archivo,'jpeg') || strpos($archivo,'png')){
                                                $image = $directory. $archivo;
                                                //echo'<img src='.$image.'>';
                                                echo'<img src='.$image.' class = "rounded-circle" width = "36" height = "36">';
                                            }
                                        }

                                        $dirint->close();
                                    } else {
                                        echo"<img src='../imagenes/cat.jpg' class = 'rounded-circle' width = '36' height = '36'>";
                                    }
                                    ?>
                                    </li>
                                    <li class="nav-link text-light">
                                        <a href="../paginas/cerrar_sesion_usuarios.php">
                                            <i class="fa-solid fa-door-open fa-2x" style="color:white"></i>
                                        </a>
                                    </li> 

                                </ul>
                            </div>
                        </div>
                    </div>
            </nav>
        </header>

        <br> <!--Espacio entre la cabecera y el main-->
        <main class="">
            <div class="container">
                <div class="row">