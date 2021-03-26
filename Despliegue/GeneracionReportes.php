<!--Pantalla inicial del módulo de generación de reportes-->
<?php
/*
Nombre: GeneracionReportes.php
Objetivo:Presentar a un usuario tipo administrador las dos opciones para la generación de reportes 
Creado por: Perez Romero Verónica
Fecha: 29 de diciembre del 2019
Versión: 1.0
Variables: 
Conexiones: ventanaFechaGR.html
*/
session_start();
if(isset($_SESSION['TipoUsuario'])){
	if ($_SESSION['TipoUsuario']!='A') 
	{;
	    header("location:homeU.php");

	}
}
?>

<!DOCTYPE html>
<html lang="es" >
<head>
	<meta charset="UTF-8">
	<title>Reportes</title>
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
				<hi class="logo">Reportes</hi>
			</div>
			<div class="cabecera__imagen column column--50">
				<img src="img/logoIMSS.png">
			</div>
		</div>
	</header>

	<main class="main">
		<section class="group tipos-reportes">
			<!--Selección entre los dos tipos de reportes que se pueden generar -->
			<h2 class="tipos-reportes__title1">Tipos de reportes</h2>
			<div class="container container--flex">
				<div class="column column--50-25">
					<a href="" class="tipos-reportes__link" role="button" data-toggle="modal" data-target="#ventanaFechaIndividuales"><span class="icon-paciente"></span></a>
					<div class="tipos-reportes__title">Reportes Individuales</div>
				</div>
				<div class="column column--50-25">
					<a href="" class="tipos-reportes__link" data-toggle="modal" data-target="#ventanaFechaGenerales"><span class="icon-pacientes"></span></a>
					<div class="tipos-reportes__title">Reportes generales</div>
				</div>
			</div>
			<!--Despliege de la ventana modal para selección de las fechas inicial y final del reporte que se generará-->
			<?php include("ventanaFechaGR.html") ?>		
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
              window.location="homeA1.php";
              });' value="Regresar" />
          	</form> 
	        </div>
	    </div>
  </footer>
	<script src= "librerias/jquery-3.4.0.min.js"></script>
	<!--script src= "js/jquery-ui.min.js"></script-->
	<script src= "librerias/bootstrap/js/bootstrap.js"></script>
	<script src= "librerias/sweetalert.min.js"></script>
	
</body>
</html>

