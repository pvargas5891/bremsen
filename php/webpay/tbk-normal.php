<?php
session_start();
define('DB_SERVER', 'mysql.bremsen.kodamas.cl');
define('DB_USERNAME', 'bremsenkodamascl');
define('DB_PASSWORD', 'q42W99E3');
define('DB_DATABASE', 'bremsen_kodamas_cl');
include_once('/home/dh_8kbk7p/bremsen.kodamas.cl/maqueta/lib/adodb5/adodb.inc.php');
include_once('/home/dh_8kbk7p/bremsen.kodamas.cl/maqueta/model/PondaAdminModel.php');
$model= new PondaAdminModel();
$model->changeDebugState(false);
$urlfracaso="http://localhost:4200/index.html#/fracaso";
$urlexito="http://localhost:4200/index.html#/exito";
$urlfracaso="http://bremsen.kodamas.cl/maqueta/fracaso.php";
$urlexito="http://bremsen.kodamas.cl/maqueta/exito.php";

if(isset($_GET['transferencia'])){
	$rsPago=$model->getPagoByUsuario($_GET['usuario']);
	$fecha=date('Y')."-".date('m')."-".date('d');
	$sql="insert into webpay (Tbk_tipo_transaccion, Tbk_respuesta, Tbk_orden_compra, Tbk_id_sesion, Tbk_codigo_autorizacion, Tbk_monto, Tbk_numero_tarjeta, Tbk_numero_final_tarjeta, Tbk_fecha_expiracion, Tbk_fecha_contable, Tbk_fecha_transaccion, Tbk_hora_transaccion, Tbk_id_transaccion, Tbk_tipo_pago, Tbk_numero_cuotas, Tbk_mac, Tbk_monto_cuota, Tbk_tasa_interes_max,Tbk_ip,token)
		Values ('',
		'0','".$rsPago->fields['pagosID']."','".$rsPago->fields['pagosID']."','003521','".$rsPago->fields['TBK_MONTO']."','6789',
		'6789','0000-00-00','".$fecha."','".$fecha."','',
		'".$rsPago->fields['pagosID']."','TR','0','577565663','0','0',
		'".$_SERVER['REMOTE_ADDR']."','noplica')";
		$model->executeCommand($sql);
	$query="UPDATE `pagos` SET estado ='transferencia' where pagosID ='".$rsPago->fields['pagosID']."'";
	$model->executeCommand($query);
	echo '<form action="'.$urlexito.'" name="pago" method="post">
	<input type="hidden" name="token_ws" value="noaplica">
	<input type="hidden" name="TBK_ORDEN_COMPRA" value="'.$rsPago->fields['pagosID'].'">
</form>
<script>
	document.pago.submit();
</script>';
exit;
}
/**
 * @author     Allware Ltda. (http://www.allware.cl)
 * @copyright  2015 Transbank S.A. (http://www.tranbank.cl)
 * @date       Jan 2015
 * @license    GNU LGPL
 * @version    1.0
 */
//TODOS LOS REQUEST Y RESPONSE PASAN POR ESTE ARCHIVO
require_once( 'libwebpay/webpay.php' );
require_once( 'certificates/cert-normal.php' );
//require_once( 'certificates/cert-normal-produccion.php' );


/* CONFIGURACION PARAMETROS DE LA CLASE WEBPAy */
$sample_baseurl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
//INTEGRACION
$webpay_settings = array(
	"MODO" => "INTEGRACION",
	"PRIVATE_KEY" => $certificate['private_key'],
	"PUBLIC_CERT" => $certificate['public_cert'],
	"WEBPAY_CERT" => $certificate['webpay_cert'],
	"COMMERCE_CODE" => $certificate['commerce_code'],
	"URL_RETURN" => $sample_baseurl."?action=result",
	"URL_FINAL" => $sample_baseurl."?action=end",
);
//print_r($webpay_settings);
/* CREACION OBJETO WEBPAY */
$webpay = new WebPaySOAP($webpay_settings); // CREA OBJETO WEBPAY
$webpay = $webpay->getNormalTransaction(); // Crea Transaccion Normal

/*echo '
<div style="background-color:lightgrey;">
	<h3>GET</h3>
	<pre>';
		print_r($_GET);
echo '</pre></div>';*/

$action = isset($_GET["action"])? $_GET["action"]: 'init';

switch ($action) {

	default:
	 $rsPago=$model->getPagoByUsuario($_GET['usuario']);
	 $_SESSION['uid'] = $_GET['usuario'];
	 $tx_step = "Init";
		$request = array(
				"amount"    => $rsPago->fields['TBK_MONTO'],      // monto a cobrar
				"buyOrder"  => $rsPago->fields['pagosID'],    // numero orden de compra
				"sessionId" => $rsPago->fields['pagosID'], // idsession local
			);

	 		                // Iniciamos Transaccion
	 		 		$result = $webpay->initTransaction($request["amount"], $request["sessionId"], $request["buyOrder"]);
	 				$webpay_token = $result["token_ws"];

					/*echo '<div style="background-color:lightgrey;">
						<h3>response</h3>
						<pre>';
					print_r($result);
					echo '</pre>
					</div>';*/

				// Verificamos respuesta de inicio en webpay
				if (strlen($webpay_token)) {

					$message = "Sesion iniciada con exito en Webpay";
					$next_page = $result["url"];


				} else {
					$message = "webpay no disponible";
					$next_page=$urlfracaso;
					$idpago = $request["buyOrder"];
				}


		break;

	case "result":
 		$tx_step = "Get Result";
		if (!isset($_POST["token_ws"])) break;
		//print_r($_POST);
		$webpay_token = trim($_POST["token_ws"]);
		$request = array(
			"token"  => $webpay_token
		);
		$rsPago=$model->getPagoByUsuario($_SESSION['uid']);
		$sql="select * from webpay where Tbk_respuesta=0 and  Tbk_orden_compra =".$rsPago->fields['pagosID'];
		$rs=$model->executeCommand($sql);
		 if(!$rs->EOF){
			 $message = "Orden de compra duplicado";
			 $next_page=$urlfracaso;
			 $idpago = $rsPago->fields['pagosID'];
		 }else{

				 //acknowledgeTransaction
				// Rescatamos resultado y datos de la transaccion
				/*echo '<h2>getTransactionResult</h2>
				<div style="background-color:lightgrey;">
					<h3>request</h3>
					<pre>';
				print_r($request);
				echo '</pre>
				</div>';*/

				$result = $webpay->getTransactionResult($webpay_token);
				//print_r($result);
				// Verificamos resultado del pago


				if ($result->detailOutput->responseCode===0) {
					$message = "Pago ACEPTADO por webpay (se deben guardatos para mostrar voucher)";
					$next_page = $result->urlRedirection;
					$next_page_title = "Finalizar Pago";
					$fecha=date('Y')."-".date('m')."-".date('d');
					$sql="insert into webpay (Tbk_tipo_transaccion, Tbk_respuesta, Tbk_orden_compra, Tbk_id_sesion, Tbk_codigo_autorizacion, Tbk_monto, Tbk_numero_tarjeta, Tbk_numero_final_tarjeta, Tbk_fecha_expiracion, Tbk_fecha_contable, Tbk_fecha_transaccion, Tbk_hora_transaccion, Tbk_id_transaccion, Tbk_tipo_pago, Tbk_numero_cuotas, Tbk_mac, Tbk_monto_cuota, Tbk_tasa_interes_max,Tbk_ip,token)
						Values ('".$trs_transaccion."',
						'".$result->detailOutput->responseCode."','".$result->detailOutput->buyOrder."','".$result->sessionId."','".$result->detailOutput->authorizationCode."','".$result->detailOutput->amount."','".$result->cardDetail->cardNumber."',
						'".$result->cardDetail->cardNumber."','".$result->detailOutput->cardExpirationDate."','".$fecha."','".$fecha."','',
						'".$result->detailOutput->buyOrder."','".$result->detailOutput->paymentTypeCode."','".$result->detailOutput->sharesNumber."','577565663','0','0',
						'".$_SERVER['REMOTE_ADDR']."','".$webpay_token."')";
						$model->executeCommand($sql);
						$_SESSION['ultimacompra']=$result->detailOutput->buyOrder;
						$query="UPDATE `pagos` SET estado ='finalizada' where pagosID ='".$result->detailOutput->buyOrder."'";
						$model->executeCommand($query);

						$model->descuentaStockByPago($result->detailOutput->buyOrder);
				} else {
						$message = "Pago RECHAZADO por webpay - ".utf8_decode($result->detailOutput->responseDescription);
						$idpago = $result->detailOutput->buyOrder;
						$next_page=$urlfracaso;
				}
		 }
		break;


	case "end":
 		$tx_step = "End";
		$request= '';
		$result = $_POST;
		/*echo '
		<div style="background-color:lightgrey;">
			<h3>POST</h3>
			<pre>';
				print_r($_POST);
		echo '</pre></div>';*/
		$webpay_token = $_POST["TBK_TOKEN"];
		$idpago = $_POST["TBK_ORDEN_COMPRA"];
		$message = "Transacion Finalizada";
		if($idpago!=""){
			$next_page=$urlfracaso;
		}else{
			$result = $model->executeCommand("select * from webpay where token = '".$_POST["token_ws"]."'");
			$idpago = $result->fields['Tbk_orden_compra'];
			$next_page=$urlexito;
		}
		break;
}


?>

<p><samp><?php  //echo $message; ?></samp></p>

<?php if (strlen($next_page)) { ?>
<form action="<?php echo $next_page; ?>" name="pago" method="post">
	<input type="hidden" name="token_ws" value="<?php echo $webpay_token; ?>">
	<input type="hidden" name="TBK_ORDEN_COMPRA" value="<?php echo $idpago; ?>">
	<!--input type="submit" value="Continuar &raquo;"-->
</form>
<script>
	document.pago.submit();
</script>
<?php } ?>

<!--br>
<a href=".">&laquo; volver a index</a-->
