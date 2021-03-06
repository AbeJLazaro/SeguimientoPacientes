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
  <title>Buscar Paciente</title>
  <link rel="stylesheet" href="librerias/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="librerias/bootstrap/css/bootstrap-grid.min.css">
  <link rel="stylesheet" href="librerias/bootstrap/css/bootstrap-reboot.min.css">
  <link rel="stylesheet" href="css/main.css">
</head>
<body>
  <div class="container my-5"> 
    <div class="row">
      <div class="col">
        <!--Titulo principal pantalla-->
        <div class="row my-3 mx-5 pt-3">
          <div class="col">
            <h1 class="text-center text-uppercase"> Buscar paciente</h1>
          </div>
        </div>
        <!--Formulario inicial para hacer la busqueda-->
        <form class="mt-5 mb-3">
          <!--NSS + agregado del paciente-->
          <div class="form-group row m-3 aling-items-center align-self-center">
            <label for="NSSA" class="LabelPersonalizadoCampoLargo col-12 col-md-4 col-form-label text-center rounded my-1 text-capitalize">NSS + agregado</label>
            <div class="col-12 col-md-8 my-1 p-0 px-md-3 ">
              <input maxlength="20" type="text" class="form-control" id="NSSA" placeholder="20 caracteres máximo">
              <small >agrega el campo con todo y los guiones</small>
            </div>
          </div>
          <!--Botones de busqueda del paciente-->
          <div class="row justify-content-end m-5">
            <div class="col-auto">
              <div class="btn-group align-self-center" role="group" >
                <button type="button" id="Regresar" class="btn BotonPersonalizado btn-lg">Regresar</button>
                <button type="button" id="Buscar" class="btn BotonPersonalizado btn-lg">Buscar</button>
              </div>
            </div>
          </div>
          <!--Busqueda de datos del paciente si es que existe-->
          <div class="row mx-5">
            <div id="Datos" class="col-12"></div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="librerias/jquery-3.4.0.min.js"></script>
  <script src="librerias/bootstrap/js/bootstrap.min.js"></script>
  <script src="librerias/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="librerias/bootstrap/js/bootstrap.js"></script>
  <script src="js/mainBP.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>
</html>