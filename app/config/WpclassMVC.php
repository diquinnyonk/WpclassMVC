<?php


/**
 * Class to init our mvc
 *
 * @package WpclassMVC
 * @subpackage BaseClass
 * @since 1.0.0
 * @access public
 */

class WpclassMVC extends BaseClass {

     /**
     * routes array. and is static, do not call on object
     *
     * @var array
     * @since 1.0.0
     * @access private
     */
    public static $routes = array();

     /**
     * for debugging purposes.
     *
     * @var string
     * @since 1.0.0
     * @access private
     */
    static private $debug = false;



    /**
     * Constructor.
     *
     * @access protected
     */
    public function __construct()
    {

        parent::__construct();

    }


	/**
	 * Init method. must be in child class
	 *
	 * @access public
	 */
    public function init()
    {

    	  add_action( 'init', array( $this,'mvc_tags'),10, 0 );

        if( ! is_admin() ) add_action( 'init', array( $this,'mvc_rewrites'), 10, 0 );

        add_filter('query_vars', array( $this,'add_query_vars_filter') );

        ///////////////////////////////////////////////////////////////////////////////////
        // check for order of actions are called: http://codex.wordpress.org/Plugin_API/Action_Reference
        // pre_get_posts gives us vars and then can load relevant controller ////////////
        add_action( 'wp', array($this, 'choose_controller'));


    }


    /**
  	 * add wordpress tags
  	 *
  	 * @since 1.0.0
  	 * @access protected
  	 *
  	 */
  	public function mvc_tags()
  	{
    		// controller /////////////////
    		add_rewrite_tag('%mvc_controller%','([^&]+)','mvc_controller=');

    		// action /////////////////
        add_rewrite_tag('%mvc_action%','([^&]+)','mvc_action=');

        // param /////////////////
        add_rewrite_tag('%individual_id%','([^&]+)','individual_id=');

        // extra /////////////////
        add_rewrite_tag('%extra%','([^&]+)','extra=');

        // extra /////////////////
        add_rewrite_tag('%extra_id%','([^&]+)','extra_id=');


    }

    /**
     * add query_vars
     *
     * @since 1.0.0
     * @access protected
     *
     */
    public function add_query_vars_filter( $vars ){

      $vars[] = "mvc_controller";
      $vars[] = "mvc_action";
      $vars[] = "individual_id";
      $vars[] = "extra";
      $vars[] = "extra_id";

      return $vars;

    }

    /**
     * add rewrites
     *
     * @since 1.0.0
     * @access protected
     *
     */
    public function mvc_rewrites()
    {


        $the_routes = self::$routes;

        foreach($the_routes as $route => $controller)
        {
            $route_components = explode("/",$route);

            $controller_action_array = explode(":",$controller);

            //echo '<br/> key/route: ' . $route . ' val/controller: ' . $controller . '<br/>';


            if(!isset( $rules['^' . $route_components[1] . ''] ) ){

                add_rewrite_rule( '^' . $route_components[1] . '/([^/]*)/([^/]*)/([^/]*)/([^/]*)', 'index.php?mvc_controller=' . $controller_action_array[0] . '&mvc_action=$matches[1]&individual_id=$matches[2]&extra=$matches[3]&extra_id=$matches[4]', 'top' );
                add_rewrite_rule( '^' . $route_components[1] . '/([^/]*)/([^/]*)/([^/]*)', 'index.php?mvc_controller=' . $controller_action_array[0] . '&mvc_action=$matches[1]&individual_id=$matches[2]&extra=$matches[3]', 'top' );
                add_rewrite_rule( '^' . $route_components[1] . '/([^/]*)/([^/]*)', 'index.php?mvc_controller=' . $controller_action_array[0] . '&mvc_action=$matches[1]&individual_id=$matches[2]', 'top' );
                add_rewrite_rule( '^' . $route_components[1] . '/([^/]*)', 'index.php?mvc_controller=' . $controller_action_array[0] . '&mvc_action=$matches[1]&individual_id=$matches[2]', 'top' );
                add_rewrite_rule( '^' . $route_components[1] . '', 'index.php?mvc_controller=' . $controller_action_array[0] . '&mvc_action=$matches[1]&individual_id=$matches[2]', 'top' );

            }


            self::log("WpclassMVC - - routes added for {$route_components[1]} - loaded from routes.php");

        }

        // check the last rewrite rule, if its new, flush_rewrite
        // dont want this running every page load, becomes super slow!
        $ver = filemtime( __FILE__ ); // Get the file time for this file as the version number
        $defaults = array( 'version' => 0, 'time' => time() );
        $r = wp_parse_args( get_option( __CLASS__ . '_flush', array() ), $defaults );

        if ( $r['version'] != $ver || $r['time'] + 172800 < time() ) { // Flush if ver changes or if 48hrs has passed.
            flush_rewrite_rules();
            // trace( 'flushed' );
            $args = array( 'version' => $ver, 'time' => time() );
            if ( ! update_option( __CLASS__ . '_flush', $args ) )
            add_option( __CLASS__ . '_flush', $args );

            self::log("ClassMVC - - flush_rewrite_rules() called");
        }
        // if(!isset( $rules['^' . $route_components[1] . ''] )){
        //   global $wp_rewrite;
        //   $wp_rewrite->flush_rules();
        //   flush_rewrite_rules();
        //
        //   //echo 'wp_rewrite->non_wp_rules: <br/>';
        //   //print_r($wp_rewrite->non_wp_rules);
        //   self::log("ClassMVC - - flush_rewrite_rules() called");
        // }
    }


    /**
     * choose controller
     *
     * @since 1.0.0
     * @access protected
     *
     */
     public function choose_controller(){

       // we need to be logged in to begin with, if not, no access and redirect to login!


       if(self::$debug == true){
         echo '<h1>in choose_controller() method </h1>';
         echo '<h2>';
         echo 'mvc_controller: ' . get_query_var( 'mvc_controller' ) . '<br/><br/>';
         echo 'mvc_action: ' . get_query_var( 'mvc_action' ) . '<br/><br/>';
         echo 'individual_id: ' . get_query_var( 'individual_id' ) . '<br/><br/>';
         echo 'extra: ' . get_query_var( 'extra' ) . '<br/><br/>';
         echo 'extra_id: ' . get_query_var( 'extra_id' ) . '<br/><br/>';
         echo '</h2>';
         echo '<br/>';
         echo '<br/>';
         echo '<br/>';
       }


       if ( get_query_var( 'mvc_controller' ) && get_query_var( 'mvc_action' ) && get_query_var( 'individual_id' ) && get_query_var( 'extra' ) && get_query_var( 'extra_id' ) ) {

         self::log("ClassMVC - - mvc_controller, mvc_action and individual_id match");

         if(self::$debug == true){
           echo '<h1>mvc_controller and action and individual_id match with extra & extra id!</h1>';
         }

         $controller = $this->class_exists($this->get_controller_name());

         $action_pre = get_query_var( 'mvc_action' );
         $action     = str_replace('-','_',$action_pre);

         $args       = array();
         $args[]     = get_query_var( 'individual_id' );
         $args[]     = get_query_var( 'extra' );
         $args[]     = get_query_var( 'extra_id' );

         $this->load_controller($controller,$action, $args);

       }
       else if ( get_query_var( 'mvc_controller' ) && get_query_var( 'mvc_action' ) && get_query_var( 'individual_id' ) && get_query_var( 'extra' ) ) {

         self::log("ClassMVC - - mvc_controller, mvc_action and individual_id match with extra");

         if(self::$debug == true){
           echo '<h1>mvc_controller and action and individual_id match!</h1>';
         }

         $controller = $this->class_exists($this->get_controller_name());

         $action_pre = get_query_var( 'mvc_action' );
         $action     = str_replace('-','_',$action_pre);

         $args       = array();
         $args[]     = get_query_var( 'individual_id' );
         $args[]     = get_query_var( 'extra' );

         $this->load_controller($controller,$action, $args);

       }
       else if ( get_query_var( 'mvc_controller' ) && get_query_var( 'mvc_action' ) && get_query_var( 'individual_id' ) ) {

         self::log("ClassMVC - - mvc_controller, mvc_action and individual_id match");

         if(self::$debug == true){
           echo '<h1>mvc_controller and action and individual_id match!</h1>';
         }

         $controller = $this->class_exists($this->get_controller_name());

         $action_pre = get_query_var( 'mvc_action' );
         $action     = str_replace('-','_',$action_pre);

         $args       = array();
         $args[]     = get_query_var( 'individual_id' );

         $this->load_controller($controller,$action, $args);

       }
       else if ( get_query_var( 'mvc_controller' ) && get_query_var( 'mvc_action' ) ) {

         self::log("ClassMVC - - mvc_controller and mvc_action match");

         if(self::$debug == true){
           echo '<h1>mvc_controller and action match!</h1>';
         }

         $controller = $this->class_exists($this->get_controller_name());

         $action_pre = get_query_var( 'mvc_action' );
         $action     = str_replace('-','_',$action_pre);

         $this->load_controller($controller,$action);

       }
       else if ( get_query_var( 'mvc_controller' ) ) {

         self::log("ClassMVC - - mvc_controller match only");

         if(self::$debug == true){
           echo '<h1>mvc_controller match!</h1>';
         }

         $controller = $this->class_exists($this->get_controller_name());

         $this->load_controller($controller,'index');

       }else{

         if(self::$debug == true){
           echo '<h1>no match! so not part of mvc, carry on with your life wordpress</h1>';
         }
         self::log('ClassMVC - - MVC not being used, carry on wordpress...');
       }


     }


    /**
     * get controller name
     *
     * @since 1.0.0
     * @access protected
     *
     * @return string
     */
    public function get_controller_name(){

        $controller_name = strtolower( get_query_var( 'mvc_controller' ) ) . '_controller';

        return $controller_name;
    }


    /**
     * check if class exists
     *
     * @since 1.0.0
     * @access protected
     *
     * @param $controller_name string - controller name
     *
     * @return $controller obj - instantiated controller
     */
    public function class_exists($controller_name){

        self::log("WpclassMVC - - controller name we are looking for: {$controller_name}");

        if(!file_exists(SITE_PATH . 'controllers/' . $controller_name . '.php')){

            self::log("WpclassMVC - - index controller called as file does not exist!");

            include_once(SITE_PATH . 'controllers/index_controller.php');

            $controller = new index_controller();

            return $controller;
        }

        // load the controller file if this far //////////////////////////////////////
        include_once(SITE_PATH . 'controllers/' . $controller_name . '.php');

        // then check if that class does indeed exist ///////////////////////////////
        if(class_exists($controller_name)) {

            $controller = new $controller_name();

        }else{

            self::log("WpclassMVC - - index controller called as class_exists() returned false");

            include_once(SITE_PATH . 'controllers/index_controller.php');

            $controller = new index_controller(); // default controller if doesnt exist
        }

        return $controller;
    }


    /**
    * load the controller
    *
    * @param $controller obj    - controller we need
    * @param $action     string - the method/function name to call
    * @param $args       array  - array of any extra args passed through
    *
    * @since 1.0.0
    * @access protected
    *
    */
    public function load_controller($controller, $action, $args = array()){ // array $args = array() -- for array type-hinting if in future we go down that route of multi e.g. /1/2/3


      if (is_callable(array($controller, $action))) {

        //call_user_func(
        call_user_func_array(
          array($controller, $action), $args
        );
        if($args != '')
        {
          self::log("ClassMVC - - $controller being used, and $action being method - and some args: " . serialize($args) . " ");
        }
        else
        {
          self::log("ClassMVC - - $controller being used, and $action being method");
        }

      }else{

        // no action so as we force all controllers to have an index action - via abstract
        // send to there, we may need to send error with the call to say so.
        call_user_func(
          array($controller, 'index')
        );

        self::log('ClassMVC - - method does not exist so moving onto index method');
        //fatal_error("$controller does not respond to $action");

      }

  }

    /**
     * error logging
     *
     * @since 1.0.0
     * @access public
     *
     */
    static function log ( $log )  {
        if ( true === WP_DEBUG ) {
            if ( is_array( $log ) || is_object( $log ) ) {
                error_log( print_r( $log, true ) );
            } else {
                error_log( $log );
            }
        }
    }









}
