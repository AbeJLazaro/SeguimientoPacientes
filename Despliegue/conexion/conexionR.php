<?php 
/*
Nombre: conexionR.php
Objetivo: Crear una conección a la base de datos cuando la función conexionMySql es mandada a llamar 
Fecha: 28 de diciembre del 2019
Versión: 1.0
Declaraciones:
Variables: conectar.
Conexiones: configR.php
Constantes: 
*/

require 'configR.php';
/*
Funcion conexionMySql: 
	No recibe ningun parametro.
	Realiza la conexión a la base de datos y manda un mensaje de error so no es posible 
*/
function conexionMySql()
{
	$conectar = mysqli_connect(SERVER,USER,PASS,BD);
	if (!$conectar) {
		echo "No se pudo conectar a la base de datos ".mysqli_connect_error();
	}
	
	mysqli_set_charset($conectar,"utf8");
	return $conectar;
}

conexionMySql();

?>