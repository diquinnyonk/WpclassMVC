<?php

/**
 * extended class from controller
 *
 * @package App
 * @subpackage index_controller
 * @since 1.0.0
 * @access public
 */
class index_controller extends controller {
	
	/**
     * Constructor.
     *
     * @access public
     */
	function __construct() {
		controller::__construct();
	}

	/**
	 * index method. inherited from abstract parent
	 *
	 * @access public
	 */
	function index(){
		
		$data = [
			'one' => 'index_controller',
			'two' => 'two'
		];
		
		view::path('index/index.php',$data);
	}


}