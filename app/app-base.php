<?php get_header(); ?>

<h1><?php echo 'WE ARE in index of APP BASE'; ?></h1>
<section id="content" role="main">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<?php get_template_part( 'entry' ); ?>
		<?php comments_template(); ?>
	<?php endwhile; endif; ?>
	<?php get_template_part( 'nav', 'below' ); ?>
</section>
<?php //get_sidebar(); ?>
<?php get_footer(); ?>