<?php

if(isset($_FILES['archivo'])){

//        print_r($_FILES);
    $leyenda = "0";
    if ($_FILES['archivo']['error']) {
        switch ($_FILES['archivo']['error']) {
            case 1: // UPLOAD_ERR_INI_SIZE
                echo "El archivo sobrepasa el limite autorizado por el servidor(archivo php.ini) !";
                break;
            case 2: // UPLOAD_ERR_FORM_SIZE
                 echo "El archivo sobrepasa el limite autorizado en el formulario HTML !";
                break;
            case 3: // UPLOAD_ERR_PARTIAL
                 echo "El envio del archivo ha sido suspendido durante la transferencia!";
                break;
            case 4: // UPLOAD_ERR_NO_FILE
                 echo "El archivo que ha enviado tiene un tamaño nulo !";
                break;
        }
    }else{

    $ruta_destino = 'excel/';
    $inputFileName = $ruta_destino . str_replace(' ','_',$_FILES['archivo']['name']);
    move_uploaded_file($_FILES['archivo']['tmp_name'], $inputFileName);    



	    if (($fichero = fopen($inputFileName, "r")) !== FALSE) {
		    // Lee los nombres de los campos
		    $nombres_campos = fgetcsv($fichero, 0, ";", "\"", "\"");
		    $num_campos = count($nombres_campos);
		    // Lee los registros
		    while (($datos = fgetcsv($fichero, 1000, ";", "\"", "\"")) !== FALSE) {
		        // Crea un array asociativo con los nombres y valores de los campos
		        /*for ($icampo = 0; $icampo < $num_campos; $icampo++) {
		            $registro[$nombres_campos[$icampo]] = $datos[$icampo];
		        }*/
		        // Añade el registro leido al array de registros
		        //$registros[] = $registro;
		        $todalainfo[]=$datos;
		      //  print_r($datos);
		      // echo '<br><br>';
		    }
		    fclose($fichero);

		    /*echo "Leidos " . count($registros) . " registros\n";

		    for ($i = 0; $i < count($registros); $i++) {
		        echo "Nombre: " . $registros[$i]["nombre"] . "\n";
		    }*/
			//$model->changeDebugState(true);
		    for ($i = 0; $i < count($todalainfo); $i++) {
		      
			   $model->insertaProducto($todalainfo[$i]);

			}
			$model->changeDebugState(false);
		    /*echo '<pre>';
		    print_r($todalainfo);
		    echo '<pre>';*/
		}
	}
  }

//$model->changeDebugState(true);
echo '<script src="'.$base_url.'/assets/library/jquery/jquery.min.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>


					 <script src="'.$base_url.'/assets/library/jquery/jquery-migrate.min.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>


					 <script src="'.$base_url.'/assets/library/modernizr/modernizr.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>


					 <script src="'.$base_url.'/assets/plugins/core_less-js/less.min.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>


					 <script src="'.$base_url.'/assets/plugins/charts_flot/excanvas.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>


					 <script src="'.$base_url.'/assets/plugins/core_browser/ie/ie.prototype.polyfill.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>


					 <script src="'.$base_url.'/assets/library/jquery-ui/js/jquery-ui.min.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>


					 <script src="'.$base_url.'/assets/plugins/core_jquery-ui-touch-punch/jquery.ui.touch-punch.min.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>';

					 	if(isset($_GET['accion']) and $_GET['accion']=='elimina'){
					 		//$model->changeDebugState(true);
					 		$model->deleteProducto($_GET['id']);
					 	}
					 ?>
					 <!-- row-app -->
					 <div class="row row-app">


					 	<!-- col -->
					 	<div class="col-md-12">

					 		<!-- col-separator.box -->
					 		<div class="col-separator bg-none col-unscrollable box col-separator-first">

					 			<!-- col-table -->
					 			<div class="col-table">

					 				<h4 class="innerAll margin-none bg-white">Productos</h4>

					 				<div class="col-separator-h"></div>

					 				<!-- col-table-row -->
					 				<div class="col-table-row">

					 					<!-- col-app -->
					 					<div class="col-app col-unscrollable">

					 						<!-- col-app -->
					 						<div class="col-app">



					 							<h3 class="innerTB">Lista de productos</h3>

					 							<!-- Widget -->
					 							<div class="widget">
					 								<div id="listadoTabla" class="widget-body innerAll inner-2x">
					 									<!-- Table -->
					 <table class="table-striped checkboxs colVis table checkboxs ">
					 	<div class="row">

					 									<!-- Color Options Column -->
					 									<div class="col-md-3">
					 										<div class="widget widget-heading-simple widget-body-gray">

					 											<script>
					 												function cargaMasiva(){
					 													document.getElementById("cargaMasiva").style.display='inline';
					 												}
					 											</script>	
					 											<div class="widget-body center">
					 												<a href="javascript:void(0);" onclick="cargaMasiva()" class="btn btn-primary"><i class="fa fa-fw fa-download"></i> Cargar</a>


					 											</div>
					 										</div>
					 									</div>
					 									<!-- // Color Options Column END -->

					 									<!-- Other Examples Column -->
					 									<div class="col-md-9">
					 										<div class="widget widget-heading-simple widget-body-gray">



					 											<div class="widget-body center">

																	<div class="row">


																	<div class="col-md-10">
																	<script>
																	function changeListadoDiscos(){
																	artista=document.getElementById("artista").value;
																	location.href="index.php?page=producto-manual&accion=filter&artista="+artista;
																	}
																	</script>

																	<input type="text" name="artista" id="artista" class="form-control" placeholder="Busca por Modelo o Marca...">


																	</div>
																	<div class="col-md-2">


																	<a href="javascript:void();" onclick="changeListadoDiscos()" class="btn btn-primary"><i class="fa fa-fw fa-download"></i> Buscar</a>

																	</div>

																	</div>

					 											</div>

					 										</div>
					 									</div>


					 								</div>
					 								<!-- // Other Examples Column END -->
					 								<div class="row">
					 									<form name="formaularioFile" method="post" action="index.php?page=producto-manual" enctype="multipart/form-data" >
						 									<div class="col-md-12" id="cargaMasiva" style="display: none">
						 										<div class="widget widget-heading-simple widget-body-gray">
						 											- Seleccione el archivo que desea cargar masivamente<br>
						 											- Recuerde que cada producto nuevo será insertado y si ya existe será actualizado<br>
						 											- Solo se permiten archivos en formato CSV con campos separados con punto y comma!!
						 											<input type="file" name="archivo" id="archivo" class="form-control">
						 											<div style="text-align: center"><br><br>
						 												<a href="javascript:void(0);" onclick="document.formaularioFile.submit();" class="btn btn-primary"><i class="fa fa-fw fa-download"></i> Cargar Archivo</a>						 												
						 											</div>
						 												
						 										</div>
						 									</div>	

					 									</form>
					 								</div>	
													<?php
														if($_GET['artista']!="")
															echo "Resultado de su busqueda: ".$_GET['artista'];
													 ?>
					 	<!-- Table heading -->
					 	<thead class="bg-gray">
					 		<tr>
					 			<th class="text-right">Acción</th>
					 			<th style="width:30%;">CODIGO</th>
								<th class="center">MARCA</th>
					 			<th class="center">MODELO</th>
					 			<th>MEDIDA</th>
					 			<th class="center">CATEGORIA</th>
					 			<th class="center">ANCHO</th>
					 			<th class="center">PERFIL</th>
					 			<th class="center">ARO</th>
					 			<th class="center">CARGA</th>
					 			<th class="center">LARGO</th>
								<th class="center">ANCHO</th>
					 			<th class="center">ALTO</th>
					 			<th class="center">PESO</th>
					 			<th class="center">NETO</th>
					 			<th class="center">UNITARIO</th>
					 			<th class="center">VALOR_INSTALACION</th>
					 			<th class="center">TOTAL</th>
					 			<th class="center">MC</th>
					 			<th class="center">NETO 2</th>
					 			<th class="center">PRECIO FINAL</th>
					 			<th class="center">PRECIO OFERTA</th>
					 			<th class="center">MODELO RUEDA</th>
					 			<th class="center">JPG</th>					 			
					 			<th class="center">TITULO</th>
					 			<th class="center">ATRIBUTOS</th>
					 			<th class="center">DESCRIPCION</th>
					 			<th class="center">LOGO</th>
					 			<th class="center">INCLUYE INSTA</th>
					 			<th class="center">DESPACHO</th>
					 			<th class="center">4X4</th>
					 			<th class="center">RUNFLAT</th>
					 			<th class="center">OFERTA</th>
					 			<th class="center">CARRETERA</th>
					 			<th class="center">STOCK</th>
					 			<th class="center">VIDEO</th>
					 			
					 		</tr>
					 	</thead>
					 	<!-- // Table heading END -->

					 	<!-- Table body -->
					 	<tbody>

					 	<?php
					 		//$model->changeDebugState(true);
					 		if(isset($_GET['accion']) && $_GET['accion']=='filter' and $_GET['artista']!="")
					 			$num_rows=$model->getProductosFilterTotalAdmin($_GET['artista']);
					 		else
					 			$num_rows=$model->getProductosAllTotal();


					 		if($num_rows>0){
					 		//echo $num_rows;
					 			$pages = new Paginator($num_rows,9,array(10,3,6,9,12,25,50,100,250,'All'));
					 			//echo $pages->limit_start."-".$pages->limit_end;

					 		if(isset($_GET['accion']) && $_GET['accion']=='filter')
					 			$rsProductos=$model->getProductosFilterAdmin($_GET['artista'],$pages->limit_start,$pages->limit_end);
					 		else
					 			$rsProductos=$model->getProductosAll($pages->limit_start,$pages->limit_end);


					 		while(!$rsProductos->EOF){
					 		$estado="";

					 		if($rsProductos->fields['estado']==1){
					 			$estado="circle_ok";
					 		}else{
					 			$estado="remove_2";
					 		}

					 		echo '<!-- Table row --><tr class="gradeX">
					 		<td class="text-right">
					                 <div class="btn-group btn-group-md ">					                    
					                     <!--a href="javascript:void(0)" onclick="eliminaNoticia(\'index.php?page=producto-manual&accion=elimina&id='.$rsProductos->fields['id'].'\')" class="btn btn-default text-danger"><i class="fa fa-times"></i></a-->
					                 </div>
					             </td>
					 			<td>'.$rsProductos->fields['CODIGO'].'</td>
								<td>'.$rsProductos->fields['Marca'].'</td>					 			
								<td>'.$rsProductos->fields['MODELO'].'</td>					 			
								<td>'.$rsProductos->fields['MEDIDA'].'</td>					 			
								<td>'.$rsProductos->fields['CATEGORIA'].'</td>					 			
								<td>'.$rsProductos->fields['ANCHO'].'</td>					 			
								<td>'.$rsProductos->fields['PERFIL'].'</td>					 			
								<td>'.$rsProductos->fields['ARO'].'</td>					 			
								<td>'.$rsProductos->fields['Carga'].'</td>					 			
								<td>'.$rsProductos->fields['LARGO'].'</td>					 			
								<td>'.$rsProductos->fields['ANCHO2'].'</td>					 			
								<td>'.$rsProductos->fields['ALTO'].'</td>					 			
								<td>'.$rsProductos->fields['Peso'].'</td>					 			
								<td>'.$rsProductos->fields['neto'].'</td>					 			
								<td>'.$rsProductos->fields['unitario'].'</td>					 			
								<td>'.$rsProductos->fields['VALOR_INSTALACION'].'</td>					 			
								<td>'.$rsProductos->fields['total'].'</td>					 			
								<td>'.$rsProductos->fields['MC'].'</td>					 			
								<td>'.$rsProductos->fields['neto2'].'</td>					 			
								<td>'.$rsProductos->fields['precio_final'].'</td>					 			
								<td>'.$rsProductos->fields['precio_oferta'].'</td>					 			
								<td>'.$rsProductos->fields['modelo_rueda'].'</td>					 			
								<td>'.$rsProductos->fields['JPG'].'</td>					 			
								<td>'.$rsProductos->fields['TITULO'].'</td>					 			
								<td>'.$rsProductos->fields['ATRIBUTOS'].'</td>					 			
								<td>'.$rsProductos->fields['DESCRIPCION'].'</td>					 			
								<td>'.$rsProductos->fields['Logo'].'</td>					 			
								<td>'.$rsProductos->fields['INCLUYE_INSTALACION'].'</td>					 			
								<td>'.$rsProductos->fields['DESPACHO'].'</td>					 			
								<td>'.$rsProductos->fields['4x4'].'</td>					 			
								<td>'.$rsProductos->fields['RUNFLAT'].'</td>					 			
								<td>'.$rsProductos->fields['OFERTA'].'</td>					 			
								<td>'.$rsProductos->fields['carretera'].'</td>					 			
								<td>'.$rsProductos->fields['STOCK'].'</td>					 			
								<td>'.$rsProductos->fields['VIDEO'].'</td>		 			
					 			
					 		</tr>
					 		<!-- // Table row END -->';
					 		$rsProductos->movenext();
					 		}
						}
					 		?>

					 	</tbody>
					 	<!-- // Table body END -->

					 </table>
					 <!-- // Table END -->


					 								</div>
					 							</div>
					 							<!-- // Widget END -->


					 <?php
					 			if($num_rows>0){
					 			echo '<div class="pagination_block">';
					 			 echo "<p class=\"paginate\">Página: $pages->current_page de $pages->num_pages</p>\n";
					              echo $pages->display_pages();
					             echo '</div>';
					 			}
					 			?>





					 						</div>
					 						<!-- // END col-app -->

					 					</div>
					 					<!-- // END col-app.col-unscrollable -->

					 				</div>
					 				<!-- // END col-table-row -->

					 			</div>
					 			<!-- // END col-table -->

					 		</div>
					 		<!-- // END col-separator.box -->

					 	</div>
					 	<!-- // END col -->

					 </div>
					 <!-- // END row-app -->




<?php

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