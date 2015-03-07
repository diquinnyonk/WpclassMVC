<?php
/**
 * Class for loading
 *
 * @package App
 * @subpackage loader
 * @since 1.0.0
 * @access public
 */

namespace diquinnyonk\WpclassMVC\Helpers\Loader;

class Loader {


    /**
     * load method. loads in models and initial controller
     *
     * @access public
     */
    static function load(){

        $models      = self::get_directory_list(SITE_PATH . 'models/');
        $controllers = self::get_directory_list(SITE_PATH . 'controllers/');

        include_once( SITE_PATH . 'models/model.php');
        include_once( SITE_PATH . 'controllers/controller.php');
        /*
        foreach($controllers as $k => $v){

            if($v != 'controller.php'){
                include_once( SITE_PATH . 'controllers/' . $v);
            }
        }*/
        foreach($models as $k => $v){

            if($v != 'model.php'){
                include_once( SITE_PATH . 'models/' . $v);
            }
        }
    }


    /**
     * get files in directory
     *
     * @param $directory string - a directory path
     *
     * @access public
     * @return $results array - return all files in path
     */
    static function get_directory_list($directory) {

        // create an array to hold directory list
        $results = array();

        // create a handler for the directory
        $handler = opendir($directory);

        // open directory and walk through the filenames
        while ($file = readdir($handler)) {

          // if file isn't this directory or its parent, add it to the results
          if ($file != "." && $file != "..") {
            $results[] = $file;
          }

        }

        // tidy up: close the handler
        closedir($handler);

        // done!
        return $results;

    }

}

Loader::load();
