<?php

include_once("config/config.app.php");
if(isset($_GET['debug']))
	$model->changeDebugState($_GET['debug']);
//include_once("include/outh.php");
//if($profile_uid=="no_session"){
  //  echo $profile_uid;
    //exit;
//}


switch($accion){
	case 'detalle':
	
		$general=array();
		$rs=$model->getProductosAllTotal();
		$general2=array();
		$general2['TOTALPRODUCTOS']=$rs;
		$general[]=$general2;
		
		$rs=$model->getTodasLasMarcas();
		$general2=array();
		while(!$rs->EOF){			
			$general2[]=$rs->fields['Marca'];			
			$rs->movenext();
		}
		$general[]=$general2;
		echo html_entity_decode(json_encode($general, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));

	break;
	case 'todos':
		
		$rs=$model->getProductosAll();
		$general=parseador($rs);
		echo html_entity_decode(json_encode($general, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));

	break;
	case 'sugerido':
		
		$rs=$model->getProductosAll(1,10);
		$general=parseador($rs);
		echo html_entity_decode(json_encode($general, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));

	break;
	case 'oferta':
		
		$rs=$model->getProductosAll();
		$general=parseador($rs);
		echo html_entity_decode(json_encode($general, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));

	break;
	case 'filtro':
		$rs=$model->getProductosFilter($_GET);
		$general=parseador($rs);
		echo html_entity_decode(json_encode($general, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));

	break;
	case 'unico':	
		$rs=$model->getProductosById($_GET['id']);
		$general=parseador($rs);
		echo html_entity_decode(json_encode($general, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
		
	break;
	case 'detallefiltro':
	
		$general=array();
		$rs=$model->getProductosFilter($_GET,"count(*) TOTAL");
		$general2=array();
		$general2['TOTALPRODUCTOS']=$rs->fields['TOTAL'];
		$general[]=$general2;
		
		$rs=$model->getTodasLasMarcas();
		$general2=array();
		while(!$rs->EOF){			
			$general2[]=$rs->fields['Marca'];			
			$rs->movenext();
		}
		$general[]=$general2;
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
			$general2['ANCHO2']=$rs->fields['ANCHO2'];
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
			$general2['MODELO_RUEDA']=$rs->fields['modelo_rueda'];
			$general2['JPG']=$rs->fields['JPG'];
			$general2['TITULO']=$rs->fields['TITULO'];
			$general2['ATRIBUTOS']=$rs->fields['ATRIBUTOS'];
			$general2['DESCRIPCION']=$rs->fields['DESCRIPCION'];
			$general2['LOGO']=$rs->fields['Logo'];
			$general2['INCLUYE_INSTALACION']=$rs->fields['INCLUYE_INSTALACION'];
			$general2['DESPACHO']=$rs->fields['DESPACHO'];
			$general2['4x4']=$rs->fields['4x4'];
			$general2['RUNFLAT']=$rs->fields['RUNFLAT'];
			$general2['OFERTA']=$rs->fields['OFERTA'];
			$stock=array();
			$contador=0;
			if($rs->fields['STOCK']!=20001)
				$contador=$rs->fields['STOCK'];
			for($i=1;$i<=$contador;$i++){
				$stock2=array();
				$stock2['codigo']=$i;
				$stock2['nombre']=$i;
				$stock[]=$stock2;
			}
			if($contador==0){
				$stock2=array();
				$stock2['codigo']=0;
				$stock2['nombre']=0;
				$stock[]=$stock2;
			}
			$general2['STOCK']=$stock;
			$general2['VIDEO']=$rs->fields['VIDEO'];
			$general[]=$general2;
			$rs->movenext();
		}
	return $general;
}
?>