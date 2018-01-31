<?php

include_once("config/config.app.php");
if(isset($_GET['debug']))
	$model->changeDebugState($_GET['debug']);
//include_once("include/outh.php");
//if($profile_uid=="no_session"){
  //  echo $profile_uid;
    //exit;
//}

$rs=$model->User_Data($_POST['id']);

$datos=array();
$general2=array();
if(!$rs->EOF){
	
	$datos['id']=$rs->fields['id'];
	$datos['username']=$rs->fields['username'];	
	$datos['password']=$rs->fields['password'];	
	$datos['nombre']=$rs->fields['nombres'];	
	$datos['email']=$rs->fields['email'];	
	$datos['region']=$rs->fields['region'];	
	$datos['ciudad']=$rs->fields['ciudad'];	
	$datos['comuna']=$rs->fields['comuna'];	
	$datos['direccion']=$rs->fields['direccion'];	
	$datos['codigopostal']=$rs->fields['codigopostal'];	
	$datos['telefono']=$rs->fields['telefono'];	
	$datos['genero']=$rs->fields['genero'];	
	$rsFactura=$model->getUltimaFacturacion($rs->fields['id']);
	if(!$rsFactuta->EOF){
		$datos['razon']=$rsFactura->fields['razon'];	
		$datos['rutempresa']=$rsFactura->fields['rutempresa'];	
		$datos['giro']=$rsFactura->fields['giro'];	
		$datos['telefonoempresa']=$rsFactura->fields['telefonoempresa'];	
		$datos['direccionempresa']=$rsFactura->fields['direccionempresa'];	
		$datos['regionempresa']=$rsFactura->fields['regionempresa'];	
		$datos['ciudadempresa']=$rsFactura->fields['ciudadempresa'];	
		$datos['comunaempresa']=$rsFactura->fields['comunaempresa'];	
	}

}

$general2[]=$datos;
		
echo html_entity_decode(json_encode($general2, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
?>