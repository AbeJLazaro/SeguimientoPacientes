//****************************************************************************************
//Nombre:         mainBP.css
//Objetivos:      Código JS para la pantalla de BuscarPaciente.php, hace todas 
//                las validaciones y pide confirmaciones para el uso de la pantalla
//Creado por:     Lázaro Martínez Abraham Josué
//Fecha:          viernes 3 de enero de 2020
//version:        1.0                 
//****************************************************************************************

//EVENTOS*********************************************************************************
//cuando se hace click en el boton guardar
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
          //cuando se haga click en el boton de la ventana emergente, se limpiaran
          //los campos y se muestra la información del paciente
              (confirm) => {
                MostrarDatos();
              });
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
              //si confirma, se hace el cambio de pantalla
              if(confirm){
                CambioPantalla(nssa);
              //si no, invalida el campo de NSSA
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
              icon: "warning",
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

//FUNCIONES*****************************************************************************************
//funcion que nos ayuda a cambiar de pantalla, guarda el valor de la matricula y cambia
//de formulario
function CambioPantalla(nssa){
  $.ajax({
    method:'POST',
    url:'control/Paciente.php',
    data: {"NSSA":nssa,"Boton":"Cambiar"}
  });
  window.location="RegistroPaciente.php";
}
//funcion para marcar como invalido un input
function Invalido(elemento){
  elemento.removeClass("is-invalid");
  elemento.removeClass("is-valid");
  elemento.addClass("is-invalid");
}
//Funcion para marcar como valido un input
function Valido(elemento){
  elemento.removeClass("is-valid");
  elemento.removeClass("is-invalid");
  elemento.addClass("is-valid");
}
//muestra los datos el paciente en caso de que se haya encontrado
function MostrarDatos(){
  var nssa=$('#NSSA').val();
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
      //si no es alguno de los errores programados, si encontró datos
      if(res!= "Ese paciente no existe" && res!="Error con la sentencia sql" && res!=""){
        swal({
          title: "Datos encontrados"
        });
        //se separan los datos por comas
        var Datos=res.split(",");
        //se le asigna a cada campo su parte según el split
        var nombre=Datos[0];
        var apPaterno=Datos[1];
        var apMaterno=Datos[2];
        var calle= Datos[3];
        var numExt=Datos[4];
        if(Datos[5]=="NULL"){
          var numInt="s/n";
        }else{
          var numInt=Datos[5];
        }
        var colonia=Datos[6];
        var delegacion=Datos[7];

        if(Datos[8]=="NULL"){
          var email="sin correo electrónico";
        }else{
          var email=Datos[8];
        }
        if(Datos[9]=="NULL"){
          var observaciones="sin observaciones";
        }else{
          var observaciones=Datos[9];
        }
        //los telefonos, depende del tipo que tenga, se selecciona un tipo
        if(Datos[10]>=1){
          var tel1=Datos[11];
          if(Datos[12]=='C'){
            var tipo1="Celular";
          }else{
            var tipo1="Fijo";
          } 
        }
        
        if(Datos[10]>=2){
          var tel2=Datos[13];
          if(Datos[14]=='C'){
            var tipo2="Celular";
          }else{
            var tipo2="Fijo";
          } 
        }

        if(Datos[10]==3){
          var tel3=Datos[15];
          if(Datos[16]=='C'){
            var tipo3="Celular";
          }else{
            var tipo3="Fijo";
          }
        }
        //genera la parte de HTML que se insertará con los datos anteriores
        var textoAInsertar=`
                            <dl>
                              <dt class="shadow p-3 mb-3 LabelPersonalizadoCampoLargo rounded">Nombre del paciente</dt>
                              <dd class="ml-5 mb-5">${nombre} ${apPaterno} ${apMaterno}</dd>
                                
                              <dt class="shadow p-3 mb-3 LabelPersonalizadoCampoLargo rounded">Domicilio</dt>
                              <dd class="ml-5">${calle} No.Ext.${numExt} No.Int.${numInt}</dd>
                              <dd class="ml-5">${colonia}</dd>
                              <dd class="ml-5 mb-5">${delegacion}</dd>

                              <dt class="shadow p-3 mb-3 LabelPersonalizadoCampoLargo rounded">Correo electronico</dt>
                              <dd class="ml-5 mb-5">${email}</dd>

                              <dt class="shadow p-3 mb-3 LabelPersonalizadoCampoLargo rounded">Observaciones</dt>
                              <dd class="ml-5 mb-5">${observaciones}</dd>

                              <dt class="shadow p-3 mb-3 LabelPersonalizadoCampoLargo rounded">Telefonos</dt>
                              <dd class="ml-5">${tipo1}  |  ${tel1}</dd> `
        //dependiendo de la cantidad de telefonos encontrados, se mostrarán
        if(Datos[10]>=2){
          textoAInsertar=textoAInsertar+`<dd class="ml-5">${tipo2}  |  ${tel2}</dd>`
        }
        if(Datos[10]==3){
          textoAInsertar=textoAInsertar+`<dd class="ml-5">${tipo3}  |  ${tel3}</dd>`
        }
        //se termina de concatenar el texto
        textoAInsertar=textoAInsertar+`</dl>`
        //se agrega el código al div correspondiente
        $('#Datos').append(textoAInsertar);
      //en caso contrario muestra el error
      }else{
        swal({
          title: "Error",
          text: res,
          icon: "warning"
        })
      }
    }
  });
}