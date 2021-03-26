/*
FUNCIÓN regresar: definida para redirigirnos a la página anterior (index.php del módulo reportes)
No recibe ningún parámetro, es llamada en botones con la función onclick.

$(regresar());
function regresar(){                                                                                      
        location.href="../index.php";
}
*/
/*
FUNCIÓN ir_reporte: esta función nos dirige a la acción pendiente (formulario) de acuerdo al valor del botón
que representa el estatus del paciente.
Recibe el estatus del paciente (int) y de acuerdo al estatus (if) nos dirige a la respectiva pantalla
 */

$(ir_reporte());
function ir_reporte(estatus){
    //se guarda una variable en $_SESSION
    $.ajax({
        method:'POST',
        url:'control/RegresoReporte.php',
        data:{"Boton":"Ir"}
    });

    if(estatus == 1){                                                       // 1 = Pendiente de resultado de laboratorio
        location.href="ResultadoLaboratorio.php";      
    } else if(estatus == 2){                                                // 2 = Pendiente de diagnóstico
        location.href="RegistroDiagnostico.php";
    } else if(estatus == 3){                                                // 3 = Actualizar diagnóstico           
        location.href="ActualizacionPaciente.php";
    }
}

/*
FUNCIÓN filtrar_datos: función diseñada para reescribir la tabla en función de la interacción de los
selectores de filtro y orden de la tabla de reportes individuales.
Recibe la selección (String [1-10 opciones]) y lo manda con método POST al archivo filtro.php. En éste
se hará la consulta sql correspondiente a la selección y armará la tabla HTML. La guardará una variable PHP con los
valores correspondientes de la BD. Esta variable la retorna y en .done el html se reescribe en el div con
la clase llamada "datos" que se encuentra en el archivo individuales.php  
*/
$(filtrar_datos());
function filtrar_datos(sel){
    var data = $("#form_Fechas").serialize()
    if (sel === undefined){
        data += '&sel=0'
        $.ajax(
            {
                url: 'control/filtro.php',        //Ruta destino
                type: 'POST',                      //Método de envío 
                dataType: 'html',                  //Tipo de "retorno"
                //data: {sel: sel},                  //Dato a enviar
                data: data,                  //Dato a enviar
            })
        .done(function(respuesta) {
            $("#datos").html(respuesta);           //Acción a ejecutar si es que hay respuesta de filtro.php
        })
        .fail(function(){
            console.log("error");                  //Acción a ejecutar si NO hay respuesta por filtro.php
        }) 
        
    }else{
        data += '&sel='+sel
        $.ajax(
            {
                url: 'control/filtro.php',        //Ruta destino
                type: 'POST',                      //Método de envío 
                dataType: 'html',                  //Tipo de "retorno"
                //data: {sel: sel},                  //Dato a enviar
                data: data,                  //Dato a enviar
            })
        .done(function(respuesta) {
            $("#datos").html(respuesta);           //Acción a ejecutar si es que hay respuesta de filtro.php
        })
        .fail(function(){
            console.log("error");                  //Acción a ejecutar si NO hay respuesta por filtro.php
        })   
    }

    
}

/*
FUNCIÓN: detecta si hay alguna interacción con los selectores. Guarda el valor correspondiente 
a la selección y éste lo manda a la función filtrar_datos. 
*/
$(document).ready(function(){
    $("select").change(function(){      //Utilizamos el selector de clase "select", para que monitoree cualquier interacción con la etiqueta html select 
        filtrar_datos($(this).val());   //Mandamos el valor del select a la función
    });
  });

/*
FUNCIÓN buscar_datos: Esta función utiliza el método .ajax de jQuery para mandar una cadena (nombre parámetro: consulta)
al archivo buscar.php mediante el método POST. En este, se validará la cadena y respecto a esta se hará la consulta SQL para 
imprimirla en tablas de acuerdo al resultado obtenido. Retorna un html que será reescrito en el div #datos ubicado en individuales.php.
*/
$(buscar_datos());
function buscar_datos(consulta){
    var data = $("#form_Fechas").serialize()
    if (consulta === undefined){
        data += '&consulta=$'
        $.ajax(
            {
                url: 'control/buscar.php',
                type: 'POST',
                dataType: 'html',
                //data: {consulta: consulta},
                data: data,
            })
        .done(function(respuesta) {
            $("#datos").html(respuesta);
        })
        .fail(function(){
            console.log("error");
        })
    }else{
        data += '&consulta='+consulta
        $.ajax(
            {
                url: 'control/buscar.php',
                type: 'POST',
                dataType: 'html',
                //data: {consulta: consulta},
                data: data,
            })
        .done(function(respuesta) {
            $("#datos").html(respuesta);
        })
        .fail(function(){
            console.log("error");
        })
    }
}

/*
FUNCIÓN: detecta si hay alguna interacción con el input text ubicado en individuales.php. 
valida que no sea una cadena vacía y posteriormente lo manda a la función filtrar_datos. 
*/
$(document).on('keyup', '#caja_busqueda', function(){
    var valor =  $(this).val();
    if(valor != ""){
        buscar_datos(valor);
    } else{
        buscar_datos();
    }
});
