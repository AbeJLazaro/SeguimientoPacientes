<?php
/*
Nombre: pdfGeneral.php
Objetivo: Generar un archivo en formato PDF que contenga a todos los pacientes que compartan el id_estatus que se eligió previamente
Creado por: Perez Romero Verónica
Fecha: 30 de diciembre del 2019
Versión: 1.0
Declaraciones:
Variables: fecha2, fecha22, tipoGeneral, dateTimeI, dateTimeF, myqli, sql, resultado, pdf, contador.
Conexiones: base de datos, plantillaH.php, conexionR.php
*/
    
	include 'plantillaH.php';				//Archivo tiene la cabecera y el pie de página del PDF
	include_once 'conexion/conexionR.php';			/*Archivo genera las variable necesarias para la conexión 
											con la base de datos*/
	
	$fecha2=$_POST["fechaInicial"];			//Fecha inicial para reporte general
	$fecha22=$_POST["fechaFinal"];			//Fecha final para reporte general
	$tipoGeneral=$_POST["tipoGeneral"];		/*Tipo de reporte que se quiere generar 1=Pacientes pendientes de 											estudio de laboratorio, 2=Pacientes pendientes de diagnóstico y 
											3=Pacientes con diagnóstico final*/
	$dateTimeI = "'".$fecha2." 00:00:00'";  //Se concatena fecha inicial con la hora inicial 
	$dateTimeF = "'".$fecha22." 23:59:59'";	//Se concatena fecha final con la hora final 
	$mysqli = conexionMySql();				//Conexión a la base de datos

	$sql="SELECT Pac.Paciente_id, Pac.Nombre, Pac.ApPaterno, Pac.ApMaterno, Pac.NSSA, Pac.Calle, Pac.NumeroExterior, Pac.NumeroInterior, Pac.Colonia, Pac.Delegacion, Pac.Observaciones, Pac.CorreoElectronico, 
                            Cdet.Fecha, Cdet.Resultado, Cdet.Tipo,
                            Rlab.Fecha AS FechaLAB, Rlab.Resultado AS ResultadoLAB,
                            Cita.Fecha AS FechaCITA, Cita.Tipo AS TipoCITA,Cita.CitaAnterior_id,
                            Cita2.Fecha AS FechaCitaAnterior, Cita2.Tipo AS TipoCitaAnterior,   
                            Cita2.Observaciones AS ObservacionesCITA, Cita2.MedicoEnfermera_id,
                            MedicEnfer.Nombre AS NombreME, MedicEnfer.ApMaterno AS ApMaternoME, MedicEnfer.ApPaterno AS ApPaternoME,
                            Diag.FechaDiagnostico, Diag.CatalogoDiagnostico_id,
                            Cdiag.Descripcion,
                            Est.NombreEstatus, Est.Estatus_id
                    FROM Paciente Pac
                    LEFT OUTER JOIN ConsultaDeteccion Cdet ON Pac.Paciente_id = Cdet.Paciente_id
                    LEFT OUTER JOIN ResultadoLaboratorio Rlab ON Pac.Paciente_id = Rlab.Paciente_id
                    LEFT OUTER JOIN Cita Cita ON Pac.Paciente_id = Cita.Paciente_id
                    LEFT OUTER JOIN Cita Cita2 ON Cita.CitaAnterior_id = Cita2.Cita_id
                    LEFT OUTER JOIN MedicoEnfermera MedicEnfer ON MedicEnfer.MedicoEnfermera_id = Cita2.MedicoEnfermera_id
                    LEFT OUTER JOIN Diagnostico Diag ON Pac.Paciente_id = Diag.Paciente_id
                    LEFT OUTER JOIN CatalogoDiagnostico Cdiag ON Diag.CatalogoDiagnostico_id = Cdiag.CatalogoDiagnostico_id
                    LEFT OUTER JOIN Estatus Est ON Pac.Estatus_id = Est.Estatus_id
                    WHERE Est.Estatus_id= $tipoGeneral 
                    AND Cdet.Fecha BETWEEN $dateTimeI AND $dateTimeF";

	$resultado = $mysqli->query($sql);

    $pdf = new PDF();                       
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $contador = 1;

    //Condicional IF en el cual si el resultado de la conexión a la base de datos es igual a 0 escribirá en el documento que no hay coincidenciad y si es diferente a 0 escribirá en el documento de cada paciente 
    if ($resultado->num_rows == 0) {
        $pdf->SetFont('Times','',12);
        $pdf->Cell(15,6,'No hay coincidencias',0,0,'L',0);
    } else {
        while ($row = $resultado->fetch_assoc())
        {
            $pdf->SetFont('Times','',12);
            $pdf->Write(15,'No. '.$contador);
            $pdf->Ln(5);
            $pdf->Write(15,utf8_decode('Nombre: '.$row['ApPaterno'].' '.$row['ApMaterno'].' '.$row['Nombre']));
            $pdf->Ln(5);
            $pdf->Write(15,utf8_decode('Afiliación: '.$row['NSSA']));
            $pdf->Ln(5);
            $pdf->Write(15,utf8_decode('Domicilio: '.$row['Calle'].' '.$row['NumeroExterior'].' '.$row['NumeroInterior'].' '.$row['Colonia'].' '.$row['Delegacion']));
            $pdf->Ln(5);
            $pdf->Write(15,utf8_decode('Correo electronico: '.$row['CorreoElectronico']));
            $pdf->Ln(5);
            $pdf->Write(15,utf8_decode('Fecha de detección: '.$row['Fecha']));
            $pdf->Ln(5);
            $pdf->Write(15,utf8_decode('Resultado de detección'));
            $pdf->Ln(5);
            if( $row['Tipo'] == 'Ayuno' )
            {
                $pdf->Write(15,utf8_decode('Ayuno:          '.$row['Resultado'].' Casual:N/A'));
            }else
            {
                $pdf->Write(15,utf8_decode('Ayuno:N/A           Casual: '.$row['Resultado']));
            }
            $pdf->Ln(5);
            $pdf->Write(15,utf8_decode('Fecha de laboratorio clínico: '.$row['FechaLAB']));
            $pdf->Ln(5);
            $pdf->Write(15,utf8_decode('Resultado de laboratorio clínico: '.$row['ResultadoLAB']));
            $pdf->Ln(5);
            if($row['TipoCITA'] == 'D')
            {
                $pdf->Write(15,utf8_decode('Fecha de atención de médico familiar: '.$row['FechaCITA']));
            } else
            {
                $pdf->Write(15,utf8_decode('Fecha de atención de médico familiar: ')); 
            }
            $pdf->Ln(5);
            $pdf->Write(15,utf8_decode('Fecha de diagnóstico final'));
            $pdf->Ln(5);
            if($row['CatalogoDiagnostico_id'] == 2 or $row['CatalogoDiagnostico_id'] == 3)
            {
                $pdf->Write(15,utf8_decode('Confirmado: '.$row['FechaDiagnostico'].'            Descartado:N/A'));
            }else
            {
                $pdf->Write(15,utf8_decode('Confirmado:N/A                  Descartado:'.$row['FechaDiagnostico']));
            }
            $pdf->Ln(5);
            $pdf->Write(15,utf8_decode('Observaciones: '.$row['Observaciones']));
            $pdf->Ln(8);
            $pdf->SetFont('Times','B',14);
            $pdf->Write(15,'Consulta Anterior');
            $pdf->Ln(5);
            $pdf->SetFont('Times','',12);
            $pdf->Write(15,utf8_decode('Fecha de la cita: '.$row['FechaCitaAnterior']));
            $pdf->Ln(5);
            $pdf->Write(15,utf8_decode('Tipo de cita: '.$row['TipoCitaAnterior']));
            $pdf->Ln(5);
            $pdf->Write(15,utf8_decode('Médico/Enfermero(a)'.$row['NombreME'].' '.$row['ApPaternoME'].' '.$row['ApMaternoME']));
            $pdf->Ln(5);
            $pdf->Write(15,utf8_decode('Observaciones de la cita: '.$row['ObservacionesCITA']));
            $pdf->Ln(10);
            $contador++;
       }
    }
	$pdf->Output();
?>