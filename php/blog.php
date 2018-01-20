<?php

include_once("config/config.app.php");
if(isset($_GET['debug']))
	$model->changeDebugState($_GET['debug']);
//include_once("include/outh.php");
//if($profile_uid=="no_session"){
  //  echo $profile_uid;
    //exit;
//}
$id="";
if(isset($_GET['id'])){
	$id=$_GET['id'];
}
$rs=$model->getBlogs($id);

$general2=array();
while(!$rs->EOF){
	$datos=array();
	$datos['id']=$rs->fields['id'];
	$datos['titulo']=$rs->fields['titulo'];	
	$datos['fotoprincipal']=$rs->fields['fotoprincipal'];	
	$datos['contenido']=$rs->fields['contenido'];	
	$general2[]=$datos;
	$rs->movenext();
}


		
echo html_entity_decode(json_encode($general2, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
?>