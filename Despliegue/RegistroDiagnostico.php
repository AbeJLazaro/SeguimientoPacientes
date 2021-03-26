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
  <title>Diagnóstico</title>
  <!--  hojas de estilo bootstrap  -->
  <link rel="stylesheet" href="librerias/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="librerias/bootstrap/css/bootstrap-grid.min.css">
  <link rel="stylesheet" href="librerias/bootstrap/css/bootstrap-reboot.min.css">
  <!--  hojas de estilo personalizado  -->
  <link rel="stylesheet" href="css/main.css">
</head>
<body>
  <div class="container my-5"> 
    <div class="row">
      <div class="col">
        <form>
          <!--Titulo Datos personales-->
          <div class="row my-3 mx-5 pt-3">
            <h2>Diagnóstico</h2>
          </div>
          <!--NSS + agregado del paciente-->
          <div class="form-group row m-2 aling-items-center align-self-center">
            <label for="NSSA" class="LabelPersonalizadoCampoLargo col-12 col-md-4 col-form-label text-center rounded my-1 text-capitalize">NSS + agregado</label>
            <div class="col-12 col-md-8 my-1 p-0 px-md-3 ">
              <input maxlength="20" type="text" class="form-control" id="NSSA" placeholder="20 caracteres máximo">
              <small >No omitir guiones</small>
            </div>
          </div>
          <!--Opcion de diagnostico-->
          <div class="form-group row m-2 my-4 mr-4 aling-items-center align-self-center">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <label class="LabelPersonalizadoCampoLargo input-group-text px-5" for="CatalogoDiagnostico_id">Diagnóstico</label>
              </div>
              <select id="CatalogoDiagnostico_id" class="custom-select">
                <option value="0" selected>Sin Diagnóstico</option>
                <option value="1">Descartado</option>
                <option value="2">Prediabetes</option>
                <option value="3">Diabetes Mellitus</option>
                <option value="4">Pendiente</option>
                <option value="5">Cancelado</option>
              </select>
            </div>
          </div>
          <!--Observaciones-->
          <div class="row">
            <div class="col">
              <div class="form-group m-2 my-4 aling-items-end align-self-center">
                <label for="Observaciones" class="LabelPersonalizadoCampoLargo col-12 col-form-label text-center rounded my-3 text-capitalize">Observaciones</label>
                <textarea class="form-control" id="Observaciones" maxlength="100" rows="3" value=""></textarea>
              </div>
            </div>
          </div>
          <!--Botones finales-->
          <div class="row justify-content-end">
              <div class="col-auto">
                <div class="btn-group align-self-center" role="group" >
                  <button type="button" id="Regresar" class="btn btn-info BotonPersonalizado btn-lg">Regresar</button>
                  <button type="button" id="Guardar" class="btn btn-info BotonPersonalizado btn-lg">Guardar</button>
                </div>
              </div>
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
  <!--  archivos javascript sweetalert  -->
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <!--  archivos javascript personalizados  -->
  <script src="js/mainRD.js"></script>
</body>
</html>