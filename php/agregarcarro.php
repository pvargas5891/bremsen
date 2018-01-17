<?php
include_once("config/config.app.php");
if(isset($_GET['debug']))
	$model->changeDebugState($_GET['debug']);
//$model->changeDebugState(true);
//include_once("include/outh.php");
//if($profile_uid=="no_session"){
  //  echo $profile_uid;
    //exit;
//}

$total=$model->getTotalStockPorProducto($_GET['value']);
//echo $total;
if($total<=0){
    $data[]="STOCK";
    exit;
}else{
    if($_GET['cantidad']>$total){
        $data[]="STOCKTEMP";
		echo json_encode($data);
        exit;
    }

    $rsCarro=$model->getCarroPorCliente($_GET['usuario']);
    $totalaevaluar=$_GET['cantidad'];
    while(!$rsCarro->EOF){
        if($_GET['value']==$rsCarro->fields['id_producto']){
            $rsProducto=$model->getProductoById($rsCarro->fields['id_producto']);
            $totalaevaluar2=$_GET['cantidad'];
            //echo $totalaevaluar;
            if($rsProducto->fields['STOCK']<$totalaevaluar2){
                $data[]="STOCKTEMP";
				echo json_encode($data);
                $model->close();
                exit;
            }

            /*$totalaevaluar2=$totalaevaluar2+$rsCarro->fields['cantidad'];
            if($rsProducto->fields['stock']<$totalaevaluar2){
                echo "STOCKTEMP2";
                $model->closeConexion();
                exit;
            }*/
        }
        $rsCarro->movenext();
    }

    $model->agregaCarro($_GET['value'],$_GET['usuario'],'','',$totalaevaluar,0,'');
	$data[]="OK";
	echo json_encode($data);
    //echo $total-$_GET['cantidad'];
}
?>
