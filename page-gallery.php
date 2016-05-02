<?php
/**
 * Template Name: Gallery
 */

get_header(); ?>

<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ): the_post(); ?>
		<h1><span>Burnt House</span> Bermuda</h1>

		<section class="main-menu">
			<?php wp_nav_menu( array( 'menu' => 'Project Nav' ) ); ?>
		</section>
		<?php the_content(); ?>

		<p>Click the image to open the gallery.</p>
	<?php endwhile; ?>
<?php endif; ?>

<?php get_footer();
