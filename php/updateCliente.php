<?php

include_once("config/config.app.php");
if(isset($_GET['debug']))
	$model->changeDebugState($_GET['debug']);
//include_once("include/outh.php");
//if($profile_uid=="no_session"){
  //  echo $profile_uid;
    //exit;
//}

$general2=array();
switch($accion){
	case 'password':
		$rs=$model->updatePassword($_POST);
		$general2[]='OK';
	break;
	case 'recupera':
		$rs=$model->getPasswordByEmail($_POST['email']);
		// se manda correo
		if(!$rs->EOF){
			$general2[]='OK';
		}else{
			$general2[]='NOK';
		}		
	break;
	default:
		$model->updateCliente($_POST);
		$general2[]='OK';
	break;
}
echo html_entity_decode(json_encode($general2, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
?>