<?php
session_start();
/*
 * Minimal bootstrap file;
 * acts like a router;
 * loads the requested file;
 */

$module = 'admin';


/*
 * Load config.app;
 * Main configuration file
 */

require_once 'config/config.app.php';
if($_GET['page']!='login')
require_once 'include/outh.php';
/*
 * Load functions library
 */

require_once 'library/functions.php';

/*
 * Load class.Menu.php;
 * Menu generator class
 */
require_once 'library/class.Menu.php';

/*
 * Load config.colors;
 * Skins configuration file
 */
require_once 'config/config.colors.php';

/*
 * Load config.menus;
 * Generate Sidebar Menu
 */
require_once 'config/config.menus.php';

/*
 * Load config.scripts;
 * Dynamically load JavaScript files in the header and footer
 */
require_once 'config/config.scripts.php';

/*
 * Requested page;
 * Index by default
 */
    $page = isset($_GET['page']) ? $_GET['page'] : 'ventas';
/* Load header */
require_once 'header.php';

/*
 * Load page;
 */

require_once 'pages/' . $page . '.php';

/* Load footer */
require_once 'footer.php';

$model->close();
