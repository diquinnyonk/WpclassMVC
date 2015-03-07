<?php
/**
 * Base abstract class for controllers
 *
 * @package App
 * @subpackage controller
 * @since 1.0.0
 * @access private
 */

namespace diquinnyonk\WpclassMVC\Controllers;

abstract class Controller {

	/**
     * parameters array.
     *
     * @var array
     * @since 1.0.0
     * @access public
     */
	public $parameters = array();

	/**
     * Constructor.
     *
     * @access public
     */
	function __construct() {
		//Why not add authorisation checks in here, then all controllers can inherit
	}

	/**
	 * index method. must be in child class as must be default action
	 *
	 * @access public
	 */
	abstract function index();

	/**
	 * toString method for debugging
	 *
	 * @access public
	 */
	public function __toString()
	{
		// get_called_class() not original base call which __CLASS__ does ////////
		return 'Controller: ' . get_called_class();
	}

}
