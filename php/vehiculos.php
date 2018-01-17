<?php

include_once("config/config.app.php");
if(isset($_GET['debug']))
	$model->changeDebugState($_GET['debug']);
//include_once("include/outh.php");
//if($profile_uid=="no_session"){
  //  echo $profile_uid;
    //exit;
//}
$general=array();

switch($accion){
	case 'marca':
		$rs=$model->getMarcasVehiculos();
		$i=1;
		while(!$rs->EOF){
			$general2= array();	
			$general2['title']=$rs->fields['MARCA'];
			$general2['id']=$i;
			$rs->movenext();
			$i++;
			$general[]=$general2;
		}
		
	break;
	case 'modelo':
		$rs=$model->getModeloVehiculos($_GET['marca']);
		$i=1;
		while(!$rs->EOF){
			$general2= array();	
			$general2['title']=$rs->fields['MODELO'];
			$general2['id']=$i;
			$rs->movenext();
			$i++;
			$general[]=$general2;
		}
	break;
	case 'ano':
		$rs=$model->getAnoVehiculos($_GET['modelo']);
		$i=1;
		while(!$rs->EOF){
			$general2= array();	
			$general2['title']=$rs->fields['ANO'];
			$general2['id']=$i;
			$rs->movenext();
			$i++;
			$general[]=$general2;
		}
	break;
	case 'ancho':
		$rs=$model->getAnchoVehiculos();
		$i=1;
		while(!$rs->EOF){
			$general2= array();	
			$general2['title']=number_format($rs->fields['ANCHO'],0,'.','.');
			$general2['id']=$i;
			$rs->movenext();
			$i++;
			$general[]=$general2;
		}
		
	break;
	case 'perfil':
		$rs=$model->getPerfilVehiculos($_GET['ancho']);
		$i=1;
		while(!$rs->EOF){
			$general2= array();	
			$general2['title']=number_format($rs->fields['PERFIL'],0,'.','.');
			$general2['id']=$i;
			$rs->movenext();
			$i++;
			$general[]=$general2;
		}
	break;
	case 'aro':
		$rs=$model->getAroVehiculos($_GET['perfil']);
		$i=1;
		while(!$rs->EOF){
			$general2= array();	
			$general2['title']=$rs->fields['ARO'];
			$general2['id']=$i;
			$rs->movenext();
			$i++;
			$general[]=$general2;
		}
	break;
	default:
		$rs=$model->getMarcasVehiculos();
		$i=1;
		while(!$rs->EOF){
			$general2= array();	
			$general2['title']=$rs->fields['MARCA'];
			$general2['id']=$i;
			$rs->movenext();
			$i++;
			$general[]=$general2;
		}
	break;
}	
	echo html_entity_decode(json_encode($general, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
exit;

$rs=$model->getVehiculosSegunCampo($_GET['tipo'],$_GET['campo1'],$_GET['campo2'],$_GET['campo3']);
while(!$rs->EOF){	
	$general2=array();
	if($_GET['tipo']==1){
		$general2[]=$rs->fields['MARCA'];
		$general2[]=$rs->fields['MODELO'];
		$general2[]=$rs->fields['ANO'];
	}else{
		$general2[]=$rs->fields['ANCHO'];
		$general2[]=$rs->fields['PERFIL'];
		$general2[]=$rs->fields['ARO'];
	}
	$general[]=$general2;
	$rs->movenext();
}

echo html_entity_decode(json_encode($general, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
?>