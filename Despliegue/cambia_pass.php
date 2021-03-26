<?php
	/* 
Nombre:cambia_pass
Objetivo:Validar los datos que inserta el administrador para poder cambiar la contraseña, además de validar la contraseña que el usuario esta insertando para una mayor seguridad.
Creado Por: BusinessSoft, Jose Luis Gamiño Gonazles, Erick Ivan Guerra Silva
Fecha:02/01/2020
Versión:1
Declaraciones:
Variables: $matricula, $matricula1, $contraseña1, $error, $errors, $Nombre, $q2, $consulta2, $array2, $conexion 
Conexiones:conexion.php, conexion1.php
Constantes:
Cuerpo del programa
*/
	require 'conexion/conexion1.php';
	include 'loguear.php';
	/*variables iniciadas con null para guardar nuevos datos*/
	$matricula=NULL;
	$matricula1=NULL;
	$contraseña1=NULL;
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	$error=array();
	$errors = array();
	if(!empty($_SESSION['Nombre']))
    {
       $Nombre = $_SESSION['Nombre'];
       	/*Generamos la setencia select para Saber el tipo de usuario que ingreso al sistema UP-14 y de esa manera enviarlo al home correspondiente*/
        $q2 = "SELECT COUNT(*) as contar2 from MedicoEnfermera where Nombre='$Nombre' and TipoUsuario='A'";
                $consulta2 = mysqli_query($conexion,$q2);/*se realiza una consulta*/
                $array2 = mysqli_fetch_array($consulta2);/*se guardan los datos de la consulta en un array*/
                if ($array2['contar2']>0){
                    /*Si el usuario que entro al sistema UP-14 es administrador se manda al siguiente home*/
                    header("location: homeA1.php");
                }
                else{
                	/*Si el usuario que entro al sistema UP-14 no es administrador se manda al siguiente home*/
                    header("location: homeU.php");
                }
    }
	if(!empty($_POST))
	{
	if(isset($_POST['login'])){
		/*Aqui regresan los datos que ya estan bien y deja en la pantalla los campos que ya estan correctos*/
	list($errors[],$error)= cambia();
				if($error==1){
					$matricula=$_POST['matricula'];
					$contraseña1=$_POST['contraseña1'];
				}
				if($error==2){
					$matricula=$_POST['matricula'];
					$contraseña1=$_POST['contraseña1'];
					$matricula1=$_POST['matricula1'];

}
			
	
	}
	}

	
?>


<html>
	<head>
		<title>Cambiar Password</title>
		
		<link rel="stylesheet" href="librerias/bootstrap/css/bootstrap.mi.css">
		  <link rel="stylesheet" href="librerias/bootstrap/css/bootstrap-grid.min.css">
 	 <link rel="stylesheet" href="librerias/bootstrap/css/bootstrap.css">
	</head>
	
	<body>
		
		<div class="container">    
		<div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
		<div class="panel panel-info" >
			<div class="panel-heading">
				<div class="panel-title">Cambiar Password</div>
				<div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="login.php">Iniciar Sesi&oacute;n</a></div>
			</div>     
			
			<div style="padding-top:30px" class="panel-body" >
				
				<form id="loginform" class="form-horizontal" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
					
					<div class="form-group">
						<label for="con_password" class="col-md-3 control-label">Matrícula Del Administrador</label>
						<div class="col-md-9">
							<input type="text" class="form-control" name="matricula" placeholder="Matrícula Del Administrador" value="<?php echo $matricula;?>" required>
						</div>
					</div>					
					<div class="form-group">
						<label for="password" class="col-md-3 control-label">Contraseña Del Administrador</label>
						<div class="col-md-9">
							<input type="password" class="form-control" name="contraseña1" placeholder="Contraseña Del Administrador" value="<?php echo $contraseña1;?>" required>
						</div>
					</div>
					

					<div class="form-group">
						<label for="con_password" class="col-md-3 control-label">Matrícula Del Usuario</label>
						<div class="col-md-9">
							<input type="text" class="form-control" name="matricula1" placeholder="Matrícula De Usuario" value="<?php echo $matricula1;?>" required>
						</div>
					</div>
					<div class="form-group">
						<label for="con_password" class="col-md-3 control-label">Nueva Contraseña</label>
						<div class="col-md-9">
							<input type="password" class="form-control" name="claveu" placeholder="Nueva Contraseña" required>
						</div>
					</div>
					
					<div class="form-group">
						<label for="con_password" class="col-md-3 control-label">Confirmar Contraseña</label>
						<div class="col-md-9">
							<input type="password" class="form-control" name="claveunew" placeholder="Confirmar Contraseña" required>
						</div>
					</div>

					<div style="margin-top:10px" class="form-group">
						<div class="col-sm-12 controls">
							<button name="login" id="btn-login" type="submit" class="btn btn-dark">Modificar</a>
						</div>
					</div>   
				</form>
				
				<?php resultBlock($errors); ?>
			</div>                     
		</div>  
		</div>
		</div>
	</body>
</html>	