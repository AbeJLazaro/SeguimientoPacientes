//****************************************************************************************
//Nombre:         mainCalendar.css
//Objetivos:      Código JS para generar un calendario con FullCalendar, usa una llamada 
//                a un archivo php para encontrar las citas guardadas.
//Creado por:     Lázaro Martínez Abraham Josué
//Fecha:          viernes 3 de enero de 2020
//version:        1.0                 
//****************************************************************************************

//VARIABLES GLOBALES**********************************************************************
var calendario;

//EVENTOS*********************************************************************************
$(document).ready(function() {
  CrearCalendario();        
});

//FUNCIONES*******************************************************************************
//funcion que crea el calendario usando FullCalendar
function CrearCalendario(){
  //genera una referencia al div del calendario
  var calendarEl = document.getElementById('Calendario');
  //inicializa la variable calendario como un objeto FullCalendar
  calendario = new FullCalendar.Calendar(calendarEl, {
    //carga los plugins necesarios
    plugins: ['dayGrid'],
    //genera el header con los botones de movimiento a la izquierda
    //en medio el titulo
    //a la derecha un boton personalizado
    header: {
      left: 'prev,today,next',
      center: 'title',
      right: 'Info'
    },
    //creacion de botones personalizados
    customButtons:{
      //boton para información
      Info:{
        //texto del boton y acción al hacer click
        text:"Información",
        click:function(){
          //mensaje de información con SweetAlert
          swal({
            title: "Informacion",
            text: "Las citas para examenes de laboratorio estan en verde\nLas citas para diagnostico estan en morado",
            icon: "info"
          });
        }
      }
    },
    //de donde saca los eventos, de un archivo php
    events:'control/calendario.php'

  });
  //cambia el idioma del calendario
  calendario.setOption('locale','Es');
  //genera y dibuja el calendario
  calendario.render();
  //quitamos y ponemos clases a botones del calendario para que todos tengan
  //el mismo tema
  $('.fc-Info-button').removeClass('fc-button-primary');
  $('.fc-Info-button').removeClass('fc-button');
  $('.fc-Info-button').addClass('btn');
  $('.fc-Info-button').addClass('BotonPersonalizado');

  $('.fc-next-button').removeClass('fc-button-primary');
  $('.fc-next-button').removeClass('fc-button');
  $('.fc-next-button').addClass('btn');
  $('.fc-next-button').addClass('BotonPersonalizado');

  $('.fc-prev-button').removeClass('fc-button-primary');
  $('.fc-prev-button').removeClass('fc-button');
  $('.fc-prev-button').addClass('btn');
  $('.fc-prev-button').addClass('BotonPersonalizado');

  $('.fc-today-button').removeClass('fc-button-primary');
  $('.fc-today-button').removeClass('fc-button');
  $('.fc-today-button').addClass('btn');
  $('.fc-today-button').addClass('BotonPersonalizado');

  $('.fc-button-group').addClass('btn-group');
}
//función que recarga el calendario
function RecargarCalendario(){
  //destruye el calendario anterior y genera uno nuevo
  calendario.destroy();
  CrearCalendario();
}