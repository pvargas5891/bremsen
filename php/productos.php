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
	case 'venta':
		$datos=array();
		
		
		$rsWebpay=$model->getWebPayByPago($_POST['id']);
		$datos['Tbk_tipo_transaccion']=$rsWebpay->fields['Tbk_tipo_transaccion'];
		$datos['Tbk_respuesta']=$rsWebpay->fields['Tbk_respuesta'];
		$datos['Tbk_orden_compra']=$rsWebpay->fields['Tbk_orden_compra'];
		$datos['Tbk_id_sesion']=$rsWebpay->fields['Tbk_id_sesion'];
		$datos['Tbk_codigo_autorizacion']=$rsWebpay->fields['Tbk_codigo_autorizacion'];
		$datos['Tbk_monto']=$rsWebpay->fields['Tbk_monto'];
		$datos['Tbk_numero_tarjeta']=$rsWebpay->fields['Tbk_numero_tarjeta'];
		$datos['Tbk_numero_final_tarjeta']=$rsWebpay->fields['Tbk_numero_final_tarjeta'];
		$datos['Tbk_fecha_expiracion']=$rsWebpay->fields['Tbk_fecha_expiracion'];
		$datos['Tbk_fecha_contable']=$rsWebpay->fields['Tbk_fecha_contable'];
		$datos['Tbk_fecha_transaccion']=$rsWebpay->fields['Tbk_fecha_transaccion'];
		$datos['Tbk_hora_transaccion']=$rsWebpay->fields['Tbk_hora_transaccion'];
		$datos['Tbk_id_transaccion']=$rsWebpay->fields['Tbk_id_transaccion'];
		$datos['Tbk_tipo_pago']=$rsWebpay->fields['Tbk_tipo_pago'];

		$trs_tipo_pago = $datos['Tbk_tipo_pago'];

$trs_nro_cuotas = $rsWebpay->fields['Tbk_numero_cuotas'];

if ($trs_nro_cuotas=='0'){$trs_nro_cuotas='00';}

$tipo_pago_descripcion="";$tipo_pago=" Credito";

if ($trs_tipo_pago=="VN"){	$tipo_pago_descripcion=" Sin Cuotas";}

if ($trs_tipo_pago=="VC"){	$tipo_pago_descripcion=" Normales";}

if ($trs_tipo_pago=="SI"){	$tipo_pago_descripcion=" Sin inter&eacute;s";}

if ($trs_tipo_pago=="CIC"){	$tipo_pago_descripcion=" Cuotas Comercio";}

if ($trs_tipo_pago=="VD"){	$tipo_pago_descripcion=" Debito";$tipo_pago=" Debito";}
		$datos['tipo_cuotas']=$tipo_pago_descripcion;
		$datos['Tbk_tipo_pago']=$tipo_pago;
		$datos['Tbk_numero_cuotas']=$trs_nro_cuotas ;
		$datos['Tbk_mac']=$rsWebpay->fields['Tbk_mac'];
		$datos['Tbk_monto_cuota']=$rsWebpay->fields['Tbk_monto_cuota'];
		$datos['Tbk_tasa_interes_max']=$rsWebpay->fields['Tbk_tasa_interes_max'];
		$datos['Tbk_ip']=$rsWebpay->fields['Tbk_ip'];
		$datos['token']=$rsWebpay->fields['token'];

		$rsDetalle=$model->getDetalleCompra($_POST['id']);
		$datos['usuario']=$rsDetalle->fields['usuario'];
		$datos['pagoId']=$rsDetalle->fields['pagoId'];
		$datos['regionInstalacion']=$rsDetalle->fields['regionInstalacion'];
		$datos['ciudadInstalacion']=$rsDetalle->fields['ciudadInstalacion'];
		$datos['comunaInstalacion']=$rsDetalle->fields['comunaInstalacion'];
		$datos['aceptaInstalacion1value']=$rsDetalle->fields['aceptaInstalacion1value'];
		$datos['nombresInstalacion2value']=$rsDetalle->fields['nombresInstalacion2value'];
		$datos['direccionInstalacion2value']=$rsDetalle->fields['direccionInstalacion2value'];
		$datos['rutInstalacion3value']=$rsDetalle->fields['rutInstalacion3value'];
		$datos['nombresInstalacion3value']=$rsDetalle->fields['nombresInstalacion3value'];
		$datos['direccionInstalacion3value']=$rsDetalle->fields['direccionInstalacion3value'];
		$datos['aceptaInstalacion3value']=$rsDetalle->fields['aceptaInstalacion3value'];
		$datos['tallerAsociadovalue']=$rsDetalle->fields['tallerAsociadovalue'];
		$datos['fechaInstalacionvalue']=$rsDetalle->fields['fechaInstalacionvalue'];
		$datos['bloqueHorariovalue']=$rsDetalle->fields['bloqueHorariovalue'];
		$datos['direccionInstalacion4value']=$rsDetalle->fields['direccionInstalacion4value'];
		$datos['aceptaInstalacion4value']=$rsDetalle->fields['aceptaInstalacion4value'];
		$datos['tipoInstalacion']=$rsDetalle->fields['tipoInstalacion'];
		$datos['costoNeumaticos']=$rsDetalle->fields['costoNeumaticos'];	
		$datos['costoInstalacion']=$rsDetalle->fields['costoInstalacion'];
		$datos['descuentoAplicado']=$rsDetalle->fields['descuentoAplicado'];
		$datos['totalTotales']=$rsDetalle->fields['totalTotales'];
		
		$cliente=$model->User_Data($datos['usuario']);
		$datos['nombreCliente']=$cliente->fields['nombres'];	
		$datos['email']=$cliente->fields['email'];
		$rsCarro=$model->getCarroPorPago($_POST['id']);

		//$datos['productosComprados']=array();
		while(!$rsCarro->EOF){
			  $rsProducto=$model->getProductoById($rsCarro->fields['id_producto']);
			  $general2['MARCA']=$rsProducto->fields['Marca'];
			  $general2['MODELO']=$rsProducto->fields['MODELO'];
			  $general2['MEDIDA']=$rsProducto->fields['MEDIDA'];
			  $general2['CANTIDAD']=$rsCarro->fields['cantidad'];
			  $general[]=$general2;
			  
			$rsCarro->movenext();
		} ;
		$datos['productosComprados']=$general;
		echo html_entity_decode(json_encode($datos, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));

	break;
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
		
		$rs=$model->getProductosFilter($_GET,'*','Marca');
		$general2=array();
		while(!$rs->EOF){			
			$general2[]=$rs->fields['Marca'];			
			$rs->movenext();
		}
		$general[]=$general2;


		$general2=array();
		$rs=$model->getProductosFilter($_GET);
		$general2temp=array();
		while(!$rs->EOF){	
			if($rs->fields['RUNFLAT']=='Si')		
				$general2temp[]='Alta Seguridad (Runflat)';		
			if($rs->fields['4x4']=='Si')		
				$general2temp[]='Camioneta (M/T)';
			if($rs->fields['carretera']=='Si')		
				$general2temp[]='Automovil (H/T)';			
			$rs->movenext();
		}
		$general2temp=array_unique($general2temp);
		//print_r($general2temp);
		foreach($general2temp as $valor){
			$general2[]=$valor;
		}
		
		$general[]=$general2;

		$general2=array();
		$rs=$model->getProductosFilter($_GET);
		$general2temp=array();
		while(!$rs->EOF){	
			if($rs->fields['OFERTA']=='Si')		
				$general2temp[]='Oferta';		
					
			$rs->movenext();
		}
		$general2temp=array_unique($general2temp);
		//print_r($general2temp);
		foreach($general2temp as $valor){
			$general2[]=$valor;
		}

		$general[]=$general2;

		echo html_entity_decode(json_encode($general, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));

	break;
	case 'enviarDatos':
		$rs=$model->getProductosAll();
		$general=parseador($rs);
		echo html_entity_decode(json_encode($general, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));

	break;
	case 'enviacontacto':
	 	//params.append('nombre', nombre);
        //params.append('email', email);
        //params.append('mensaje', mensaje);
		//params.append('accion', 'enviacontacto');
$mail->From = "ventas@bremsen.cl";
$mail->FromName = "Contacto Bremsen Web";
$mail->Subject = "Contacto Via Web";
$body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">

<title>Contacto</title>

<body style="margin:0; padding:0; background-position:top center; font-family:Arial, Helvetica, sans-serif">';
$table="Contacto Via Web:<br>";
$table.="Nombre Completo:".$_GET['nombre']."<br>";
$table.="Email:".$_GET['email']."<br>";
$table.="Mensaje:".$_GET['mensaje']."<br>";
$body .= $table;
$body .= "</body>
</html>";

$mail->Body = $body;
$mail->AddAddress('ventas@bremsen.cl', 'ventas@bremsen.cl');
$mail->Send();
$mail->ClearAddresses();

$mail->Body = $body;
$mail->AddAddress('pvargas.figueroa@gmail.com', 'pvargas.figueroa@gmail.com');
$mail->Send();
$mail->ClearAddresses();

		$rs=$model->getProductosAll();
		$general=parseador($rs);
		echo html_entity_decode(json_encode($general, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));

	break;
	case 'enviaconfirmacion':
		$rs=$model->getProductosAll();
		$general=parseador($rs);
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
			if(strtoupper($rs->fields['OFERTA'])=='SI'){
				$general2['PRECIO_FINAL']=$rs->fields['precio_oferta'];
			}
			$general2['PRECIO_OFERTA']=$rs->fields['precio_oferta'];
			$general2['MODELO_RUEDA']=$rs->fields['modelo_rueda'];
			$porciones = explode(".", $rs->fields['JPG']);
			$general2['JPG']=strtoupper($porciones[0]).".".$porciones[1];
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