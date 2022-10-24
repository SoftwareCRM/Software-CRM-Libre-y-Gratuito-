<?php session_start(); 
if (empty($_SESSION['id_usu'])){
    echo "<script>alert('¡Necesita ingresar sesión primero!');window.location='../paginas/index.php';</script>";
  } else {

require_once("/xampp/htdocs/final_poo/plantillas/cabecera.php");

error_reporting(0); //Oculta errores

$usu_usu = $_SESSION['usu_usu'];
$nom_usu = $_SESSION['nom_usu'];
$imagen = "";

if (!empty($_SESSION['foto_perfil'])){
  $imagen = $_SESSION['foto_perfil'];
  header("Content-type: image/jpeg");
  $imagen;
} 

if(!isset($_SESSION['usu_usu'])){
    echo "<script>window.location='../index.php' </script>";

} else {
?>

<div class="container py-4"> <!--Contener del contenido de la portada-->
  <div class="p-4 py-0 bg-light rounded-3 pb-0 mb-0">
    <div class="container-fluid py-5">
      <h1 class="display-5 fw-bold col-12 text-center pb-2"><?php echo "¡Bienvenido! ".$nom_usu?></h1>
      <p class="col-md-12 fs-4 text-center">Esperamos que disfrute de esta herramienta de indole libre y de condigo abierto, si desea compartir este sistema hacer click en el botón de más abajo para ir al enlace de descarga.</p>
      <div class="d-grid d-md-block text-center">
        <button class="btn btn-info col-6" type="button">Descargar</button>
      </div>
    </div>
  </div>

  <div><br></div> <!--SALTO DE LINEA-->
<a href="../manual_de_usuario.pdf"></a>
  <div class="row align-items-md-stretch">
      <div class="col-md-6">
        <div class="h-100 p-5 bg-dark rounded-3">
          <h2 class="text-white fw-bold">Manual de Usuario</h2>
          <p class="text-white">En caso de que necesite ayuda sobre alguna función del sistema, la misma posee un manual de usuario, en el cual usted puede documentarse o guiarse sobre el uso de esta herramienta.</p>
          <div class="d-grid d-md-block">
            <a href="../manual_de_usuario.pdf" target="_blank"><button href="/manual_de_usuario.pdf" class="btn btn-info col-6" type="button">Manual de Usuario</button></a>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="h-100 p-5 bg-light border rounded-3">
          <h2 class="fw-bold">Tutoriales</h2>
          <p>Esta herramienta cuenta con una serie de videos-tutoriales para una mayor accesibilidad hacia los usuarios, donde se explica de forma por encima las funciones del sistema.</p>
          <div class="d-grid d-md-block">
            <a href="" target="_blank"><button class="btn btn-info col-6" type="button">Tutoriales</button></a>
          </div>        
        </div>
      </div>
    </div>
</div>

<?php } ?>

<?php require_once("/xampp/htdocs/final_poo/plantillas/pie.php"); }?>


                