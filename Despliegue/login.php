 <?php
    /* 
Nombre:cambia_pass
Objetivo:Valida si la matricula y la contraseña son del mismo usuario y estas se encuentran en la base de datos para que de esta manera, el usuario pueda acceder al home.
Creado Por: BusinessSoft, Jose Luis Gamiño Gonazles, Erick Ivan Guerra Silva
Fecha:02/01/2020
Versión:1
Declaraciones:
Variables: $error, $errors, $usuario, $Nombre,  $q2, $consulta2, $array2, $conexion, $errorsA 
Conexiones: conexion.php, conexion1.php, loguear.php, homeUphp, homeA1.php
Constantes:
Cuerpo del programa
*/
	require 'conexion/conexion1.php';
	include 'loguear.php';
	$usuario=NULL;
	session_start(); //Iniciar una nueva sesión o reanudar la existente
	$errorsA=0;
	$errors = array();
    
	if(!empty($_SESSION['Nombre']))
    {
       $Nombre = $_SESSION['Nombre'];
         /*Generamos la setencia select para Saber el tipo de usuario que ingreso al sistema UP-14 y de esa manera enviarlo al home correspondiente*/
        $q2 = "SELECT COUNT(*) as contar2 from MedicoEnfermera where Nombre='$Nombre' and TipoUsuario='A'";
                $consulta2 = mysqli_query($conexion,$q2);
                $array2 = mysqli_fetch_array($consulta2);
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
		list($errors[],$errorsA) = logear();//se manda a llamar funcion logear para verificar los datos
		if($errorsA==1){
					$usuario=$_POST['usuario'];//guarda el usuario
				}	
	}

?>

<!DOCTYE html>
<html lang="en" xmlns:th="http://www.thymeleaf.org">>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=deivice-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Inicio de Sesión</title>
    
    <!-- BOOTSTRAP -->
   <!--  hojas de estilo bootstrap  -->
   <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="librerias/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="librerias/bootstrap/css/bootstrap-grid.min.css">
  <link rel="stylesheet" href="librerias/bootstrap/css/bootstrap-reboot.min.css">

    <!-- iconos -->
    
    <!-- accede a nuestro css -->
    <link rel="stylesheet" type="text/css" href="css/login.css" th:href="@{css/login.css}">
  
</head>
    <script src="js/noback.js"></script>

<body>


	<form id="loginform" class="form-horizontal" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
    <div class="modal-dialog text-center">
        <div class="col-sm-8 main-section">
            <div class="modal-content">
                <div class="col-12 ">
                    	<h1> IMSS </h1>
                    	Pacientes UP-14
                </div>   
                <form class="col-12" th:action="@{/login}" method="get">
                    <div class="form-group" >
                        <input type="text" class="form-control" name="usuario" placeholder="Matrícula" value="<?php echo $usuario;?>" required>
                    </div>
                    <div class="form-group" >
                        <input type="password" class="form-control" name="clave" placeholder="Contraseña" required>
                    </div>
                    <button type="submit" class="btn btn-dark"><i class="fas fa-sign-in-alt"></i><span class="icon-login"></span>  Login </button>
	

                </form>
		<?php echo resultBlock($errors); ?>
                <br>
                <div class="col-12 forgot">
                    <a href='cambia_pass.php'>¿Haz olvidado tu contraseña? </a>
                </div>
            </div>
        </div>
    </div>
	</form>
      
</body>
</html>

