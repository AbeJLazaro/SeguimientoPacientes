<?php
/*
Nombre: pdfIndividual.php
Objetivo: Generar un archivo en formato PDF que contenga a el paciente con NSSA que se selecciona en la tabla anterior
Creado por: Perez Romero Verónica
Fecha: 30 de diciembre del 2019
Versión: 1.0
Declaraciones:
Variables: NSSA, mysql, sql, resultado, pdf.
Conexiones: base de datos, plantilla.php, conexionR.php
*/
	include 'plantilla.php';			        //Archivo tiene la cabecera y el pie de página del PDF
	include_once 'conexion/conexionR.php';		/*Archivo genera las variable necesarias para la conexión 
										          con la base de datos*/
    
	
	$NSSA=$_POST["NSSA"];				          //Identificador del paciente 
	$mysql = conexionMySql();			           //Conexión a la base de datos
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
					WHERE Pac.NSSA= '$NSSA'";

	$resultado = $mysql->query($sql);

	$pdf = new PDF();          //Se crea un objeto tipo pdf 
	$pdf->AliasNbPages();
	$pdf->AddPage();
	
    //Ciclo while en el que mientras exista resultados de la conección a la base de datos se escribirá la información del cada paciente 
	while ($row = $resultado->fetch_assoc()) {
		$pdf->SetFont('Times','',12);
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
		if( $row['Tipo'] == 'Ayuno' ){
			$pdf->Write(15,utf8_decode('Ayuno:			'.$row['Resultado'].' Casual:N/A'));
        }else{
        	$pdf->Write(15,utf8_decode('Ayuno:N/A 			Casual: '.$row['Resultado']));
        }
        $pdf->Ln(5);
        $pdf->Write(15,utf8_decode('Fecha de laboratorio clínico: '.$row['FechaLAB']));
        $pdf->Ln(5);
        $pdf->Write(15,utf8_decode('Resultado de laboratorio clínico: '.$row['ResultadoLAB']));
        $pdf->Ln(5);
        if($row['TipoCITA'] == 'D'){
        	$pdf->Write(15,utf8_decode('Fecha de atención de médico familiar: '.$row['FechaCITA']));
        } else{
            $pdf->Write(15,utf8_decode('Fecha de atención de médico familiar: ')); 
        }
        $pdf->Ln(5);
        $pdf->Write(15,utf8_decode('Fecha de diagnóstico final'));
        $pdf->Ln(5);
        if($row['CatalogoDiagnostico_id'] == 2 or $row['CatalogoDiagnostico_id'] == 3){
        	$pdf->Write(15,utf8_decode('Confirmado: '.$row['FechaDiagnostico'].'			Descartado:N/A'));
        }else{
        	$pdf->Write(15,utf8_decode('Confirmado:N/A 					Descartado:'.$row['FechaDiagnostico']));
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
	}
	
	$pdf->Output();
?>
