//****************************************************************************************
//Nombre:         mainRD.css
//Objetivos:      Código JS para registrar el diagnostico para un paciente mediante  
//                su número de NSS. Usa validaciones y funciones para los botones.
//Creado por:     Lázaro Martínez Abraham Josué
//Fecha:          viernes 3 de enero de 2020
//version:        1.0                 
//****************************************************************************************

//EVENTOS*********************************************************************************
//cuando se hace click en el boton guardar
$('#Guardar').click(function(){
  //datos del formulario
  var diagnostico=$('#CatalogoDiagnostico_id').val();
  var nssa=$('#NSSA').val();
  var observaciones=$('#Observaciones').val();
  //se valida los campos si estan llenos o no
  if($('#CatalogoDiagnostico_id').val()=="0"){
    Invalido($('#CatalogoDiagnostico_id'));
  }else{
    Valido($('#CatalogoDiagnostico_id'));
  }
  if($('#NSSA').val()==""){
    Invalido($('#NSSA'));
  }else{
    Valido($('#NSSA'));
  }

  //envio de datos con ajax
  if(diagnostico!="" && nssa!=""){
    //si es cualquiera menos Sin Diagnostico
    if(diagnostico!=0){
      //se espera confirmacio
      swal({
        title: "¿Desea guardar los cambios?",
        icon: "info",
        buttons: true,
      })//si se confirma, procede todo lo demas
      .then(
        (confirm) => {
          //se pide confirmacion
          if(confirm){ 
            $.ajax({
              method: 'POST',
              //ruta del archivo php de control
              url: 'control/RegistroDiagnostico.php',
              //datos que se enviaran
              data: {"NSSA": nssa, "Diagnostico": diagnostico, 
              "Observaciones":observaciones,"Boton": 'Guardar'},
              
              // el parametro res es la respuesta que da php mediante impresion de pantalla (echo)
              success: function(res){
                //se regresa un guardado si todo salió bien
                if(res=='Guardado'){
                  //se muestra una ventana de confirmación
                  swal({
                    title: "Diagnóstico guardado",
                    icon: "success",
                  }).then(
                  //cuando se haga click en el boton de la ventana emergente, se limpiaran
                  //los campos y se regresará a Home
                      (confirm) => {
                        $('#CatalogoDiagnostico_id').val("0");
                        $('#NSSA').val("");
                        $('#Observaciones').val("");
                      });
                }else{
                  //si no es ninguna de los otros, es un error inesperado, se muestra 
                  //el error arrojado
                  swal({
                    title: "Error",
                    text: res,
                    icon: "warning",
                  });
                  if(res=="Paciente inactivo"){
                    Invalido($('#NSSA'));
                  }
                }
              }
            });
          }
        }
      );
    //si escogió "Sin Diagnostico" se detine el proceso
    }else{
      swal({
        title: "Debes escoger una opcion valida (cualquiera menos Sin Diagnostico)",
        icon: "warning",
        dangerMode: true
      });
    }
  //si los campos no estan llenos, se muestra un mensaje pidiendolo
  }else{
    swal({
      title: "Debes llenar todos los campos",
      icon: "info",
    });
  }
});
//si se hace click en el boton regresar
$('#Regresar').click(function(){
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
//si se encuentra a un paciente que ya tenía Diagnostico anterior
$('#NSSA').focusout(function(){
  var nssa=$('#NSSA').val();
  //con el valor del nssa, se hace un llamado con ajax al archivo php
  //para buscar coincidencias en la base de datos
  $.ajax({
    method:'POST',
    url:'control/RegistroDiagnostico.php',
    data:{"NSSA":nssa,"Boton":"Buscar"},
    success: function(res){
      //si el mensaje que regresa es distinto de una cadena vacia, llenará
      //los campos
      if(res!=""){
        //muestra un mensaje de aviso
        swal({
          title: "Paciente ya con diagnóstico",
          text: "Se encontró un diagnóstico anterior para ese paciente",
          icon: "info"
        }).then(
          (confirm)=>{
            //llena los campos, el de diagnostico, y el de observaciones en caso
            //de existir
            var Datos=res.split(",");
            $('#CatalogoDiagnostico_id').val(Datos[0]);
            if(Datos[1]!="NULL"){
              $('#Observaciones').val(Datos[1]);
            }
          }
        );
      }
    }
  });
});

//FUNCIONES*******************************************************************************
//funcion para marcar como invalido un input
function Invalido(elemento){
  elemento.removeClass("is-invalid");
  elemento.removeClass("is-valid");
  elemento.addClass("is-invalid");
}
//guncion para marcar como valido un input
function Valido(elemento){
  elemento.removeClass("is-valid");
  elemento.removeClass("is-invalid");
  elemento.addClass("is-valid");
}