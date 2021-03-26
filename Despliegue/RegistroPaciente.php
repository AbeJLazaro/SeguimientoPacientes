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
  <title>Registro de Paciente</title>
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
            <h1 class="text-center text-uppercase"> registro de paciente</h1>
          </div>
        </div>
        <!--Empieza el formulario-->
        <form>
          <!--Titulo Datos personales-->
          <div class="row my-3 mx-5 pt-3">
            <h2>Datos personales</h2>
          </div>
          <!--NSS + agregado del paciente-->
          <div class="form-group row m-2 aling-items-center align-self-center">
            <label for="NSSA" class="LabelPersonalizadoCampoLargo col-12 col-md-4 col-form-label text-center rounded my-1 text-capitalize">NSS + agregado</label>
            <div class="col-12 col-md-8 my-1 p-0 px-md-3 ">
              <input maxlength="20" type="text" class="form-control" id="NSSA" placeholder="20 caracteres máximo" 
              value= <?php 
                if(isset($_SESSION['NSSA'])){
                  echo $_SESSION['NSSA'];
                }else{
                  echo "";
                }
              ?> >
              <small >agrega el campo con todo y los guiones</small>
            </div>
          </div>
          <!--Nombre del paciente-->
          <div class="form-group row m-2 aling-items-center align-self-center">
            <label for="NombrePaciente" class="LabelPersonalizadoCampoLargo col-12 col-md-4 col-form-label text-center rounded my-1 text-capitalize">Nombre</label>
            <div class="col-12 col-md-8 my-1 p-0 px-md-3">
              <input maxlength="100"type="text" class="form-control" id="NombrePaciente" placeholder="100 caracteres máximo">
            </div>
          </div>
          <!--Apeido Paterno del paciente-->
          <div class="form-group row m-2 aling-items-center align-self-center">
            <label for="ApPaterno" class="LabelPersonalizadoCampoLargo col-12 col-md-4 col-form-label text-center rounded my-1 text-capitalize">Apellido paterno</label>
            <div class="col-12 col-md-8 my-1 p-0 px-md-3">
              <input maxlength="100"type="text" class="form-control" id="ApPaterno" placeholder="100 caracteres máximo">
            </div>
          </div>
          <!--Apeido Materno del paciente-->
          <div class="form-group row m-2 aling-items-center align-self-center">
            <label for="ApMaterno" class="LabelPersonalizadoCampoLargo col-12 col-md-4 col-form-label text-center rounded my-1 text-capitalize">Apellido materno</label>
            <div class="col-12 col-md-8 my-1 p-0 px-md-3">
              <input maxlength="100"type="text" class="form-control" id="ApMaterno" placeholder="100 caracteres máximo">
            </div>
          </div>
          <div class="row my-3 mx-5 pt-3">
            <h2>Domicilio</h2>
          </div>
          <!--Calle-->
          <div class="form-group row m-2 aling-items-center align-self-center">
            <label for="Calle" class="LabelPersonalizadoCampoLargo col-12 col-md-4 col-form-label text-center rounded my-1 text-capitalize">Calle</label>
            <div class="col-12 col-md-8 my-1 p-0 px-md-3">
              <input maxlength="44"type="text" class="form-control" id="Calle" placeholder="44 caracteres máximo">
            </div>
          </div>
          <!--Numero Exterior-->
          <div class="form-group row m-2 aling-items-center align-self-center">
            <label for="NumeroExterior" class="LabelPersonalizadoCampoLargo col-12 col-md-4 col-form-label text-center rounded my-1 text-capitalize">Número exterior</label>
            <div class="col-12 col-md-8 my-1 p-0 px-md-3">
              <input maxlength="10"type="text" class="form-control" id="NumeroExterior" placeholder="10 dígitos">
            </div>
          </div>
          <!--Numero Interior-->
          <div class="form-group row m-2 aling-items-center align-self-center">
            <label for="NumeroInterior" class="LabelPersonalizadoCampoLargo col-12 col-md-4 col-form-label text-center rounded my-1 text-capitalize">Número interior</label>
            <div class="col-12 col-md-8 my-1 p-0 px-md-3">
              <input maxlength="10"type="text" class="form-control" id="NumeroInterior" placeholder="10 dígitos">
            </div>
          </div>
          <!--Colonia-->
          <div class="form-group row m-2 aling-items-center align-self-center">
            <label for="Colonia" class="LabelPersonalizadoCampoLargo col-12 col-md-4 col-form-label text-center rounded my-1 text-capitalize">Colonia</label>
            <div class="col-12 col-md-8 my-1 p-0 px-md-3">
              <input maxlength="44"type="text" class="form-control" id="Colonia" placeholder="44 caracteres máximo">
            </div>
          </div>
          <!--Delegación-->
          <div class="form-group row m-2 aling-items-center align-self-center">
            <label for="Delegacion" class="LabelPersonalizadoCampoLargo col-12 col-md-4 col-form-label text-center rounded my-1 text-capitalize">Delegación</label>
            <div class="col-12 col-md-8 my-1 p-0 px-md-3">
              <input maxlength="44"type="text" class="form-control" id="Delegacion" placeholder="44 caracteres máximo">
            </div>
          </div>
          <!--Información de contacto-->
          <div class="row my-3 mx-5 pt-3">
            <h2>Información de contacto</h2>
          </div>          
          <div class="row my-3 mx-5 pt-3">
            <h4>Telefonos</h4>
          </div>
          <!--Telefono1-->
          <div class="form-group col m-2 my-4 aling-items-center align-self-center" id="Tel1">
            <div class="row">
              <div class="input-group col-4 justify-content-md-center">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <input type="radio" aria-label="Large" id="Fijo1" name="Telefono1" checked="" value="F">
                  </div>
                </div>
                <label class="form-check-label col-form-label-lg border rounded px-3" for="Fijo1">Fijo</label>
              </div>
              <div class="input-group col-4 justify-content-md-center">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <input type="radio" aria-label="Large" id="Celular1" name="Telefono1" value="C">
                  </div>
                </div>
                <label class="form-check-label col-form-label-lg border rounded px-3" for="Celular1">Celular</label>
              </div>
              <div class="input-group col-4 justify-content-md-center">
                <button type="button" id="EliminarTelefono1" class="btn BotonPersonalizado btn-lg"> Eliminar </button>
              </div>
            </div>
            <div class="form-group row m-2 aling-items-center align-self-center">
              <label for="NumeroTelefono1" class="LabelPersonalizadoCampoLargo col-12 col-md-4 col-form-label text-center rounded my-1 text-capitalize">Número</label>
              <div class="col-12 col-md-8 my-1 p-0 px-md-3">
                <input maxlength="10" type="tel" class="form-control" id="NumeroTelefono1" placeholder="a 10 digitos">
              </div>
            </div>
          </div>
          <!--Telefono2-->
          <div class="form-group col m-2 my-4 aling-items-center align-self-center" id="Tel2">
            <div class="row">
              <div class="input-group col-4 justify-content-md-center">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <input type="radio" aria-label="Large" id="Fijo2" name="Telefono2" checked="" value="F">
                  </div>
                </div>
                <label class="form-check-label col-form-label-lg border rounded px-3" for="Fijo2">Fijo</label>
              </div>
              <div class="input-group col-4 justify-content-md-center">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <input type="radio" aria-label="Large" id="Celular2" name="Telefono2" value="C">
                  </div>
                </div>
                <label class="form-check-label col-form-label-lg border rounded px-3" for="Celular2">Celular</label>
              </div>
              <div class="input-group col-4 justify-content-md-center">
                <button type="button" id="EliminarTelefono2" class="btn BotonPersonalizado btn-lg"> Eliminar </button>
              </div>
            </div>
            <div class="form-group row m-2 aling-items-center align-self-center">
              <label for="NumeroTelefono2" class="LabelPersonalizadoCampoLargo col-12 col-md-4 col-form-label text-center rounded my-1 text-capitalize">Número</label>
              <div class="col-12 col-md-8 my-1 p-0 px-md-3">
                <input maxlength="10" type="tel" class="form-control" id="NumeroTelefono2" placeholder="a 10 digitos">
              </div>
            </div>
          </div>
          <!--Telefono3-->
          <div class="form-group col m-2 my-4 aling-items-center align-self-center" id="Tel3">
            <div class="row">
              <div class="input-group col-4 justify-content-md-center">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <input type="radio" aria-label="Large" id="Fijo3" name="Telefono3" checked="" value="F">
                  </div>
                </div>
                <label class="form-check-label col-form-label-lg border rounded px-3" for="Fijo3">Fijo</label>
              </div>
              <div class="input-group col-4 justify-content-md-center">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <input type="radio" aria-label="Large" id="Celular3" name="Telefono3" value="C">
                  </div>
                </div>
                <label class="form-check-label col-form-label-lg border rounded px-3" for="Celular3">Celular</label>
              </div>
              <div class="input-group col-4 justify-content-md-center">
                <button type="button" id="EliminarTelefono3" class="btn BotonPersonalizado btn-lg"> Eliminar </button>
              </div>
            </div>
            <div class="form-group row m-2 aling-items-center align-self-center">
              <label for="NumeroTelefono3" class="LabelPersonalizadoCampoLargo col-12 col-md-4 col-form-label text-center rounded my-1 text-capitalize">Número</label>
              <div class="col-12 col-md-8 my-1 p-0 px-md-3">
                <input maxlength="10" type="tel" class="form-control" id="NumeroTelefono3" placeholder="a 10 digitos">
              </div>
            </div>
          </div>
          <!--BotonAgregarTelefono-->
          <div class="row mx-3">
            <div class="col ">
              <button type="button" id="AgregarBoton" class="btn BotonPersonalizado btn-lg">+ Agregar</button>
            </div>
          </div>
          <!-- titulo Correo electronico-->
          <div class="row my-3 mx-5 pt-3">
            <h4>Contacto por internet</h4>
          </div>
          <!--Correo electronico-->
          <div class="form-group row m-2 my-4 aling-items-center align-self-center">
            <label for="Email" class="LabelPersonalizadoCampoLargo col-12 col-md-4 col-form-label text-center rounded my-1 text-capitalize">Correo electrónico</label>
            <div class="col-12 col-md-8 my-1 p-0 px-md-3">
              <input maxlength="230"type="email" class="form-control" id="Email" placeholder="230 caracteres máximo">
            </div>
          </div>
          <!--Observaciones-->
          <div class="form-group m-2 my-4 aling-items-center align-self-center">
            <label for="Observaciones" class="LabelPersonalizadoCampoLargo col-12 col-form-label text-center rounded my-3 text-capitalize">Observaciones</label>
            <textarea class="form-control" id="Observaciones" maxlength="100" rows="3" value=""></textarea>
          </div>
          <!--Botones finales-->
          <div class="row justify-content-end">
            <div class="col-auto">
              <div class="btn-group align-self-center" role="group" >
                <button type="button" id="Regresar" class="btn BotonPersonalizado btn-lg">Regresar</button>
                <button type="button" id="Guardar" class="btn BotonPersonalizado btn-lg">Guardar</button>
                <button type="button" id="Siguiente" class="btn BotonPersonalizado btn-lg">Siguiente</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <?php 
    if(isset($_SESSION['NSSA'])){
      $_SESSION['NSSA']="";
    }
  ?>
  <script src="librerias/jquery-3.4.0.min.js"></script>
  <script src="librerias/bootstrap/js/bootstrap.min.js"></script>
  <script src="librerias/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="librerias/bootstrap/js/bootstrap.js"></script>
  <script src="js/mainRP.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>
</html>