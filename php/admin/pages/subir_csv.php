<?php
error_reporting(0);
include_once("include/universal.php");
//$model->changeDebugState(true);
//include_once("include/header.php");
$arch = $_FILES["arch"];

print_r($arch);

if((is_uploaded_file($arch))) {
   echo"ok";
}else{
   echo"no";
}

    //SE ABRE EL ARCHIVO EN MODO LECTURA

?>
