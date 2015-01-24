<?php
//////////////////////////////////////////////////////////////
// set routes here and WpclassMVC will add routes
//
// you must setup controller! and it must match name of route!
//
// controller.php is abstract and expects you to have index()
// in your controller
//
//

$routes = array(

	//Requests to /users will go to the users_controller's 'index' action
	'/users' 	=> 'users',
	'/test' => 'test'


);

///////////////////////////////////////
// add to WpclassMVC routes array ///////
// dont touch /////////////////////////
WpclassMVC::$routes = $routes;
