<?php
include_once("config/config.app.php");
//header("Access-Control-Allow-Origin: *");
//header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
//header('Access-Control-Allow-Methods: GET, POST, PUT');
//print_r($_POST);
//print_r($_GET);
$rs=$model->existeEmail($_POST['email']);
if(!$rs->EOF){
	$data="EXISTE";
	echo json_encode($data);
	exit;
}
$model->registroUsuario($_POST);
$data="OK";
echo json_encode($data);
?>