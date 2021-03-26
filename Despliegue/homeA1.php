  <?php


session_start();
if(!empty($_SESSION['Nombre']))
{
$Nombre = $_SESSION['Nombre'];
}
else{
	header("location: salir.php");
}
if(isset($_SESSION['TipoUsuario'])){
	if ($_SESSION['TipoUsuario']!='A') 
	{
	    echo "<script>alert('Los reportes solo pueden ser generados por administradores');</script>";
	    header("location:homeU.php");

	}
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>Home</title>
	
	<link rel="stylesheet" href="css/new.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/boton.css">


	<script src="js/noback.js"></script>

</head>




<body>
	<h1 align="center"> Proceso de Seguimiento a Sospechosos de Diabetes </h1>

	<div style="float:right;  position: relative; top:-20px"><a class="button"><span class="icon-user"></span><?php echo "$Nombre" ?></a></div>
	<br>
	<br>
	<div style="float:right;  position: relative; top: -30px"><a href="salir.php" class="buton"><span class="icon-arrow-with-circle-left"></span>Cerrar Sesi&oacute;n</a></div>


	<div class="container">
		<div align="center" style=" position: relative; top:20px">
				<img src="img/logo.png" style="width:90px;height:90px;"/><div align="center">
			</div>
		<nav>
			<div align="left">
			<ul id="menu_principal">
				<li>
					<label for="drop-1">
						
						Formularios
						
						<span class="mif-chevron-right mif-2x derecha"></span>
						<span class="mif-expand-more mif-2x derecha"></span>
						<span class=" icon-chevron-small-right"></span>
					</label>
					<input type="checkbox" id="drop-1">

					<ul>
						<li><a href="RegistroPaciente.php">Registrar Paciente</a></li>
						<li><a href="ActualizacionPaciente.php">Actualizar Paciente</a></li>
						<li><a href="BuscarPaciente.php">Buscar Paciente</a></li>
						<li><a href="RegistroCita.php">Registrar Cita</a></li>
						<li><a href="ActualizacionCita.php">Actualizar Cita</a></li>
						<li><a href="ResultadoLaboratorio.php">Agregar Resultados de Laboratorio</a></li>
						<li><a href="RegistroDiagnostico.php">Diagnóstico</a></li>
						<li><a href="RegistroMedicoEnfermera.php">Registrar Personal</a></li>
						<li><a href="ActualizacionMedicoEnfermera.php">Actualizar Personal</a></li>
					</ul>
				</li>


				<li><a href="GeneracionReportes.php">Todos los Reportes</a></li>
				<li><a href="cabeceraTPer.php">Matrículas Registradas</a></li>
				<li><a href="cabeceraTPac.php">Pacientes Registrados</a></li>
				<li><a href="correo.php">Mandar correos</a></li>
			</ul>
		</nav>
		</div>
	</div>

	<script src="js/noback.js"></script>
</body>
</html>