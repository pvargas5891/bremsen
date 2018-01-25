

<!-- crop ponda -->
<script src="lib/croponda/js/jquery.Jcrop.js"></script>
<link rel="stylesheet" href="lib/croponda/css/croponda.css" type="text/css" />
<link rel="stylesheet" href="lib/croponda/css/jquery.Jcrop.css" type="text/css" />
<!-- crop ponda Fin -->

<!-- Editor -->
<script src="lib/editor/ckeditor.js"></script>
<script src="lib/editor/adapters/jquery.js"></script>

<!-- Editor Fin -->

<!-- crop ponda -->
<link rel="stylesheet" type="text/css" href="lib/picedit/css/font.css" />
<link rel="stylesheet" type="text/css" href="lib/picedit/css/picedit.css" />
<!-- crop ponda Fin -->

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
<link href="http://www.vinilospormayor.cl/maqueta/admin/input/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="http://www.vinilospormayor.cl/maqueta/admin/input/js/fileinput.js" type="text/javascript"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js" type="text/javascript"></script>

<?php

	$accion_exe="inserta";
	$titulo="Ingreso";
	if(isset($_GET['accion']) and $_GET['accion']=='actualiza'){
		$rsNoticia=$model->getProductoById($_GET['id']);
		$idNoticia=$_GET['id'];
		$accion_exe="actualiza";
		$titulo="Edición";
	}


?>


<!-- row-app -->
<div class="row row-app">
    <!-- col -->
    <div class="col-md-12">
        <!-- col-separator.box -->
        <div class="col-separator col-unscrollable bg-none box col-separator-first">
            <!-- col-table -->
            <div class="col-table">
                <h4 class="innerAll margin-none bg-white">
                    Gestor
				</h4>
                <div class="col-separator-h"></div>
                <!-- col-table-row -->
                <div class="col-table-row">
                    <!-- col-app -->
                    <div class="col-app col-unscrollable">
                        <!-- col-app -->
                        <div class="col-app">
                            <!-- Form -->
                            <form action="ingresoNoticiaAsync.php" class="form-horizontal margin-none" id="validateSubmitForm" name="validateSubmitForm" enctype="multipart/form-data" method="post" autocomplete="off">
                                <div class="center">

								</div>
								<!-- Widget -->
								<h3 class="innerTB"><?php echo $titulo; ?> de Producto</h3>
								<input type="hidden" name="accion" value="<?php echo $accion_exe; ?>">
								<input type="hidden" name="idproducto" value="<?php echo $idNoticia; ?>">


								<!-- Row -->
								<div class="row">
									<!-- Column -->
									<div class="col-md-12">
										<div class="widget">
											<!-- Widget heading -->
											<div class="widget-head">
												<h4 class="heading">
													Opciones
												</h4>
											</div>
											<!-- // Widget heading END -->
											<div class="widget-body innerAll inner-2x">
												<!-- Row -->
												<div class="row innerLR">
													<!-- Column -->
													<div class="widget-body innerAll inner-2x">
														<div class="col-md-8">
															<h4 class="innerTB">Estado</h4>
															<div class="radio">
																<label class="radio-custom">
																	<?php
																		$publicado="checked";
																		$despublicado="";
																		$archivado="";
																		if(isset($idNoticia) and $rsNoticia->fields['estado']==0){
																			$publicado="";
																			$despublicado="checked";
																		}
																		if(isset($idNoticia) and $rsNoticia->fields['estado']==2){
																			$publicado="";
																			$despublicado="";
																			$archivado="checked";
																		}
																	?>
																	<input type="radio" name="estado" value="1" <?php echo $publicado; ?>>
																	<i class="fa fa-circle-o checked"></i> Publicado
																</label>
															</div>
															<div class="radio">
																<label class="radio-custom">
																	<input type="radio" name="estado" value="0" <?php echo $despublicado; ?>>
																	<i class="fa fa-circle-o"></i> No Publicado
																</label>
															</div>


															<h4 class="innerTB">Producto Novedad</h4>
															<div class="radio">
																<label class="radio-custom">
																	<?php
																		$novedad="";
																		$nonovedad="checked";
																		if(isset($idNoticia) and $rsNoticia->fields['novedad']==1){
																			$novedad="checked";
																			$nonovedad="";
																		}

																	?>
																	<input type="radio" name="novedad" value="1" <?php echo $novedad; ?>>
																	<i class="fa fa-circle-o checked"></i> Si
																</label>
															</div>
															<div class="radio">
																<label class="radio-custom">
																	<input type="radio" name="novedad" value="0" <?php echo $nonovedad; ?>>
																	<i class="fa fa-circle-o"></i> No
																</label>
															</div>

															<h4 class="innerTB">Producto Oferta</h4>
															<div class="radio">
																<label class="radio-custom">
																	<?php
																		$oferta="";
																		$nooferta="checked";
																		if(isset($idNoticia) and $rsNoticia->fields['oferta']==1){
																			$oferta="checked";
																			$nooferta="";
																		}

																	?>
																	<input type="radio" name="oferta" value="1" <?php echo $novedad; ?>>
																	<i class="fa fa-circle-o checked"></i> Si
																</label>
															</div>
															<div class="radio">
																<label class="radio-custom">
																	<input type="radio" name="oferta" value="0" <?php echo $nonovedad; ?>>
																	<i class="fa fa-circle-o"></i> No
																</label>
															</div>

															<h4 class="innerTB">Categorias</h4>
															<select  name="categorias_seleccion[]" multiple="multiple" style="width: 100%;" id="select2_2">
																<?php
															//	$model->changeDebugState(true);
																	$rsCategoria=$model->getCategorias();
																	while(!$rsCategoria->EOF){

																		echo '<optgroup label="'.$rsCategoria->fields['nombre'].'">';
																		$rsSubCategoria=$model->getSubCategorias('',$rsCategoria->fields['id']);
																		while(!$rsSubCategoria->EOF){
																			$selected="";
																			if(isset($idNoticia) and $model->productoCategoria($rsSubCategoria->fields['id'],$idNoticia))
																			$selected="selected";
																			echo '<option value="'.$rsSubCategoria->fields['id'].'" '.$selected.'>'.$rsSubCategoria->fields['nombre'].'</option>';
																			$rsSubCategoria->movenext();
																		}
																		echo '</optgroup>';

																		$rsCategoria->movenext();
																	}
																?>
															</select>

															<h4 class="innerTB">Tags</h4>
															<select  name="tags[]" multiple="multiple" style="width: 100%;" id="select2_tag">
																<?php


																	$rsTags=$model->getTagsActivos();
																	while(!$rsTags->EOF){
																	$selected="";
																		if(isset($idNoticia)){
																			$rsTag2=$model->getTagByProducto($idNoticia);
																			$selected="";
																			while(!$rsTag2->EOF){
																				if($rsTag2->fields['tag']==$rsTags->fields['id'])
																					$selected="selected";
																				$rsTag2->movenext();
																			}

																		}
																		echo '<option value="'.$rsTags->fields['id'].'" '.$selected.'>'.$rsTags->fields['tag'].'</option>';


																		$rsTags->movenext();
																	}
																?>
															</select>
															<?php
																$tags="";
																if(isset($idNoticia)){
																	$rsTag=$model->getTagByProducto($idNoticia);
																	while(!$rsTag->EOF){
																		$tags.=$rsTag->fields['tag'];
																		$rsTag->movenext();
																		if(!$rsTag->EOF){
																			$tags.=",";
																		}

																	}
																}
															?>
															<div class="bg-gray innerAll inner-2x">
																<input type="text" name="tagadicionales" class="form-control" placeholder="Escriba Tag Adicionales separados por coma">
															</div>
														</div>

												</div>

												</div>

											</div>
										</div>
										<!-- // Widget END -->
									</div>

								</div>
								<div class="row">


									<div class="col-md-12">
										<div class="widget">
											<!-- Widget heading -->
											<div class="widget-head">
												<h4 class="heading">
													Ingreso
												</h4>
											</div>
											<!-- // Widget heading END -->
											<div class="widget-body innerAll inner-2x">
												<!-- Row -->
												<div class="row innerLR">
													<!-- Column -->
													<div class="widget-body innerAll inner-2x">
														<div class="form-group form-control-default required">
															<label for="exampleInputFirstName">Codigo SKU</label>
															<input type="text" name="sku" class="form-control" value="<?php echo $rsNoticia->fields['sku']; ?>" id="exampleInputFirstName" placeholder="Sku">
														</div>
														<div class="form-group form-control-default required">
															<label for="exampleInputFirstName">Banda</label>
															<input type="text" name="titulo" class="form-control" value="<?php echo $rsNoticia->fields['titulo']; ?>" id="exampleInputFirstName" placeholder="Titulo">
														</div>
														<div class="form-group form-control-default required">
															<label for="exampleInputFirstName">Album</label>
															<input type="text" name="album" class="form-control" value="<?php echo $rsNoticia->fields['album']; ?>" id="exampleInputFirstName" placeholder="Album">
														</div>
														<div class="form-group form-control-default required">
															<label for="exampleInputFirstName">Sello</label>
															<input type="text" name="sello" class="form-control" value="<?php echo $rsNoticia->fields['sello']; ?>" id="exampleInputFirstName" placeholder="Sello">
														</div>

														<div class="form-group form-control-default required">
															<label for="exampleInputFirstName">Formato</label>
															<input type="text" name="formato" class="form-control" value="<?php echo $rsNoticia->fields['formato']; ?>" id="exampleInputFirstName" placeholder="Formato">
														</div>
														<div class="form-group form-control-default required">
															<label for="exampleInputFirstName">Genero</label>
															<input type="text" name="genero" class="form-control" value="<?php echo $rsNoticia->fields['genero']; ?>" id="exampleInputFirstName" placeholder="Genero">
														</div>
														<div class="form-group form-control-default required">
															<label for="exampleInputFirstName">Año</label>
															<input type="text" name="ano" class="form-control" value="<?php echo $rsNoticia->fields['ano']; ?>" id="exampleInputFirstName" placeholder="Año">
														</div>
														<div class="form-group form-control-default required">
															<label for="exampleInputFirstName">Stock</label>
															<input type="text" name="stock" class="form-control" value="<?php echo $rsNoticia->fields['stock']; ?>" id="exampleInputFirstName" placeholder="Stock">
														</div>
														<div class="form-group form-control-default required">
															<label for="exampleInputFirstName">Precio</label>
															<input type="text" name="precio" class="form-control" value="<?php echo $rsNoticia->fields['precio']; ?>" id="exampleInputFirstName" placeholder="Precio">
														</div>
														<div class="form-group form-control-default required">
															<label for="exampleInputFirstName">Precio Oferta (Solo si el producto es Oferta)</label>
															<input type="text" name="preciooferta" class="form-control" value="<?php echo $rsNoticia->fields['preciooferta']; ?>" id="exampleInputFirstName" placeholder="Precio Oferta">
														</div>
														<div class="form-group form-control-default required">
															<label for="exampleInputFirstName">Cantidad de unidades</label>
															<input type="text" name="qty" class="form-control" value="<?php echo $rsNoticia->fields['qty']; ?>" id="exampleInputFirstName" placeholder="Cantidad de unidades">
														</div>
														<br>
													</div>





													<div class="widget">

														<!-- Widget heading -->
														<div class="widget-head">
															<h4 class="heading glyphicons file_import">
																<i></i>Imagen de portada
															</h4>
														</div>
														<!-- // Widget heading END -->
														<div class="widget-body innerAll inner-2x">


															<input  id="imagenoculta1" name="imagenoculta1" type="hidden" value="<?php echo $imagen; ?>">

															 <input id="imagen1" name="imagen1" type="file" multiple class="file-loading">

															<script>


															$(document).on('ready', function() {
																	var $input = $("#imagen1");
																	$input.on("filepredelete", function(jqXHR) {
																		var abort = true;
																			if (confirm("Estas seguro(a) de eliminar esta imagen?")) {
																					abort = false;
																					$("#imagenoculta1").val("");
																			}
																			return abort;


																});


																$input.fileinput({
																		uploadUrl: "http://www.vinilospormayor.cl/maqueta/admin/upload.php", // server upload action
																		uploadAsync: true,
																		showPreview: true,
																		allowedFileExtensions: ['jpg', 'png', 'gif'],
																		showUpload: false, // hide upload button
																		showRemove: true, // hide remove button
																		maxFileCount: 1,
																		overwriteInitial: false
																		<?php
																				if(isset($_GET['accion']) and $_GET['accion']=='actualiza'){
																		?>
																		,initialPreview: [
																					'<img src="<?php echo $base_url."/galerias/".$rsNoticia->fields['imagen']; ?>" class="file-preview-image" alt="The Earth" title="The Earth">'
																		],
																		initialPreviewConfig: [
																			{caption: "<?php echo  $rsNoticia->fields['imagen']; ?>", width: "120px", url: "http://www.vinilospormayor.cl/maqueta/admin/delete.php", key: 1}
																		]
																		<?php

																				}
																		 ?>



																	}).on('filebatchselected', function(event, files) {
																			console.log(files[0].name);
																	});
															});
															</script>




														</div>
													</div>



												<div class="widget">

													<!-- Widget heading -->
													<div class="widget-head">
														<h4 class="heading glyphicons file_import">
															<i></i>Video Contenido
														</h4>
													</div>
													<!-- // Widget heading END -->
													<div class="widget-body innerAll inner-2x">
														<textarea name="video" rows="5" cols="85" class="form-control" placeholder="Ingrese video"><?php echo $rsNoticia->fields['video']; ?></textarea>
													</div>
												</div>


												<div class="separator bottom"></div>
												<div class="separator bottom"></div>


											</div>
											<script>
											function totalpistasamostrar(disco){
												totalpistas=document.getElementById(disco+"totalpistas").value;
												document.getElementById("pistas"+disco).innerHTML="";
												html="";
												for(i=1;i<=totalpistas;i++){
													html+='<input type="text" name="'+disco+'pista'+i+'" id="'+disco+'pista'+i+'" class="form-control" placeholder="Ingresar Nombre Pista '+i+'"><div class="separator bottom"></div>';
												}
												document.getElementById("pistas"+disco).innerHTML=html;
											}
											function desbloqueardisco(disco){
												document.getElementById("disco"+disco).style.display='inline';
													document.getElementById("ocultadisco"+disco).style.display='none';

											}
											</script>


											<?php
											$discos=array();
											$discos[]=array('primero','A','B');
											$discos[]=array('segundo','C','D');
											$discos[]=array('tercero','E','F');
											$discos[]=array('cuarto','G','H');
											$discos[]=array('quinto','I','J');
											$discos[]=array('sexto','K','L');
											$discos[]=array('septimo','M','N');
											$discos[]=array('octavo','O','P');
											$discos[]=array('noveno','Q','R');
											$discos[]=array('decimo','S','T');
											$e=1;

											for($i=0;$i<count($discos);$i++){
												$oculto="";
												if($i>1)
													$oculto=' style="display:none;"';
											 ?>
											<div class="widget" <?php echo $oculto; ?> id="<?php echo "disco".$e; ?>">
												<!-- Widget heading -->
												<div class="widget-head">
													<h4 class="heading glyphicons file_import">
														<i></i>Pistas Disco <?php echo $e; ?>
													</h4>

												</div>
												<!-- // Widget heading END -->
												<div class="row">


													<div class="widget" style="width: 80%">

														<!-- Widget heading -->
														<div class="widget-head">
															<h4 class="heading glyphicons file_import">
																<i></i>Lado <?php echo $discos[$i][1]; ?>
															</h4>

														</div>
														<!-- // Widget heading END -->
														<div class="row">
												<div class="widget-body innerAll inner-2x">

													<div class="col-sm-4">
													<!-- Search Bar -->
													<?php
														$total=0;
														if(isset($rsNoticia->fields['id'])){
															$rsPistas=$model->getPistasByProducto($rsNoticia->fields['id'],$discos[$i][0],$discos[$i][1]);
															while(!$rsPistas->EOF){
																	$rsPistas->movenext();
																	$total++;
															}
															$rsPistas->movefirst();
														}
													 ?>
													<div class="input-group innerT half pull-right">
														<input type="text" class="form-control" name="<?php echo $discos[$i][0]; echo $discos[$i][1]; ?>totalpistas" id="<?php echo $discos[$i][0];  echo $discos[$i][1]; ?>totalpistas" placeholder="Ingresar Numero Pistas" value="<?php echo $total; ?>">
														<span class="input-group-btn">
																<button class="btn btn-primary rounded-none" type="button" onclick="totalpistasamostrar('<?php echo $discos[$i][0]; echo $discos[$i][1]; ?>');"><i class="fa fa-plus"></i></button>
														</span>
													</div>
												</div>
												<div class="separator bottom"></div>
												<div class="separator bottom"></div>
												<br>
												<br>
												<div id="pistas<?php echo $discos[$i][0]; echo $discos[$i][1]; ?>">
														<?php
														if(isset($rsNoticia->fields['id'])){
														$b=1;
														while(!$rsPistas->EOF){
															echo '<input type="text" name="'. $discos[$i][0].''.$discos[$i][1].'pista'.$b.'" id="'. $discos[$i][0].''.$discos[$i][1].'pista'.$b.'" class="form-control" placeholder="Ingresar Nombre Pista '.$b.'" value="'.$rsPistas->fields['pista'].'"><div class="separator bottom"></div>';
															$b++;
															$rsPistas->movenext();
														}
													}
														 ?>
												</div>


											</div>
											</div>
											</div>


											<div class="widget" style="width: 80%">

												<!-- Widget heading -->
												<div class="widget-head">
													<h4 class="heading glyphicons file_import">
														<i></i>Lado <?php echo $discos[$i][2]; ?>
													</h4>

												</div>
												<!-- // Widget heading END -->
												<div class="row" >
										<div class="widget-body innerAll inner-2x">

											<div class="col-sm-4">
											<!-- Search Bar -->
											<?php
												$total=0;
												if(isset($rsNoticia->fields['id'])){
													$rsPistas=$model->getPistasByProducto($rsNoticia->fields['id'],$discos[$i][0],$discos[$i][2]);
													while(!$rsPistas->EOF){
															$rsPistas->movenext();
															$total++;
													}
													$rsPistas->movefirst();
												}
											 ?>
											 <div class="input-group innerT half pull-right">
 												<input type="text" class="form-control" name="<?php echo $discos[$i][0]; echo $discos[$i][2]; ?>totalpistas" id="<?php echo $discos[$i][0];  echo $discos[$i][2]; ?>totalpistas" placeholder="Ingresar Numero Pistas" value="<?php echo $total; ?>">
 												<span class="input-group-btn">
 														<button class="btn btn-primary rounded-none" type="button" onclick="totalpistasamostrar('<?php echo $discos[$i][0]; echo $discos[$i][2]; ?>');"><i class="fa fa-plus"></i></button>
 												</span>
 											</div>
										</div>
										<div class="separator bottom"></div>
										<div class="separator bottom"></div>
										<br>
										<br>
										<div id="pistas<?php echo $discos[$i][0]; echo $discos[$i][2]; ?>">
												<?php
												if(isset($rsNoticia->fields['id'])){
												$b=1;
												while(!$rsPistas->EOF){
													echo '<input type="text" name="'. $discos[$i][0].''.$discos[$i][2].'pista'.$b.'" id="'. $discos[$i][0].''.$discos[$i][2].'pista'.$b.'" class="form-control" placeholder="Ingresar Nombre Pista '.$b.'" value="'.$rsPistas->fields['pista'].'"><div class="separator bottom"></div>';
													$b++;
													$rsPistas->movenext();
												}
											}
												 ?>
										</div>


									</div>
									</div>
									</div>



											</div>
											<?php
											if($e>=2 and $e <10){
											 ?>
												<div class="widget-head" id="ocultadisco<?php echo $e+1; ?>" style="display:inline;">
													<span class="input-group-btn">
													<button class="btn btn-primary rounded-none" type="button" onclick="desbloqueardisco('<?php echo $e+1; ?>');">	Agregar Otro Disco	<i class="fa fa-plus"></i></button>
													</span>
												</div>
											<?php
											}
											 ?>

											</div>

											<?php
											$e++;
										}
											 ?>


											<!-- // Widget END -->
											<div class="bg-gray innerAll center inner-2x">
												<div class="row">
													<!-- Column -->
													<div class="separator"></div>
													<!-- Form actions -->
													<div class="form-actions">
														<button type="button" id="btn_guardar" class="btn btn-primary"><i class="fa fa-check-circle"></i> Guardar</button>
														<button type="button" class="btn btn-default" onclick="redireccion('index.php?page=lista_1')"><i class="fa fa-times"></i> Cancelar</button>
													</div>
													<!-- // Form actions END -->
												</div>
												<!-- // Row END -->
											</div>
										</div>

									</div>

								</div>
							</div>
							<!-- // Widget END -->

						</div>

					</div>


				</form>


				<!-- // Form END -->
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
