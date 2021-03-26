//****************************************************************************************
//Nombre:         mainRP.css
//Objetivos:      Código JS para registrar a un paciente, valida los campos del formulario
//                y da funcionalidad a los botones. También prepara datos para el cambio de
//                pantala a la de GlucosaDeteccion.p
//Creado por:     Lázaro Martínez Abraham Josué
//Fecha:          viernes 3 de enero de 2020
//version:        1.0                 
//****************************************************************************************

//VARIABLES*******************************************************************************
//Variable que nos indica si ya se guardaron los cambios
var guardado=0;
//variable que nos indica cuantos telefonos activos hay
var telefonoActivo=1;
//se desactiva el boton de siguiente hasta que se guarde y se ocultan los demás
//telefonos
$('#Siguiente').attr('disabled',true);
$("#Tel2").hide();
$("#Tel3").hide();

//EVENTOS*********************************************************************************
//cuando se hace click en el boton guardar
$('#Guardar').click(function(){
  limpiarSesion();
  //se valida los campos si estan llenos o no
  VisualValidacion();
  //datos del formulario
  var nssa=$('#NSSA').val();
  var nombre=$('#NombrePaciente').val();
  var apPaterno=$('#ApPaterno').val();
  var apMaterno=$('#ApMaterno').val();
  var calle=$('#Calle').val();
  var numeroExterior=$('#NumeroExterior').val();
  var numeroInterior=$('#NumeroInterior').val();
  var colonia=$('#Colonia').val();
  var delegacion=$('#Delegacion').val();
  var correo=$("#Email").val();
  var observaciones=$("#Observaciones").val();
  var telefono1=$('#NumeroTelefono1').val();
  var tipoTelefono1=TipoTelefonoFun('1');
  var telefono2=$('#NumeroTelefono2').val();
  var tipoTelefono2=TipoTelefonoFun('2');
  var telefono3=$('#NumeroTelefono3').val();
  var tipoTelefono3=TipoTelefonoFun('3');
  //Con una función se valida que los campos estén bien
  var continuar=Validacion(nombre, apPaterno, apMaterno, calle, numeroExterior,
    colonia,delegacion,telefono1);
  //si los campos obligatorios estan llenos, se continua
  if(continuar){
    //se muestra un dialogo para confirmación
    swal({
      title: "¿Desea guardar los cambios?",
      icon: "info",
      buttons: true
    })//si se confirma, procede a comprobar varios campos
    .then(
      (confirm) => {
        if (confirm) {
          //se valida que todo tenga el formato indicado
          //nombres sin numeros
          //digitos sin letras
          var FormatoCorrecto=ContenidoValidacion();
          if(FormatoCorrecto=="Correcto"){
          //no se pide confirmación
            if(guardado!=1){
              
              $.ajax({
                method: 'POST',
                //ruta del archivo php de control
                url: 'control/Paciente.php',
                //datos que se enviaran
                data:{"NSSA": nssa,
                      "Nombre":nombre,
                      "ApPaterno":apPaterno,
                      "ApMaterno":apMaterno,
                      "Calle":calle,
                      "NumeroExterior":numeroExterior,
                      "NumeroInterior":numeroInterior,
                      "Colonia":colonia,
                      "Delegacion":delegacion,
                      "Telefono1":telefono1,
                      "TipoTelefono1":tipoTelefono1,
                      "Telefono2":telefono2,
                      "TipoTelefono2":tipoTelefono2,
                      "Telefono3":telefono3,
                      "TipoTelefono3":tipoTelefono3,
                      "Email":correo,
                      "Observaciones":observaciones,
                      "Boton":"Guardar"},
                
                // el parametro res es la respuesta que da php mediante impresion de pantalla (echo)
                success: function(res){
                  //se regresa un mensaje especifico si todo salió bien
                  var success="Datos personales del paciente registrados";
                  success=success+"\nTeléfono 1 agregado";
                  var success2=success+"\nTeléfono 2 agregado";
                  var success3=success2+"\nTeléfono 3 agregado";
                  if(res==success || res==success2 || res==success3){
                    //se muestra una ventana de confirmación
                    swal({
                      title: "Paciente registrado",
                      icon: "success",
                    }).then(
                      (confirm)=>{
                        $('#Regresar').attr('disabled',true);
                        $('#Siguiente').attr('disabled',false);
                        $('#NSSA').attr('disabled',true);
                      }
                    );
                    guardado=1;
                  }else{
                    if(res=="Ese paciente ya existe"){
                      Invalido($('#NSSA'));
                    }
                    swal({
                      title: "Error",
                      text: res,
                      icon: "warning",
                    });
                  }
                }
              });
            }else{
              $.ajax({
              method: 'POST',
              //ruta del archivo php de control
              url: 'control/Paciente.php',
              //datos que se enviaran
              data:{"NSSA": nssa,
                    "Nombre":nombre,
                    "ApPaterno":apPaterno,
                    "ApMaterno":apMaterno,
                    "Calle":calle,
                    "NumeroExterior":numeroExterior,
                    "NumeroInterior":numeroInterior,
                    "Colonia":colonia,
                    "Delegacion":delegacion,
                    "Telefono1":telefono1,
                    "TipoTelefono1":tipoTelefono1,
                    "Telefono2":telefono2,
                    "TipoTelefono2":tipoTelefono2,
                    "Telefono3":telefono3,
                    "TipoTelefono3":tipoTelefono3,
                    "Email":correo,
                    "Observaciones":observaciones,
                    "Boton":"ActualizarDeGuardar"},
              
              // el parametro res es la respuesta que da php mediante impresion de pantalla (echo)
              success: function(res){
                //se regresa un mensaje especifico si todo salió bien
                var success="Datos personales del paciente actualizados";
                success=success+"\nTeléfono 1 agregado";
                var success2=success+"\nTeléfono 2 agregado";
                var success3=success2+"\nTeléfono 3 agregado";
                if(res==success || res==success2 || res==success3){
                  //se muestra una ventana de confirmación
                  swal({
                    title: "Paciente actualizado",
                    text: res,
                    icon: "success",
                  });
                  $('#Regresar').attr('disabled',true);
                  $('#Siguiente').attr('disabled',false);
                  $('#NSSA').attr('disabled',true);
                }else{
                  swal({
                    title: "Error",
                    text: res,
                    icon: "warning",
                  });
                }
              }
            }); 
            } 
          }else{
            //si hay problema con el el formato de los datos, se imprime el
            //error
            swal({
              title: "Error en los datos",
              text: FormatoCorrecto,
              icon: "warning",
              buttons:false,
              dangerMode: true
            });
          }               
        }
      }
    );
    //se valida que los campos tengan opciones validas
      
  //si los campos no estan llenos, se muestra un mensaje pidiendolo
  }else{
    swal({
      title: "Debes llenar todos los campos",
      icon: "info",
    });
  }
});
//si se hace click en el boton agregar para telefono
$('#AgregarBoton').click(function(){
  //se incrementa en una unidad la cantidad de telefonos activos
  telefonoActivo=telefonoActivo+1;
  //se compara sus valores, si es 2, se muestra la opción para agregar
  //el telefono dos
  if(telefonoActivo==2){
    $("#Tel2").show();
  //si es 3, se muestra la opcion para agregar el telefono 3
  }else if(telefonoActivo==3){
    $("#Tel3").show();
  //si es 4, significa que se trata de agregar un telefono de mas
  //caso que no se puede
  }else if(telefonoActivo>3){
    //se muestra un error
    swal({
      title: "Solo puedes agregar hasta 3 teléfonos",
      icon: "warning",
    });
    //y se decrementa la cantidad de telefonos para que permanezca en 3
    telefonoActivo=telefonoActivo-1;
  }
});
//eventos cuando se presiona el boton de eliminar de los telefonos
$('#EliminarTelefono3').click(function(){
  //decrementa la cantidad de telefonos activos y se oculta la opción
  //para agregar el telefono3
  telefonoActivo=telefonoActivo-1;
  $("#Tel3").hide();
  $('#NumeroTelefono3').val("");
  document.getElementById('Celular3').checked = false;
  document.getElementById('Fijo3').checked = true;
});

$('#EliminarTelefono2').click(function(){
  //decrementa la cantidad de telefonos activos y se oculta la opción
  //para agregar el telefono3
  telefonoActivo=telefonoActivo-1;
  //si existen aun dos telefonos (los que eran 1 y 3)
  if(telefonoActivo==2){
    //se compara si el telefono3 tenía datos
    var telefono=$('#NumeroTelefono3').val();
    //si si tiene datos, se pasan al telefono2
    if(telefono!=""){
      //se pasa el numero de telefono del 3 al 2 y se limpia el 3
      $('#NumeroTelefono2').val(telefono);
      $('#NumeroTelefono3').val("");
      //se pasa el tipo de telefono del 3 al 2
      document.getElementById('Fijo2').checked =$('#Fijo3').is(':checked');
      document.getElementById('Celular2').checked =$('#Celular3').is(':checked');
      //se resetean los tipos del telefono 3
      document.getElementById('Celular3').checked = false;
      document.getElementById('Fijo3').checked = true;
      //se oculta el div del telefono 3
      $("#Tel3").hide();
    //si no tiene datos el telefono 3
    }else{
      //se oculta el telefono 3 y se resetean sus tipos
      $("#Tel3").hide();
      document.getElementById('Celular3').checked = false;
      document.getElementById('Fijo3').checked = true;
      //se resetea el telefono 2
      $('#NumeroTelefono2').val("");
      document.getElementById('Celular2').checked = false;
      document.getElementById('Fijo2').checked = true;
    }
  //si solo queda un telefono (solo estaban el telefono 1 y 2)
  }else if(telefonoActivo==1){
    //se oculta el telefono 2 y se resetea
    $("#Tel2").hide();
    $('#NumeroTelefono2').val("");
    document.getElementById('Celular2').checked = false;
    document.getElementById('Fijo2').checked = true;
  }
});

$('#EliminarTelefono1').click(function(){
  //se decrementa la cantidad de telefonos que hay
  telefonoActivo=telefonoActivo-1;
  //si aun hay dos telefonos(estaban todos los telefonos)
  if(telefonoActivo==2){
    //se toman los valores de ambos telefonos
    var telefono1=$('#NumeroTelefono2').val();
    var telefono2=$('#NumeroTelefono3').val();
    //si al menos uno tenía datos
    if(telefono1!="" || telefono2!=""){
      //el telefono 1 tiene los datos y tipo del telefono 2
      $('#NumeroTelefono1').val(telefono1);
      document.getElementById('Fijo1').checked =$('#Fijo2').is(':checked');
      document.getElementById('Celular1').checked =$('#Celular2').is(':checked');
      //el telefono 2 tiene los datos y tupo del telefono 3
      $('#NumeroTelefono2').val(telefono2);
      document.getElementById('Fijo2').checked =$('#Fijo3').is(':checked');
      document.getElementById('Celular2').checked =$('#Celular3').is(':checked');
      //el telefono 3 resetea y se oculta
      $('#NumeroTelefono3').val("");
      document.getElementById('Celular3').checked = false;
      document.getElementById('Fijo3').checked = true;
      $("#Tel3").hide();
    //si ninguno tenía datos
    }else{
      //se resetean telefono 1
      $('#NumeroTelefono1').val("");
      document.getElementById('Celular1').checked = false;
      document.getElementById('Fijo1').checked = true;
      //se resetean los tipos del telefono 2
      document.getElementById('Celular2').checked = false;
      document.getElementById('Fijo2').checked = true;
      //se resetea el telefono 3 y se oculta
      document.getElementById('Celular3').checked = false;
      document.getElementById('Fijo3').checked = true;
      $("#Tel3").hide();
    }
  //si aun queda un telefono activo
  }else if(telefonoActivo==1){
    //se checa el valor del telefono 2, si tenía valores o no
    var telefono=$('#NumeroTelefono2').val();
    //si si tenía datos
    if(telefono!=""){
      //el telefono 1 obtiene los datos del telefono2
      $('#NumeroTelefono1').val(telefono);
      document.getElementById('Fijo1').checked =$('#Fijo2').is(':checked');
      document.getElementById('Celular1').checked =$('#Celular2').is(':checked');
      //el telefono dos se resetea y se oculta
      $('#NumeroTelefono2').val("");
      document.getElementById('Celular2').checked = false;
      document.getElementById('Fijo2').checked = true;
      $("#Tel2").hide();
    }else{
      //si no tenía datos, se resetea el telefono 1
      $('#NumeroTelefono1').val("");
      document.getElementById('Celular1').checked = false;
      document.getElementById('Fijo1').checked = true;
      //se resetea y se oculta el telefono 2
      document.getElementById('Celular2').checked = false;
      document.getElementById('Fijo2').checked = true;
      $("#Tel2").hide();
    }
  //si solo quedaba un telefono, se marca error, no se puede eliminar el ultimo
  //telefono, debe permanecer por lo menos uno
  }else if(telefonoActivo<1){
    swal({
      title: "Debe haber por lo menos un teléfono",
      icon: "warning",
    });
    //se vuelve a aumentar en 1 el valor de telefonos activos indicando que 
    //queda 1
    telefonoActivo=telefonoActivo+1;
  }
});
//si se hace click en siguiente
$('#Siguiente').click(function(){
  //se limpia la variable session
  limpiarSesion();
  var nssa=$('#NSSA').val();
  //si se guardó, se cambia de pantalla guardando el NSSA
  if(guardado==1){
    swal({
      title: "Pasando a registrar la glucosa",
      icon: "success",
    }).then(
      (confirm)=>{
        $.ajax({
          method:'POST',
          url:'control/Paciente.php',
          data: {"NSSA":nssa,"Boton":"Cambiar"}
        });
        window.location="GlucosaDeteccion.php";
      }
    );
  //si no se ha guardado, se manda un mensaje
  }else{
    swal({
      title: "Debes Guardar antes de pasar a siguiente",
      icon: "info",
    });
  }
});
//si se hace click en el boton regresar
$('#Regresar').click(function(){
  limpiarSesion()
  //se muestra un dialogo para confirmación
  swal({
    title: "¿Desea regresar a la pantalla principal?",
    text: "Los datos no guardados se perderan",
    icon: "warning",
    buttons: true,
    dangerMode: true
  })//si se confirma, nos regresa a home
  .then(
    (confirm) => {
      if (confirm) {
        //se muestra un dialogo
        swal("Regresando a la pantalla principal", {
          icon: "success",
        }).then(
          (confirm)=>{
            //regresar a home dependiendo del tipo de usuario
            $.ajax({
              method: 'POST',
              url: 'control/Regreso.php',
              success: function(res){
                if(res=="A"){
                  window.location="homeA1.php";
                }else{
                  window.location="homeU.php";
                }
              }
            });
          }
        );
      }
    }
  );
});
//si se ingresa un paciente que existe
$('#NSSA').focusout(function(){
  //datos del formulario
  var nssa=$('#NSSA').val();
  //envio de datos con ajax
  if(nssa!=""){
    //no se pide confirmación, solo se busca
    $.ajax({
      method: 'POST',
      //ruta del archivo php de control
      url: 'control/Paciente.php',
      //datos que se enviaran
      data: {"NSSA": nssa,"Boton":"Encontrar"},
      
      // el parametro res es la respuesta que da php mediante impresion de pantalla (echo)
      success: function(res){
        //se regresa un guardado si todo salió bien
        if(res=='Encontrado'){
          //se muestra una ventana de confirmación
          swal({
            title: "El Paciente ya existe",
            icon: "success",
          }).then(
            (confirm)=>{
              guardado=1;
              LlenarCampos(nssa);
            }
          );
        }
      }
    });   
  }
});
//FUNCIONES*****************************************************************************************
//funcion que valida que los elementos no sean nulos
function Validacion(p1,p2,p3,p4,p5,p6,p7,p8){
  if(p1!="" && p2!="" && p3!="" && p4!="" && p5!="" && p6!="" && p7!="" && p8 !=""){
    return true;
  }else{
    return false;
  }
}
//funcion para marcar como invalido un input
function Invalido(elemento){
  elemento.removeClass("is-invalid");
  elemento.removeClass("is-valid");
  elemento.addClass("is-invalid");
}
//funcion para marcar como valido un input
function Valido(elemento){
  elemento.removeClass("is-valid");
  elemento.removeClass("is-invalid");
  elemento.addClass("is-valid");
}
//cambiar el valor de $_SESSION
function limpiarSesion(){
  $.ajax({
    method: 'POST',
    url: 'control/Paciente.php',
    data: {"Boton":"Limpiar"}
  });
}
//funcion que le da tache o palomita a los campos
function VisualValidacion(){
  //si los campos estan vacios, los marca como invalidos
  if($('#NSSA').val()==""){
    Invalido($('#NSSA'));
  }else{
    Valido($('#NSSA'));
  }
  if($('#NombrePaciente').val()==""){
    Invalido($('#NombrePaciente'));
  }else{
    Valido($('#NombrePaciente'));
  }
  if($('#ApPaterno').val()==""){
    Invalido($('#ApPaterno'));
  }else{
    Valido($('#ApPaterno'));
  }
  if($('#ApMaterno').val()==""){
    Invalido($('#ApMaterno'));
  }else{
    Valido($('#ApMaterno'));
  }
  if($('#Calle').val()==""){
    Invalido($('#Calle'));
  }else{
    Valido($('#Calle'));
  }
  if($('#NumeroExterior').val()==""){
    Invalido($('#NumeroExterior'));
  }else{
    Valido($('#NumeroExterior'));
  }
  if($('#Colonia').val()==""){
    Invalido($('#Colonia'));
  }else{
    Valido($('#Colonia'));
  }
  if($('#Delegacion').val()==""){
    Invalido($('#Delegacion'));
  }else{
    Valido($('#Delegacion'));
  }
  if($('#NumeroTelefono1').val()==""){
    Invalido($('#NumeroTelefono1'));
  }else{
    Valido($('#NumeroTelefono1'));
  }
}
//funcion que checa que los campos tengan lo indicado, numeros o letras
function ContenidoValidacion(){
  //expresiones regulares
  var numeros = new RegExp('[^A-Za-z0-9áÁéÉíÍóÓúÚ üÜñÑ\.]');
  var noNumeros = /\D/;
  var nssa =new RegExp('[^A-Za-z0-9áÁéÉíÍóÓúÚüÜñÑ-]');
  //se valida que tenga todo el formato correcto, que los nombres no tengan
  //numeros no contengan letras
  //numero de seguro social con el agregado +++++++++++++++++++++++++++++++++++
  if(nssa.exec($('#NSSA').val())){
    Invalido($('#NSSA'));
    return "El numero de seguro social con el agregado solo puede contener caracteres alfanumericos y guiones";
  }else{
    Valido($('#NSSA'));
  }
  //nombre del paciente++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  if(numeros.exec($('#NombrePaciente').val())){
    Invalido($('#NombrePaciente'));
    return "El nombre del paciente solo puede contener letras";
  }else{
    Valido($('#NombrePaciente'));
  }
  //apeido paterno del paciente++++++++++++++++++++++++++++++++++++++++++++++++
  if(numeros.exec($('#ApPaterno').val())){
    Invalido($('#ApPaterno'));
    return "El Apeido Paterno del paciente solo puede contener letras";
  }else{
    Valido($('#ApPaterno'));
  }
  //apeido materno del paciente++++++++++++++++++++++++++++++++++++++++++++++++
  if(numeros.exec($('#ApMaterno').val())){
    Invalido($('#ApMaterno'));
    return "El Apeido Materno del paciente solo puede contener letras";
  }else{
    Valido($('#ApMaterno'));
  }
  //nombre de la calle del domicilio+++++++++++++++++++++++++++++++++++++++++++
  if(numeros.exec($('#Calle').val())){
    Invalido($('#Calle'));
    return "El nombre de la calle solo puede contener letras";
  }else{
    Valido($('#Calle'));
  }
  //numero exterior del domicilio++++++++++++++++++++++++++++++++++++++++++++++
  if(noNumeros.exec($('#NumeroExterior').val())){
    Invalido($('#NumeroExterior'));
    return "El numero exterior solo puede contener numeros";
  }else{
    Valido($('#NumeroExterior'));
  }
  //numero interior del domicilio++++++++++++++++++++++++++++++++++++++++++++++
  if(noNumeros.exec($('#NumeroInterior').val())){
    Invalido($('#NumeroInterior'));
    return "El numero interior solo puede contener numeros";
  }else{
    Valido($('#NumeroInterior'));
  }
  //nombre de la colonia del domicilio+++++++++++++++++++++++++++++++++++++++++
  if(numeros.exec($('#Colonia').val())){
    Invalido($('#Colonia'));
    return "El nombre de la colonia solo puede contener letras";
  }else{
    Valido($('#Colonia'));
  }
  //nombre de la delegación del domicilio++++++++++++++++++++++++++++++++++++++
  if(numeros.exec($('#Delegacion').val())){
    Invalido($('#Delegacion'));
    return "El nombre de la delegación solo puede contener letras";
  }else{
    Valido($('#Delegacion'));
  }
  //telefono 1, el que es obligatorio++++++++++++++++++++++++++++++++++++++++++
  if(noNumeros.exec($('#NumeroTelefono1').val())){
    Invalido($('#NumeroTelefono1'));
    return "El telefono solo puede contener numeros";
  }else{
    var tel=$('#NumeroTelefono1').val();
    if(tel.length!=10){
      Invalido($('#NumeroTelefono1'));
      return "El telefono debe estar a 10 digitos";
    }else{
      Valido($('#NumeroTelefono1'));
    }
  }
  //si existen dos telefonos
  //se compara el contenido del telefono2+++++++++++++++++++++++++++++++++++++
  if(telefonoActivo>=2){
    if(noNumeros.exec($('#NumeroTelefono2').val())){
      Invalido($('#NumeroTelefono2'));
      return "El telefono solo puede contener numeros";
    }else{
      var tel=$('#NumeroTelefono2').val();
      if(tel.length!=10){
        Invalido($('#NumeroTelefono2'));
        return "El telefono debe estar a 10 digitos";
      }else{
        Valido($('#NumeroTelefono2'));
      }
    }
  }
  //si existen dos telefonos
  //se compara el contenido del telefono3+++++++++++++++++++++++++++++++++++++
  if(telefonoActivo>2){
    if(noNumeros.exec($('#NumeroTelefono3').val())){
      Invalido($('#NumeroTelefono3'));
      return "El telefono solo puede contener numeros";
    }else{
      var tel=$('#NumeroTelefono3').val();
      if(tel.length!=10){
        Invalido($('#NumeroTelefono3'));
        return "El telefono debe estar a 10 digitos";
      }else{
        Valido($('#NumeroTelefono3'));
      }
    } 
  }
  return "Correcto";
  //revisar regex para correos electronicos
  //$("#Email").val();
}
//funcion que nos dice que tipo de telefono esta marcada
function TipoTelefonoFun(num){
  if($('#Celular'+num).is(':checked')){
    return "C";
  }else{
    return "F";
  }
}
//funcion que muestra el segundo formulario con los datos de la base de datos
function LlenarCampos(nssa){
  //ocultan los botones del inicio y se muestra el otro formulario
  $('#BotonesInicio').hide();
  $('#BusquedaEncontrada').show();
  //se desabilita el campo de NSSA
  $('#NSSA').attr('disabled',true);
  //se manda a llamar el archivo php
  $.ajax({
    method: 'POST',
    //ruta del archivo php de control
    url: 'control/Paciente.php',
    //datos que se enviaran
    data: {"NSSA": nssa,"Boton":"Buscar"},
    
    // el parametro res es la respuesta que da php mediante impresion de pantalla (echo)
    success: function(res){
      swal({
        title: "Datos encontrados",
      });
      //se separan los datos por comas
      var Datos=res.split(",");
      //se le asigna a cada campo su parte según el split
      $('#NombrePaciente').val(Datos[0]);
      $('#ApPaterno').val(Datos[1]);
      $('#ApMaterno').val(Datos[2]);
      $('#Calle').val(Datos[3]);
      $('#NumeroExterior').val(Datos[4]);
      if(Datos[5]=="NULL"){
        $('#NumeroInterior').val("");
      }else{
        $('#NumeroInterior').val(Datos[5]);
      }
      $('#Colonia').val(Datos[6]);
      $('#Delegacion').val(Datos[7]);
      if(Datos[8]=="NULL"){
        $("#Email").val("");
      }else{
        $("#Email").val(Datos[8]);
      }
      if(Datos[9]=="NULL"){
        $("#Observaciones").val("");
      }else{
        $("#Observaciones").val(Datos[9]);
      }
      //los telefonos, depende del tipo que tenga, se selecciona un tipo
      //en el formulario y segun cuantos telefonos haya, se despliega un telefono
      if(Datos[10]>=1){
        $('#NumeroTelefono1').val(Datos[11]);
        if(Datos[12]=='C'){
          document.getElementById('Fijo1').checked =false;
          document.getElementById('Celular1').checked =true;
        }else{
          document.getElementById('Celular1').checked =false;
          document.getElementById('Fijo1').checked =true;
        } 
      }
      
      if(Datos[10]>=2){
        telefonoActivo=2;
        $("#Tel2").show();
        $('#NumeroTelefono2').val(Datos[13]);
        if(Datos[14]=='C'){
          document.getElementById('Fijo2').checked =false;
          document.getElementById('Celular2').checked =true;
        }else{
          document.getElementById('Celular2').checked =false;
          document.getElementById('Fijo2').checked =true;
        } 
      }

      if(Datos[10]==3){
        $("#Tel3").show();
        telefonoActivo=3;
        $('#NumeroTelefono3').val(Datos[15]);
        if(Datos[12]=='C'){
          document.getElementById('Fijo3').checked =false;
          document.getElementById('Celular3').checked =true;
        }else{
          document.getElementById('Celular3').checked =false;
          document.getElementById('Fijo3').checked =true;
        } 
      }

    }
  });  
  ActividadPaciente(nssa); 
}
//funcion que revisa si el paciente esta activo o no
function ActividadPaciente(nssa){
  //llamada al metodo ajax
  $.ajax({
    //el fin de esto es encontrar el estatus del paciente
    method: 'POST',
    url:'control/Paciente.php',
    data:{"NSSA":nssa,"Boton":"RevisarEstatus"},
    success: function(res){
      //si es diferente de estatus activo
      if(res==2 || res==3 || res==4 || res==5){
        //avisa con un mensaje
        swal({
              title: "Paciente inactivo",
              icon: "warning"
            });
        //se inhabilita todo
        DeshabilitarTodo();
      }
    }
  });
}
//Funcion que deshabilita todos los campos del formulario
function DeshabilitarTodo(){
  $('#NombrePaciente').attr('disabled',true);
  $('#ApPaterno').attr('disabled',true);
  $('#ApMaterno').attr('disabled',true);
  $('#Calle').attr('disabled',true);
  $('#NumeroExterior').attr('disabled',true);
  $('#NumeroInterior').attr('disabled',true);
  $('#Colonia').attr('disabled',true);
  $('#Delegacion').attr('disabled',true);
  $("#Email").attr('disabled',true);
  $('#NumeroTelefono1').attr('disabled',true);
  $('#Fijo1').attr('disabled',true);
  $('#Celular1').attr('disabled',true);
  $('#NumeroTelefono2').attr('disabled',true);
  $('#Fijo2').attr('disabled',true);
  $('#Celular2').attr('disabled',true);
  $('#NumeroTelefono3').attr('disabled',true);
  $('#Fijo3').attr('disabled',true);
  $('#Celular3').attr('disabled',true);
  $('#AgregarBoton').attr('disabled',true);
  $('#EliminarTelefono1').attr('disabled',true);
  $('#EliminarTelefono2').attr('disabled',true);
  $('#EliminarTelefono3').attr('disabled',true);
  $('#Guardar').attr('disabled',true);
}