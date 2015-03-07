<?php
/**
* Partner model
*
* @package App
* @subpackage model
* @since 1.0.0
* @access private
*/
namespace diquinnyonk\WpclassMVC\Models;

class Partner extends Model {

	public $id = "";
	public $name = "";

	function __construct($id="") {
		//Normally you'd connect to the database to fetch the object's properties here
		if ($id != "") {
			$this->id = $id;
			$this->name = "#$this->id";
			$this->is_valid = true;
		}
	}

	function delete() {
	}

}
