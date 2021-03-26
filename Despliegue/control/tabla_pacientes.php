<?php
/*
*************************************************************************************************
Nombre: tabla_pacientes.php	 
Objetivo: Mostrar a todos los pacientes en una tabla que tenga el NSSA y el nombre del paciente.
Creado por: Oropeza Castañeda Ángel Eduardo 
Fecha: 31 de diciembre del 2019
Versión: 1.0
Declaraciones:
Variables: mysqli, salida, query, resultado y q.
Conexiones: main.js, menu_principal.php
Constantes:
*************************************************************************************************
*/

    include('../conexion/conexionR.php');
    $mysqli = conexionMySql();

    $salida = "";
    
    //SELECT GENERAL CUANDO LA CONSULTA ESTÁ VACÍA
    $query = "SELECT Nombre, ApPaterno, ApMaterno , NSSA
                FROM Paciente
                ORDER BY ApPaterno";

    //SELECT si hay algo en la barra de búsqueda
    if(isset($_POST['consulta'])){
        $q = $mysqli->real_escape_string($_POST['consulta']); //Guardamos la consulta de la barra de busqueda en la variable
        //Hacemos la consulta utilizando el valor de la variable q
        $query = "SELECT Nombre, ApPaterno, ApMaterno , NSSA
                  FROM Paciente     
                  WHERE NSSA LIKE '%".$q."%'";
    } 
    
    $resultado = $mysqli->query($query);
    
    //Si tenemos contenido en la consulta, formamos la estructura de la
    //tabla HTML  
    if($resultado->num_rows > 0){
        $salida=" 
        <div class='row d-flex justify-content-center'>
        <div class='table-responsive'>
          <table id='tabla_id' class='table table-bordered table-hover table' style='width:90%; margin-left: 35px;'>
            <thead class='thead-light'>
              <tr>
                  
                  <th scope='col' style='text-align:center; width:35%;'><strong>NSSA</strong></th>
                  <th scope='col' style='text-align:center; width:65%;'><strong>Nombre</strong></th>
                  
              </tr>
                  
                </thead>
                <tbody>";
        //Rellenamos los valores de la tabla con el contenido de la consulta
        //utilizando html y php
        while($fila = $resultado->fetch_assoc()){
            $salida.="<tr>
            
            <td  scope='col' align='center'><strong>".$fila['NSSA']."<strong></td>
            <td  scope='col'>".$fila['ApPaterno']." ".$fila['ApMaterno']." ".$fila['Nombre']."</td>
                        </tr>";
        }

        $salida.="</tbody></table></div></div>"; //Cerramos las etiquetas html
    
    // Si no hay contenido en la consulta, enviamos el siguiente mensaje
    } else {
        $salida.="Sin coincidencia";
    }

    echo $salida; ///Retornamos el html o "sin coincidencia"

    $mysqli->close();
?>