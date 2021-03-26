//****************************************************************************************
//Nombre:         mainGD.css
//Objetivos:      Código JS para guardar los datos de la glucosa en la consulta de 
//                detección, usa validaciones y funcionalidades para su pantalla.
//Creado por:     Lázaro Martínez Abraham Josué
//Fecha:          viernes 3 de enero de 2020
//version:        1.0                 
//****************************************************************************************

//inhabilita el boton de regresar, se activará una vez que se guarde el resultado 
//de la consulta de detección de la glucosa
$('#Regresar').attr('disabled',true);

//EVENTOS*********************************************************************************
//cuando se hace click en el boton guardar
$('#Guardar').click(function(){
  //datos del formulario
  var glucosa=$('#GlucosaDeteccion').val();
  var tipo=TipoGlucosa();
  //se valida los campos si estan llenos o no
  if($('#GlucosaDeteccion').val()=="" || $('#GlucosaDeteccion').val()<0){
    Invalido($('#GlucosaDeteccion'));
  }else{
    Valido($('#GlucosaDeteccion'));
  }
  //si el campo de glucosa es diferente de una cadena vacia y es mayor a cero
  if(glucosa!="" ){
    //si el campo de glucosa es mayor a cero se procede
    if(glucosa>0){
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
              url: 'control/Paciente.php',
              //datos que se enviaran
              data: {"Glucosa": glucosa,"Tipo": tipo, "Boton": 'AgregarGlucosa'},
              // el parametro res es la respuesta que da php mediante impresion de pantalla (echo)
              success: function(res){
                //se regresa un guardado si todo salió bien
                if(res=='Guardado'){
                  //se muestra una ventana de confirmación
                  swal({
                    title: "Datos guardados",
                    icon: "success",
                  }).then(
                  //cuando se haga click en el boton de la ventana emergente, se limpiaran
                  //los campos y se regresará a Home
                      (confirm) => {
                        $('#GlucosaDeteccion').val("");
                        document.getElementById('NoAyuno').checked = false;
                        document.getElementById('Ayuno').checked = true;
                        $('#Regresar').attr('disabled',false);
                        $('#Borrar').attr('disabled',true);
                      });
                }else{
                  //si es un error inesperado, se muestra 
                  //el error arrojado
                  swal({
                    title: "Error",
                    text: res,
                    icon: "warning",
                  });
                }
              }
            });
          }
        }
      );
    //si no, se muestra un mensaje de error
    }else{
      swal({
        title: "No puedes ingresar datos negativos",
        icon: "warning",
        dangerMode:true
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
//si se hace click en el boton borrar
$('#Borrar').click(function(){
  //se muestra un dialogo para confirmación
  swal({
    title: "¿Desea cancelar todo el registro?",
    text: "El paciente se inactivará",
    icon: "warning",
    buttons: true,
    dangerMode: true
  })//si se confirma, nos regresa a home
  .then(
    (confirm) => {
      if (confirm) {
        //Desactivar a paciente
        $.ajax({
          method:'POST',
          url: 'control/Paciente.php',
          data:{"Boton":"Abortar"},
          success: function(res){
            if(res=="Abortado"){
              swal({
                title: "Registro cancelado con éxito",
                text: "Te regresaremos a la página de inicio",
                icon: "success"
              }).then(
                (confirm)=>{
                  //regresar a home
                  limpiarSesion();
                  window.location="Home.php";
                }
              );
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
    }
  );
});
//funcion que checa el maximo y minimo de un input
$('#GlucosaDeteccion').keyup(function(){
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
//funcion para marcar como valido un input
function Valido(elemento){
  elemento.removeClass("is-valid");
  elemento.removeClass("is-invalid");
  elemento.addClass("is-valid");
}
//funcion para determinar el tipo de consulta (ayuno o no ayuno) que esta
function TipoGlucosa(){
  if($('#NoAyuno').is(':checked')){
    return "No ayuno";
  }else{
    return "Ayuno";
  }
}
//funcion para cambiar el valor de $_SESSION
function limpiarSesion(){
  $.ajax({
    method: 'POST',
    url: 'control/Paciente.php',
    data: {"Boton":"Limpiar"}
  });
}