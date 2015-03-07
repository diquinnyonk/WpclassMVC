<?php

////////////////////////
// bootstrap and load //
////////////////////////

namespace diquinnyonk\WpclassMVC;

if( ! is_admin() ):

    if (!defined('SITE_PATH')) {
        define('SITE_PATH', dirname(__FILE__).'/');
    }

    require_once( SITE_PATH . 'Helpers/Loader.php');
    require_once( SITE_PATH . 'Helpers/Helpers.php');

    require_once( SITE_PATH . 'Config/BaseClass.php');
    require_once( SITE_PATH . 'Config/WpclassMVC.php');
    require_once( SITE_PATH . 'Config/Routes.php');

    require_once( SITE_PATH . 'Helpers/View.php');


    $mvc = \diquinnyonk\WpclassMVC\Config\WpclassMVC::get_instance();

endif;
