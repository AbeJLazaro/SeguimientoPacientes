<?php
//****************************************************************************************
//Nombre:         MedicoEnfermera.php
//Objetivos:      Tiene las instrucciones necesarias para las pantallas relacionadas al
//                registro y actualización de personal como lo son 
//                "RegistroMedicoEnfermera.php" y "ActualizacionMedicoEnfermera.php"
//Creado por:     Lázaro Martínez Abraham Josué
//Fecha:          viernes 3 de enero de 2020
//version:        1.0                 
//****************************************************************************************
//Se llama al archivo conexion.php que contiene la funcion para conectar con la base
//se datos
include('../conexion/conexion.php');
//Se llama al archivo global para usar la variable $_SESSION
include('../conexion/global.php');

//si la variable $_POST contiene la llave Matricula, se genera una variable para
//trabajar su valor. Se toma el valor de la llave Boton de la variable $_POST
//en una variable llamada $Boton
if(isset($_POST['Matricula'])){
  $Matricula=$_POST['Matricula'];
}
$Boton=$_POST['Boton'];

//se checa que valor trae la llave de Boton
switch ($Boton) {
  //en caso de que la tarea sea guardar datos
  case 'Guardar':
    //se toman los datos que deben ser no nulos
    $Password=$_POST['Password'];
    $Nombre=$_POST['Nombre'];
    $ApPaterno=$_POST['ApPaterno'];
    $ApMaterno=$_POST['ApMaterno'];
    $Categoria=$_POST['Categoria'];
    $Subcategoria=$_POST['Subcategoria'];
    $Tipo=$_POST['Tipo'];

    //se valida que los datos no sean nulos
    if($Matricula!=null and $Nombre!=null and $ApPaterno!=null and $ApMaterno!=null 
      and $Password!=null and $Categoria!=null 
      and $Subcategoria!=null and $Tipo!=null){

      try{
        //abrimos una conexion
        $conexion = AbrirBase();

        //generamos la sentencia insert para guardar los datos
        $insert=$conexion->prepare("INSERT INTO MedicoEnfermera
        (Matricula,Contrasena,Nombre,ApPaterno,ApMaterno,Categoria_id,Subcategoria_id,
        TipoUsuario)
        VALUES
        (:matricula,MD5(:password),:nombre,:apPaterno,:apMaterno,:categoria,:subcategoria,
        :tipo)");

        //cambio de parametros que no deben ser nulos
        $insert->bindParam('matricula',$Matricula,PDO::PARAM_STR);
        $insert->bindParam('password',$Password,PDO::PARAM_STR);
        $insert->bindParam('nombre',$Nombre,PDO::PARAM_STR);
        $insert->bindParam('apPaterno',$ApPaterno,PDO::PARAM_STR);
        $insert->bindParam('apMaterno',$ApMaterno,PDO::PARAM_STR);
        $insert->bindParam('categoria',$Categoria,PDO::PARAM_INT);
        $insert->bindParam('tipo',$Tipo,PDO::PARAM_STR);
        //si la subcategoria vale "5" (no aplica), se cambia por un valor
        //NULL (nulo)
        if($Subcategoria==5){
          $insert->bindValue('subcategoria',NULL,PDO::PARAM_NULL);
        }else{
          $insert->bindParam('subcategoria',$Subcategoria,PDO::PARAM_INT);
        }
        //se ejecuta la sentencia y se guarda su valor de exito en la variable
        //$valorID
        $valorID=$insert->execute();
        //si el insert fue exitoso se manda un mensaje de exito
        if($valorID){
          echo "Guardado";
        //si el insert no es exitoso, se revisa por que
        }else{
          //se hace una sentencia select para saber si la persona ya existe dentro
          //de las tablas del personal
          $select=$conexion->prepare("SELECT MedicoEnfermera_id FROM MedicoEnfermera 
            WHERE Matricula=:matricula");
          //se cambian los parametros y se executa la sentencia select
          $select->bindParam('matricula',$Matricula,PDO::PARAM_STR);
          $select->execute();
          //si el select encuentra al menos un registro, significa
          //que la persona ya existe, se manda un mensaje de aviso
          if($select->rowCount()>0){
            echo "Esa persona ya existe dentro del personal";
          //si no existe, el error es de otro tipo
          }else{
            echo "Otro tipo de error ocurrió";
          }
        }
      //si existe una excepción se regresa el mensaje de esta excepción
      }catch(Exception $e){
        echo $e->getMessage();
      }
    }
    break;
  //si se hace una busqueda de la informacion del personal
  case 'Buscar':
    //se valida que el campo no esté vacio
    if ($Matricula!=null) {
      try{
        //abrimos la base de datos
        $conexion =AbrirBase();

        //generamos la sentencia sql para buscar los datos del personal
        $select =$conexion->prepare("SELECT * FROM MedicoEnfermera WHERE 
                  Matricula =:matricula");
        //cambiamos los parametros, ejecutamos y guardamos el valor de exito
        //en la variable $registro
        $select->bindParam("matricula",$Matricula,PDO::PARAM_STR);
        $registro=$select->execute();
        //si el select es exitoso
        if($registro){
          //si nos trajó por lo menos un registro
          if($select->rowCount()>=1){
            //tomamos el primer registro encontrado y lo guardamos en la variable
            //$registro
            $registro=$select->fetch(PDO::PARAM_STR);
            //generamos un mensaje tipo CSV con la información del paciente
            //usando la variable $registro
            $mensaje="";
            $mensaje=$mensaje.$registro['Nombre'].",";
            $mensaje=$mensaje.$registro['ApPaterno'].",";
            $mensaje=$mensaje.$registro['ApMaterno'].",";
            $mensaje=$mensaje.$registro['TipoUsuario'].",";
            $mensaje=$mensaje.$registro['Categoria_id'].",";
            //si subcategoria_id es una cadena vacia, es por que el valor era nulo
            //por ello se cambia y se concatena una palabra "NULL", en caso contrario 
            //se concatena el valor que tiene la variable
            if($registro['Subcategoria_id']==""){
              $mensaje=$mensaje."NULL".",";
            }else{
              $mensaje=$mensaje.$registro['Subcategoria_id'].",";
            }
            //se regresa el mensaje con la información concatenada
            echo $mensaje;
          //si no trae ningun registro, manda mensaje de error, de que ese
          //personal no existe dentro de la base de datos
          }else{
            echo "Ese paciente no existe";
          }
        //si no se puede hace el select se marca un error
        }else{
          echo "Error con la sentencia sql";
        }
      //si existe una excepción se regresa el mensaje de esta excepción
      }catch(Exception $e){
        echo $e->getMessage();
      }
    }

    break;
  //en caso de que se actualice la información de un paciente
  case 'Actualizar':
    //se toman los datos que deben ser no nulos
    $Password=$_POST['Password'];
    $Nombre=$_POST['Nombre'];
    $ApPaterno=$_POST['ApPaterno'];
    $ApMaterno=$_POST['ApMaterno'];
    $Categoria=$_POST['Categoria'];
    $Subcategoria=$_POST['Subcategoria'];
    $Tipo=$_POST['Tipo'];

    //se valida que los datos no sean nulos
    if($Matricula!=null and $Nombre!=null and $ApPaterno!=null and $ApMaterno!=null 
      and $Password!=null and $Categoria!=null 
      and $Subcategoria!=null and $Tipo!=null){

      try{
        //abrimos una conexion
        $conexion = AbrirBase();

        //generamos la sentencia update para actualizar los datos
        //del personal
        $update=$conexion->prepare("UPDATE MedicoEnfermera SET
                                    Contrasena=MD5(:password),
                                    Nombre=:nombre,
                                    ApPaterno=:apPaterno,
                                    ApMaterno=:apMaterno,
                                    Categoria_id=:categoria,
                                    Subcategoria_id=:subcategoria,
                                    TipoUsuario=:tipo
                                    WHERE Matricula=:matricula");

        //cambio de parametros no nulos
        $update->bindParam('matricula',$Matricula,PDO::PARAM_INT);
        $update->bindParam('password',$Password,PDO::PARAM_STR);
        $update->bindParam('nombre',$Nombre,PDO::PARAM_STR);
        $update->bindParam('apPaterno',$ApPaterno,PDO::PARAM_STR);
        $update->bindParam('apMaterno',$ApMaterno,PDO::PARAM_STR);
        $update->bindParam('categoria',$Categoria,PDO::PARAM_INT);
        $update->bindParam('tipo',$Tipo,PDO::PARAM_STR);
        //si la subcategoria es "5" (no aplica) se cambia por un valor NULL
        if($Subcategoria==5){
          $update->bindValue('subcategoria',NULL,PDO::PARAM_NULL);
        }else{
          $update->bindParam('subcategoria',$Subcategoria,PDO::PARAM_INT);
        }
        //se ejecuta la sentencia y se guarda su valor en la variable $registro
        $registro=$update->execute();
        //si el update fue exitoso se manda un mensaje de exito
        if($registro){
          echo "Datos personales actualizados";
        //si el update no es exitoso, se manda mensaje de error
        }else{
          echo "Otro tipo de error ocurrió";
        }
      //si existe una excepción se regresa el mensaje de esta excepción
      }catch(Exception $e){
        echo $e->getMessage();
      }
    }
    break;
  //opcion para actualizar sin cambiar la contraseña
  case 'ActualizarSinPassword':
    //se toman los valores de los valores no nulos
    $Nombre=$_POST['Nombre'];
    $ApPaterno=$_POST['ApPaterno'];
    $ApMaterno=$_POST['ApMaterno'];
    $Categoria=$_POST['Categoria'];
    $Subcategoria=$_POST['Subcategoria'];
    $Tipo=$_POST['Tipo'];
    //se verifica que los valores no sean nulos
    if($Matricula!=null and $Nombre!=null and $ApPaterno!=null and $ApMaterno!=null 
      and $Categoria!=null 
      and $Subcategoria!=null and $Tipo!=null){
      //se hace el mismo procedimiento que en "Actualizar" pero dejamos fuera la
      //contraseña
      try{
        //abrimos una conexion
        $conexion = AbrirBase();

        //generamos la sentencia update
        $update=$conexion->prepare("UPDATE MedicoEnfermera SET
                                    Nombre=:nombre,
                                    ApPaterno=:apPaterno,
                                    ApMaterno=:apMaterno,
                                    Categoria_id=:categoria,
                                    Subcategoria_id=:subcategoria,
                                    TipoUsuario=:tipo
                                    WHERE Matricula=:matricula");

        //cambio de parametros
        $update->bindParam('matricula',$Matricula,PDO::PARAM_INT);
        $update->bindParam('nombre',$Nombre,PDO::PARAM_STR);
        $update->bindParam('apPaterno',$ApPaterno,PDO::PARAM_STR);
        $update->bindParam('apMaterno',$ApMaterno,PDO::PARAM_STR);
        $update->bindParam('categoria',$Categoria,PDO::PARAM_INT);
        $update->bindParam('tipo',$Tipo,PDO::PARAM_STR);

        if($Subcategoria==5){
          $update->bindValue('subcategoria',NULL,PDO::PARAM_NULL);
        }else{
          $update->bindParam('subcategoria',$Subcategoria,PDO::PARAM_INT);
        }
        //se ejecuta la sentencia
        $registro=$update->execute();
        //si el update fue exitoso
        if($registro){
          echo "Datos personales actualizados";
        //si el update no es exitoso, se revisa por que
        }else{
          echo "Otro tipo de error ocurrió";
        }
      //si existe una excepción se regresa el mensaje de esta excepción
      }catch(Exception $e){
        echo $e->getMessage();
      }
    }
    break;
  //si desde la pagina de registro se vuelve a guardar la informacion
  case 'ActualizarDeGuardar':
    //se toman los datos que no deben ser nulos
    $Password=$_POST['Password'];
    $Nombre=$_POST['Nombre'];
    $ApPaterno=$_POST['ApPaterno'];
    $ApMaterno=$_POST['ApMaterno'];
    $Categoria=$_POST['Categoria'];
    $Subcategoria=$_POST['Subcategoria'];
    $Tipo=$_POST['Tipo'];
    //se verifica que no sean nulos
    if($Matricula!=null and $Nombre!=null and $ApPaterno!=null and $ApMaterno!=null 
      and $Password!=null and $Categoria!=null 
      and $Subcategoria!=null and $Tipo!=null){

      try{
        //abrimos una conexion
        $conexion = AbrirBase();

        //generamos la sentencia update
        $update=$conexion->prepare("UPDATE MedicoEnfermera SET
                                    Contrasena=MD5(:password),
                                    Nombre=:nombre,
                                    ApPaterno=:apPaterno,
                                    ApMaterno=:apMaterno,
                                    Categoria_id=:categoria,
                                    Subcategoria_id=:subcategoria,
                                    TipoUsuario=:tipo
                                    WHERE Matricula=:matricula");

        //cambio de parametros no nulos
        $update->bindParam('matricula',$Matricula,PDO::PARAM_INT);
        $update->bindParam('password',$Password,PDO::PARAM_STR);
        $update->bindParam('nombre',$Nombre,PDO::PARAM_STR);
        $update->bindParam('apPaterno',$ApPaterno,PDO::PARAM_STR);
        $update->bindParam('apMaterno',$ApMaterno,PDO::PARAM_STR);
        $update->bindParam('categoria',$Categoria,PDO::PARAM_INT);
        $update->bindParam('tipo',$Tipo,PDO::PARAM_STR);
        //si subcategoria es 5 de no aplica, se coloca como un valor nulo
        if($Subcategoria==5){
          $update->bindValue('subcategoria',NULL,PDO::PARAM_NULL);
        }else{
          $update->bindParam('subcategoria',$Subcategoria,PDO::PARAM_INT);
        }
        //se ejecuta la sentencia
        $valorID=$update->execute();
        //si el update fue exitoso se manda mensaje de exito
        if($valorID){
          echo "Datos personales actualizados";
        //si el update no es exitoso se manda mensaje de error
        }else{
          echo "Otro tipo de error ocurrió";
        }
      //si existe una excepción se regresa el mensaje de esta excepción
      }catch(Exception $e){
        echo $e->getMessage();
      }
    }
    break; 
  //si se buscan la existencia de una persona dentro del personal registrado
  case 'Encontrar':
    //se valida que el campo no esté vacio
    if ($Matricula!=null) {
      try{
        //abrimos la base de datos
        $conexion =AbrirBase();

        //generamos la sentencia sql para buscar los datos del personal
        $select =$conexion->prepare("SELECT MedicoEnfermera_id FROM MedicoEnfermera WHERE 
                  Matricula =:matricula");
        //se cambian los parametros, se ejecuta la sentencia
        $select->bindParam("matricula",$Matricula,PDO::PARAM_STR);
        $select->execute();
        //si nos regresa un registro manda mensaje de que se encontró el personal
        if($select->rowCount()==1){
          echo "Encontrado";
        //en caso de que no tenga regsitros el select, mandamos mensaje de que no
        //existen datos de esa persona
        }else{
          echo "No existen datos para esa matrícula";
        }
      //si existe una excepción se regresa el mensaje de esta excepción
      }catch(Exception $ex){
        echo $e->getMessage();
      }
    }

    break;
  //para cambiar de pantalla
  case 'Cambiar':
    //se inicializa una llave de $_SESSION con el valor de la matricula en $_POST
    $_SESSION['PasarMatricula']=$_POST['Matricula'];
    break;
  //si la tarea es limpiar la variable session
  case 'Limpiar':
    //se cambia el valor de la llave por una cadena vacia
    $_SESSION['PasarMatricula']="";
    break;
  //si no es ninguno de los casos anteriores, se manda mensaje de error
  default:
    echo "Error";
    break;
}
?>