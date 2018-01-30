<?php
echo '
<script src="'.$base_url.'/assets/library/jquery/jquery.min.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>


					 <script src="'.$base_url.'/assets/library/jquery/jquery-migrate.min.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>


					 <script src="'.$base_url.'/assets/library/modernizr/modernizr.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>


					 <script src="'.$base_url.'/assets/plugins/core_less-js/less.min.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>


					 <script src="'.$base_url.'/assets/plugins/charts_flot/excanvas.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>


					 <script src="'.$base_url.'/assets/plugins/core_browser/ie/ie.prototype.polyfill.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>


					 <script src="'.$base_url.'/assets/library/jquery-ui/js/jquery-ui.min.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>


					 <script src="'.$base_url.'/assets/plugins/core_jquery-ui-touch-punch/jquery.ui.touch-punch.min.js?v=v2.0.0-rc1&amp;sv=v0.0.1.2"></script>';


           //$model->changeDebugState(true);
					 if(isset($_GET['accion']) and $_GET['accion']=='elimina'){

					 		$model->deleteDescuento($_GET['id']);
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

								 				<div class="col-separator-h"></div>

					 				<!-- col-table-row -->
					 				<div class="col-table-row">

					 					<!-- col-app -->
					 					<div class="col-app col-unscrollable">

					 						<!-- col-app -->
					 						<div class="col-app">

                        <div class="col-app box col-unscrollable overflow-hidden">
                        <!-- col-table -->
                        <div class="col-table">
                        <div class="innerLR heading-buttons border-bottom">
                        <h3 class="innerTB margin-none pull-left">
                        Sección Codigos Descuento
                        </h3>

                        <div class="clearfix"></div>
                        </div>
                        <!-- col-table-row -->
                        <div class="col-table-row">
                        <!-- col-app -->
                        <div class="col-app col-unscrollable">
                        <!-- col-app -->
                        <div class="col-app">


                        <div class="widget-body innerAll inner-2x">



                            <div class="widget-body innerAll inner-2x">

                        <?php


                        if($_POST['accion']=="ingresa"){

                        	
                          $model->insertDescuento($_POST);
                        }
                        if($_POST['accion']=="actualizafrm"){                        	
                          $model->actualizaDescuento($_POST);
                        }
                         ?>

                        <form name="frmPagina" method="post" action="index.php?page=descuento" enctype="multipart/form-data">
                         <div class="innerLR heading-buttons border-bottom">
                        
                        <div class="clearfix"></div>
                        </div>



                        <div class="col-md-12">
                          <?php


                          if($_GET['accion']=="actualiza"){
                            $rsProductos=$model->getCodigosDescuento($_GET['id']);
                            echo '  <input type="hidden" name="accion" value="actualizafrm">';
                            echo '  <input type="hidden" name="id" value="'.$rsProductos->fields['id'].'">';                           
                          }else{
                            echo '<input type="hidden" name="accion" value="ingresa">';
                          }
                          ?>
                     
                        </div>


                        <div class="col-md-12">
                          <?php

						  $nombre="";
						  $codigo="";
						  $porcentaje="";
						  $boton="Inserta";
                          if($_GET['accion']=="actualiza"){
							$nombre=$rsProductos->fields['nombre'];
							$codigo=$rsProductos->fields['codigo'];
							$porcentaje=$rsProductos->fields['porcentaje'];
							$boton="Actualiza";
                          }
                          ?>
                            <div class="form-group"> <label for="exampleInputEmail1">Nombre Descuento</label> 
							  <input type="text" class="form-control" name="nombre" value="<?php echo $nombre; ?>" placeholder="Nombre Descuento"> 
							</div>
							<div class="form-group"> <label for="exampleInputEmail1">Codigo Descuento</label> 
							  <input type="text" class="form-control" name="codigo" value="<?php echo $codigo; ?>" placeholder="Codigo Descuento"> 
							</div>
							<div class="form-group"> <label for="exampleInputEmail1">Porcentaje</label> 
							  <input type="text" class="form-control" name="porcentaje" value="<?php echo $porcentaje; ?>" placeholder="Porcentaje"> 
							</div>
                              <div class="col-sm-offset-9 col-sm-3">
                                    <a href="javascript:void(0);" onclick="javascript:document.frmPagina.submit();" class="btn btn-primary"><i class="fa fa-download"></i> <?php echo $boton ?></a>
                             </div>
                        </div>
                      </form>

                      </div>









                        </div>
                        <!-- // END col-app -->
                        </div>
                        <!-- // END col-app -->
                        </div>
                        <!-- // END col-table-row -->
                        </div>
                        <!-- // END col-table -->
                        </div>
                        <!-- // END col-app.box -->
                        </div>

					 							<h3 class="innerTB">Codigos de descuento ingresados</h3>

					 							<!-- Widget -->
					 							<div class="widget">
					 								<div id="listadoTabla" class="widget-body innerAll inner-2x">
					 									<!-- Table -->
					 <table class="table-striped checkboxs colVis table checkboxs ">
					 	<div class="row">




					 								</div>

					 	<!-- Table heading -->
					 	<thead class="bg-gray">
					 		<tr>
					 			<th >Nombre</th>
								<th class="center">Codigo</th>
								<th class="center" style="width:30%;">Descuento</th>
					 			<th class="text-right">Acción</th>
					 		</tr>
					 	</thead>
					 	<!-- // Table heading END -->

					 	<!-- Table body -->
					 	<tbody>

					 	<?php
					 	  $rsProductos=$model->getCodigosDescuento();
					 		while(!$rsProductos->EOF){

					 		echo '<!-- Table row --><tr class="gradeX">
					 			<td >'.$rsProductos->fields['nombre'].'</td>
								<td class="center">'.$rsProductos->fields['codigo'].'</td>
								<td class="center">'.$rsProductos->fields['porcentaje'].'</td>
					 			<td class="text-right">
					                 <div class="btn-group btn-group-md ">
					                     <a href="index.php?page=descuento&accion=actualiza&id='.$rsProductos->fields['id'].'" class="btn btn-inverse"><i class="fa fa-pencil"></i></a>
					                     <a href="javascript:void(0)" onclick="eliminaNoticia(\'index.php?page=descuento&accion=elimina&id='.$rsProductos->fields['id'].'\')" class="btn btn-default text-danger"><i class="fa fa-times"></i></a>

					                 </div>
					             </td>
					 		</tr>
					 		<!-- // Table row END -->';
					 		$rsProductos->movenext();
					 		}

					 		?>

					 	</tbody>
					 	<!-- // Table body END -->

					 </table>
					 <!-- // Table END -->


					 								</div>
					 							</div>
					 							<!-- // Widget END -->
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
