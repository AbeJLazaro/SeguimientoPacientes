<?php
/*
*************************************************************************************************
Nombre: buscar.php		 
Objetivo: Brindar funcionalidad a la barra de búsqueda en la generación de reportes individuales.
Creado por: Oropeza Castañeda Ángel Eduardo
Fecha: 31 de diciembre del 2019
Versión: 1.0
Declaraciones: 
Variables: mysqli, query, q, resultado, salida.
Conexiones: Base de datos e individuales.php
Constantes: 
*************************************************************************************************
*/
    //realizamos la conexión con la base de datos
    include('../conexion/conexionR.php');
    $mysqli = conexionMySql();

    $salida = "";

    //Si hay algún valor en el input text, entramos al if.
    if (isset($_POST['consulta'])) {
        $consulta=$_POST['consulta'];
        $fecha1=$_POST["fechaInicial"];
        $fecha12=$_POST["fechaFinal"];
        $dateTimeI = "'".$fecha1." 00:00:00'";
        $dateTimeF = "'".$fecha12." 23:59:59'";
        if($consulta!='$'){
            //Guardamos el valor escrito en la barra de busqueda
            $q = $mysqli->real_escape_string($_POST['consulta']); 
            //Hacemos una consulta con el valor de $q en el WHERE          
            $query = "SELECT Pac.Paciente_id, Pac.Nombre, Pac.ApPaterno, Pac.ApMaterno, Pac.NSSA, Pac.Calle, Pac.NumeroExterior, Pac.NumeroInterior, Pac.Colonia, Pac.Delegacion, Pac.Observaciones, Pac.CorreoElectronico,
            Cdet.Fecha AS FechaDET, Cdet.Resultado, Cdet.Tipo,
            Rlab.Fecha AS FechaLAB, Rlab.Resultado AS ResultadoLAB,
            Cita.Fecha AS FechaCITA, Cita.Tipo AS TipoCITA,
            Diag.FechaDiagnostico AS FechaDIAG, Diag.CatalogoDiagnostico_id,
            Cdiag.Descripcion,
            Est.NombreEstatus, Est.Estatus_id
            FROM Paciente Pac
            INNER JOIN ConsultaDeteccion Cdet ON Pac.Paciente_id = Cdet.Paciente_id
            LEFT OUTER JOIN ResultadoLaboratorio Rlab ON Pac.Paciente_id = Rlab.Paciente_id
            LEFT OUTER JOIN Cita Cita ON Pac.Paciente_id = Cita.Paciente_id
            LEFT OUTER JOIN Diagnostico Diag ON Pac.Paciente_id = Diag.Paciente_id
            LEFT OUTER JOIN CatalogoDiagnostico Cdiag ON Diag.CatalogoDiagnostico_id = Cdiag.CatalogoDiagnostico_id
            LEFT OUTER JOIN Estatus Est ON Pac.Estatus_id = Est.Estatus_id
            WHERE Cdet.Fecha BETWEEN $dateTimeI AND $dateTimeF AND Cdet.Fecha is not NULL
            
            AND CONCAT(NSSA,' ',ApPaterno,' ',ApMaterno,' ',Nombre) LIKE '%".$q."%' OR CONCAT(Nombre,' ',ApPaterno,' ',ApMaterno) LIKE '%".$q."%'
            GROUP BY Pac.Paciente_id"; 
        } else {
            //SELECT GENERAL CUANDO LA CONSULTA ESTÁ VACÍA
            $query = "SELECT Pac.Paciente_id, Pac.Nombre, Pac.ApPaterno, Pac.ApMaterno, Pac.NSSA, Pac.Calle, Pac.NumeroExterior, Pac.NumeroInterior, Pac.Colonia, Pac.Delegacion, Pac.Observaciones, Pac.CorreoElectronico,
            MAX(Cdet.Fecha) AS FechaDET, Cdet.Resultado, Cdet.Tipo,
            MAX(Rlab.Fecha) AS FechaLAB, Rlab.Resultado AS ResultadoLAB,
            MAX(Cita.Fecha) AS FechaCITA, Cita.Tipo AS TipoCITA,
            MAX(Diag.FechaDiagnostico) AS FechaDIAG, Diag.CatalogoDiagnostico_id,
            Cdiag.Descripcion,
            Est.NombreEstatus, Est.Estatus_id
            FROM Paciente Pac
            INNER JOIN ConsultaDeteccion Cdet ON Pac.Paciente_id = Cdet.Paciente_id
            LEFT OUTER JOIN ResultadoLaboratorio Rlab ON Pac.Paciente_id = Rlab.Paciente_id
            LEFT OUTER JOIN Cita Cita ON Pac.Paciente_id = Cita.Paciente_id
            LEFT OUTER JOIN Diagnostico Diag ON Pac.Paciente_id = Diag.Paciente_id
            LEFT OUTER JOIN CatalogoDiagnostico Cdiag ON Diag.CatalogoDiagnostico_id = Cdiag.CatalogoDiagnostico_id
            LEFT OUTER JOIN Estatus Est ON Pac.Estatus_id = Est.Estatus_id
            WHERE Cdet.Fecha BETWEEN $dateTimeI AND $dateTimeF
            GROUP BY Pac.Paciente_id
            ORDER BY Paciente_id DESC";
        }

    }  
    
    $resultado = $mysqli->query($query);
    
    //Si hay contenido en la base de datos, entramos al condicional y estructuramos
    //la tabla. 
    if($resultado->num_rows > 0){
        $salida=" 
        <div class='row'>
        <div class='table-responsive'>
          <table id='tabla_id' class='table table-bordered table-sm' style='margin-left: 12px;'>
            <thead class='thead-light'>
              <tr>
                  
                  <th rowspan='2' scope='col' style='text-align:center'>Nombre</th>
                  <th rowspan='2' scope='col' style='text-align:center'>Afiliacion</th>
                  <th rowspan='1' scope='col' style='text-align:center'>Domicilio</th>
                  <th rowspan='2' scope='col' style='text-align:center'>Correo electrónico</th>
                  <th rowspan='2' scope='col' style='text-align:center'>Fecha de detección</th>
                  <th colspan='2' scope='col' style='text-align:center'>Resultado de la detección (UP14)</th>
                  <th rowspan='2' scope='col' style='text-align:center'>Fecha de estudio laboratorio clínico</th>
                  <th rowspan='2' scope='col' style='text-align:center'>Resultado de laboratorio clínico</th>
                  <th rowspan='2' scope='col' style='text-align:center'>Fecha atención médico familiar</th>
                  <th colspan='2' scope='col' style='text-align:center'>Fecha del diagnóstico final</th>
                  <th rowspan='2' scope='col' style='text-align:center'>Observaciones</th> 
                  <th rowspan='2' scope='col' style='text-align:center'>Estatus</th>
                  <th rowspan='2' scope='col' style='text-align:center'>PDF</th>
                  

                <tr>
                    <th scope='col' style='text-align:center'></th>
                    <th scope='col' style='text-align:center'>Ayunas</th>
                    <th scope='col' style='text-align:center'>Casual</th>
                    <th scope='col' style='text-align:center'>Confirmado</th>
                    <th scope='col' style='text-align:center'>Descartado</th>
                </tr>
                </thead>
                <tbody>";
        
        //Concatenamos el html de los contenidos <td> rellenándolos con la 
        //base de dat0s
        while($fila = $resultado->fetch_assoc()){ 
            $salida.="<tr>
            
            <td rowspan='2' scope='col' align='center'><strong>".$fila['ApPaterno']." ".$fila['ApMaterno']." ".$fila['Nombre']."<strong></td>
            <td rowspan='2' scope='col'>".$fila['NSSA']."</td>
            <td scope='col'>".$fila['Calle']." ".$fila['NumeroExterior']." ".$fila['NumeroInterior']." ".$fila['Colonia']." ".$fila['Delegacion']."</td>
            <td rowspan='2' scope='col'>".$fila['CorreoElectronico']."</td>
            <td rowspan='2' scope='col'>".$fila['FechaDET']."</td>";
            if( $fila['Tipo'] == 'Ayuno' ){ //Colocamos el valor en la correspondiente columna de ayuno/casual
                $salida.="<td rowspan='2' scope='col' align='center'>".$fila['Resultado']."</td>
                <td rowspan='2' scope='col'></td>";
            } else{
                $salida.="<td rowspan='2' scope='col'></td>
                <td rowspan='2' scope='col' align='center'>".$fila['Resultado']."</td>";
            }
            $salida.="<td rowspan='2' scope='col'>".$fila['FechaLAB']."</td>
            <td rowspan='2' scope='col' align='center'>".$fila['ResultadoLAB']."</td>";
            if($fila['TipoCITA'] == 'D'){
                $salida.="
                <td rowspan='2' scope='col' align='center'>".$fila['FechaCITA']."</td>";
            } else{
                $salida.="
                <td rowspan='2' scope='col' align='center'></td>";
            }
            if($fila['CatalogoDiagnostico_id'] == 2 or $fila['CatalogoDiagnostico_id'] == 3){ //Acomodamos los valores de paciente confirmado y descartado
                $salida.="
                <td rowspan='2' scope='col' align='center'>".$fila['FechaDIAG']."</td>
                <td rowspan='2' scope='col'></td>";
            } else{
                $salida.="
                <td rowspan='2' scope='col'></td>
                <td rowspan='2' scope='col' align='center'>".$fila['FechaDIAG']."</td>";
            }
            $salida.="
            <td rowspan='2' scope='col'>".$fila['Observaciones']."</td>
            <td rowspan='2' scope='col'><button type='button' class='btn btn-success' value='".$fila['Estatus_id']."' onclick='ir_reporte(".$fila['Estatus_id'].")'>".$fila['NombreEstatus']."</button></td>
            <td rowspan='2' scope='col'><form target='_blank' method='POST' action='pdfIndividual.php'>
                    <input type='hidden' name='NSSA' value='".$fila['NSSA']."'/>
                    <input class='btn btn-default' type='submit' value='PDF'/>
                    </form></td>
            <td rowspan='2' scope='col'></td>
        </tr>
        <tr>
            <td scope='col' align='left'></td>
        </tr>";
        }

        $salida.="</tbody></table></div></div>"; //Cerramos todas las etiquetas html
    
    //Si no hay contenido en la consulta, mostramos el siguiente mensaje
    } else {
        $salida.="Sin coincidencia";
    }

    echo $salida; //Retornamos la cadena que contiene al html de la tabla 

    $mysqli->close();
?>