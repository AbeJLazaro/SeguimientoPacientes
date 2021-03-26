//****************************************************************************************
//Nombre:         mainRL.css
//Objetivos:      Código JS para registrar el resultado de los examenes médicos (dato de 
//                la glucosa) para un paciente que se hizo los examenes por medio de 
//                su número de NSS. Usa validaciones y funciones para los botones.
//Creado por:     Lázaro Martínez Abraham Josué
//Fecha:          viernes 3 de enero de 2020
//version:        1.0                 
//****************************************************************************************

//EVENTOS*********************************************************************************
//cuando se hace click en el boton guardar
$('#Guardar').click(function(){
  //datos del formulario
  var resultado=$('#Resultado').val();
  var nssa=$('#NSSA').val();
  //se valida los campos si estan llenos o no
  if($('#FechaCita').val()==""){
      Invalido($('#FechaCita'));
    }else{
      Valido($('#FechaCita'));
    }
    if($('#NSSA').val()==""){
      Invalido($('#NSSA'));
    }else{
      Valido($('#NSSA'));
    }

  //envio de datos con ajax
  //se valida que los campos no estén vacios
  if(resultado!="" && nssa!=""){
    //si el resultado es mayor a 0, debe ser positivo
    if(resultado>0){
      //se espera confirmacion
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
              url: 'control/ResultadoLaboratorio.php',
              //datos que se enviaran
              data: {"NSSA": nssa, "Resultado": resultado, "Boton": 'Guardar'},
              
              // el parametro res es la respuesta que da php mediante impresion de pantalla (echo)
              success: function(res){
                //se regresa un guardado si todo salió bien
                if(res=='Guardado'){
                  //se muestra una ventana de confirmación
                  swal({
                    title: "Resultado registrado",
                    icon: "success",
                  }).then(
                  //cuando se haga click en el boton de la ventana emergente, se limpiaran
                  //los campos y se regresará a Home
                      (confirm) => {
                        $('#Resultado').val("");
                        $('#NSSA').val("");
                      });
                //si no, se muestra el error asociado
                }else{
                  swal({
                    title: "Error",
                    text: res,
                    icon: "warning",
                  });
                  //si es alguno de estos dos errores, invalida el campo del NSSA
                  if(res=='Ese paciente no existe' || res=="Paciente inactivo"){
                    Invalido($('#NSSA'));
                  }
                }
              }
            });
          }
        }
      );
    //si se ingresó un número negativo
    }else{
      Invalido($('#Resultado'))
      swal({
        title: "El resultado no puede tener un número negativo",
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
//validar cantidad del input de glucosa resultado
$('#Resultado').keyup(function(){
  //si es mayor a 999 se cambia por 999
  if($(this).val()>999){
    $(this).val("999");
  }
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