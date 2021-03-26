// ***************************************************************************************
//Nombre:         mainAC.css
//Objetivos:      Código JS para la pantalla de ActualizarCita.php, hace todas las
//                validaciones y pide confirmaciones para el uso de la pantalla
//Creado por:     Lázaro Martínez Abraham Josué
//Fecha:          viernes 3 de enero de 2020
//version:        1.0                 
// ***************************************************************************************

//EVENTOS*********************************************************************************
//cuando se hace click en el boton guardar
$('#Guardar').click(function(){
  //datos del formulario
  var fechaAnterior=$('#FechaCitaAnterior').val();
  var fechaNueva=$('#FechaCitaNueva').val();
  var nssa=$('#NSSA').val();
  //se valida los campos si estan llenos o no
  if($('#FechaCitaAnterior').val()==""){
      Invalido($('#FechaCitaAnterior'));
  }else{
    Valido($('#FechaCitaAnterior'));
  }
  if($('#NSSA').val()==""){
    Invalido($('#NSSA'));
  }else{
    Valido($('#NSSA'));
  }
  if($('#FechaCitaNueva').val()==""){
    Invalido($('#FechaCitaNueva'));
  }else{
    Valido($('#FechaCitaNueva'));
  }
  //envio de datos con ajax
  if(fechaAnterior!="" && fechaNueva!="" && nssa!=""){
      //se espera confirmacio
    swal({
      title: "¿Desea guardar los cambios?",
      icon: "info",
      buttons: true,
    })//si se confirma, procede todo lo demas
    .then(
      (confirm) => {
        if(confirm){
          $.ajax({
            method: 'POST',
            //ruta del archivo php de control
            url: 'control/ActualizacionCita.php',
            //datos que se enviaran
            data: {
              "NSSA": nssa, 
              "FechaCitaAnterior": fechaAnterior, 
              "FechaCitaNueva": fechaNueva, 
              "Boton": 'Guardar'
            },
            
            // el parametro res es la respuesta que da php mediante impresion de pantalla (echo)
            success: function(res){
              //se regresa un guardado si todo salió bien
              if(res=='Guardado'){
                //se muestra una ventana de confirmación
                swal({
                  title: "Cita actualizada exitosamente",
                  icon: "success",
                }).then(
                //cuando se haga click en el boton de la ventana emergente, se limpiaran
                //los campos y se regresará a Home
                    (confirm) => {
                      $('#FechaCitaAnterior').val("");
                      $('#NSSA').val("");
                      $('#FechaCitaNueva').val("");
                      RecargarCalendario();
                    });
              }else{
                //si no es ninguna de los otros, es un error inesperado, se muestra 
                //el error arrojado
                swal({
                  title: "Error",
                  text: res,
                  icon: "warning",
                });
                if(res=='Ese paciente no existe' || res=="Paciente inactivo"){
                  Invalido($('#NSSA'));
                }
                if(res=='Fecha inválida, debe ser mayor a la actual'){
                  Invalido($('#FechaCitaNueva'));
                }
                if(res=='Cita inactiva, no la puedes cambiar' 
                  || res=='Dicha cita no existe'){
                  Invalido($('#FechaCitaAnterior'));
                }
              }
            }
          });
        }
      }
    );
        
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
