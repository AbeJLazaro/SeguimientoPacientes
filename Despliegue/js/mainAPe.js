//****************************************************************************************
//Nombre:         mainAPe.css
//Objetivos:      Código JS para la pantalla de ActualizarMedicoEnfermera.php, hace todas 
//                las validaciones y pide confirmaciones para el uso de la pantalla
//Creado por:     Lázaro Martínez Abraham Josué
//Fecha:          viernes 3 de enero de 2020
//version:        1.0                 
//****************************************************************************************
//VARIABLES GLOBALES**********************************************************************
var deshabilitado=1;
//oculta el formulario de datos encontrados
$('#BusquedaEncontrada').hide();
//deshabilita los campos subcategoria y tipo de usuario
$('#Subcategoria_id').attr('disabled',true);
$('#TipoUsuario').attr('disabled',true);

//EVENTOS*********************************************************************************
//cuando se hace click en el boton guardar
$('#Guardar').click(function(){
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
  var continuar=Validacion(matricula,nombre, apPaterno, 
    apMaterno,categoria, subcategoria,tipo);
  //se revisa la contraseña
  var contra;
  //si el boton para mantener la contraseña esta seleccionado, se regresa true
  if($('#MantenerContraseña').is(':checked')){
    contra=true;
  }else{
    //si no, se revisa el contenido del input
    //si esta vacio, se regresa un false
    if(password==""){
      contra=false;
    }else{
      contra=true;
    }
  }
  //si los campos obligatorios estan llenos, se continua
  if(continuar && contra){
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
            //se revisa si el boton para mantener la contraseña esta seleccionado
            if($('#MantenerContraseña').is(':checked')){
              $.ajax({
                method: 'POST',
                //ruta del archivo php de control
                url: 'control/MedicoEnfermera.php',
                //datos que se enviaran
                data:{"Matricula": matricula,
                      "Nombre":nombre,
                      "ApPaterno":apPaterno,
                      "ApMaterno":apMaterno,
                      "Categoria":categoria,
                      "Subcategoria":subcategoria,
                      "Tipo":tipo,
                      "Boton":"ActualizarSinPassword"},
                
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
                      "Boton":"Actualizar"},
                
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
//si se hace click en el boton regresar del segundo formulario
$('#Regresar2').click(function(){
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

  if($('#Categoria_id').val()==5){
    $('#TipoUsuario').val("U");
  }else{
    $('#TipoUsuario').val("A");
  }
});
//si se hace click en el boton Buscar
$('#Buscar').click(function(){
  //datos del formulario
  var matricula=$('#Matricula').val();
  //se valida los campos si estan llenos o no
  if($('#Matricula').val()==""){
    Invalido($('#Matricula'));
  }else{
    Valido($('#Matricula'));
  }

  //envio de datos con ajax
  if(matricula!=""){
    //no se pide confirmación, solo se busca
    $.ajax({
      method: 'POST',
      //ruta del archivo php de control
      url: 'control/MedicoEnfermera.php',
      //datos que se enviaran
      data: {"Matricula": matricula,"Boton":"Encontrar"},
      
      // el parametro res es la respuesta que da php mediante impresion de pantalla (echo)
      success: function(res){
        //se regresa un guardado si todo salió bien
        if(res=='Encontrado'){
          //se muestra una ventana de confirmación
          swal({
            title: "Personal encontrado",
            icon: "success",
          }).then(
            (confirm)=>{
              LlenarCampos(matricula);
            }
          );
        }else{
          //Si el error se debe a que el paciente no existe, se pregunta si se
          //desea agregar al paciente
          if(res=='No existen datos para esa matrícula'){
            swal({
              title: res,
              text: "¿Desea registrar al personal?",
              icon: "info",
              buttons:true
            }).then(
            (confirm) =>{
              if(confirm){
                CambioPantalla(matricula);
              }else{
                Invalido($('#Matricula'));
              }
            });
          //si el error es de otro tipo, se muestra
          }else{
            Invalido($('#Matricula'));
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
//FUNCIONES*****************************************************************************************
//funcion que valida que los elementos no sean nulos
function Validacion(p1,p2,p3,p4,p5,p6,p7){
  if(p1!="" && p2!="" && p3!="" && p4!="" && p5!="" && p6!="" && p7!=""){
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
  //si esta seleccionada la opcion de no cambiar la contraseña
  if ($('#MantenerContraseña').is(':checked')) {
    Valido($('#Password'));
  //si no, se checa el contenido de la su contenido
  }else{
    if($('#Password').val()==""){
      Invalido($('#Password'));
    }else{
      Valido($('#Password'));
    }
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
  var numeros = new RegExp('[^A-Za-záÁéÉíÍóÓúÚ üÜñÑ\.]');
  var noNumeros = /\D/;
  //se valida que tenga todo el formato correcto, que los nombres no tengan
  //numeros no contengan letras
  //matricula de puros numeros++++++++++++++++++++++++++++++++++++++++++++++++++
  if(noNumeros.exec($('#Matricula').val())){
    Invalido($('#Matricula'));
    return "La Matrícula solo puede contener números";
  }else{
    Valido($('#Matricula'));
  }
  //si la contraseña no se va a cambiar
  if ($('#MantenerContraseña').is(':checked')) {
    Valido($('#Password'));
    Valido($('#Password2'));
  //si no se tiene esa opcion seleccionada, se revisan los campos de contraseña
  }else{
    //password de 6 caracteres++++++++++++++++++++++++++++++++++++++++++++++++++
    if($('#Password').val().length<6){
      Invalido($('#Password'));
      return "La contraseña debe ser de por lo menos 6 caracteres";
    }else{
      Valido($('#Password'));
    }
    //Repetir password +++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    if($('#Password2').val()!=$('#Password').val()){
      Invalido($('#Password'));
      Invalido($('#Password2'));
      return "Las contraseñas deben coincidir";
    }else{
      Valido($('#Password'));
      Valido($('#Password2'));
    }
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
    return "El Apellido Paterno solo puede contener letras";
  }else{
    Valido($('#ApPaterno'));
  }
  //apeido materno del paciente++++++++++++++++++++++++++++++++++++++++++++++++
  if(numeros.exec($('#ApMaterno').val())){
    Invalido($('#ApMaterno'));
    return "El Apellido Materno solo puede contener letras";
  }else{
    Valido($('#ApMaterno'));
  }
  return "Correcto";
}
//funcion para cambiar de pantalla
function CambioPantalla(matricula){
  $.ajax({
    method:'POST',
    url:'control/MedicoEnfermera.php',
    data:{"Matricula":matricula,"Boton":"Cambiar"}
  });
  window.location="RegistroMedicoEnfermera.php";
}
//funcion que llena los datos
function LlenarCampos(matricula){
  //ocultan los botones del inicio y se muestra el otro formulario
  $('#BotonesInicio').hide();
  $('#BusquedaEncontrada').show();
  //se desabilita el campo de NSSA
  $('#Matricula').attr('disabled',true);
  //se manda a llamar el archivo php
  $.ajax({
    method: 'POST',
    //ruta del archivo php de control
    url: 'control/MedicoEnfermera.php',
    //datos que se enviaran 
    data: {"Matricula": matricula,"Boton":"Buscar"},
    
    // el parametro res es la respuesta que da php mediante impresion de pantalla (echo)
    success: function(res){
      swal({
        title: "Datos encontrados"
      });
      //se separan los datos por comas
      var Datos=res.split(",");
      //se le asigna a cada campo su parte según el split
      $('#Nombre').val(Datos[0]);
      $('#ApPaterno').val(Datos[1]);
      $('#ApMaterno').val(Datos[2]);
      $('#TipoUsuario').val(Datos[3]);
      $('#Categoria_id').val(Datos[4]);
      if(Datos[5]!="NULL"){
        $('#Subcategoria_id').val(Datos[5]);
      }else{
        $('#Subcategoria_id').val("5");
      }
      if(Datos[4]==5){
        $('#Subcategoria_id').attr('disabled',false);
        deshabilitado=0;
      }
      
    }
  });
}