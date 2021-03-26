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
  <title>Glucosa de detección</title>
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
            <h1 class="text-center text-uppercase"> Glucosa de detección</h1>
          </div>
        </div>
        <form class="mt-5">
          <!--label para registrar la cantidad de glucosa en la deteccion-->
          <div class="form-group row m-5 aling-items-center align-self-center">
            <label for="GlucosaDeteccion" class="LabelPersonalizadoCampoLargo col-12 col-md-4 col-form-label text-center rounded my-1 text-capitalize">Glucosa</label>
            <div class="col-12 col-md-8 my-1 p-0 px-md-3 ">
              <input maxlength="5" type="number" class="form-control" id="GlucosaDeteccion" placeholder="">
            </div>
          </div>
          <!--tipo de deteccion, ayunas o no ayunas-->
          <div class="form-group col m-5 aling-items-center align-self-center">
            <div class="row">
              <div class="input-group col-6 justify-content-md-center">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <input type="radio" aria-label="Large" id="Ayuno" name="TipoDeteccion" checked="" value="Ayuno">
                  </div>
                </div>
                <label class="form-check-label col-form-label-lg border rounded px-3" for="Ayuno">Ayuno</label>
              </div>
              <div class="input-group col-6 justify-content-md-center">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <input type="radio" aria-label="Large" id="NoAyuno" name="TipoDeteccion" value="No ayuno">
                  </div>
                </div>
                <label class="form-check-label col-form-label-lg border rounded px-3" for="NoAyuno">No Ayuno</label>
              </div>
            </div>
          </div>
          <!--Botones finales-->
          <div class="row justify-content-end m-5">
            <div class="col-auto">
              <div class="btn-group align-self-center" role="group" >
                <button type="button" id="Borrar" class="btn BotonPersonalizado btn-lg">Borrar</button>
                <button type="button" id="Regresar" class="btn BotonPersonalizado btn-lg">Regresar</button>
                <button type="button" id="Guardar" class="btn BotonPersonalizado btn-lg">Guardar</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="librerias/jquery-3.4.0.min.js"></script>
  <script src="librerias/bootstrap/js/bootstrap.min.js"></script>
  <script src="librerias/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="librerias/bootstrap/js/bootstrap.js"></script>
  <script src="js/mainGD.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>
</html>