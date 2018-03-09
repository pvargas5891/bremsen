<?php
include_once("config/config.app.php");
if($_GET['debug']==true)
    $model->changeDebugState(true);
//include_once("include/outh.php");
//if($profile_uid=="no_session"){
  //  echo $profile_uid;
    //exit;
//}

 $rsCarro=$model->getCarroPorCliente($_GET['cliente']);
 if(!$rsCarro->EOF){
    $model->actualizaMontos($rsCarro->fields['pagosID']);
 }

$rs=$model->getTipoInstalacionByComuna($_GET['comuna']);
    $general=array();
    $entro=0;
    while(!$rs->EOF){
        $general2=array();
        
        $general2['tipo']=$rs->fields['tipo'];
        $valorTemp=0;
        if($rs->fields['tipo']==1){
            $rsCarro=$model->getCarroPorCliente($_GET['cliente']);
            
            while(!$rsCarro->EOF){	
                $producto=$model->getProductosById($rsCarro->fields['id_producto']);
                if($producto->fields['ARO']>14){
                    $valorTemp+=0;
                }else{
                    $valorTemp+=$rsCarro->fields['cantidad']*$rs->fields['precio'];
                }
                $rsCarro->movenext();
            }
            $general2['valor']=$valorTemp;
        }
        if($rs->fields['tipo']==2){
           // 40000
            
             $rsPago=$model->getPagoByUsuario($_GET['cliente']);
             //gratis >$400000
             if($rsPago->fields['TBK_MONTO']>400000){
                $general2['valor']=0;
             }else{
                $general2['valor']=$rs->fields['precio'];
             }
             
        }
        if($rs->fields['tipo']==3){
            //40000
            
             $rsPago=$model->getPagoByUsuario($_GET['cliente']);
              //$25.000 Compras >$250.000 and <= 400000
             if($rsPago->fields['TBK_MONTO']>250000 and $rsPago->fields['TBK_MONTO'] <= 400000){
                $general2['valor']=25000;
             }else{//gratis >400000
                if($rsPago->fields['TBK_MONTO']>400000){
                    $general2['valor']=0;
                 }else{
                    $general2['valor']=$rs->fields['precio'];
                 }
                
             }         
            
              
        }
        if($rs->fields['tipo']==4){
            $entro=1;
            $general2['valor']=0;
            $rsCarro=$model->getCarroPorCliente($_GET['cliente']);
            $valorTemp=0;
            while(!$rsCarro->EOF){	
                $producto=$model->getProductosById($rsCarro->fields['id_producto']);
                if($producto->fields['ARO']<15){
                    $valorTemp+=$rs->fields['menor15'];
                }elseif($producto->fields['ARO']==15){
                    $valorTemp+=$rs->fields['igual15'];
                }elseif($producto->fields['ARO']>17){
                    $valorTemp+=$rs->fields['mayor17'];
                }else{
                    $general2['valor']=$rs->fields['precio'];
                }
                $rsCarro->movenext();
            }
            $general2['valor']=$valorTemp;
        }
        
        $general[]=$general2;
        $rs->movenext();
    }

    if($model->getRegionByComuna($_GET['comuna'])==13 and $entro==0){
            $general2=array();
            $rs=$model->getTipoInstalacionByComuna(277,4);
            $general2['tipo']=$rs->fields['tipo'];
            
            $rsCarro=$model->getCarroPorCliente($_GET['cliente']);
            $general2['valor']=$rs->fields['precio'];
            $valorTemp=$rs->fields['precio'];
            while(!$rsCarro->EOF){	
                $producto=$model->getProductosById($rsCarro->fields['id_producto']);
                if($producto->fields['ARO']<15){
                    $valorTemp+=$rs->fields['menor15'];
                }elseif($producto->fields['ARO']==15){
                    $valorTemp+=$rs->fields['igual15'];
                }elseif($producto->fields['ARO']>17){
                    $valorTemp+=$rs->fields['mayor17'];
                }
                $rsCarro->movenext();
            }
            $general2['valor']=$valorTemp;
            $general[]=$general2;
        }
        
    echo json_encode($general);
?>