<?php

session_start();

$Boton=$_POST['Boton'];

switch ($Boton) {
  case 'Ir':
    $_SESSION['RegresarAReporte']=1;
    break;
  case 'Regresar':
    $_SESSION['RegresarAReporte']=0;
    break;
  case 'Revisar':
    echo $_SESSION['RegresarAReporte'];
    break;
  default:
    echo "";
    break;
}

?>