<?php
//****************************************************************************************
//Nombre:         RegistroDiagnostico.php
//Objetivos:      Contiene las instrucciones necesarias para registrar el diagnostico de 
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
$Boton=$_POST['Boton'];

//se hace un switch con el metodo post del valor boton enviado
switch ($Boton) {
  //si el boton es guardar, se manda la instrucción para guardar el diagnostico
  case 'Guardar':
    //se toma el valor de la variable diagnostico que no debe ser nulo
    $Diagnostico=$_POST['Diagnostico'];
    //se toma el valor de observaciones. Si es no exite, se coloca un cadena
    //vacia
    if(isset($_POST['Observaciones'])){
      $Observaciones=$_POST['Observaciones'];
    }else{
      $Observaciones="";
    }

    //se compara que los valores obligatorios no sean nulos
    if($NSSA!=null && $Diagnostico!=null){  
      try{
        //abrimos una conexion
        $conexion = AbrirBase();

        //se busca el id del paciente
        $select=$conexion->prepare("SELECT Paciente_id FROM Paciente
                                    WHERE NSSA=:nssa");
        //se cambian los parametros, se ejecuta la sentencia select y el
        //resultado/registro se guarda en la variable $Paciente
        $select->bindParam("nssa",$NSSA,PDO::PARAM_STR);
        $select->execute();
        $Paciente=$select->fetch(PDO::PARAM_STR);

        //generamos la sentencia insert
        $insert = $conexion->prepare("INSERT INTO Diagnostico
                                      (Paciente_id,MedicoEnfermera_id,
                                      CatalogoDiagnostico_id,Observaciones)
                                      VALUES(:PID,:MEID,:diagnostico,:observaciones)");
        //cambiamos valores, y revisamos los que pueden ser nulos
        $insert->bindParam("PID",$Paciente['Paciente_id'],PDO::PARAM_INT);
        $insert->bindParam("MEID",$_SESSION['MedicoEnfermera_id'],PDO::PARAM_INT);
        $insert->bindParam("diagnostico",$Diagnostico,PDO::PARAM_INT);
        //si el valor de observaciones es una cadena vacia, se cambia por un valor nulo
        if($Observaciones==""){
          $insert->bindValue("observaciones",NULL,PDO::PARAM_NULL);
        }else{
          $insert->bindParam("observaciones",$Observaciones,PDO::PARAM_STR);
        }
        //se ejecuta la sentencia insert y se guarda su valor de exito en la variable 
        //$registro
        $registro=$insert->execute();
        //si se completa, se regresa el valor Guardado
        if ($registro) {
          echo 'Guardado';
        //en caso contrario, se muestra el error
        } else {
          //se revisa el errorCode de la ejecución
          switch ($conexion->errorCode()) {
            //se revisa si el error se debe a que el paciente esta inactivo
            case '45005':
              echo "Paciente inactivo";
              break;
            //si no, se busca si se debe a que el paciente no exista
            default:
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
      }catch(Exception $e){
        echo $e->getMessage();
      }
    }
    break;
  //si se hace una busqueda de los datos de un diagnostico anterior
  case 'Buscar':
    //se revisa que el valor del NSSA no sea nulo
    if($NSSA!=null){  
      try{
        //abrimos una conexion
        $conexion = AbrirBase();

        //se busca el id del paciente
        $select=$conexion->prepare("SELECT Paciente_id FROM Paciente
                                    WHERE NSSA=:nssa");
        //se cambian parametros, se ejecuta y se guarda en la variable 
        //$Paciente el registro de la sentencia
        $select->bindParam("nssa",$NSSA,PDO::PARAM_STR);
        $select->execute();
        $Paciente=$select->fetch(PDO::PARAM_STR);

        //generamos la sentencia select para encontrar datos del paciente
        $selectDatos = $conexion->prepare("SELECT CatalogoDiagnostico_id,Observaciones
                                          FROM Diagnostico 
                                          WHERE Paciente_id=:PID
                                          AND FechaDiagnostico=
                                          (SELECT MAX(FechaDiagnostico)
                                            FROM Diagnostico
                                            WHERE Paciente_id=:PID2)");
        //cambiamos valores, y revisamos los que pueden ser nulos
        $selectDatos->bindParam("PID",$Paciente['Paciente_id'],PDO::PARAM_INT);
        $selectDatos->bindParam("PID2",$Paciente['Paciente_id'],PDO::PARAM_INT);
        $registro=$selectDatos->execute();
        //si se completa, se regresa un mensaje con los datos separados por comas
        if ($selectDatos->rowCount()>0) {
          //se pasa la sentencia encontrada a una variable
          $registro=$selectDatos->fetch(PDO::PARAM_STR);
          $mensaje="";

          //diagnostico Anterior
          $mensaje=$mensaje.$registro['CatalogoDiagnostico_id'].",";
          //Observaciones
          if($registro['Observaciones']==""){
            $mensaje=$mensaje."NULL";
          }else{
            $mensaje=$mensaje.$registro['Observaciones'];
          }
          //se regresa el mensaje
          echo $mensaje;
        //en caso de no hayar coincidencias, se regresa un mensaje vacio
        } else {
          echo "";
        } 
      //si exite algun problema con la conexion de la base de datos, se muestra el error
      }catch(Exception $e){
        echo $e->getMessage();
      }
    }
    break;
  //si no es ninguna de las tareas anteriores se muestra un mensaje de rror
  default:
    echo "Error";
    break;
}

?>