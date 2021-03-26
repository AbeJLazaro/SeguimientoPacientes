<?php
//****************************************************************************************
//Nombre:         ActualizacionCita.php
//Objetivos:      Tiene las instrucciones necesarias para el funcionamiento correcto de 
//                la pantalla "ActualizacionCita.php" a la que se accede mediante el 
//                menú de inicio. Usa funciones de conexion con la base de datos y 
//                uso de variables tipo $_POST.
//Creado por:     Lázaro Martínez Abraham Josué
//Fecha:          viernes 3 de enero de 2020
//version:        1.0                 
//****************************************************************************************

//Se llama al archivo conexion.php que contiene la funcion para conectar con la base
//se datos
include('../conexion/conexion.php');

//se inicializan variables con los valores de la variables $_POST para 
//trabajar sus valores de forma mas sencilla
$NSSA=$_POST['NSSA'];
$FechaCitaAnterior=$_POST['FechaCitaAnterior'];
$FechaCitaNueva=$_POST['FechaCitaNueva'];
$Boton=$_POST['Boton'];

//se hace un switch con el metodo post del valor boton enviado para saber
//que tarea se realizara
switch ($_POST['Boton']) {
  //si el boton es guardar, se manda la instrucción para guardar una cita
  case 'Guardar':
    //se valida que los campos no esten vacios
    if ($NSSA!=null and $FechaCitaNueva!=null and $FechaCitaAnterior!=null) {
      //como hacemos una conexion con BD usamos try-catch
      try {
        //abrimos una conexion
        $conexion = AbrirBase();
        
        //generamos la sentencia Select pasa saber si existe dicha cita que se
        //quiere actualizar
        $select =$conexion->prepare("SELECT Cita_id FROM Cita WHERE 
                  Paciente_id=(SELECT Paciente_id
                    FROM Paciente
                    WHERE NSSA=:nssa
                    )
                  AND Fecha =:fecha");
        $select->bindParam("nssa",$NSSA,PDO::PARAM_STR);
        $select->bindParam("fecha",$FechaCitaAnterior,PDO::PARAM_STR);
        $select->execute();
        $registro=$select->fetch(PDO::FETCH_ASSOC);
        //si existe un resultado, entonces se hace la actualizacion
        if($select->rowCount()==1){

          //se hace la actualización de dicha cita con una sentencia update
          $update="UPDATE Cita SET Fecha='{$FechaCitaNueva}' 
          WHERE Cita_id={$registro['Cita_id']}";
          
          //si se actualiza, se regresa un mensaje de exito
          if($conexion->query($update)){
            echo 'Guardado';
          //si no se actualiza, hay que cachar el sqlerror code
          }else{
            if($select->rowCount()>1){
              echo "Error, mas de un resultado";
            }else{
              switch ($conexion->errorCode()) {
                case '45005':
                  echo "Paciente inactivo";
                  break;
                case '45004':
                  echo "Fecha inválida, debe ser mayor a la actual";
                  break;
                case '45002':
                  echo "Cita inactiva, no la puedes cambiar";
                  break;
                default:
                  echo $conexion->errorCode();
                  //echo $data;
                  break;
              }
            }
          }
        //en caso contrario (no se encontró la cita indicada para el paciente indicado), 
        //se busca por que el select no arrojó resultados
        }else{
          $select ="SELECT * FROM Paciente WHERE NSSA='{$NSSA}'";
          $paciente = $conexion->query($select)->fetchAll(PDO::FETCH_ASSOC);
          if($paciente){
            //si existe, significa que no hay citas para ese paciente en esa fecha
            echo "Dicha cita no existe";
          }else{
            //si no existe, se regresa un mensaje que indica que no existe el paciente
            echo "Ese paciente no existe";
          }
        }
      //si exite algun problema con la conexion de la base de datos, se muestra el error
      } catch (Exception $ex) {
        echo $e->getMessage();
      }
    }
    break;
  //si no es ninguno de los botones de arriba, algo muy raro paso, se muestra 
  //un mensaje de tipo error
  default:
    echo 'Boton no encontrado';
    break;
}

?>