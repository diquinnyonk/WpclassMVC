<?php

////////////////////////
// bootstrap and load //
////////////////////////

if( ! is_admin() ):

    if (!defined('SITE_PATH')) {
        define('SITE_PATH', dirname(__FILE__).'/');
    }

    require_once( SITE_PATH . 'helpers/utility.php');
    require_once( SITE_PATH . 'helpers/helpers.php');

    require_once( SITE_PATH . 'config/BaseClass.php');
    require_once( SITE_PATH . 'config/WpclassMVC.php');
    require_once( SITE_PATH . 'config/routes.php');

    require_once( SITE_PATH . 'helpers/view.php');


    $mvc = WpclassMVC::get_instance();

endif;
