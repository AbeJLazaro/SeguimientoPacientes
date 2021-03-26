<?php
//****************************************************************************************
//Nombre:         RegistroCita.php
//Objetivos:      Contiene las instrucciones necesarias para registrar una cita para 
//                un paciente por medio de su NSSA.
//Creado por:     Lázaro Martínez Abraham Josué
//Fecha:          viernes 3 de enero de 2020
//version:        1.0                 
//****************************************************************************************
//Se llama al archivo conexion.php que contiene la funcion para conectar con la base
//se datos
include('../conexion/conexion.php');
//Se llama al archivo global para usar la variable $_SESSION
include('../conexion/global.php');

//se obtiene el valor de las datos no nulas en variables para su fácil trabajo
$NSSA=$_POST['NSSA'];
$FechaCita=$_POST['FechaCita'];
$Boton=$_POST['Boton'];


//se hace un switch con el metodo post del valor boton enviado
switch ($_POST['Boton']) {
  //si el boton es guardar, se manda la instrucción para guardar una cita
  case 'Guardar':
    //se valida que los campos no esten vacios
    if ($NSSA!=null and $FechaCita!=null) {
      //como hacemos una conexion con BD usamos try-catch
      try {
        //abrimos una conexion
        $conexion = AbrirBase();
        
        //generamos la sentencia insert
        $insert = "INSERT INTO Cita
        (Fecha, Paciente_id, MedicoEnfermera_id)
        VALUES
        ('{$_POST['FechaCita']}', (SELECT Paciente_id FROM Paciente 
        WHERE NSSA='{$_POST['NSSA']}'), {$_SESSION['MedicoEnfermera_id']})";
        //si se completa, se regresa el valor Guardado
        if ($conexion->query($insert)) {
          echo 'Guardado';
        //en caso contrario, se muestra el error
        } else {
          switch ($conexion->errorCode()) {
            //se revisa si el error se debe a que ya hay una cita para el paciente
            case '45003':
              echo "No se puede agendar otra cita, Paciente con cita activa";
              break;
            //se revisa si el error se debe a que la fecha es menor a la actual
            case '45004':
              echo "Fecha inválida, debe ser mayor a la actual";
              break;
            case '45005':
              echo "Paciente inactivo";
              break;
            default:
              //si no, se busca si se debe a que el paciente no exista
              $select ="SELECT * FROM Paciente WHERE NSSA='{$_POST['NSSA']}'";
              $datos = $conexion->query($select)->fetchAll(PDO::FETCH_ASSOC);
              if($datos){
                //si existe, significa que hay un error en la programación de la
                //sentencia sql del insert
                echo "Error en la sintaxis";
              }else{
                //si no existe, se muestra
                echo "Ese paciente no existe";
              }
              break;
          }
        } 
      //si exite algun problema con la conexion de la base de datos, se muestra el error
      } catch (Exception $ex) {
        echo $e->getMessage();
      }
    }
    break;
  //si no es algún caso de los anteriores, se manda mensaje de error
  default:
    echo 'Boton no encontrado';
    break;
}

?>