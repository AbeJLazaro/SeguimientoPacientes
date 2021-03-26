<?php
/*
Nombre: correo.php
Objetivo:Notificar mediante un correo a los pacientes que no han acudido a una cita programada
Creado por: Perez Romero Verónica
Fecha: 2 de enero del 2020
Versión: 1.0
Declaraciones:
Variables: mysqli, sql, resultado, row, hoy, mail.
Conexiones: base de datos.
Constantes: 
*/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'librerias/correo/Exception.php';
require 'librerias/correo/PHPMailer.php';
require 'librerias/correo/SMTP.php';
require 'conexion/conexionR.php';

$mysqli = conexionMySql(); //Conexión a la base de datos
$sql="SELECT Pac.Nombre, Pac.ApPaterno, Pac.ApMaterno, Pac.CorreoElectronico,MAX(Cita.Fecha) AS FechaCITA, Cita.Tipo AS TipoCITA FROM Paciente Pac JOIN Cita Cita ON Pac.Paciente_id = Cita.Paciente_id
WHERE Cita.Fecha>CURRENT_TIMESTAMP AND Pac.CorreoElectronico IS NOT NULL GROUP BY Pac.Paciente_id";
$resultado = $mysqli->query($sql);

$hoy = date("Y-m-d H:i:s");			//Se obtiene la fecha del dia actual
$hoy = date("Y-m-d").' 00:00:00';	//Se concatena con la hora del inicio del día 
$mail = new PHPMailer(true);
try {
	$mail->SMTPDebug = 0;                     
    $mail->isSMTP();                                           
    $mail->Host       = 'smtp.gmail.com';                    
    $mail->SMTPAuth   = true;                                 
    $mail->Username   = 'controlpacientesup14@gmail.com';	// Correo del emisor de correo
    $mail->Password   = 'controlUP14';             // Contraseña del emisor del correo
    $mail->SMTPSecure = 'tls';         
    $mail->Port       = 587;           	// Puerto
	
	
    $mail->setFrom('controlpacientesup14@gmail.com', 'Control de pacientes UP14');	//Correo y nombre que se mostrarán al receptor del correó

    //Ciclo while en el que mientras exista resultados d ela conección a la base de datos se comprobará si tienen una cita activada(que se agendo), si es así se verificará si la fecha de la cita es menor a la fecha actual
	while ($row=$resultado->fetch_assoc()) {
    
		if ($row['TipoCITA']=='D') {
			if ($row['FechaCITA']>$hoy) {
			  //Datos del receptor del correo 
	    	$mail->addAddress($row['CorreoElectronico'], $row['ApPaterno'].' '.$row['ApMaterno'].' '.$row['Nombre']);
	    	//Asumto y cuerpo del correo
		    $mail->Subject = 'Cita medica';
		    $mail->Body    = 'Se le recuerda que debe acudir a su cita para controlar, descartar o confirmar la posibilidad de que tenga diabetes';
			}
		}else{
      if ($row['FechaCITA']>$hoy) {
        //Datos del receptor del correo 
        $mail->addAddress($row['CorreoElectronico'], $row['ApPaterno'].' '.$row['ApMaterno'].' '.$row['Nombre']);
        //Asumto y cuerpo del correo
        $mail->Subject = 'Cita medica';
        $mail->Body    = 'Se le recuerda que debe acudir a su cita para hacer sus estudios medicos';
      }
    }
	}

	$mail->send();
  
  header("location:homeA1.php");
	     
} catch (Exception $e) {
    echo $e->getMessage();
}	



?>