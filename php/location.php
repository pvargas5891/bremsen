<?php
include_once("config/config.app.php");
//$model->changeDebugState(true);
//include_once("include/outh.php");
//if($profile_uid=="no_session"){
  //  echo $profile_uid;
    //exit;
//}

if(isset($_GET['region'])){
    $rs=$model->getCiudadesByRegion($_GET['region']);
    $general=array();
    while(!$rs->EOF){
        $general2=array();
        $general2[]=$rs->fields['CIU_CODIGO'];
        $general2[]=$rs->fields['CIU_NOMBRE'];
        $general[]=$general2;
        $rs->movenext();
    }
    echo json_encode($general);
	exit;
}
if(isset($_GET['ciudad'])){
    $rs=$model->getComunasByCiudad($_GET['ciudad']);
    $general=array();
    while(!$rs->EOF){
        $general2=array();
        $general2[]=$rs->fields['COM_CODIGO'];
        $general2[]=$rs->fields['COM_NOMBRE'];
        $general[]=$general2;
        $rs->movenext();
    }
    echo json_encode($general);
	exit;
}
$rs=$model->getRegiones();
    $general=array();
    while(!$rs->EOF){
        $general2=array();
        $general2[]=$rs->fields['REG_CODIGO'];
        $general2[]=$rs->fields['REG_NOMBRE'];
        $general[]=$general2;
        $rs->movenext();
    }
    echo json_encode($general);
?>