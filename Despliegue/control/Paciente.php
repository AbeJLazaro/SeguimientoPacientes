<?php
//****************************************************************************************
//Nombre:         Paciente.php
//Objetivos:      Contiene las instrucciones necesarias para las pantallas relacionadas
//                con el registro de un paciente, como lo son "RegistroPaciente.php",
//                "ActualizacionPaciente.php" y "GuclosaDeteccion.php".
//                Usa sentencias y manipulación para con la base de datos y tiene casos
//                especificos para cada tarea.
//Creado por:     Lázaro Martínez Abraham Josué
//Fecha:          viernes 3 de enero de 2020
//version:        1.0                 
//****************************************************************************************

//Se llama al archivo conexion.php que contiene la funcion para conectar con la base
//se datos
include('../conexion/conexion.php');
//Se llama al archivo global para usar la variable $_SESSION
include('../conexion/global.php');

//si la variable $_POST contiene la llave NSSA, se genera una variable para
//trabajar su valor. Se toma el valor de la llave Boton de la variable $_POST
//en una variable llamada $Boton
if(isset($_POST['NSSA'])){
  $NSSA=$_POST['NSSA'];
}
$Boton=$_POST['Boton'];

//se hace un switch con el metodo post del valor boton enviado para saber
//que tarea se realizara
switch ($Boton) {
  //si se trata de una tarea de guardar, es cuando se hace una (o primera) selección
  //del boton "Guardar"
  case 'Guardar':
    //se toman los datos que deben ser no nulos y se guardan en variables con 
    //nombres comprensibles para su uso
    $Nombre=$_POST['Nombre'];
    $ApPaterno=$_POST['ApPaterno'];
    $ApMaterno=$_POST['ApMaterno'];
    $Calle=$_POST['Calle'];
    $NumeroExterior=$_POST['NumeroExterior'];
    $Colonia=$_POST['Colonia'];
    $Delegacion=$_POST['Delegacion'];
    $Telefono1=$_POST['Telefono1'];
    $TipoTelefono1=$_POST['TipoTelefono1'];

    //se checa el valor de los elementos que pueden estar nulos
    //Numero Interior
    if(isset($_POST['NumeroInterior'])){
      $NumeroInterior=$_POST['NumeroInterior'];
    }else{
      $NumeroInterior="";
    }
    //Teléfono 2 y tipo de teléfono 2
    if(isset($_POST['Telefono2'])){
      $Telefono2=$_POST['Telefono2'];
      $TipoTelefono2=$_POST['TipoTelefono2'];
    }else{
      $Telefono2="";
      $TipoTelefono2="";
    }
    //Teléfono 3 y tipo de teléfono 3
    if(isset($_POST['Telefono3'])){
      $Telefono3=$_POST['Telefono3'];
      $TipoTelefono3=$_POST['TipoTelefono3'];
    }else{
      $Telefono3="";
      $TipoTelefono3="";
    }
    //Email 
    if(isset($_POST['Email'])){
      $Email=$_POST['Email'];
    }else{
      $Email="";
    }
    //Observaciones
    if(isset($_POST['Observaciones'])){
      $Observaciones=$_POST['Observaciones'];
    }else{
      $Observaciones="";
    }
    //se valida que los campos obligatorios no esten vacios
    if($NSSA!=null and $Nombre!=null and $ApPaterno!=null and $ApMaterno!=null 
      and $Calle!=null and $NumeroExterior!=null 
      and $Colonia!=null and $Delegacion!=null and $Telefono1!=null 
      and $TipoTelefono1!=null){

      try{
        //abrimos una conexion
        $conexion = AbrirBase();

        //generamos la sentencia insert para guardar los datos del paciente
        $insert=$conexion->prepare("INSERT INTO Paciente
        (NSSA,Nombre,ApPaterno,ApMaterno,Calle,NumeroExterior,
        NumeroInterior,Colonia,Delegacion,CorreoElectronico,
        Observaciones,MedicoEnfermera_id)
        VALUES
        (:nssa,:nombre,:apPaterno,:apMaterno,:calle,:numeroExterior,
        :numeroInterior,:colonia,:delegacion,:email,:observaciones,:MEID)");

        //Se cambian los parametros de los valores no nulos
        $insert->bindParam('nssa',$NSSA,PDO::PARAM_STR);
        $insert->bindParam('nombre',$Nombre,PDO::PARAM_STR);
        $insert->bindParam('apPaterno',$ApPaterno,PDO::PARAM_STR);
        $insert->bindParam('apMaterno',$ApMaterno,PDO::PARAM_STR);
        $insert->bindParam('calle',$Calle,PDO::PARAM_STR);
        $insert->bindParam('numeroExterior',$NumeroExterior,PDO::PARAM_INT);
        $insert->bindParam('colonia',$Colonia,PDO::PARAM_STR);
        $insert->bindParam('delegacion',$Delegacion,PDO::PARAM_STR);
        $insert->bindParam('MEID',$_SESSION['MedicoEnfermera_id'],PDO::PARAM_INT);
        //se cambian los parametros de los valores que pueden ser nulos
        //si contienen una cadena vacia sus variables, se cambia el valor
        //del parametro por una referencia a un valor nulo
        //Número interior
        if($NumeroInterior==""){
          $insert->bindValue('numeroInterior',NULL,PDO::PARAM_NULL);
        }else{
          $insert->bindParam('numeroInterior',$NumeroInterior,PDO::PARAM_INT);
        }
        //Email
        if($Email==""){
          $insert->bindValue('email',NULL,PDO::PARAM_NULL);
        }else{
          $insert->bindParam('email',$Email,PDO::PARAM_STR);
        }
        //Observaciones
        if($Observaciones==""){
          $insert->bindValue('observaciones',NULL,PDO::PARAM_NULL);
        }else{
          $insert->bindParam('observaciones',$Observaciones,PDO::PARAM_STR);
        }
        //se ejecuta la sentencia insert y su valor de exito se guarda en la variable
        //$valorID
        $valorID=$insert->execute();
        //si el insert fue exitoso
        if($valorID){
          //se inicializa un mensaje de que el paciente, por lo menos sus datos personales
          //se han guardado
          $mensaje="Datos personales del paciente registrados";
          //se genera la sentencia para agregar los telefonos
          $insertTel=$conexion->prepare("INSERT INTO 
            Telefono(Tipo,NumTelefono,Paciente_id)
            VALUES(:tipo,:numero,(
              SELECT Paciente_id 
              FROM Paciente
              WHERE NSSA=:nssa))");
          //se intercambian los parametros por los necesarios
          $insertTel->bindParam('tipo',$TipoTelefono1,PDO::PARAM_STR);
          $insertTel->bindParam('numero',$Telefono1,PDO::PARAM_INT);
          $insertTel->bindParam('nssa',$NSSA,PDO::PARAM_STR);

          //se ejecuta el comando
          $tel1=$insertTel->execute();
          //si es valida la insercion, se agrega al mensaje
          if($tel1){
            $mensaje=$mensaje."\nTeléfono 1 agregado";
          //si no, ocurrio un problema, se agrega al mensaje
          }else{
            $mensaje=$mensaje."\nTeléfono 1 no se pudo agregar";
          }

          //si existe dato para telefono 2, entonces se hace lo mismo que 
          //con el telefono 1
          if($Telefono2!=""){
            $insertTel->bindParam('tipo',$TipoTelefono2,PDO::PARAM_STR);
            $insertTel->bindParam('numero',$Telefono2,PDO::PARAM_INT);
            $insertTel->bindParam('nssa',$NSSA,PDO::PARAM_STR);
            $tel2=$insertTel->execute();
            if($tel2){
              $mensaje=$mensaje."\nTeléfono 2 agregado";
            }else{
              $mensaje=$mensaje."\nTeléfono 2 no se pudo agregar";
            }
          }

          //lo mismo para telefono 3 en caso de que exista
          if($Telefono3!=""){
            $insertTel->bindParam('tipo',$TipoTelefono3,PDO::PARAM_STR);
            $insertTel->bindParam('numero',$Telefono3,PDO::PARAM_INT);
            $insertTel->bindParam('nssa',$NSSA,PDO::PARAM_STR);
            $tel3=$insertTel->execute();
            if($tel3){
              $mensaje=$mensaje."\nTeléfono 3 agregado";
            }else{
              $mensaje=$mensaje."\nTeléfono 3 no se pudo agregar";
            }
          }
          echo $mensaje;
        //si el insert de datos personales no es exitoso, se busca la razón
        }else{
          //se hace una sentencia select para saber si el paciente ya existe
          $select=$conexion->prepare("SELECT Paciente_id FROM Paciente 
            WHERE NSSA=:nssa");
          $select->bindParam('nssa',$NSSA,PDO::PARAM_STR);
          $select->execute();
          //si si existe, se informa
          if($select->rowCount()>0){
            echo "Ese paciente ya existe";
          //si no existe, el error es de otro tipo
          }else{
            echo "No se pudo insertar";
          }
        }
      //si se causa una excepción, se regresa el mensaje de la excepción
      }catch(Exception $e){
        echo $e->getMessage();
      }
    }
    break;
  //si la tarea se trata de BUSCAR, es por que se hace una busqueda de los datos del
  //paciente en cuestión
  case 'Buscar':
    //se vuelve a inicializar la variable NSSA con el valor en $_POST para asegurar
    //su obtencion
    $NSSA=$_POST['NSSA'];
    //se valida que el campo no esté vacio
    if ($NSSA!=null) {
      try{
        //abrimos la base de datos
        $conexion =AbrirBase();

        //generamos la sentencia sql para buscar los datos del paciente
        $select =$conexion->prepare("SELECT * FROM Paciente WHERE 
                  NSSA =:nssa");
        $select->bindParam("nssa",$NSSA,PDO::PARAM_STR);
        //se ejecuta la sentencia insert y su valor de exito se guarda en la variable
        //$registro
        $registro=$select->execute();
        //si el select fue exitoso
        if($registro){
          //si la cantidad de registros que generó el select es al menos 1
          if($select->rowCount()>=1){
            //se saca el valor del primer registro del select y se guarda en
            //la variable $registro
            $registro=$select->fetch(PDO::PARAM_STR);

            //se genera un mensaje con el que se regresaran los valores en tipo
            //CSV
            $mensaje="";
            //se empiezan a concatenar los valores obtenidos, en caso de que un
            //campo haya sido nulo, el select nos lo regresa como una cadena vacia,
            //si el valor de un campo es nulo, entonces lo concatenamos como
            //la palabra NULL
            $mensaje=$mensaje.$registro['Nombre'].",";
            $mensaje=$mensaje.$registro['ApPaterno'].",";
            $mensaje=$mensaje.$registro['ApMaterno'].",";
            $mensaje=$mensaje.$registro['Calle'].",";
            $mensaje=$mensaje.$registro['NumeroExterior'].",";
            if($registro['NumeroInterior']==""){
              $mensaje=$mensaje."NULL".",";
            }else{
              $mensaje=$mensaje.$registro['NumeroInterior'].",";
            }
            $mensaje=$mensaje.$registro['Colonia'].",";
            $mensaje=$mensaje.$registro['Delegacion'].",";
            if($registro['CorreoElectronico']==""){
              $mensaje=$mensaje."NULL".",";
            }else{
              $mensaje=$mensaje.$registro['CorreoElectronico'].",";
            }
            if($registro['Observaciones']==""){
              $mensaje=$mensaje."NULL";
            }else{
              $mensaje=$mensaje.$registro['Observaciones'];
            }
            //para la información de los telefonos, generamos otra sentencia select
            //para encontrar los telefonos asociados a un paciente
            $selectTel =$conexion->prepare("SELECT NumTelefono,Tipo 
                                            FROM Telefono t
                                            JOIN Paciente p ON t.Paciente_id=p.Paciente_id
                                            WHERE NSSA =:nssa");
            $selectTel->bindParam("nssa",$NSSA,PDO::PARAM_STR);
            $selectTel->execute();
            //en la variable $telefonos se guarda todos los registro obtenidos
            //por la sentencia Select
            $telefonos=$selectTel->fetchAll(PDO::PARAM_STR);
            //se inicia una variable de cantidad de telefonos como cero, esta
            //variable contará la cantidad de telefonos que se encuentran
            $cantidadTelefonos=0;
            //se genera la variable que contendrá la información de los telefono
            //tipo y su número
            $mensajeTelefono="";
            //por cada registro en la variable $telefonos
            foreach ($telefonos as $tel) {
              //se incrementa en uno la cantidad de telefonos encontrados
              //y se concatena el número del telefono y tu tipo
              $cantidadTelefonos=$cantidadTelefonos+1;
              $mensajeTelefono=$mensajeTelefono.$tel['NumTelefono'].",";
              $mensajeTelefono=$mensajeTelefono.$tel['Tipo'].",";
            }
            //se concatena el mensaje con la información personal del paciente
            //junto con la cantidad de telefonos que hay y la información de los
            //telefonos del paciente
            //se regresa el mensaje
            echo $mensaje.",".$cantidadTelefonos.",".$mensajeTelefono;
          //si la cantidad de registros es cero significa que el paciente no existe
          }else{
            //se regresa un mensaje que avisa de dicho error
            echo "Ese paciente no existe";
          }
        //si el select no fue exitoso es por que hay un error con la sentencia
        }else{
          echo "Error con la sentencia sql";
        }
      //si existe una excepción, se regresa el valor de esa excepcion
      }catch(Exception $e){
        echo $e->getMessage();
      }
    }

    break;
  //Si la tarea se trata de hacer una actualización de datos desde la pantalla
  //ActualizarPaciente.php
  case 'Actualizar':
    //se toman los datos que deben ser no nulos y se guardan en variables con 
    //nombres comprensibles para su uso
    $Nombre=$_POST['Nombre'];
    $ApPaterno=$_POST['ApPaterno'];
    $ApMaterno=$_POST['ApMaterno'];
    $Calle=$_POST['Calle'];
    $NumeroExterior=$_POST['NumeroExterior'];
    $Colonia=$_POST['Colonia'];
    $Delegacion=$_POST['Delegacion'];
    $Telefono1=$_POST['Telefono1'];
    $TipoTelefono1=$_POST['TipoTelefono1'];
    $Estado=$_POST['Estado'];

    //se checa el valor de los elementos que pueden estar nulos
    //Numero Interior
    if(isset($_POST['NumeroInterior'])){
      $NumeroInterior=$_POST['NumeroInterior'];
    }else{
      $NumeroInterior="";
    }
    //número y tipo del teléfono 2
    if(isset($_POST['Telefono2'])){
      $Telefono2=$_POST['Telefono2'];
      $TipoTelefono2=$_POST['TipoTelefono2'];
    }else{
      $Telefono2="";
      $TipoTelefono2="";
    }
    //número y tipo del teléfono 3
    if(isset($_POST['Telefono3'])){
      $Telefono3=$_POST['Telefono3'];
      $TipoTelefono3=$_POST['TipoTelefono3'];
    }else{
      $Telefono3="";
      $TipoTelefono3="";
    }
    //email
    if(isset($_POST['Email'])){
      $Email=$_POST['Email'];
    }else{
      $Email="";
    }
    //Observaciones
    if(isset($_POST['Observaciones'])){
      $Observaciones=$_POST['Observaciones'];
    }else{
      $Observaciones="";
    }
    //especificaciones en caso de que se haya
    //guardado un tipo de estado "Otro"
    if(isset($_POST['EspecificarOtro'])){
      $Especificar=$_POST['EspecificarOtro'];
    }else{
      $Especificar="";
    }
    //se valida que los campos obligatorios no esten vacios
    if($NSSA!=null and $Nombre!=null and $ApPaterno!=null and $ApMaterno!=null 
      and $Calle!=null and $NumeroExterior!=null 
      and $Colonia!=null and $Delegacion!=null and $Telefono1!=null 
      and $TipoTelefono1!=null and $Estado!=null){

      try{
        //abrimos una conexion
        $conexion = AbrirBase();

        //generamos la sentencia insert
        $update=$conexion->prepare("UPDATE Paciente SET
                                    Nombre=:nombre,
                                    ApPaterno=:apPaterno,
                                    ApMaterno=:apMaterno,
                                    Calle=:calle,
                                    NumeroExterior=:numeroExterior,
                                    NumeroInterior=:numeroInterior,
                                    Colonia=:colonia,
                                    Delegacion=:delegacion,
                                    CorreoElectronico=:email,
                                    MedicoEnfermera_id=:MEID,
                                    Observaciones=:observaciones,
                                    CatalogoActivo_id=:estado
                                    WHERE NSSA=:nssa");

        //cambio de parametros de los valores no nulos
        $update->bindParam('nssa',$NSSA,PDO::PARAM_STR);
        $update->bindParam('nombre',$Nombre,PDO::PARAM_STR);
        $update->bindParam('apPaterno',$ApPaterno,PDO::PARAM_STR);
        $update->bindParam('apMaterno',$ApMaterno,PDO::PARAM_STR);
        $update->bindParam('calle',$Calle,PDO::PARAM_STR);
        $update->bindParam('numeroExterior',$NumeroExterior,PDO::PARAM_INT);
        $update->bindParam('colonia',$Colonia,PDO::PARAM_STR);
        $update->bindParam('delegacion',$Delegacion,PDO::PARAM_STR);
        $update->bindParam('MEID',$_SESSION['MedicoEnfermera_id'],PDO::PARAM_INT);
        $update->bindParam('estado',$Estado,PDO::PARAM_INT);
        //se cambian los parametros de los valores que pueden ser nulos
        //si contienen una cadena vacia sus variables, se cambia el valor
        //del parametro por una referencia a un valor nulo
        //Número interior
        if($NumeroInterior==""){
          $update->bindValue('numeroInterior',NULL,PDO::PARAM_NULL);
        }else{
          $update->bindParam('numeroInterior',$NumeroInterior,PDO::PARAM_INT);
        }
        //email
        if($Email==""){
          $update->bindValue('email',NULL,PDO::PARAM_NULL);
        }else{
          $update->bindParam('email',$Email,PDO::PARAM_STR);
        }
        //observaciones
        if($Observaciones==""){
          $update->bindValue('observaciones',NULL,PDO::PARAM_NULL);
        }else{
          $update->bindParam('observaciones',$Observaciones,PDO::PARAM_STR);
        }

        //se ejecuta la sentencia
        $valorID=$update->execute();
        //si el UPDATE fue exitoso
        if($valorID){
          //se inicializa un mensaje de que el paciente, por lo menos sus datos personales
          //se han guardado
          $mensaje="Datos personales del paciente actualizados";
          //se eliminan los telefonos anteriores
          $delete=$conexion->prepare("DELETE FROM Telefono 
                                      WHERE Paciente_id=(
                                        SELECT Paciente_id
                                        FROM Paciente
                                        WHERE NSSA=:nssa)");
          $delete->bindParam("nssa",$NSSA,PDO::PARAM_STR);
          $borradoExitoso=$delete->execute();
          //si el borrado de telefonos es exitoso, se procede
          if($borradoExitoso){

            //se genera la sentencia para agregar los telefonos
            $insertTel=$conexion->prepare("INSERT INTO 
              Telefono(Tipo,NumTelefono,Paciente_id)
              VALUES(:tipo,:numero,(
                SELECT Paciente_id 
                FROM Paciente
                WHERE NSSA=:nssa))");
            //se intercambian los parametros por los necesarios
            $insertTel->bindParam('tipo',$TipoTelefono1,PDO::PARAM_STR);
            $insertTel->bindParam('numero',$Telefono1,PDO::PARAM_INT);
            $insertTel->bindParam('nssa',$NSSA,PDO::PARAM_STR);

            //se ejecuta el comando
            $tel1=$insertTel->execute();
            //si es valida la insercion, se agrega al mensaje
            if($tel1){
              $mensaje=$mensaje."\nTeléfono 1 agregado";
            //si no, ocurrio un problema, se agrega al mensaje
            }else{
              $mensaje=$mensaje."\nTeléfono 1 no se pudo agregar";
            }

            //si existe dato para telefono 2, entonces se hace lo mismo que 
            //con el telefono 1
            if($Telefono2!=""){
              $insertTel->bindParam('tipo',$TipoTelefono2,PDO::PARAM_STR);
              $insertTel->bindParam('numero',$Telefono2,PDO::PARAM_INT);
              $insertTel->bindParam('nssa',$NSSA,PDO::PARAM_STR);
              $tel2=$insertTel->execute();
              if($tel2){
                $mensaje=$mensaje."\nTeléfono 2 agregado";
              }else{
                $mensaje=$mensaje."\nTeléfono 2 no se pudo agregar";
              }
            }

            //lo mismo para telefono 3 en caso de que exista
            if($Telefono3!=""){
              $insertTel->bindParam('tipo',$TipoTelefono3,PDO::PARAM_STR);
              $insertTel->bindParam('numero',$Telefono3,PDO::PARAM_INT);
              $insertTel->bindParam('nssa',$NSSA,PDO::PARAM_STR);
              $tel3=$insertTel->execute();
              if($tel3){
                $mensaje=$mensaje."\nTeléfono 3 agregado";
              }else{
                $mensaje=$mensaje."\nTeléfono 3 no se pudo agregar";
              }
            }
            //si el estado es "otro", se debe especificar la razón
            if($Estado=='5'){
              $insertOtro=$conexion->prepare("INSERT INTO 
                                              DesactivoOtro(Paciente_id,Descripcion)
                                              VALUES((
                                                SELECT Paciente_id 
                                                FROM Paciente
                                                WHERE NSSA=:nssa),:otro)");
              $insertOtro->bindParam('nssa',$NSSA,PDO::PARAM_STR);
              $insertOtro->bindParam('otro',$Especificar,PDO::PARAM_STR);
              $registroEstado=$insertOtro->execute();
              //si es exitoso el guardado del estatus en DesactivoOtro, 
              //se concatena un mensjae de exito
              if($registroEstado){
                $mensaje=$mensaje."\nEstado otro actualizado";
              //en caso contrario se concatena un error
              }else{
                $mensaje=$mensaje."\nEstado otro no actualizado";
              }
            }
            //se regresa el mensaje completo concatenado
            echo $mensaje;
          }else{
            //si no se borra bien los telefonos, se regresa el error
            echo $mensaje."\nError al guardar los teléfonos";
          }
        //si el insert no es exitoso, se revisa por que
        }else{
          //se regresa un mensaje de error
          echo "Otro tipo de error ocurrió";
        }
      //si se causa una excepción, se regresa el mensaje de la excepción 
      }catch(Exception $e){
        echo $e->getMessage();
      }
    }
    break;
  //si desde la pagina de registro se vuelve a guardar la informacion
  case 'ActualizarDeGuardar':
    //se toman los datos que deben ser no nulos y se guardan en variables con 
    //nombres comprensibles para su uso
    $Nombre=$_POST['Nombre'];
    $ApPaterno=$_POST['ApPaterno'];
    $ApMaterno=$_POST['ApMaterno'];
    $Calle=$_POST['Calle'];
    $NumeroExterior=$_POST['NumeroExterior'];
    $Colonia=$_POST['Colonia'];
    $Delegacion=$_POST['Delegacion'];
    $Telefono1=$_POST['Telefono1'];
    $TipoTelefono1=$_POST['TipoTelefono1'];

    //se checa el valor de los elementos que pueden estar nulos
    //Numero Interior
    if(isset($_POST['NumeroInterior'])){
      $NumeroInterior=$_POST['NumeroInterior'];
    }else{
      $NumeroInterior="";
    }
    //Teléfono 2 y tipo de teléfono 2
    if(isset($_POST['Telefono2'])){
      $Telefono2=$_POST['Telefono2'];
      $TipoTelefono2=$_POST['TipoTelefono2'];
    }else{
      $Telefono2="";
      $TipoTelefono2="";
    }
    //Teléfono 3 y tipo de teléfono 3
    if(isset($_POST['Telefono3'])){
      $Telefono3=$_POST['Telefono3'];
      $TipoTelefono3=$_POST['TipoTelefono3'];
    }else{
      $Telefono3="";
      $TipoTelefono3="";
    }
    //Email 
    if(isset($_POST['Email'])){
      $Email=$_POST['Email'];
    }else{
      $Email="";
    }
    //Observaciones
    if(isset($_POST['Observaciones'])){
      $Observaciones=$_POST['Observaciones'];
    }else{
      $Observaciones="";
    }
    //se valida que los campos obligatorios no esten vacios
    if($NSSA!=null and $Nombre!=null and $ApPaterno!=null and $ApMaterno!=null 
      and $Calle!=null and $NumeroExterior!=null 
      and $Colonia!=null and $Delegacion!=null and $Telefono1!=null 
      and $TipoTelefono1!=null){

      try{
        //abrimos una conexion
        $conexion = AbrirBase();

        //generamos la sentencia insert
        $update=$conexion->prepare("UPDATE Paciente SET
                                    Nombre=:nombre,
                                    ApPaterno=:apPaterno,
                                    ApMaterno=:apMaterno,
                                    Calle=:calle,
                                    NumeroExterior=:numeroExterior,
                                    NumeroInterior=:numeroInterior,
                                    Colonia=:colonia,
                                    Delegacion=:delegacion,
                                    CorreoElectronico=:email,
                                    MedicoEnfermera_id=:MEID,
                                    Observaciones=:observaciones
                                    WHERE NSSA=:nssa");

        //cambio de parametros que no deben ser nulos 
        $update->bindParam('nssa',$NSSA,PDO::PARAM_STR);
        $update->bindParam('nombre',$Nombre,PDO::PARAM_STR);
        $update->bindParam('apPaterno',$ApPaterno,PDO::PARAM_STR);
        $update->bindParam('apMaterno',$ApMaterno,PDO::PARAM_STR);
        $update->bindParam('calle',$Calle,PDO::PARAM_STR);
        $update->bindParam('numeroExterior',$NumeroExterior,PDO::PARAM_INT);
        $update->bindParam('colonia',$Colonia,PDO::PARAM_STR);
        $update->bindParam('delegacion',$Delegacion,PDO::PARAM_STR);
        $update->bindParam('MEID',$_SESSION['MedicoEnfermera_id'],PDO::PARAM_INT);
        //se cambian los parametros de los valores que pueden ser nulos
        //si contienen una cadena vacia sus variables, se cambia el valor
        //del parametro por una referencia a un valor nulo
        //Número interior
        if($NumeroInterior==""){
          $update->bindValue('numeroInterior',NULL,PDO::PARAM_NULL);
        }else{
          $update->bindParam('numeroInterior',$NumeroInterior,PDO::PARAM_INT);
        }
        //Email
        if($Email==""){
          $update->bindValue('email',NULL,PDO::PARAM_NULL);
        }else{
          $update->bindParam('email',$Email,PDO::PARAM_STR);
        }
        //Observaciones
        if($Observaciones==""){
          $update->bindValue('observaciones',NULL,PDO::PARAM_NULL);
        }else{
          $update->bindParam('observaciones',$Observaciones,PDO::PARAM_STR);
        }

        //se ejecuta la sentencia
        $valorID=$update->execute();
        //si el UPDATE fue exitoso
        if($valorID){
          //se inicializa un mensaje de que el paciente, por lo menos sus datos personales
          //se han guardado
          $mensaje="Datos personales del paciente actualizados";
          //se eliminan los telefonos anteriores
          $delete=$conexion->prepare("DELETE FROM Telefono 
                                      WHERE Paciente_id=(
                                        SELECT Paciente_id
                                        FROM Paciente
                                        WHERE NSSA=:nssa)");
          $delete->bindParam("nssa",$NSSA,PDO::PARAM_STR);
          $borradoExitoso=$delete->execute();
          //si el borrado de telefonos es exitoso, se procede
          if($borradoExitoso){

            //se genera la sentencia para agregar los telefonos
            $insertTel=$conexion->prepare("INSERT INTO 
              Telefono(Tipo,NumTelefono,Paciente_id)
              VALUES(:tipo,:numero,(
                SELECT Paciente_id 
                FROM Paciente
                WHERE NSSA=:nssa))");
            //se intercambian los parametros por los necesarios
            $insertTel->bindParam('tipo',$TipoTelefono1,PDO::PARAM_STR);
            $insertTel->bindParam('numero',$Telefono1,PDO::PARAM_INT);
            $insertTel->bindParam('nssa',$NSSA,PDO::PARAM_STR);

            //se ejecuta el comando
            $tel1=$insertTel->execute();
            //si es valida la insercion, se agrega al mensaje
            if($tel1){
              $mensaje=$mensaje."\nTeléfono 1 agregado";
            //si no, ocurrio un problema, se agrega al mensaje
            }else{
              $mensaje=$mensaje."\nTeléfono 1 no se pudo agregar";
            }

            //si existe dato para telefono 2, entonces se hace lo mismo que 
            //con el telefono 1
            if($Telefono2!=""){
              $insertTel->bindParam('tipo',$TipoTelefono2,PDO::PARAM_STR);
              $insertTel->bindParam('numero',$Telefono2,PDO::PARAM_INT);
              $insertTel->bindParam('nssa',$NSSA,PDO::PARAM_STR);
              $tel2=$insertTel->execute();
              if($tel2){
                $mensaje=$mensaje."\nTeléfono 2 agregado";
              }else{
                $mensaje=$mensaje."\nTeléfono 2 no se pudo agregar";
              }
            }

            //lo mismo para telefono 3 en caso de que exista
            if($Telefono3!=""){
              $insertTel->bindParam('tipo',$TipoTelefono3,PDO::PARAM_STR);
              $insertTel->bindParam('numero',$Telefono3,PDO::PARAM_INT);
              $insertTel->bindParam('nssa',$NSSA,PDO::PARAM_STR);
              $tel3=$insertTel->execute();
              if($tel3){
                $mensaje=$mensaje."\nTeléfono 3 agregado";
              }else{
                $mensaje=$mensaje."\nTeléfono 3 no se pudo agregar";
              }
            }
            //si el estado es "otro", se debe especificar la razón
            
            echo $mensaje;
          }else{
            //si no se borra bien los mensajes, se regresa el error
            echo $mensaje."\nError al guardar los teléfonos";
          }
        //si el insert no es exitoso, se revisa por que
        }else{
          //se regresa un mensaje de error
          echo "Otro tipo de error ocurrió";
        }
      //si se genera una excepción, se regresa el mensaje de la excepción
      }catch(Exception $e){
        echo $e->getMessage();
      }
    }
    break; 
  //si la tarea es "Encontrar" si existe o no un paciente, se procede con este
  //case
  case 'Encontrar':
    //se valida que el campo obligatorio para la busqueda no esté vacio
    if ($NSSA!=null) {
      try{
        //abrimos la base de datos
        $conexion =AbrirBase();

        //generamos la sentencia sql para buscar los datos del paciente
        $select =$conexion->prepare("SELECT Paciente_id FROM Paciente WHERE 
                  NSSA =:nssa");
        //cambiamos el parametro y ejecutamos la sentencia select
        $select->bindParam("nssa",$NSSA,PDO::PARAM_STR);
        $select->execute();
        //si el select trae una linea se manda mensaje de que se encontró
        if($select->rowCount()==1){
          echo "Encontrado";
        //en caso contrario, se manda un mensaje de error, no se encontró al 
        //paciente con dicho NSS
        }else{
          echo "Ese paciente no existe";
        }
      //si existe una excepción, se regresa el mensaje
      }catch(Exception $e){
        echo $e->getMessage();
      }
    }
    break;
  //Si se trata de cambiar, este case nos inicializa la llave "NSSA" de la variable
  //$_SESSION para usarla en otra pantalla
  case 'Cambiar':
    $_SESSION['NSSA']=$_POST['NSSA'];
    break;
  //limpia la llave NSSA de la variable $_SESSION
  case 'Limpiar':
    if(isset($_SESSION['NSSA'])){
      $_SESSION['NSSA']="";
    }
    break;
  //opcion para agregar la glucosa del paciente
  case 'AgregarGlucosa':
    //se inicializan los valores del $_POST dentro de variables entendibles
    $Glucosa=$_POST['Glucosa'];
    $Tipo=$_POST['Tipo'];
    $NSSA=$_SESSION['NSSA'];
    //se checa que los valores obligatorios no esten vacios
    if($NSSA!=null and $Glucosa!=null and $Tipo!=null){
      try{
        //iniciamos conexion con la base de datos
        $conexion=AbrirBase();

        //Se genera la sentencia insert para guardar los datos del paciente
        $insert=$conexion->prepare("INSERT INTO ConsultaDeteccion 
                          (Resultado,Paciente_id,MedicoEnfermera_id,Tipo)
                          VALUES(:glucosa,(
                            SELECT Paciente_id
                            FROM Paciente
                            WHERE NSSA=:nssa),:MEID,:tipo)");
        //se cambian los parametros, ninguno es nulo
        $insert->bindParam("nssa",$NSSA,PDO::PARAM_STR);
        $insert->bindParam("glucosa",$Glucosa,PDO::PARAM_INT);
        $insert->bindParam("tipo",$Tipo,PDO::PARAM_STR);
        $insert->bindParam("MEID",$_SESSION['MedicoEnfermera_id'],PDO::PARAM_INT);
        //se ejecuta la sentencia insert y su valor de exito se guarda en la variable
        //$registros
        $registros=$insert->execute();
        //si el insert fue exitoso, se regresa el mensaje de "Guardado"
        if($registros){
          echo "Guardado";
        //en caso contrario, se regresa un mensaje de error
        }else{
          echo "Error";
        }
      //si existe una excepción, se regresa el mensaje de dicha excepción
      }catch(Exception $e){
        echo $e->getMessage();
      }
    }
    break;
  //Si la tarea es revisar el estatus del paciente
  case 'RevisarEstatus':
    //se revisa que el valor del NSSA no sea nulo
    if($NSSA!=null){
      try{ 
        //iniciamos una conexion con la base de datos
        $conexion=AbrirBase();

        //preparamos la sentencia SQL que nos regrese el valor
        //del estatus del paciente
        $select=$conexion->prepare("SELECT CatalogoActivo_id
                                    FROM Paciente
                                    WHERE NSSA=:nssa");
        //cambiamos parametros y executamos la instrucción guardando su valor
        //de exito en la variable $registro
        $select->bindParam("nssa",$NSSA,PDO::PARAM_STR);
        $registro=$select->execute();
        //si fue exitosa la consulta
        if($registro){
          //se saca el registro encontrado
          $paciente=$select->fetch(PDO::PARAM_STR);
          //se busca el estatus_id y se regresa
          echo $paciente['CatalogoActivo_id'];
        }else{
          //si no fue exitosa la sentencia, se envia el error
          echo "Error al hacer la búsqueda del estatus";
        }
      //si existe una excepción, se regresa el mensaje de la excepción
      }catch(Exception $e){
        echo $e->getMessage();
      }
    }
    break;
  //para encontrar la ultima actualizacion del estatus otro del paciente
  case 'ObtenerEstatusOtro':
    //se valida que la variable $NSSA no este nula
    if($NSSA!=null){
      try{ 
        //iniciamos una conexion con la base de datos
        $conexion=AbrirBase();
        //preparamos la sentencia SQL para encontrar la descripción de los 
        //registros del paciente con tal NSSA que tiene inserciones en la tabla
        //desactivoOtro, se ordena de forma descendente para que el primer
        //registro que encontremos sea el mas reciente
        $select=$conexion->prepare("SELECT Descripcion
                                    FROM DesactivoOtro
                                    WHERE Paciente_id=(
                                      SELECT Paciente_id
                                      FROM Paciente
                                      WHERE NSSA=:nssa)
                                    ORDER BY FechaRegistro DESC");
        //cambiamos parametros, executamos y guardamos el valor de exito en la 
        //variable $registro
        $select->bindParam("nssa",$NSSA,PDO::PARAM_STR);
        $registro=$select->execute();
        //si fue exitosa la consulta
        if($registro){
          //se saca el registro encontrado
          $paciente=$select->fetch(PDO::PARAM_STR);
          //se busca el estatus_id y se regresa
          echo $paciente['Descripcion'];
        }else{
          //si no fue exitosa la sentencia, se envia el error
          echo "Error al hacer la busqueda de la Descripcion";
        }
      //si existe una excepción se regresa el mensaje de esta excepción
      }catch(Exception $e){
        echo $e->getMessage();
      }
    }
    break;
  //actualiza el estatus del paciente anterior mantenidiendo los datos pero 
  //desactivandolo, de esta forma se aborta el procedimiento de registro de 
  //un paciente
  case 'Abortar':
    //se toma el valor de la variable NSSA como el guardado en la variable
    //$_SESSION
    $NSSA=$_SESSION['NSSA'];
    //si el dato es diferente de null
    if($NSSA!=null){
      try{
        //conexion a la base de datos
        $conexion=AbrirBase();

        //sentencia update para actualizar
        $update=$conexion->prepare("UPDATE Paciente 
                                    SET CatalogoActivo_id=5
                                    WHERE NSSA=:nssa");
        //Cambiamos parametros, ejecutamos y mantenemos el valor de exito de la
        //ejecución en la variable registro1
        $update->bindParam('nssa',$NSSA,PDO::PARAM_STR);
        $registro1=$update->execute();
        //si la actualización fue exitosa
        if($registro1){
          //se genera la inserción para la tabla Desactivo otro
          $insertOtro=$conexion->prepare("INSERT INTO 
                                          DesactivoOtro(Paciente_id,Descripcion)
                                          VALUES((
                                            SELECT Paciente_id 
                                            FROM Paciente
                                            WHERE NSSA=:nssa),'Registro Abortado')");

          //se cambian los parametros y se ejecuta, se guarda el valor de exito en 
          //la variable $registroEstado
          $insertOtro->bindParam('nssa',$NSSA,PDO::PARAM_STR);
          $registroEstado=$insertOtro->execute();
          //si la inserción en dicha tabla es exitosa, se regresa mensaje de que
          //se terminó de abortar el procedimiento
          if($registroEstado){
            echo "Abortado";
          //en caso contrario, si no se pudo hacer la insreción en DesactivoOtro,
          //se regresa mensaje de error
          }else{
            echo "Error al terminar de abortar";
          }
        //si la actualización no fue exitosa, se manda mensaje de error
        }else{
          echo "Error al abortar";
        }
      //si existe una excepción se regresa el mensaje de esta excepción
      }catch(Exception $e){
        echo $e->getMessage();
      }
    }
    break;
  //si no es ninguna de las tareas anteriores, se manda mensaje de error
  default:
    echo "Boton no encontrado";
    break;
}


?>