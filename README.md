WpclassMVC
==========

An MVC framework for themers. This goes into your theme and go from there!

This is an MVC framework I put together, it came about due to a project where the requirement was it needed to be on wordpress for the client but the actual requirements of the site did not really use wordpress default functionality too much. So I create WpclassMVC (I'm not the best with names sorry). It worked really well and I know it requires a bit more work to make it better, I wanted to share it anyone else that has a need for it.


The base layout for the folder and file structre was inspired from [php-mvc-router](https://github.com/pokeb/php-mvc-router) by [pokeb](https://github.com/pokeb)

##Install:
pull this repo or download and unzip it to the root of your theme folder. The folder can be renamed to whatever you want but I called it App
Include the bootstrap file in functions.php:
```php
// mvc app ////////////////////
include( 'app/bootstrap.php');
```
thats it, its installed!

(please note if last slash issue not resolved then amend .htaccess with code at bottom of this readme under known issues).

##Routes
So now you may want to define some routes, head on over to app/config/routes.php and here you set up the url routes you wish to have for your MVC app:
```php
$routes = array(
	//Requests to /users will go to the user_controller's 'index' action
	'/users' 	=> 'users',
	'/test' => 'test'
);
```

by default I have given you users and test to begin with but of course go with whatever you wish.
Now all that happens is the route will look for that named controller if it is not their it will default to index_controller so you need to create your controller so that it can process the request.

##Controller
Now you may be wondering why only base routes, well wordpress url tags enable us to do all the route checking in the WpclassMVC class. So if you wish to create a url for test/test-page
```php
you would go into test_controller and put the following:
/**
	 * index method. inherited from abstract parent
	 *
	 * @access public
	 */
	function test_page(){
		
  // models are available to code here ///

		$data = [
			'one' => 'test_controller',
			'two' => 'two'
		];
		
		view::path('test/test-page.php',$data);
		
	}
```

##Models

You have your function name that matches the path and you can pass $data through to the view which is the first path. All models are availble so you can have custom model work from there. Although wordpress is available so you may find you can do quite a lot of your data calls in your controller but try to keep with the skinny controllers, fat models concept if you can :)


##Views
So test_page() view::path is asking for the test-page.php file to load so lets head on over to that view and view the source:
```
<?php 
$data = view::$data;

get_header(); ?>

	<h1><?php echo 'WE ARE in test/test-page.php of APP BASE'; ?></h1>
	
	<section id="content" role="main">
	<?php 

		echo '<h1>ready?</h1>';
		echo '<pre>';
		echo '<p>Whats in the data:</p>';
		print_r($data);
		echo '</pre>';


	?>


	</section>

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
```

As you can see it's default wordpress theme file and you can do what you like, to access your data just use the view::$data call.
And there you go you are free to do what you want, anytime or place.

If this is popular I will of course take on request and improvements if you think you see a way to do anything better.



Known issues:
going to a link within WpclassMVC without a forward slash on it just does ne work!
Yes I will fix this but till then just put this in your root .htaccess before wordpress code:
```apache
<IfModule mod_rewrite.c>
 RewriteCond %{REQUEST_URI} /+[^\.]+$
 RewriteRule ^(.+[^/])$ %{REQUEST_URI}/ [R=301,L]
</IfModule>
```
it ensures all requests have the last slash added


Passing more than one parameter:
I have a version where you can pass two parameters through but it's not the neatest solution so this is going to require further digging to create solution.
