<?php
//$model->changeDebugState(true);
echo '
<script type="text/javascript" src="'.$base_url.'/js/calendar.js"></script>
<script type="text/javascript" src="'.$base_url.'/js/calendar-es.js"></script>
<script type="text/javascript" src="'.$base_url.'/js/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" href="'.$base_url.'css/calendario.css" />

<script src="'.$base_url.'/assets/library/jquery/jquery.min.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>


					 <script src="'.$base_url.'/assets/library/jquery/jquery-migrate.min.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>


					 <script src="'.$base_url.'/assets/library/modernizr/modernizr.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>


					 <script src="'.$base_url.'/assets/plugins/core_less-js/less.min.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>


					 <script src="'.$base_url.'/assets/plugins/charts_flot/excanvas.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>


					 <script src="'.$base_url.'/assets/plugins/core_browser/ie/ie.prototype.polyfill.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>


					 <script src="'.$base_url.'/assets/library/jquery-ui/js/jquery-ui.min.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>


					 <script src="'.$base_url.'/assets/plugins/core_jquery-ui-touch-punch/jquery.ui.touch-punch.min.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>



<div class="container" style="width: 96%;"><br>
<h3>Ventas ordenadas por fecha de compra descendente</h3><br>';
$rsVentas = $model->getPagosFinalizados($_POST);

/*echo '
<form name="formbusqueda" method="post" action="index.php">
<table class="table table-bordered table-condensed">
<tr>
<td align="right"><strong>Fecha Inicio:</strong></td>
<td><input class="form-control" type="text" name="fechainicio" id="fechainicio" value="'.$_POST['fechainicio'].'"></td>
<td align="right"><strong>Fecha Termino:</strong></td>
<td><input class="form-control" type="text" name="fechatermino" id="fechatermino" value="'.$_POST['fechatermino'].'"></td>
<td align="right"><strong>Orden De Compra:</strong></td>
<td><input class="form-control" id="inputEmail3" type="text" name="orden" value="'.$_POST['orden'].'"></td>
<td>&nbsp;<input type="hidden" name="accion" value="ventas"></td>
<td><a href="javascript:void(0)" onclick="busquedaventas();" class="btn btn-block btn-primary"><i class="fa fa-fw fa-check"></i> Buscar&nbsp;&nbsp;</a></td>
</tr>
</table></form><br>';*/

while(!$rsVentas->EOF){
$rsClientes=$model->User_Data($rsVentas->fields['id_usuario']);
$rsWebpay=$model->getWebPayByPago($rsVentas->fields['pagosID']);
$rsSuc=$model->getSucursalByPago($rsVentas->fields['pagosID']);
//$codigodescuento=$model->getCodigoDescuentoByPago($rsVentas->fields['pagosID']);
  //$descuento=$model->getDescuento2($codigodescuento);
  //$porciento = $model->porcentaje($rsVentas->fields['TBK_MONTO'],$descuento,2);
echo '

<br>
<table style="border: #000 1px solid;" class="table table-striped table-responsive swipe-horizontal table-primary" >
  <thead>
		<tr>

           <th><strong>Orden de compra</strong></th>
           <th><strong>Monto Pagado</strong></th>
           <th><strong>Fecha Compra</strong></th>
           <th><strong>Codigo Descuento</strong></th>
           <th><strong>Descontado</strong></th>
        </tr>
		</thead>
        <tr>
               <td class="center">'.$rsVentas->fields['pagosID'].'</td>
               <td class="center">$'.$rsVentas->fields['TBK_MONTO'].'.-</td>
               <td class="text-primary" >'.$rsWebpay->fields['Tbk_fecha_transaccion'].'</td>
               <td>'.$codigodescuento.'('.$descuento.'%)</td>
               <td>'.$porciento.'</td>
            </tr>

		<tr>
		<td colspan="9">
		<table class="fixedHeaderColReorder table-striped table-responsive swipe-horizontal table table-primary">
       <thead>
	   <tr>
           <th style="color: #000 !important;"><strong>Rut</strong></th>
           <th style="color: #000 !important;"><strong>Nombre</strong></th>
           <th style="color: #000 !important;"><strong>Email</strong></th>
           <th style="color: #000 !important;"><strong>Direccion</strong></th>
           <th style="color: #000 !important;"><strong>Telefono</strong></th>
           <th style="color: #000 !important;"><strong>Region/Ciudad/Comuna</strong></th>
           <th style="color: #000 !important;"><strong>Postal</strong></th>
        </tr>
		</thead>';
    echo '<tr>
           <td>'.$rsClientes->fields['rut'].'</td>
           <td>'.$rsClientes->fields['nombres'].' '.$rsClientes->fields['apellido'].'</td>
           <td>'.$rsClientes->fields['email'].'</td>
           <td>'.$rsClientes->fields['direccion'].'</td>
           <td>'.$rsClientes->fields['telefono'].'</td>
           <td>'.$model->extraeNombreRegion($rsClientes->fields['region']).'/'.$model->extraeNombreCiudad($rsClientes->fields['ciudad']).'/'.$model->extraeNombreComuna($rsClientes->fields['comuna']).'</td>
           <td>'.$rsClientes->fields['postal'].'</td>
        </tr>
		</table>
		</td>
		</tr>
        ';
    
    echo '<tr>
           <td align="center" colspan="9"><strong>Dirección De Despacho</strong></td>
        </tr>';

    $rsDespacho=$model->getDespachoByPago($rsVentas->fields['pagosID']);
    if(!$rsDespacho->EOF){
    echo '<tr>
           <td align="center" colspan="9">Dirección: '.$rsDespacho->fields['direccion'].', '.$model->extraeNombreRegion($rsDespacho->fields['region']).'/'.$model->extraeNombreCiudad($rsDespacho->fields['ciudad']).'/'.$model->extraeNombreComuna($rsDespacho->fields['comuna']).'
           (Codigo Postal: '.$rsDespacho->fields['postal'].') <br> A nombre de: '.$rsDespacho->fields['nombre'].' ('.$rsDespacho->fields['email'].')</td>
        </tr>';
    }else{
      echo '<tr>
             <td align="center" colspan="9">Dirección: '.$rsClientes->fields['direccion'].', '.$model->extraeNombreRegion($rsClientes->fields['region']).'/'.$model->extraeNombreCiudad($rsClientes->fields['ciudad']).'/'.$model->extraeNombreComuna($rsClientes->fields['comuna']).'
             (Codigo Postal: '.$rsClientes->fields['postal'].') <br> A nombre de: '.$rsClientes->fields['nombres'].' '.$rsClientes->fields['apellido'].' ('.$rsClientes->fields['email'].')</td>
          </tr>';
    }

		echo '<tr>
					 <td align="center" colspan="9"><strong>Sucursal de despacho Chilexpress:</strong><br>'.$model->extraeNombreSuc($rsSuc->fields['sucursal']).'</td>
				</tr>';
    echo '<tr>
           <td align="center" colspan="9"><strong>Productos comprados</strong></td>
        </tr>
        <tr>
           <td colspan="9">
           <table class="footable table table-striped table-primary">
        <tr>
           <td style="width: 300px"><strong>Nombre Producto</strong></td>
           <td class="center" ><strong>Cantidad</strong></td>
        </tr>
        ';
        $rsCarro=$model->getCarroPorPago($rsVentas->fields['pagosID']);
    while(!$rsCarro->EOF){
      $rsProducto=$model->getProductoById($rsCarro->fields['id_producto']);
      if($rsProducto->fields['titulo']){
      echo '  <tr>
           <td style="width: 70%"><strong>TITULO</strong>: '.$rsProducto->fields['titulo'].' - <strong>ALBUM:</strong> '.$rsProducto->fields['album'].' - <strong>SKU:</strong> '.$rsProducto->fields['sku'].' <strong>SELLO:</strong> '.$rsProducto->fields['sello'].' <br><strong>FORMATO:</strong> '.$rsProducto->fields['formato'].'</strong> - <strong>GENERO:</strong> '.$rsProducto->fields['genero'].' - <strong>AÑO:</strong> '.$rsProducto->fields['ano'].'<br><strong>PRECIO:</strong> $ '.number_format($rsProducto->fields['precio'], 0, ",", ".").'</td>
           <td class="center" ><strong>'.$rsCarro->fields['cantidad'].'</strong></td>
        </tr>';
      }
        $rsCarro->movenext();
    }

    echo '</table></td>
        </tr>';
    $rsVentas->movenext();

echo '</table><hr>';
}

echo '</div><br><br><br><br><br><br>

<script type="text/javascript">
                Calendar.setup({
                    inputField : "fechainicio", // id del campo de texto
                    ifFormat : "%Y-%m-%d", // formato de la fecha que se escriba en el campo de texto
                    button : "lanzadorFecha1" // el id del botón que lanzará el calendario
                });

                Calendar.setup({
                    inputField : "fechatermino", // id del campo de texto
                    ifFormat : "%Y-%m-%d", // formato de la fecha que se escriba en el campo de texto
                    button : "lanzadorFecha2" // el id del botón que lanzará el calendario
                });
                </script>';

echo '<script src="'.$base_url.'/assets/library/bootstrap/js/bootstrap.min.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>
<script src="'.$base_url.'/assets/plugins/core_nicescroll/jquery.nicescroll.min.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>
<script src="'.$base_url.'/assets/plugins/core_breakpoints/breakpoints.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>
<script src="'.$base_url.'/assets/plugins/core_preload/pace.min.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>
<script src="'.$base_url.'/assets/components/core_preload/preload.pace.init.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>
<script src="'.$base_url.'/assets/components/core/core.init.js?v=v2.0.0-rc1"></script>
<script src="'.$base_url.'/assets/components/admin_menus/sidebar.main.init.js?v=v2.0.0-rc1"></script>
<script src="'.$base_url.'/assets/components/admin_menus/sidebar.collapse.init.js?v=v2.0.0-rc1"></script>
<script src="'.$base_url.'/assets/plugins/forms_elements_bootstrap-select/js/bootstrap-select.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>
<script src="'.$base_url.'/assets/components/forms_elements_bootstrap-select/bootstrap-select.init.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>
<script src="'.$base_url.'/assets/components/admin_menus/sidebar.kis.init.js?v=v2.0.0-rc1"></script>
<script src="'.$base_url.'/assets/plugins/forms_elements_bootstrap-datepicker/js/bootstrap-datepicker.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>
<script src="'.$base_url.'/assets/components/forms_elements_bootstrap-datepicker/bootstrap-datepicker.init.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>
<script src="'.$base_url.'/assets/plugins/tables_responsive/js/footable.min.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>
<script src="'.$base_url.'/assets/components/tables_responsive/tables-responsive-footable.init.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>
<script src="'.$base_url.'/assets/components/tables/tables-classic.init.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>
<script src="'.$base_url.'/assets/components/forms_elements_fuelux-checkbox/fuelux-checkbox.init.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>
<script src="'.$base_url.'/assets/plugins/tables_datatables/js/jquery.dataTables.min.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>
<script src="'.$base_url.'/assets/plugins/tables_datatables/extras/TableTools/media/js/TableTools.min.js?v=v2.0.0-rc1"></script>
<script src="'.$base_url.'/assets/plugins/tables_datatables/extras/ColVis/media/js/ColVis.min.js?v=v2.0.0-rc1"></script>
<script src="'.$base_url.'/assets/components/tables_datatables/js/DT_bootstrap.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>
<script src="'.$base_url.'/assets/components/tables_datatables/js/datatables.init.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>
<script src="'.$base_url.'/assets/plugins/tables_datatables/extras/FixedHeader/FixedHeader.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>
<script src="'.$base_url.'/assets/plugins/tables_datatables/extras/ColReorder/media/js/ColReorder.min.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>
<script src="'.$base_url.'/assets/plugins/forms_elements_select2/js/select2.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>
<script src="'.$base_url.'/assets/components/forms_elements_select2/select2.init.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>';
?>
