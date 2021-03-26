//****************************************************************************************
//Nombre:         mainRPeW.css
//Objetivos:      Código JS para registrar a un paciente, valida los campos del formulario
//                y da funcionalidad a los botones. También prepara datos para el cambio de
//                pantala a la de GlucosaDeteccion.p
//Creado por:     Lázaro Martínez Abraham Josué
//Fecha:          viernes 3 de enero de 2020
//version:        1.0                 
//****************************************************************************************

//VARIABLES*******************************************************************************
//bandera que nos indica si ya se guardó o no
var guardado=0;
//bandera que nos indica si esta deshabilitado o no
var deshabilitado=1;
//se bloquean los inputs de subcategoria y tipo usuario
$('#Subcategoria_id').attr('disabled',true);
$('#TipoUsuario').attr('disabled',true);

//EVENTOS*********************************************************************************
//cuando se hace click en el boton guardar
$('#Guardar').click(function(){
  limpiarSesion();
  //se valida los campos si estan llenos o no
  VisualValidacion();
  //datos del formulario
  var matricula=$('#Matricula').val();
  var password=$('#Password').val();
  var nombre=$('#Nombre').val();
  var apPaterno=$('#ApPaterno').val();
  var apMaterno=$('#ApMaterno').val();
  var categoria=$('#Categoria_id').val();
  var subcategoria=$('#Subcategoria_id').val();
  var tipo=$('#TipoUsuario').val();
  //Con una función se valida que los campos estén bien
  var continuar=Validacion(matricula,password,nombre, apPaterno, 
    apMaterno,categoria, subcategoria,tipo);
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
                url: 'control/MedicoEnfermera.php',
                //datos que se enviaran
                data:{"Matricula": matricula,
                      "Password":password,
                      "Nombre":nombre,
                      "ApPaterno":apPaterno,
                      "ApMaterno":apMaterno,
                      "Categoria":categoria,
                      "Subcategoria":subcategoria,
                      "Tipo":tipo,
                      "Boton":"Guardar"},
                
                // el parametro res es la respuesta que da php mediante impresion de pantalla (echo)
                success: function(res){
                  //se regresa un mensaje especifico si todo salió bien
                  if(res=="Guardado"){
                    //se muestra una ventana de confirmación
                    swal({
                      title: "Medico registrado",
                      icon: "success",
                    });
                    $('#Matricula').attr('disabled',true);
                    guardado=1;
                  }else{
                    if(res=="Esa persona ya existe dentro del personal"){
                      Invalido($('#Matricula'));
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
                url: 'control/MedicoEnfermera.php',
                //datos que se enviaran
                data:{"Matricula": matricula,
                      "Password":password,
                      "Nombre":nombre,
                      "ApPaterno":apPaterno,
                      "ApMaterno":apMaterno,
                      "Categoria":categoria,
                      "Subcategoria":subcategoria,
                      "Tipo":tipo,
                      "Boton":"ActualizarDeGuardar"},
                
                // el parametro res es la respuesta que da php mediante impresion de pantalla (echo)
                success: function(res){
                  //se regresa un mensaje especifico si todo salió bien
                  if(res=="Datos personales actualizados"){
                    //se muestra una ventana de confirmación
                    swal({
                      title: "Personal actualizado",
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
//evento para que se desbloquee la opción de subcategoria en caso de que
//sea enfermero el personal
$('#Categoria_id').change(function(){
  limpiarSesion();
  //si el valor es 5 (enfermeria) y esta deshabilitado el campo
  if($('#Categoria_id').val()==5 && deshabilitado==1){
    //se deshabilita y se cambia la bandera
    $('#Subcategoria_id').attr('disabled',false);
    deshabilitado=0;
    //si no, si el valor es diferente de enfermeria y no esta deshabilitado el
    //selected
  }else if($('#Categoria_id').val()!=5 && deshabilitado!=1){
    //se desactiva y se cambia la bandera
    $('#Subcategoria_id').attr('disabled',true);
    deshabilitado=1;
    $('#Subcategoria_id').val("5");
  }
  //si la categoria es 5, tipo de usuario es "Normal"
  if($('#Categoria_id').val()==5){
    $('#TipoUsuario').val("U");
  //si es cualquier otro, es "Administrador"
  }else{
    $('#TipoUsuario').val("A");
  }
});
//Funciones*******************************************************************************
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
//funcion que le da tache o palomita a los campos
function VisualValidacion(){
  if($('#Matricula').val()==""){
    Invalido($('#Matricula'));
  }else{
    Valido($('#Matricula'));
  }
  if($('#Password').val()==""){
    Invalido($('#Password'));
  }else{
    Valido($('#Password'));
  }
  if($('#Nombre').val()==""){
    Invalido($('#Nombre'));
  }else{
    Valido($('#Nombre'));
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
}
//funcion que checa que los campos tengan lo indicado, numeros o letras
function ContenidoValidacion(){
  //expresiones regulares
  var numeros = new RegExp('[^A-Za-z0-9áÁéÉíÍóÓúÚ üÜñÑ\.]');
  var noNumeros = /\D/;
  //se valida que tenga todo el formato correcto, que los nombres no tengan
  //numeros no contengan letras
  //matricula de puros numeros++++++++++++++++++++++++++++++++++++++++++++++++++
  if(noNumeros.exec($('#Matricula').val())){
    Invalido($('#Matricula'));
    return "La Matricula solo puede contener numeros";
  }else{
    Valido($('#Matricula'));
  }
  //password de 6 caracteres++++++++++++++++++++++++++++++++++++++++++++++++++++
  if($('#Password').val().length<6){
    Invalido($('#Password'));
    return "La contraseña debe ser de por lo menos 6 caracteres";
  }else{
    Valido($('#Password'));
  }
  //Repetir password +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  if($('#Password2').val()!=$('#Password').val()){
    Invalido($('#Password'));
    Invalido($('#Password2'));
    return "Las contraseñas deben coincidir";
  }else{
    Valido($('#Password2'));
    Valido($('#Password2'));
  }
  //nombre del paciente++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  if(numeros.exec($('#Nombre').val())){
    Invalido($('#Nombre'));
    return "El nombre solo puede contener letras";
  }else{
    Valido($('#Nombre'));
  }
  //apeido paterno del paciente++++++++++++++++++++++++++++++++++++++++++++++++
  if(numeros.exec($('#ApPaterno').val())){
    Invalido($('#ApPaterno'));
    return "El Apeido Paterno solo puede contener letras";
  }else{
    Valido($('#ApPaterno'));
  }
  //apeido materno del paciente++++++++++++++++++++++++++++++++++++++++++++++++
  if(numeros.exec($('#ApMaterno').val())){
    Invalido($('#ApMaterno'));
    return "El Apeido Materno solo puede contener letras";
  }else{
    Valido($('#ApMaterno'));
  }


  return "Correcto";
}
//funcion que limpia la variable de SESSION
function limpiarSesion(){
  $.ajax({
    method: 'POST',
    url: 'control/MedicoEnfermera.php',
    data: {"Boton":"Limpiar"}
  });
}