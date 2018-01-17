<?php
include_once("config/config.app.php");
//$model->changeDebugState(true);
//include_once("include/outh.php");
//if($profile_uid=="no_session"){
  //  echo $profile_uid;
    //exit;
//}
if(isset($_GET['region'])){
    $rs=$model->getTalleresByRegion($_GET['region']);
    $general=array();
    while(!$rs->EOF){
        $general2=array();
        $general2[]=$rs->fields['id'];
        $general2[]=$rs->fields['direccion'];
        $general[]=$general2;
        $rs->movenext();
    }
    echo json_encode($general);
	exit;
}
?>