<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie lt-ie9 lt-ie8 lt-ie7 paceSimple sidebar sidebar-fusion sidebar-kis footer-sticky navbar-sticky"> <![endif]-->
<!--[if IE 7]>    <html class="ie lt-ie9 lt-ie8 paceSimple sidebar sidebar-fusion sidebar-kis footer-sticky navbar-sticky"> <![endif]-->
<!--[if IE 8]>    <html class="ie lt-ie9 paceSimple sidebar sidebar-fusion sidebar-kis footer-sticky navbar-sticky"> <![endif]-->
<!--[if gt IE 8]> <html class="ie paceSimple sidebar sidebar-fusion sidebar-kis footer-sticky navbar-sticky"> <![endif]-->
<!--[if !IE]><!--><html class="paceSimple sidebar sidebar-fusion sidebar-kis footer-sticky navbar-sticky"><!-- <![endif]-->
<head>
    <title>Administrador Vinilos Por Mayor</title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <!--
**********************************************************
In development, use the LESS files and the less.js compiler
instead of the minified CSS loaded by default.
**********************************************************
<link rel="stylesheet/less" href="../assets/less/admin/module.admin.stylesheet-complete.less" />
    -->
    <!--[if lt IE 9]>
    <link rel="stylesheet" href="../assets/components/library/bootstrap/css/bootstrap.min.css" />
    <![endif]-->
    <?php
$skin = isset($_GET['skin']) && $_GET['skin'] !== 'purple-wine' ? $_GET['skin'] : false;
if ($skin)
echo '<link href="' . ASSETS_PATH . '/css/skins/module.' . $module . '.stylesheet-complete.skin.' . $skin . '.min.css" rel="stylesheet" />
        ';
else
echo '
        <link href="' . ASSETS_PATH . '/css/' . $module . '/module.' . $module . '.stylesheet-complete.min.css" rel="stylesheet" />
        ';
?>
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <?php foreach ($scripts as $id =>
            $script)
{
$sections = !empty($script['sections']) && !empty($script['sections'][$page]);
$inPages = in_array($page, $script['pages']);
$inSections = !$sections ? false : in_array($section, $script['sections'][$page]); if ($script['header'] && ((!$sections && $inPages) || ($sections && $inSections)))
echo '
            <script src="' . $script['file'] . '"></script>
            ' . "\n\t";
} ?>
            <script>if (/*@cc_on!@*/false && document.documentMode === 10) { document.documentElement.className+=' ie ie10'; }</script>

		<script src="lib/ponda/jquery.Rut.js" type="text/javascript"></script>
		<script src="lib/ponda/ajax.js"></script>

		<!-- content manager -->
				<script src="lib/ponda/contentManager.js"></script>
		<!-- content manager fin -->

		</head>
        <body class=" menu-right-hidden">
		<div class="bg-exito" id="exito" style="display:none;">
<div class="exito"><span class="display-block bg-success innerAll text-center text-white"><i class="icon-desktop-play fa-5x"></i></span></div>
</div>
            <!-- Main Container Fluid -->
            <div class="container-fluid menu-hidden">
                <!-- Main Sidebar Menu -->
                <div id="menu" class="hidden-print hidden-xs sidebar-blue sidebar-brand-primary">
                    <div id="sidebar-fusion-wrapper">
                        <div id="brandWrapper">
                            <a href="index.php" class="display-block-inline pull-left logo">
                                <img src="../assets/images/logo/logo.png" alt="">
                            </a>

                        </div>
                        <?php
						if($_GET['page']!='login'){
						?>
                        <ul class="menu list-unstyled" id="navigation_current_page">
                            <?php Menu::make($config["menu"]["admin"]["default"], $page, $module, "collapse", "default"); ?>
                            </ul>
                            <ul class="menu list-unstyled hide" id="navigation_components">
                                <?php Menu::make($config["menu"]["admin"]["components"], $page, $module, "collapse", "components"); ?>
                                </ul>
                                <ul class="menu list-unstyled hide" id="navigation_modules_front">
                                    <?php Menu::make($config["menu"]["admin"]["front_modules"], $page, $module, "collapse", "front_modules"); ?>
                                    </ul>
						<?php
						}
						?>
                                </div>

                            </div>
                            <!-- // Main Sidebar Menu END -->
                            <!-- Main Sidebar Menu -->
                            <div id="menu_kis" class="hidden-print sidebar-light">
                                <div>
                                    <ul class="list-unstyled">
                                        <li>
                                            <a href="#" class="glyphicons globe"><i></i><span>Herramientas</span></a>
                                        </li>


                                    </ul>
                                </div>
                            </div>
                            <!-- // Main Sidebar Menu END -->
                            <!-- Content -->
                            <div id="content">
                                <div class="navbar hidden-print navbar-primary main" role="navigation">
                                    <div class="user-action user-action-btn-navbar pull-left border-right">
                                        <button class="btn btn-sm btn-navbar btn-primary btn-stroke"><i class="fa fa-bars fa-2x"></i></button>
                                    </div>
                                    <div class="col-md-3 padding-none visible-md visible-lg">
                                        <div class="input-group innerLR">
                                            <!--input type="text" class="form-control input-sm" placeholder="Buscar ..."-->
                                            <!--span class="input-group-btn">
                                                <button class="btn btn-primary" type="button"><i class="fa fa-search"></i></button>
                                            </span-->
                                        </div>
                                        <!-- /input-group -->
                                    </div>
                                    <!--div class="user-action visible-xs user-action-btn-navbar pull-right">
                                        <button class="btn btn-sm btn-navbar-right btn-primary"><i class="fa fa-fw fa-arrow-right"></i><span class="menu-left-hidden-xs"> Modulos</span></button>
                                    </div-->
                                    <div class="user-action pull-right menu-right-hidden-xs menu-left-hidden-xs">
						<?php
						if($_GET['page']!='login'){
						?>
									   <div class="dropdown username hidden-xs pull-left">
                                            <a class="dropdown-toggle " data-toggle="dropdown" href="#">
                                                <span class="media margin-none">
                                                    <!--span class="pull-left">
                                                        <img src="../assets/images/people/35/16.jpg" alt="user" class="img-circle">
                                                    </span-->
                                                    <span class="media-body">
														<?php echo $_SESSION['nombres']; ?> <span class="caret"></span> </span>
                                                </span>
                                            </a>
                                            <ul class="dropdown-menu pull-right">
                                                <!--li>
                                                    <a href="index.php?page=social_account" class="glyphicons user"><i></i> Cuenta</a>
                                                </li>
                                               <li>
                                                    <a href="index.php?page=social_messages" class="glyphicons envelope"><i></i>Notificaciones</a>
                                                </li-->
                                                <li><a href="index.php?accion=salir" class="glyphicons user"><i></i>Cerrar </a></li>
                                            </ul>
                                        </div>
                                 <?php
								 }
								?>
                                    </div>
                                    <!--ul class="notifications pull-right hidden-xs">
                                        <li class="dropdown notif">
                                            <a href="" class="dropdown-toggle" data-toggle="dropdown"><i class="notif-block fa fa-comments-o"></i><span class="badge badge-primary">7</span></a>
                                            <ul class="dropdown-menu chat media-list">
                                                <li class="media">
                                                    <a class="pull-left" href="#">
                                                        <img class="media-object thumb" src="../assets/images/people/100/15.jpg" alt="50x50" width="50"/>
                                                    </a>
                                                    <div class="media-body">
                                                        <span class="label label-default pull-right">5 min</span>
                                                        <h5 class="media-heading">
                                                            Pablo Vargas
                                                        </h5>
                                                        <p class="margin-none">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                                    </div>
                                                </li>

                                                <li>
                                                    <a href="#" class="btn btn-primary"><i class="fa fa-list"></i> <span>Ver todas las</span></a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul-->
                                    <div class="clearfix"></div>
                                </div>
                                <!-- // END navbar -->

                                <div class="layout-app">
