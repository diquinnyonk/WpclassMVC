<?php
/**
* Base abstract class for singleton instances
*
* @package Quinn
* @subpackage BaseClass
* @since 1.0.0
* @access private
*/

namespace diquinnyonk\WpclassMVC\Config;

abstract class BaseClass {

  private static $instance = array();


  /**
  * Constructor. The child class should call this constructor from its own constructor
  *
  * @access protected
  */
  protected function __construct() {}

    /**
    * instanstiate mate
    *
    * @since 1.0.0
    * @access public
    *
    *
    * @return array
    */
    public static function get_instance() {
      $c = get_called_class();
      if ( !isset( self::$instance[$c] ) ) {
        self::$instance[$c] = new $c();
        self::$instance[$c]->init();
      }

      return self::$instance[$c];
    }

    /**
    * Init method. must be in child class
    *
    * @access public
    */
    abstract public function init();

    /**
    * debug method, I use it often
    *
    * @access public
    */
    public static function debug($var){
      echo '<pre>';
        print_r($var);
        echo '</pre>';
      }

    }
