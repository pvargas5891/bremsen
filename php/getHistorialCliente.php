<?php

include_once("config/config.app.php");
if(isset($_GET['debug']))
	$model->changeDebugState($_GET['debug']);
//include_once("include/outh.php");
//if($profile_uid=="no_session"){
  //  echo $profile_uid;
    //exit;
//}

$rsVentas = $model->getPagosFinalizados($_POST);

$datos=array();
$general2=array();


while(!$rsVentas->EOF){
	$datos=array();
	$rsWebpay=$model->getWebPayByPago($rsVentas->fields['pagosID']);
	$rsDetalle=$model->getDetalleCompra($rsVentas->fields['pagosID']);
	$rsCarro=$model->getCarroPorPago($rsVentas->fields['pagosID']);
	$datos['orden']=$rsVentas->fields['pagosID'];	
	$datos['fecha']=$rsWebpay->fields['Tbk_fecha_transaccion'];	
	$datos['monto']=$rsDetalle->fields['totalTotales'];
	  if($rsVentas->fields['estado']=='finalizada')
     $tipopago='Webpay';
  else   
     $tipopago='Transferencia';
	$datos['tipo']= $tipopago;

    while(!$rsCarro->EOF){
	  $rsProducto=$model->getProductoById($rsCarro->fields['id_producto']);

	  $rsCarro->movenext();
	}  
	$general2[]=$datos;
	$rsVentas->movenext();
}


		
echo html_entity_decode(json_encode($general2, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
?>