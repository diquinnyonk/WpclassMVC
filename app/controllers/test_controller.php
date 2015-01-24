<?php
/**
 * extended class from controller
 *
 * @package App
 * @subpackage mentors_controller
 * @since 1.0.0
 * @access public
 */
class test_controller extends controller {

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
			'one' => 'test_controller',
			'two' => 'two'
		];

		view::path('test/index.php',$data);

	}

	/**
	 * index method. inherited from abstract parent
	 *
	 * @access public
	 */
	function test_page(){

		$data = [
			'one' => 'test_controller',
			'two' => 'two'
		];

		view::path('test/test-page.php',$data);

	}

	/**
	* index method. inherited from abstract parent
	*
	* @access public
	*/
	function multiple($one ='',$two = '',$three = ''){

		$data = [
			'method' => 'test_controller::multiple',
			'one' 	 => $one,
			'two' 	 => $two,
			'three'  => $three
		];

		view::path('test/multiple.php',$data);

	}

}
