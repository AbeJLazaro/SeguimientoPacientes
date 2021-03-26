<?php
/*
Nombre: generalesR.php
Objetivo:Presentar a un usuario tipo administrador las tres opciones de las cuales se pueden generar un reporte en formato PDF con todos los pacientes que coincidan en el estatus seleccionado.
Creado por: Perez Romero Verónica
Fecha: 1 de enero del 2020
Versión: 1.0
Declaraciones:
Variables: fecha2, fecha22.
Conexiones: pdfGeneral.php
*/

session_start();
if(isset($_SESSION['TipoUsuario'])){
  if ($_SESSION['TipoUsuario']!='A') 
  {
      header("location:homeU.php");

  }
}

$fecha2=$_POST["fecha2"];   //Fecha inicial para reporte general
$fecha22=$_POST["fecha22"]; //Fecha final para reporte general
?>

<!DOCTYPE html>
<html lang="es" >
<head>
  <meta charset="UTF-8">
  <title>Reportes Generales</title>
  <meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0, maximum-scale=3.0, minimum-scale=1.0">
  
  <link rel="stylesheet" href="librerias/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="css/estilosGR.css">
  <link rel="stylesheet" href="css/stylesGR.css" >
  <link rel="stylesheet" href="css/sweetalert.css">
  
</head>
<body>
  <header class="cabecera">
    <div class="container--flex">
      <div class="logo-container column column--50">
        <hi class="logo">Reportes Generales</hi>
      </div>
      <div class="cabecera__imagen column column--50">
        <img src="img/logoIMSS.png">
      </div>
    </div>
  </header>

  <main class="main">
    <section >
      <!--Se envia fechaInicial,fechaFinal y tipoGeneral a la pantalla pdfGeneral por el método POST-->
      <form target='_blank' method="POST" action="pdfGeneral.php">
        <div class=row >
          <div class="col-sm-7">
            <h3 align="right">Pacientes pendientes  de estudio de laboratorio </h3>
            <input type="hidden" name="fechaInicial" value="<?php echo($fecha2); ?>">
            <input type="hidden" name="fechaFinal" value="<?php echo($fecha22); ?>">
            <input type="hidden" name="tipoGeneral" value="1">
          </div>
          <div class="col-sm-5">
            <input class="btn btn-success" type="submit" value="Generar PDF" />
          </div>
      </div>
      </form>

      <form target='_blank' method="POST" action="pdfGeneral.php">
        <div class=row >
          <div class="col-sm-7">
            <h3 align="right">Pacientes pendientes de diagnóstico</h3>
            <input type="hidden" name="fechaInicial" value="<?php echo($fecha2); ?>">
            <input type="hidden" name="fechaFinal" value="<?php echo($fecha22); ?>">
            <input type="hidden" name="tipoGeneral" value="2">
          </div>
          <div class="col-sm-5">
            <input class="btn btn-success" type="submit" value="Generar PDF" />
          </div>
      </div>
      </form>
      
      <form target='_blank' method="POST" action="pdfGeneral.php">
        <div class=row >
          <div class="col-sm-7">
            <h3 align="right">Pacientes con diagnóstico final</h3>
            <input type="hidden" name="fechaInicial" value="<?php echo($fecha2); ?>">
            <input type="hidden" name="fechaFinal" value="<?php echo($fecha22); ?>">
            <input type="hidden" name="tipoGeneral" value="3">
          </div>
          <div class="col-sm-5">
            <input class="btn btn-success" type="submit" value="Generar PDF" />
          </div>
      </div>
      </form>
    </section>
  </main>
  <footer>
	    <div class=row>
	        <div class="col-sm-10">
	          
	        </div>
	        <div class="col-sm-2">
            <!--Se genera alerta para asegurar que se desea regresar-->
            <form>
              <input class="btn btn-light" name="button" type="button" 
              onclick='
              swal({
              title: "¿Seguro que deseas regresar?",
              text: "No podrás deshacer este paso...",
              type: "warning",
              showCancelButton: true,
              cancelButtonText: "Cancelar",
              confirmButtonColor: "#2E8B57",
              confirmButtonText: "Continuar",
              closeOnConfirm: false },
              function(){
              window.location="GeneracionReportes.php";
              });' value="Regresar" />
          </form>

	        </div>
	    </div>
  </footer>
  <script src= "librerias/jquery-3.4.0.min.js"></script>
  <script src= "librerias/bootstrap/js/bootstrap.js"></script>
  <script src= "js/mainRI.js"></script>
  <script src= "librerias/sweetalert.min.js"></script>
</body>
</html>


