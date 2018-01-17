<?php

include_once("config/config.app.php");
if(isset($_GET['debug']))
	$model->changeDebugState($_GET['debug']);
//include_once("include/outh.php");
//if($profile_uid=="no_session"){
  //  echo $profile_uid;
    //exit;
//}
//print_r($_GET);

switch($accion){

	case 'actualiza':
		
		$rs=$model->updateCantidadCarro($_GET['idcarro'],$_GET['cantidad']);
		$rs=$model->getCarroPorCliente($rs);


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

	break;
	case 'elimina':
	
		$rs=$model->quitarCarro($_GET['idcarro']);
		$rs=$model->getCarroPorCliente($rs);


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
		
	break;

	default:
	echo "no pesca";
	break;
}

function parseador($rs){
	
	
	$general=array();
		while(!$rs->EOF){
			$general2=array();
			$general2['ID']=$rs->fields['id'];
			$general2['CODIGO']=$rs->fields['CODIGO'];
			$general2['MARCA']=$rs->fields['Marca'];
			$general2['MODELO']=$rs->fields['MODELO'];
			$general2['MEDIDA']=$rs->fields['MEDIDA'];
			$general2['CATEGORIA']=$rs->fields['CATEGORIA'];
			$general2['ANCHO']=$rs->fields['ANCHO'];
			$general2['PERFIL']=$rs->fields['PERFIL'];
			$general2['ARO']=$rs->fields['ARO'];
			$general2['CARGA']=$rs->fields['Carga'];
			$general2['LARGO']=$rs->fields['LARGO'];
			$general2['ALTO']=$rs->fields['ALTO'];
			$general2['PESO']=$rs->fields['Peso'];
			$general2['NETO']=$rs->fields['neto'];
			$general2['UNITARIO']=$rs->fields['unitario'];
			$general2['VALOR_INSTALACION']=$rs->fields['VALOR_INSTALACION'];
			$general2['TOTAL']=$rs->fields['total'];
			$general2['MC']=$rs->fields['MC'];
			$general2['NETO2']=$rs->fields['neto2'];
			$general2['PRECIO_FINAL']=$rs->fields['precio_final'];
			$general2['PRECIO_OFERTA']=$rs->fields['precio_oferta'];
			//$general2['MODELO']=$rs->fields['MODELO'];
			$general2['JPG']=$rs->fields['JPG'];
			$general2['TITULO']=$rs->fields['TITULO'];
			$general2['ATRIBUTOS']=$rs->fields['ATRIBUTOS'];
			$general2['DESCRIPCION']=$rs->fields['DESCRIPCION'];
			$general2['LOGO']=$rs->fields['Logo'];
			$general2['INCLUYE_INSTALACION']=$rs->fields['INCLUYE_INSTALACION'];
			$general2['DESPACHO']=$rs->fields['DESPACHO'];
			$general2['ULTIMOS_DIAS']=$rs->fields['ultimos_dias'];
			$general2['RUNFLAT']=$rs->fields['RUNFLAT'];
			$general2['OFERTA']=$rs->fields['OFERTA'];
			$general2['ALTO_DESEMPENO']=$rs->fields['alto_desempeno'];
			$general[]=$general2;
			$rs->movenext();
		}
	return $general;
}
?>