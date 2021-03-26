<?php
/*
Nombre: individualesR.php
Objetivo: Contiene la barra de búsqueda y el botón de regresar. Aloja
el contenido principal en forma de tabla, de los pacientes que se desea
generar un reporte individual.
Creado por: Oropeza Castañeda Ángel Eduardo y Perez Romero Verónica
Fecha: 30 de diciembre del 2019
Versión: 1.0
Declaraciones:
Variables: fecha1, fecha12
Conexiones: buscar.php, filtro.php y mainRI.js
Constantes:
*/

//Verifica que el usuario sea tipo A [administrador]
session_start();
if(isset($_SESSION['TipoUsuario'])){
  if ($_SESSION['TipoUsuario']!='A') 
  {
      header("location:homeU.php");

  }
}
$fecha1=$_POST["fecha1"];     //Fecha inicial para reporte individual
$fecha12=$_POST["fecha12"];   //Fecha final para reporte individual

?>
<!DOCTYPE html>
<html lang="es" >
<head>
  <meta charset="UTF-8">
  <title>Reportes Individuales</title>
  <meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0, maximum-scale=3.0, minimum-scale=1.0">
  
  
  <link rel="stylesheet" href="librerias/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="css/estilosGR.css">
  <link rel="stylesheet" href="css/stylesGR.css" >
  <link rel="stylesheet" href="css/sweetalert.css">
  
  
</head>
<body>
  <header class="cabecera">
    <div class="container--flex">
      <div class="logo-container column column--50">
        <hi class="logo">Reportes Individuales</hi>
      </div>
      <div class="cabecera__imagen column column--50">
        <img src="img/logoIMSS.png">
      </div>
    </div>
  </header>

  <main class="main">
    <nav id="barraNavegacion">
    <div class="row">
      <div class="col-sm-5">
        <label for="caja_busqueda" style="margin: 0px 0px 0px 10px">Buscar: </label>
        <input type="text" name="caja_busqueda" id="caja_busqueda" placeholder="Inserte Nombre/Afiliación" style="margin: 0px 0px 15px 12px" class="form-control"></input>
      </div>
  
      <div class="col-sm-5">
      <label for="filtro" style="margin: 0px 0px 0px 10px">Filtrar: </label>
        <select class="form-control-sm" name="filtro" id="filtro" default="0">
            <option value="0">Todos</option>
            <option value="1">Diabetes mellitus</option>
            <option value="2">Prediabetes</option>
            <option value="3">Cancelado</option>
            <option value="4">Descartado</option>
            <option value="5">Sin diagnóstico</option>
        </select>  
        
        <span>Ordenar:</span>
        <select class="form-control-sm" name="ordenar">
          <option value="6">Ultimos registros</option>
          <option value="7">Nombre (A-Z)</option>
          <option value="8">Nombre (Z-A)</option>
          <option value="9">Fecha (Ascendente)</option>
          <option value="10">Fecha (Descendente)</option>
        </select>
      </div>
      <form id="form_Fechas">
          <input type="hidden" name="fechaInicial" value="<?php echo($fecha1); ?>">
          <input type="hidden" name="fechaFinal" value="<?php echo($fecha12); ?>">     
      </form>
      
    </div>
  </nav>

  <section>

    <div id="datos">

    </div>

  </section>
  </main>
  <footer>
    <div class=row>
      <div class="col-sm-11">
        
      </div>
      <div class="col-sm-1">
        <!--Se genera alerta para asegurar que se desea regresar-->
        <form>
              <input class="btn btn-light" name="button" type="button" 
              onclick='
              swal({
              title: "¿Seguro que deseas regresar?",
              text: "No podrás deshacer este paso...",
              type: "warning",
              showCancelButton: true,
              cancelButtonText: "Cancelar",
              confirmButtonColor: "#2E8B57",
              confirmButtonText: "Continuar",
              closeOnConfirm: false },
              function(){
              window.location="GeneracionReportes.php";
              });' value="Regresar" />
          </form>
      </div>
    </div>
  </footer>
  <script src= "librerias/jquery-3.4.0.min.js"></script>
  <script src= "librerias/bootstrap/js/bootstrap.js"></script>
  <script src= "js/mainRI.js"></script>
  <script src= "librerias/sweetalert.min.js"></script>
</body>
</html>
