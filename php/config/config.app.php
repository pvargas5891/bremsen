<?php
// disable error reporting
error_reporting(E_ERROR);
ini_set('display_errors', 'On');
//ini_set('session.save_path', 'tmp');
session_start();


header ('Content-type: text/html; charset=utf-8');
header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT');


define('DB_SERVER', 'mysql.bremsen.kodamas.cl');
define('DB_USERNAME', 'bremsenkodamascl');
define('DB_PASSWORD', 'q42W99E3');
define('DB_DATABASE', 'bremsen_kodamas_cl');
$base_url = 'http://bremsen.kodamas.cl/maqueta/';
$base_url_admin = 'http://bremsen.kodamas.cl/maqueta//admin';
$base_fisica= '/home/dh_8kbk7p/bremsen.kodamas.cl/maqueta';
include_once('lib/adodb5/adodb.inc.php');
include_once('model/PondaAdminModel.php');
include_once('lib/mailer/class.phpmailer.php');
include_once('lib/paginator.class.php');
$mail = new PHPMailer();
$mail->Host = "localhost";
$mail->Mailer = "mail";
/*$mail->SMTPAuth = true;
$mail->Username = "contacto_lippi";
$mail->Password = "CN456";*/
$mail->IsHTML(true);

$model= new PondaAdminModel();
$model->changeDebugState(false);

/*foreach ($_POST as $key => $input_arr)
{
    $_POST[$key] = addslashes(limpiarCadena($input_arr));
}*/

$input_arr = array();
foreach ($_GET as $key => $input_arr)
{
    $_GET[$key] = addslashes(limpiarCadena($input_arr));
}

function limpiarCadena($valor)
{
    $valor = str_ireplace("SELECT","",$valor);
    $valor = str_ireplace("COPY","",$valor);
    $valor = str_ireplace("DELETE","",$valor);
    $valor = str_ireplace("UNION ALL","",$valor);
    //$valor = str_ireplace("ALL","",$valor);
    $valor = str_ireplace("DROP","",$valor);
    $valor = str_ireplace("DUMP","",$valor);
    $valor = str_ireplace(" OR ","",$valor);
    $valor = str_ireplace("%","",$valor);
    $valor = str_ireplace("LIKE","",$valor);
    $valor = str_ireplace("--","",$valor);
    $valor = str_ireplace("^","",$valor);
    $valor = str_ireplace("[","",$valor);
    $valor = str_ireplace("]","",$valor);
    $valor = str_ireplace("\\","",$valor);
    $valor = str_ireplace("!","",$valor);
    $valor = str_ireplace("�","",$valor);
    //$valor = str_ireplace("?","",$valor);
    //$valor = str_ireplace("=","",$valor);
    //$valor = str_ireplace("&","",$valor);
    $valor = str_ireplace("<","",$valor);
    $valor = str_ireplace(">","",$valor);
    $valor = str_ireplace("vega.invalid","",$valor);
    return $valor;
}

$accion="";
if(isset($_GET['accion'])){
    $accion=$_GET['accion'];
}elseif(isset($_POST['accion'])){
    $accion=$_POST['accion'];
}
//include_once('func/validacion.php');
