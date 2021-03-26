<?php
//****************************************************************************************
//Nombre:         conexion.php
//Objetivos:      Contener una función para generar la conexión a una base de datos
//                predeterminada
//Creado por:     Lázaro Martínez Abraham Josué
//Fecha:          viernes 3 de enero de 2020
//version:        1.0                 
//****************************************************************************************

//se ocupa un objeto PDO para iniciar una conexión con la base de datos
function AbrirBase(){
  //se ocupa un try catch, en caso de haber un error, se atrapa el error
  //y se regresa un mensaje de error
  try{
    return new PDO('mysql:host=desarrollos-web.xyz;dbname=desarr61_businesssoft;charset=utf8', 'desarr61_busines', 'u{6ujTCevc1U');  
  }catch(PDOException $e){
    echo $e->getMessage();
  }
}

?>