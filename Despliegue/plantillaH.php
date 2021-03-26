<?php
/*
Nombre: plantillaH.php
Objetivo:Declarar el formato de la cabecera y el pie de página de los documentos PDF de los reportes generales
Fecha: 30 de diciembre del 2019
Versión: 1.0
Declaraciones:
Variables: 
Conexiones: fpdfp.php
Constantes: 
*/
	require 'librerias/fpdf/fpdf.php'; //Archivo con la libreria necesaria para crear el PDF
	
	class PDF extends FPDF
	{
		//Cabecera del PDF
		function Header()
		{
			$this->Image('img/logoIMSS2.png',180,10,20);
			$this->SetFont('Times','B',15);
			$this->Cell(30);
			$this->Cell(120,10,'Reporte General',0,0,'C');

			$this->Ln(20);
		}
		//Pie de página del PDF
		function Footer()
		{
			$this->SetY(-15);
			$this->SetFont('Times','I',8);
			$this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');

		}
	}


?>