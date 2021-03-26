//****************************************************************************************
//Nombre:         mainAP.css
//Objetivos:      Código JS para la pantalla de ActualizarPaciente.php, hace todas las
//                validaciones y pide confirmaciones para el uso de la pantalla
//Creado por:     Lázaro Martínez Abraham Josué
//Fecha:          viernes 3 de enero de 2020
//version:        1.0                 
//****************************************************************************************

//VARIABLES GLOBALES**********************************************************************
//Variable que nos indica si ya se guardaron los cambios
var deshabilitado=0;
//variable que nos indica cuantos telefonos activos hay
var telefonoActivo=1;

//valores inicializados
//telefonos 2 y 3 se esconden
$("#Tel2").hide();
$("#Tel3").hide();
//el formulario busqueda ocultada se esconde y el campo EspecificarOtro
$("#BusquedaEncontrada").hide();
$("#EspecificarOtro").hide();

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
  var estatus=$('#Activo').val();
  var especificarOtro=$('#Especificar').val();
  //Con una función se valida que los campos estén bien
  var continuar=Validacion(nombre, apPaterno, apMaterno, calle, numeroExterior,
    colonia,delegacion,telefono1,estatus);
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
                    "Estado":estatus,
                    "EspecificarOtro":especificarOtro,
                    "Boton":"Actualizar"},
              
              // el parametro res es la respuesta que da php mediante impresion de pantalla (echo)
              success: function(res){
                //se regresa un mensaje especifico si todo salió bien
                var success="Datos personales del paciente actualizados";
                success=success+"\nTeléfono 1 agregado";
                var success2=success+"\nTeléfono 2 agregado";
                var success3=success2+"\nTeléfono 3 agregado";

                var success4=success+"\nEstado otro actualizado";
                var success5=success2+"\nEstado otro actualizado";
                var success6=success3+"\nEstado otro actualizado";
                if(res==success || res==success2 || res==success3 ||
                  res==success4 || res==success5 || res==success6){
                  //se muestra una ventana de confirmación
                  swal({
                    title: "Paciente actualizado",
                    text: res,
                    icon: "success",
                  });
                }else{
                  swal({
                    title: "Error",
                    text: res,
                    icon: "warning",
                  });
                }
              }
            }); 
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
//cuando se haga click en el boton buscar
$('#Buscar').click(function(){
  //datos del formulario
  var nssa=$('#NSSA').val();
  //se valida los campos si estan llenos o no
  if($('#NSSA').val()==""){
    Invalido($('#NSSA'));
  }else{
    Valido($('#NSSA'));
  }

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
            title: "Paciente encontrado",
            icon: "success",
          }).then(
            (confirm)=>{
              LlenarCampos(nssa);
            }
          );
        }else{
          //Si el error se debe a que el paciente no existe, se pregunta si se
          //desea agregar al paciente
          if(res=='Ese paciente no existe'){
            swal({
              title: "El paciente no existe",
              text: "¿Desea registrar al paciente?",
              icon: "info",
              buttons:true
            }).then(
            (confirm) =>{
              if(confirm){
                CambioPantalla(nssa);
              }else{
                Invalido($('#NSSA'));
              }
            });
          //si el error es de otro tipo, se muestra
          }else{
            Invalido($('#NSSA'));
            swal({
              title: "Error",
              text: res,
              icon: "warning"
            });
          }
        }
      }
    });   
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
//si se hace click en el boton regresar
$('#Regresar').click(function(){
  limpiarSesion()
  $.ajax({
    method:'POST',
    url:'control/RegresoReporte.php',
    data:{"Boton":"Revisar"},
    success: function(res){
      //si viene de reportes
      if(res=='1'){
        //se muestra un dialogo para confirmación
        swal({
          title: "¿Desea regresar a la pantalla de reportes?",
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
                    method:'POST',
                    url:'control/RegresoReporte.php',
                    data:{"Boton":"Regresar"}
                  });
                  window.location="GeneracionReportes.php";
                }
              );
            }
          });
      //si no viene de reportes
      }else{
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
      }
    }
  });   
});
//si se hace click en el boton regresar del segundo formulario
$('#Regresar2').click(function(){
  limpiarSesion()
  $.ajax({
    method:'POST',
    url:'control/RegresoReporte.php',
    data:{"Boton":"Revisar"},
    success: function(res){
      //si viene de reportes
      if(res=='1'){
        //se muestra un dialogo para confirmación
        swal({
          title: "¿Desea regresar a la pantalla de reportes?",
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
                    method:'POST',
                    url:'control/RegresoReporte.php',
                    data:{"Boton":"Regresar"}
                  });
                  window.location="GeneracionReportes.php";
                }
              );
            }
          });
      //si no viene de reportes
      }else{
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
      }
    }
  });   
});
//acciones para el catalogo de estatus
$('#Activo').change(function(){
  //variable que toma el valor del selected de estatus del paciente
  var Activo=$('#Activo').val();
  //si es diferente a 1(activo) y la bandera deshabilitado es igual a 0(no
  //deshabilitado)
  if(Activo!=1 && deshabilitado==0){
    //se deshabilita todo con la función y se cambia la bandera a 1
    DeshabilitarTodo();
    deshabilitado=1;
  //si no, si Activo es 1 (activo) y deshabilitado es igual a 1(esta deshabilitado)
  }else if(Activo==1 && deshabilitado==1){
    //habilita todo y cambia la bandera a 0
    HabilitarTodo();
    deshabilitado=0;
    //esconde el campo de especificar otro (por si pasa de Otro a Activo)
    $('#EspecificarOtro').hide();
  }
  //si activo es igual a 5 se muestra el especificar otro
  if(Activo==5){
    $('#EspecificarOtro').show();
  //si no, lo oculta
  }else{
    $('#EspecificarOtro').hide();
  }
});
//FUNCIONES*****************************************************************************************
//funcion que valida que los elementos no sean nulos
function Validacion(p1,p2,p3,p4,p5,p6,p7,p8,p9){
  //si todos los parametros son diferentes de una cadena vacia
  if(p1!="" && p2!="" && p3!="" && p4!="" && p5!="" && p6!="" && p7!="" && p8 !="" && p9!=""){
    //y si el campo activo es Otro y el campo de especificar no tiene nada escrito, regresa falso
    if($('#Activo').val()==5 && $('#Especificar').val()==""){
      return false;
    //si no, manda un true
    }else{
      return true;
    }
  //si alguno es una cadena vacia, regresa un falso
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
//funcion que da formato de invalido o valido a los campos del formulario
function VisualValidacion(){
  //si algun campo obligatorio esta vacio, lo marca con rojo
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
  //checa si el campo especificar otro esta vacio si el estatus es "Otro"
  if($('#Activo').val()==5){
    if($('#Especificar').val()==""){
      Invalido($('#Especificar'));
    }else{
      Valido($('#Especificar'));
    }
  }
}
//funcion que checa que los campos tengan contenido indicado, numeros o letras
function ContenidoValidacion(){
  //expresiones regulares
  var numeros = new RegExp('[^A-Za-záÁéÉíÍóÓúÚ üÜñÑ\.]');
  var noNumeros = /[\D]/;
  //se valida que tenga todo el formato correcto, que los nombres no tengan
  //numeros no contengan letras
  //nombre del paciente++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  if(numeros.exec($('#NombrePaciente').val())){
    Invalido($('#NombrePaciente'));
    return "El nombre del paciente solo puede contener letras";
  }else{
    Valido($('#NombrePaciente'));
  }
  //apeido paterno del paciente++++++++++++++++++++++++++++++++++++++++++++++++
  if(numeros.exec($('#ApPaterno').val())!=null){
    Invalido($('#ApPaterno'));
    return "El Apellido Paterno del paciente solo puede contener letras";
  }else{
    Valido($('#ApPaterno'));
  }
  //apeido materno del paciente++++++++++++++++++++++++++++++++++++++++++++++++
  if(numeros.exec($('#ApMaterno').val())){
    Invalido($('#ApMaterno'));
    return "El Apellido Materno del paciente solo puede contener letras";
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
    return "El numero exterior solo puede contener números";
  }else{
    Valido($('#NumeroExterior'));
  }
  //numero interior del domicilio++++++++++++++++++++++++++++++++++++++++++++++
  if(noNumeros.exec($('#NumeroInterior').val())){
    Invalido($('#NumeroInterior'));
    return "El numero interior solo puede contener números";
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
    return "El nombre de la delegación sólo puede contener letras";
  }else{
    Valido($('#Delegacion'));
  }
  //telefono 1, el que es obligatorio++++++++++++++++++++++++++++++++++++++++++
  if(noNumeros.exec($('#NumeroTelefono1').val())){
    Invalido($('#NumeroTelefono1'));
    return "El teléfono solo puede contener números";
  }else{
    var tel=$('#NumeroTelefono1').val();
    if(tel.length!=10){
      Invalido($('#NumeroTelefono1'));
      return "El teléfono debe estar a 10 dígitos";
    }else{
      Valido($('#NumeroTelefono1'));
    }
  }
  //si existen dos telefonos
  //se compara el contenido del telefono2+++++++++++++++++++++++++++++++++++++
  if(telefonoActivo>=2){
    if(noNumeros.exec($('#NumeroTelefono2').val())){
      Invalido($('#NumeroTelefono2'));
      return "El teléfono solo puede contener números";
    }else{
      var tel=$('#NumeroTelefono2').val();
      if(tel.length!=10){
        Invalido($('#NumeroTelefono2'));
        return "El telefono debe estar a 10 dígitos";
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
      return "El teléfono solo puede contener números";
    }else{
      var tel=$('#NumeroTelefono3').val();
      if(tel.length!=10){
        Invalido($('#NumeroTelefono3'));
        return "El telefono debe estar a 10 dígitos";
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
      //se separa el mensaje por comas dado que es un mensaje en tipo
      //CSV con los datos del paciente
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
//Funcion que deshabilita todos los campos del formulario
function DeshabilitarTodo(){
  if(deshabilitado==0){
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
  }
}
//funcion que habilita todos los campos del formulario
function HabilitarTodo(){
  if(deshabilitado==1){
    $('#NombrePaciente').attr('disabled',false);
    $('#ApPaterno').attr('disabled',false);
    $('#ApMaterno').attr('disabled',false);
    $('#Calle').attr('disabled',false);
    $('#NumeroExterior').attr('disabled',false);
    $('#NumeroInterior').attr('disabled',false);
    $('#Colonia').attr('disabled',false);
    $('#Delegacion').attr('disabled',false);
    $("#Email").attr('disabled',false);
    $('#NumeroTelefono1').attr('disabled',false);
    $('#Fijo1').attr('disabled',false);
    $('#Celular1').attr('disabled',false);
    $('#NumeroTelefono2').attr('disabled',false);
    $('#Fijo2').attr('disabled',false);
    $('#Celular2').attr('disabled',false);
    $('#NumeroTelefono3').attr('disabled',false);
    $('#Fijo3').attr('disabled',false);
    $('#Celular3').attr('disabled',false);
    $('#AgregarBoton').attr('disabled',false);
    $('#EliminarTelefono1').attr('disabled',false);
    $('#EliminarTelefono2').attr('disabled',false);
    $('#EliminarTelefono3').attr('disabled',false);
  }
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
      //si ocurre un error, se muestra
      if(res=="Error al hacer la búsqueda del estatus" || res=="Error con la base de datos"){
        swal({
              title: "Error",
              text: res,
              icon: "warning"
            });
      }else if(res!=1){
        //si no hay error, y el estatus del paciente es diferente de 1 (Activo)
        swal({
              title: "Paciente inactivo",
              icon: "warning"
            });
        //significa que esta inactivo, por ello inhabilita todo
        DeshabilitarTodo();
        deshabilitado=1;
      }
      //selecciona el valor correspondiente en el dropmenu
      if(res==1){
        $('#Activo').val("1");
      }else if(res==2){
        $('#Activo').val("2");
      }else if(res==3){
        $('#Activo').val("3");
      }else if(res==4){
        $('#Activo').val("4");
      }else if(res==5){
        $('#Activo').val("5");
        $('#EspecificarOtro').show();
        $.ajax({
          method: 'POST',
          url:'control/Paciente.php',
          data:{"NSSA":nssa,"Boton":"ObtenerEstatusOtro"},
          success: function(res){
            $('#Especificar').val(res);
          }
        });
      }
    }
  });
}
//funcion para cambiar de pantalla
function CambioPantalla(nssa){
  $.ajax({
    method:'POST',
    url:'control/Paciente.php',
    data:{"NSSA":nssa,"Boton":"Cambiar"}
  });
  window.location="RegistroPaciente.php";
}