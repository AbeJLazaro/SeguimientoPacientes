<?php
//****************************************************************************************
//Nombre:         Regreso.php
//Objetivos:      Solo nos regresa el valor de la variable $_SESSION[TipoUsuario]
//                la cual nos va a indicar a que home regresar 
//Creado por:     Lázaro Martínez Abraham Josué
//Fecha:          viernes 3 de enero de 2020
//version:        1.0                 
//****************************************************************************************
//incluye la inicialización de la variable $_SESSION
include('../conexion/global.php');
//regresa el valor de su valor en la llave TipoUsuario
echo $_SESSION['TipoUsuario'];

?>