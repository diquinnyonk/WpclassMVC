<?php

/**
 * extended class from controller
 *
 * @package App
 * @subpackage users_controller
 * @since 1.0.0
 * @access public
 */

namespace diquinnyonk\WpclassMVC\Controllers;

Use \diquinnyonk\WpclassMVC\Helpers\View AS View;

class users_controller extends controller {

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
			'one' => 'users_controller',
			'two' => 'two'
		];

		view::path('users/index.php',$data);

	}



}
