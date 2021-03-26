<?php 
session_start();
if(!isset($_SESSION['MedicoEnfermera_id'])){
  header("location:login.php");
}?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro de cita</title>
  <!--  hojas de estilo bootstrap  -->
  <link rel="stylesheet" href="librerias/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="librerias/bootstrap/css/bootstrap-grid.min.css">
  <link rel="stylesheet" href="librerias/bootstrap/css/bootstrap-reboot.min.css">
  <!--  hojas de estilo fullcalendar  -->
  <link rel="stylesheet" href="librerias/fullcalendar/core/main.css"/>
  <link rel="stylesheet" href="librerias/fullcalendar/daygrid/main.css"/>
  <!--  hojas de estilo personalizado  -->
  <link rel="stylesheet" href="css/main.css">
</head>
<body>
  <div class="container my-5"> 
    <div class="row">
      <div class="col">
        <!--Titulo principal pantalla-->
        <div class="row my-3 mx-5 pt-3">
          <div class="col">
            <h1 class="text-center text-uppercase">Registro de cita</h1>
          </div>
        </div>
        <!--Formulario-->
        <form class="mt-5 mb-3">
          <!--NSS + agregado del paciente-->
          <div class="form-group row m-3 aling-items-center align-self-center">
            <label for="NSSA" class="LabelPersonalizadoCampoLargo col-12 col-md-4 col-form-label text-center rounded my-1 text-capitalize">NSS + agregado</label>
            <div class="col-12 col-md-8 my-1 p-0 px-md-3">
              <input maxlength="20" type="text" class="form-control" name="NSSA" id="NSSA" placeholder="20 caracteres máximo" >
              <small >agrega el campo con todo y los guiones</small>
            </div>
          </div>
          <!--Fecha de cita-->
          <div class="form-group row m-3 aling-items-center align-self-center">
            <label for="FechaCita" class="LabelPersonalizadoCampoLargo col-12 col-md-4 col-form-label text-center rounded my-1 text-capitalize">Fecha</label>
            <div class="col-12 col-md-8 my-1 p-0 px-md-3 ">
              <input type="date" class="form-control col-form-label-lg" name="FechaCita" id="FechaCita">
            </div>
          </div>
          <!--Botones de opciones-->
          <div class="row justify-content-end m-5">
            <div class="col-auto">
              <div class="btn-group align-self-center" role="group" >
                <button type="button" id="Regresar" class="btn BotonPersonalizado btn-lg">Regresar</button>
                <button type="button" id="Guardar" class="btn BotonPersonalizado btn-lg" >Guardar</button>
              </div>
            </div>
          </div>
          <!--  calendario  -->
          <div class="row justify-content-center m-5">
            <div class="col">
              <div id="Calendario"></div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!--  archivos javascript jquery  -->
  <script src="librerias/jquery-3.4.0.min.js"></script>
  <!--  archivos javascript bootstrap  -->
  <script src="librerias/bootstrap/js/bootstrap.min.js"></script>
  <script src="librerias/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="librerias/bootstrap/js/bootstrap.js"></script>
  <!--  archivos javascript personalizado  -->
  <script src="js/mainRC.js"></script>
  <!--  archivos javascript sweetalert  -->
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <!--  archivos javascript fullcalendar  -->
  <script src='librerias/fullcalendar/core/main.js'></script>
  <script src='librerias/fullcalendar/daygrid/main.js'></script>
  <script src='librerias/fullcalendar/core/locales-all.min.js'></script>
  <script src='js/mainCalendar.js'></script>
</body>
</html>