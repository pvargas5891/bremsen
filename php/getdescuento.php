<?php

include_once("config/config.app.php");
if(isset($_GET['debug']))
	$model->changeDebugState($_GET['debug']);
//include_once("include/outh.php");
//if($profile_uid=="no_session"){
  //  echo $profile_uid;
    //exit;
//}

$rs=$model->getDescuento($_GET['codigo']);
$datos=array();
$general2=array();
if(!$rs->EOF){
	
	$datos['valor']=$rs->fields['porcentaje'];

	
}

$general2[]=$datos;
		
echo html_entity_decode(json_encode($general2, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
?>