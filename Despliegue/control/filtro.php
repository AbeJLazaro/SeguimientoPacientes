<?php
/*
*************************************************************************************************
Nombre: filtro.php
Objetivo: Dar funcionalidad a los selectores de filtro y orden para organizar los datos de la manera elegida.
Creado por: Oropeza Castañeda Ángel Eduardo
Fecha: 31 de diciembre del 2019
Versión: 1.0
Declaraciones:
Variables: mysqli, salida, seleccionador, query y resultado.
Conexiones: Con base de datos y individuales.php
Constantes:
*************************************************************************************************
*/

    include('../conexion/conexionR.php');
    $mysqli = conexionMySql();

    $salida = "";
    //Si hay un cambio en los selectores de la página, entramos al if
    if(isset($_POST['sel'])){
        $seleccionador = $_POST['sel']; //Guardamos la elección en una variable
        $fecha1=$_POST["fechaInicial"];
        $fecha12=$_POST["fechaFinal"];
        $dateTimeI = "'".$fecha1." 00:00:00'";
        $dateTimeF = "'".$fecha12." 23:59:59'";
        //De acuerdo al valor del seleccionador (FILTRO/ORDEN) es el tipo de consulta que se realizará
        if( $seleccionador == '0'){ //FILTRO: todos los registros 
            
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
        } else if($seleccionador == '1'){ //FILTRO: diabetes mellitus
            
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
            WHERE Cdet.Fecha BETWEEN $dateTimeI AND $dateTimeF AND Diag.CatalogoDiagnostico_id = 3
            GROUP BY Pac.Paciente_id"; 

        } else if($seleccionador == '2'){ //FILTRO: Prediabetes
            
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
            WHERE Cdet.Fecha BETWEEN $dateTimeI AND $dateTimeF AND Diag.CatalogoDiagnostico_id = 2
            GROUP BY Pac.Paciente_id"; 

        } else if($seleccionador == '3'){ //FILTRO: Cancelado
            
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
            WHERE Cdet.Fecha BETWEEN $dateTimeI AND $dateTimeF AND Diag.CatalogoDiagnostico_id = 5
            GROUP BY Pac.Paciente_id"; 
        } else if($seleccionador == '4'){ //FILTRO: Descartado
            
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
            WHERE Cdet.Fecha BETWEEN $dateTimeI AND $dateTimeF AND Diag.CatalogoDiagnostico_id = 1
            GROUP BY Pac.Paciente_id"; 
        } else if($seleccionador == '5'){ //FILTRO: Sin diagnóstico
            
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
            WHERE Cdet.Fecha BETWEEN $dateTimeI AND $dateTimeF AND Diag.CatalogoDiagnostico_id = 4
            GROUP BY Pac.Paciente_id"; 
            
        } else if($seleccionador == '6'){ //ORDEN: Ultimos registros
            
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
            
        
        }else if($seleccionador == '7'){ //ORDEN: Nombre(A-Z)
            
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
                    ORDER BY ApPaterno";
        } else if($seleccionador == '8'){ //ORDEN: Nombre(Z-A)
            
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
                    ORDER BY ApPaterno DESC";
        } else if($seleccionador == '9'){ //ORDEN: Fecha(ascendente)
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
                    ORDER BY Cdet.Fecha";

        } else if($seleccionador == '10'){ //ORDEN: Fecha(descendente)
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
                    ORDER BY Cdet.Fecha DESC"; 

        }
    }


    $resultado = $mysqli->query($query);

    //Si hay contenido en la consulta, entramos al if y formamos la estructura 
    //HTML de la tabla.
    if($resultado->num_rows > 0){
        $salida="
        <div class='row'>
        <div class='table-responsive'>
        <table id='tabla_id' class='table table-bordered table-sm' style='margin-left: 12px;'
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
                
                </tr>

                <tr>
                    <th scope='col' style='text-align:center'></th>
                    <th scope='col' style='text-align:center'>Ayunas</th>
                    <th scope='col' style='text-align:center'>Casual</th>
                    <th scope='col' style='text-align:center'>Confirmado</th>
                    <th scope='col' style='text-align:center'>Descartado</th>
                </tr>
                </thead>
                <tbody>";

        //Concatenamos en la variable salida los valores de la BD en estructura HTML con php. 
        while($fila = $resultado->fetch_assoc()){
            $salida.="<tr>
            
            <td rowspan='2' scope='col' align='center'><strong>".$fila['ApPaterno']." ".$fila['ApMaterno']." ".$fila['Nombre']."<strong></td>
            <td rowspan='2' scope='col'>".$fila['NSSA']."</td>
            <td scope='col'>".$fila['Calle']." ".$fila['NumeroExterior']." ".$fila['NumeroInterior']." ".$fila['Colonia']." ".$fila['Delegacion']."</td>
            <td rowspan='2' scope='col'>".$fila['CorreoElectronico']."</td>
            <td rowspan='2' scope='col'>".$fila['FechaDET']."</td>";
            if( $fila['Tipo'] == 'Ayuno' ){ //Coloca en la columna correspondiente a Ayuno/Casual
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
            if($fila['CatalogoDiagnostico_id'] == 2 or $fila['CatalogoDiagnostico_id'] == 3){ //Coloca en la correspondiente columna de pacientes confirmados y descartados
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
        </tr>
        <tr>
            <td scope='col' align='left'></td>
        </tr>";
        }

        $salida.="</tbody></table></div></div>"; //Cerramos etiquetas HTML
    
    // Si no hay contenido en la consulta, enviamos el siguiente mensaje
    } else {
        $salida.="Sin coincidencia";
    }

    echo $salida; ///Retornamos el html o "sin coincidencia"

?> 
