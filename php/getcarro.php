<?php
include_once("config/config.app.php");
if(isset($_GET['debug']))
	$model->changeDebugState($_GET['debug']);
//$model->changeDebugState(true);
//include_once("include/outh.php");
//if($profile_uid=="no_session"){
  //  echo $profile_uid;
    //exit;
//}

$rs=$model->getCarroPorCliente($_GET['value']);


		while(!$rs->EOF){	
			$general2=array();		
			$general2['id_carro']=$rs->fields['id_carro'];			
			$general2['id_producto']=$rs->fields['id_producto'];			
			$general2['cantidad']=$rs->fields['cantidad'];			
			$general2['TBK_MONTO']=$rs->fields['TBK_MONTO'];			
			$general2['pagosID']=$rs->fields['pagosID'];			
			$general[]=$general2;
			$rs->movenext();
		}
		
		echo html_entity_decode(json_encode($general, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		
?>
