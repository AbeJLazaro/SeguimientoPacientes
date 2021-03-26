<?php 
session_start();
if(!isset($_SESSION['MedicoEnfermera_id'])){
  header("location:login.php");
}
if(isset($_SESSION['TipoUsuario'])){
  if ($_SESSION['TipoUsuario']!='A') 
  {
      header("location:homeU.php");

  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Registro de Personal</title>
  <!--  hojas de estilo bootstrap  -->
  <link rel="stylesheet" href="librerias/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="librerias/bootstrap/css/bootstrap-grid.min.css">
  <link rel="stylesheet" href="librerias/bootstrap/css/bootstrap-reboot.min.css">
  <!--  hojas de estilo personalizado  -->
  <link rel="stylesheet" href="css/main.css">
</head>
<body>
  <div class="container"> 
    <div class="row">
      <div class="col">
        <!--Titulo principal pantalla-->
        <div class="row my-3 mx-5 pt-3">
          <div class="col">
            <h1 class="text-center text-uppercase">Registro de Personal</h1>
          </div>
        </div>
        <form>
          <!--Titulo Datos Administrativos-->
          <div class="row my-3 mx-5 pt-3">
            <h2>Datos administrativos</h2>
          </div>
          <!--Matricula-->
          <div class="form-group row m-2 aling-items-center align-self-center">
            <label for="Matricula" class="LabelPersonalizadoCampoLargo col-12 col-md-4 col-form-label text-center rounded my-1 text-capitalize">Matrícula</label>
            <div class="col-12 col-md-8 my-1 p-0 px-md-3 ">
              <input maxlength="11" type="text" class="form-control" id="Matricula" placeholder="11 dígitos máximo"
              value= <?php 
                if(isset($_SESSION['PasarMatricula'])){
                  echo $_SESSION['PasarMatricula'];
                }else{
                  echo "";
                }
              ?>>
            </div>
          </div>
          <!--Contraseña-->
          <div class="form-group row m-2 aling-items-center align-self-center">
            <label for="Contraseña" class="LabelPersonalizadoCampoLargo col-12 col-md-4 col-form-label text-center rounded my-1 text-capitalize">Contraseña</label>
            <div class="col-12 col-md-8 my-1 p-0 px-md-3">
              <input maxlength="20"type="password" class="form-control" id="Password" placeholder="20 dígitos máximo">
            </div>
          </div>
          <!--Repetir Contraseña-->
          <div class="form-group row m-2 aling-items-center align-self-center">
            <label for="Contraseña" class="LabelPersonalizadoCampoLargo col-12 col-md-4 col-form-label text-center rounded my-1 text-capitalize">Repetir Contraseña</label>
            <div class="col-12 col-md-8 my-1 p-0 px-md-3">
              <input maxlength="20"type="password" class="form-control" id="Password2" placeholder="20 dígitos máximo">
            </div>
          </div>
          <!--Nombre del Personal-->
          <div class="form-group row m-2 aling-items-center align-self-center">
            <label for="NombreMedicoEnfermera" class="LabelPersonalizadoCampoLargo col-12 col-md-4 col-form-label text-center rounded my-1 text-capitalize">Nombre</label>
            <div class="col-12 col-md-8 my-1 p-0 px-md-3">
              <input maxlength="100"type="text" class="form-control" id="Nombre" placeholder="100 caracteres máximo">
            </div>
          </div>
          <!--Apellido Paterno del Personal-->
          <div class="form-group row m-2 aling-items-center align-self-center">
            <label for="ApPaterno" class="LabelPersonalizadoCampoLargo col-12 col-md-4 col-form-label text-center rounded my-1 text-capitalize">Apellido Paterno</label>
            <div class="col-12 col-md-8 my-1 p-0 px-md-3">
              <input maxlength="100"type="text" class="form-control" id="ApPaterno" placeholder="100 caracteres máximo">
            </div>
          </div>
            <!--Apellido Materno del Personal-->  
          <div class="form-group row m-2 aling-items-center align-self-center">
            <label for="ApMaterno" class="LabelPersonalizadoCampoLargo col-12 col-md-4 col-form-label text-center rounded my-1 text-capitalize">Apellido Materno</label>
            <div class="col-12 col-md-8 my-1 p-0 px-md-3">
              <input maxlength="100"type="text" class="form-control" id="ApMaterno" placeholder="100 caracteres máximo">
            </div>
          </div>
          <!--Categoria-->
          <div class="form-group row m-2 my-4 mr-4 aling-items-center align-self-center">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <label class="LabelPersonalizadoCampoLargo input-group-text px-5" for="Categoria_id">Categoria</label>
              </div>
              <select id="Categoria_id" class="custom-select">
                <option value="1" selected>Director</option>
                <option value="2">Jefe de servicio de Medicina Familiar</option>
                <option value="3">Jefe de enfermería</option>
                <option value="4">Jefe de laboratorio</option>
                <option value="5">Enfermería</option>
              </select>
            </div>
          </div>
          <!--Subcategoria--> 
          <div class="form-group row m-2 my-4 mr-4 aling-items-center align-self-center">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <label class="LabelPersonalizadoCampoLargo input-group-text px-5" for="Subcategoria_id">Subcategoria</label>
              </div>
              <select id="Subcategoria_id" class="custom-select">
                <option value="1">Auxiliar Enfermer@ General</option>
                <option value="2">Auxiliar Enfemer@ Salud Pública</option>
                <option value="3">Enfermer@ General</option>
                <option value="4">Enfermer@ Especialista Medicina Familiar</option>
                <option value="5" selected>No aplica</option>
              </select>
            </div>
          </div>
          <!--Tipo Usuario--> 
          <div class="form-group row m-2 my-4 mr-4 aling-items-center align-self-center">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <label class="LabelPersonalizadoCampoLargo input-group-text px-5" for="TipoUsuario">Tipo Usuario</label>
              </div>
              <select id="TipoUsuario" class="custom-select">
                <option value="U">Normal</option>
                <option value="A" selected>Administrador</option>
              </select>
            </div>
          </div>
          <!--Botones-->
          <div class="row justify-content-end">
              <div class="col-auto">
                <div class="btn-group align-self-center" role="group" >
                <button type="button" id="Regresar" class="btn btn-info BotonPersonalizado btn-lg">Regresar</button>
                <button type="button" id="Guardar" class="btn btn-info BotonPersonalizado btn-lg">Guardar</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php 
    if(isset($_SESSION['Matricula'])){
      $_SESSION['Matricula']="";
    }
  ?>

  <!--  archivos javascript jquery  -->
  <script src="librerias/jquery-3.4.0.min.js"></script>
  <!--  archivos javascript bootstrap  -->
  <script src="librerias/bootstrap/js/bootstrap.min.js"></script>
  <script src="librerias/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="librerias/bootstrap/js/bootstrap.js"></script>
  <!--  archivos javascript sweetalert  -->
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <!--  archivos javascript personalizados  -->
  <script src="js/mainRPe.js"></script>
</body>
</html>