<?php 
//****************************************************************************************
//Nombre:         calendario.php
//Objetivos:      Genera un mensaje en formato JSON que sirve para la inicialización y 
//                visualización de los calendarios en las pantallas de Citas.
//Creado por:     Lázaro Martínez Abraham Josué
//Fecha:          viernes 3 de enero de 2020
//version:        1.0                 
//****************************************************************************************
  //se especifica el tipo de contenido que regresa el archivo php
  header("Content-Type: application/json");
  //Se llama al archivo conexion.php que contiene la funcion para conectar con la base
  //se datos
  include('../conexion/conexion.php');
  $pdo=AbrirBase();
  //se hace un select para encontrar los usuarios y las fechas de sus ultimas citas
  //se hace con un Join de una tabla "Color" para ponerle color a las etiquetas
  //en el calendario
  $select=$pdo->prepare("SELECT NSSA as title,MAX(Fecha) as start,Color as color, allDay
                        FROM Cita c
                        JOIN Paciente p
                        ON p.Paciente_id=c.Paciente_id
                        JOIN Color co 
                        ON co.Tipo=c.Tipo
                        GROUP BY NSSA");
  //se ejecuta la sentencia select
  $select->execute();
  //se guardan todos los resultados en la variable $resultado
  $resultado=$select->fetchAll(PDO::FETCH_ASSOC);
  //se regresa el mensaje en forma se JSON
  echo json_encode($resultado);
?>