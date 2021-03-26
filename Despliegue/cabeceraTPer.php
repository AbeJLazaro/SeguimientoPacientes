<?php
/*
Nombre: CabeceraTPer.php
Objetivo: Contiene la barra de búsqueda y el botón de regresar 
y aloja la tabla de pacientes
Creado por: Oropeza Castañeda Ángel Eduardo y Perez Romero Verónica
Fecha: 2 de enero del 2020
Versión: 1.0
Declaraciones:
Variables:
Conexiones: tabla_personal.php y mainTper.js
Constantes:
*/

//Validación del tipo de usuario
session_start();
if(isset($_SESSION['TipoUsuario'])){
  if ($_SESSION['TipoUsuario']!='A') 
  {
      header("location:homeU.php");

  }
}
?>
<!DOCTYPE html">
<html lang="es" xml:lang="es">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css">
<link rel="stylesheet" href="css/estilosGR.css">
<link rel="stylesheet" href="css/sweetalert.css">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Personal</title>


</head>

<body>
  <header class="cabecera">
    <div class="container--flex">
      <div class="logo-container column column--50">
        <hi class="logo">Personal</hi>
      </div>
      <div class="cabecera__imagen column column--50">
        <img src="img/logoIMSS.png">
      </div>
    </div>
  </header>

  <nav id="barraNavegacion">
    <div class="row">
      <div class="col-sm-5">
        <label for="caja_busqueda" style="margin: 0px 0px 0px 30px">Buscar: </label>
        <input type="text" name="caja_busqueda" id="caja_busqueda" placeholder="Inserte Nombre/Matrícula" style="margin: 0px 0px 10px 30px" class="form-control"></input>
      </div>
    </div>
  </nav>

  <section>

    <div id="datos">

    </div>

  </section>
   
  <footer>
    <div class=row>
      <div class="col-sm-10">
        
      </div>
      <div class="col-sm-2">
      <!--Se genera alerta para asegurar que se desea regresar-->
        <button type="button" name="Regresar" onclick='
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
              window.location="homeA1.php";
              })' class="btn btn-light">Regresar</button>
      </div>
    </div>
  </footer>



<script src= "librerias/jquery-3.4.0.min.js"></script>
<script src= "librerias/bootstrap/js/bootstrap.js"></script>
<script src= "librerias/sweetalert.min.js"></script>
<script src="js/mainTPer.js"></script>
</body>

</html>