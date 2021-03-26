<?php
/* 
Nombre:cambia_pass
Objetivo:Validar que el usuario este en la BD y verificar que la contraseña sea correcta
Creado Por: BusinessSoft, Luis GAmiño Gonazles, Erick Ivan Guerra Silva
Fecha:02/01/2020
Versión:1
Declaraciones:function logear()
Variables: $conexion1, $consulta1, $matricula, $qu, $errorsA, $registro, $matricula, $matricula1, $contraseña1, $error, $errors, $Nombre, $q2, $consulta2, $array2, $conexion, $matriculaA, $clave, $matricula1, $claveu1, $comclaveu1, $claveunew1, $array1, $array 
Conexiones:conexion.php, conexion1.php
Constantes:
Cuerpo del programa
*/

function logear()
	{
		
		require 'conexion/conexion1.php';
		require 'conexion/conexion.php';
		$conexion1=AbrirBase();
		$errorsA=0;
		$Matricula = mysqli_real_escape_string($conexion,$_POST['usuario']);/*Con el metodo POST se guarda lo recibido en la variable matricula*/
		$clave = md5(mysqli_real_escape_string($conexion,$_POST['clave']));/*Con el metodo POST se guarda lo recibido en la variable clave*/
		/*Generamos la setencia select para saber si el usuario se encutra en la base de datos*/
		$qu = "SELECT COUNT(*) as contar1 from MedicoEnfermera where Matricula ='$Matricula'";
		/*se verifica que la matricula insertada se encuentre en la base de datos*/
		$consulta1 = mysqli_query($conexion,$qu);
		$array1 = mysqli_fetch_array($consulta1);
		if ($array1['contar1']>0) { /*se accede si la matricula esta en la base de datos */
			$errorsA=1;
			/*Generamos la setencia select para saber si el usuario y la contraseña se encutra en la base de datos*/
			$q = "SELECT COUNT(*) as contar from MedicoEnfermera where Matricula ='$Matricula' and Contrasena = '$clave'"; 
			/*se compruba si la contraseña es correcta*/
			$consulta = mysqli_query($conexion,$q);
			$array = mysqli_fetch_array($consulta);
			if ($array['contar']>0){ /*si la contraseña es correcta se accede*/
				/*Generamos la setencia select para Saber el tipo de usuario que ingreso al sistema UP-14 y de esa manera enviarlo al home correspondiente*/
				$q2 = "SELECT COUNT(*) as contar2 from MedicoEnfermera where Matricula ='$Matricula' and Contrasena = '$clave' and TipoUsuario='A'";
					/*se verifica el tipo de usuario*/ 
				$consulta2 = mysqli_query($conexion,$q2);
				$array2 = mysqli_fetch_array($consulta2);
				$SELECT= $conexion1->prepare("SELECT MedicoEnfermera_id,Nombre,TipoUsuario From MedicoEnfermera WHERE Matricula=:Matricula");
				$SELECT->bindParam("Matricula",$Matricula,PDO::PARAM_STR);
				$SELECT->execute();
				$registro=$SELECT->fetch(PDO::PARAM_STR);
				session_start();
				$_SESSION['MedicoEnfermera_id']=$registro['MedicoEnfermera_id'];
				$_SESSION['Nombre']=$registro['Nombre'];
				$_SESSION['TipoUsuario']=$registro['TipoUsuario'];

				if ($array2['contar2']>0){/*se accede si ees un administrador*/
					
					header("location: homeA1.php");
				}
				else{
					/*se accede si no es administrador*/
					header("location: homeU.php");
				}

			}else{
				/*Se manda un error si la contraseña es incorrecta*/
				$errors= "Contraseña Incorrecta";

				
			}
		}else{
			/*Se manda un error si la matricula es incorrecta*/
			$errors= "Matricula no encontrado";
		}	
		return array($errors,$errorsA);
	}
function resultBlock($errors){
		if(count($errors) > 0)
		{
			echo "<div id='error' class='alert alert-Danger' role='alert'>
			<a href='#' onclick=\"showHide('error');\">Errores</a>
			<ul>";
			foreach($errors as $error)
			{
				echo "<li>".$error."</li>";
			}
			echo "</ul>";
			echo "</div>";
		}
	}
function cambia(){/* esta funcion ayuada a que el usuaio recupere su contraseña*/
require 'conexion/conexion1.php';

$errorsA=0;
/*declaracion de varaibles */
$matriculaA = mysqli_real_escape_string($conexion,$_POST['matricula']);/*Con el metodo POST se guarda lo recibido en la variable matricula*/
$clave = md5(mysqli_real_escape_string($conexion,$_POST['contraseña1']));/*Con el metodo POST se guarda lo recibido en la variable contraseña1*/
$matricula1 = mysqli_real_escape_string($conexion,$_POST['matricula1']);/*Con el metodo POST se guarda lo recibido en la variable matricula1*/
$claveu1 = md5(mysqli_real_escape_string($conexion,$_POST['claveu']));/*Con el metodo POST se guarda lo recibido en la variable claveu1*/
$comclaveu1 = mysqli_real_escape_string($conexion,$_POST['claveu']);/*Con el metodo POST se guarda lo recibido en la variable comclaveu1*/
$claveunew1 = md5(mysqli_real_escape_string($conexion,$_POST['claveunew']));/*Con el metodo POST se guarda lo recibido en la variable claveunew1*/
/*se hace una consulta de los datos ingresados para saber si los datos son de un administrador */
$q = "SELECT COUNT(*) as contar from MedicoEnfermera where Matricula ='$matriculaA' and Contrasena = '$clave' and TipoUsuario = 'A'";
$consulta = mysqli_query($conexion,$q);
$array = mysqli_fetch_array($consulta);

if ($array['contar']>0){ /* se accede si los datos son de un Administrador*/
	$errorsA="1";

	$q1 = "SELECT COUNT(*) as contar1 from MedicoEnfermera where Matricula ='$matricula1'";
		/*se verifica que la matricula insertada se encuentre en la base de datos */ 
	$consulta1 = mysqli_query($conexion,$q1);
	$array1 = mysqli_fetch_array($consulta1);
	if ($array1['contar1']>0) {
		$errorsA="2";
		/*requisitos de la nueva contraseña */
		 if (strlen($comclaveu1)<5){
		 	/*verfica que la clave no puede ser menor a cinco caracteres */
			$errors ="La contraseña debe tener al menos 5 caracteres";
		}
   		else if(strlen($comclaveu1) > 16){
   			/*verifica que la clave no puede ser mayor a 16 caracteres*/
      		$errors ="La contraseña no puede tener más de 16 caracteres";
   		}
		else if (!preg_match('`[a-z]`',$comclaveu1)){
			/*verifica que la clave tenga una letra minuscula*/
      		$errors = "La clave debe tener al menos una letra minúscula";
   		}
   		else if (!preg_match('`[A-Z]`',$comclaveu1)){
   			/*verifica que la clave tenga una letra mayuscula*/
      		$errors ="La clave debe tener al menos una letra mayúscula";
        }
	
   		else if (!preg_match('`[0-9]`',$comclaveu1)){
   			/*verifica que la clave tenga un numero*/
   			$errors = "La clave debe tener al menos un caracter numérico";
   		}

		else{
		if ($claveu1 == $claveunew1) {	/* se valida si las contraseñas nuevas son iguales*/		
			$query = "UPDATE MedicoEnfermera SET Contrasena = '$claveu1' WHERE Matricula = '$matricula1'";/*se inserta la contraseña nueva en la base de datos */
			$resultado=$conexion->query($query);
			if ($resultado) {
				/*se regresa al login para que el usuario pueda ingresar al sistema */
				header("location: login.php");
			}
			else{
				/*alerta que se manda cuando no se pudó cambiar la clave*/
				$errors = "ocurrio un error";
			}
		}else{		
			/*alerta que se manda cuando las claves son diferentes*/
			$errors = "Contraseñas diferentes";

		}
		}

	}
	else{
		/*alerta que se manda cuando no se encuntra la matricula*/
		$errors = "Matricula del usuario no encontrada";
		
			
	}
}else{
	/*alerta que se manda cuando no se encuntra la matricula o contraseña del administrador estan mal*/
	$errors = "Matricula o contraseña del administrador es erronea";
	
}

return array($errors,$errorsA);
}



?>