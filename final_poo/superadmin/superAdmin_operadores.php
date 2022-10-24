<?php session_start();  
if (empty($_SESSION['id_usu'])){
  echo "<script>alert('¡Necesita ingresar sesión primero!');window.location='../index.php';</script>";
} else if ($_SESSION['acceso_usu'] == 2) {
  
require_once("/xampp/htdocs/final_poo/plantillas/cabecera.php");
require_once("/xampp/htdocs/final_poo/insertar/insertar_operadores.php");
require_once("/xampp/htdocs/final_poo/insertar/insertar_pdf.php");

$objOperadores = new Operadores(); 
$objPDF = new PDF_insertar();

if (isset($_POST['buscar'])){
  if($_POST['busqueda']){
    $insertar = $objOperadores->BuscadorSuperAdmin($_POST['busqueda']);
  }
}

if (isset($_GET['borrar'])) {
  $insertar = $objOperadores->EliminarUsuarioSuperAdmin($_GET['borrar']);    
}

if (isset($_GET['id'])) {
  $insertar = $objOperadores->AscensoUsuarioSuperAdmin($_GET['id']);    
}

if (isset($_GET['id_'])) {
  $insertar = $objOperadores->DescensoUsuarioSuperAdmin($_GET['id_']);    
}

?>


<div class="border"> 
        <div class="py-3">
          <h3 class="text-center py-1 pb-2 border border-dark">Operadores/Usuarios</h3>
        </div>
        <div class="pb-3">
          <form class="d-flex pe-1 " method="post"> <!-- BUSCADOR -->
            <div class="input-group mb-3">

                <input type="text" class="form-control" placeholder="Buscar por nombre del operador o usuario" name="busqueda" aria-describedby="button-addon2" onkeypress="return Direccion(event);" onpaste="return false">
                <button class="btn btn-primary" type="submit" id="button-addon2" name="buscar">
                    <i class="fa-solid fa-magnifying-glass fa-lg"></i>
                </button>
            </div>
          </form>
        </div>
        <table class="table table-hover">
          <thead>
            <tr>
                <th scope="col">Nombre del Operador</th>
                <th scope="col">Usuario</th>
                <th scope="col">Contraseña</th>
                <th scope="col">Nivel de Acceso</th>
                <th scope="col">Opciones</th>
            </tr>
          </thead>
          <tbody> 
          
            <?php $compras = $objOperadores->MostrarOperadoresSuperAdmin(); 
                foreach ($compras as $e){ 
            ?>

            <form action="" method="get"> <!-- FORMULARIO PDF -->

              <tr>
                <!--<th></th> Nombre-->
                <td class="col-3">
                    <?php echo $e["nom_usu"];?>
                </td>

                <td class="col-3">
                    <?php echo $e['usu_usu']?>
                </td> <!--Cantidad a Vender-->

                <td class="col-2">
                    <?php echo $e['contrasenna_usu']?>
                </td><!--Precio-->

                <td class="col-2">
                    <?php echo $e['nv_acceso_perm'] ?>
                </td>

                <td class="col-2">
                  <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                    <!-- Esqueleto del Modal de Modificar-->
                    <?php if ($e['id_perm'] == 0){ ?>
                      <a href="./superAdmin_operadores.php?id=<?php echo $e["id_usu"];?>" type="button" class="btn btn-info me-1 ascenso_boton_usuario">Ascender</a>
                    <?php } else { ?>
                      <a href="./superAdmin_operadores.php?id_=<?php echo $e["id_usu"];?>" type="button" class="btn btn-info me-1 descenso">Descender</a>
                    <?php } ?>
                    <!-- Esqueleto del Modal de Eliminar-->
                      <a href="./superAdmin_operadores.php?borrar=<?php echo $e["id_usu"];?>" class="btn btn-danger" onclick="return EliminacionUsuario()" type="button">Eliminar</a>
                  </div>
                </td>
              </tr> 

            </form> <!-- FORMULARIO PDF -->

            <?php } ?>
          </tbody>
        </table>
      </div>


<?php require_once("/xampp/htdocs/final_poo/plantillas/pie.php"); }

  else{
    echo "<script>alert('¡No tiene los permisos necesarios para ingresar a esta sección!');window.history.back(-1);</script>";
  }

?>

