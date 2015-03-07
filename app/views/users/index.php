<?php
Use \diquinnyonk\WpclassMVC\Helpers\View AS View;

$data = View::$data;

get_header(); ?>

	<h1><?php echo 'WE ARE in users/index.php of APP BASE'; ?></h1>

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
