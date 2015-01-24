<?php

/**
 * class to get template and pass data to it
 *
 * @package App
 * @subpackage view
 * @since 1.0.0
 * @access public
 */

class view {

   /**
    * data array.
    *
    * @var array
    * @since 1.0.0
    * @access public
    */
	public static $data = array(); 

   /**
    * template path
    *
    * @var array
    * @since 1.0.0
    * @access public
    */
	public static $path = 'app-base.php';


   /**
    * path loads in path and renders and passes data to it
    *
    * @param $path string - path to template file
    * @param $data array  - array of data
    *
    * @access public
    */
	static function path($path,$data){

		if(isset($path))
		{
			self::$path = $path;
		}

		if(isset($data))
		{
			self::$data = $data;
		}

		self::render();

	}

	/**
     * wordpress filter to include our new template
     *
     * @access public
     */
	static function render(){
		add_filter( 'template_include', array( __CLASS__ ,'template_path') );
	}
	
	/**
     * path to template file
     *
     * @access public
     */
    static function template_path() {
        return SITE_PATH . 'views/' . self::$path;
    }

    /**
     * data to our view
     *
     * @access public
     */
    static function data($our_data){
     	self::$data = $our_data;
    }


}

