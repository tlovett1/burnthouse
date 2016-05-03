<?php
/**
 * Template Name: Tour
 */

get_header(); ?>

<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ): the_post(); ?>
		<h1><span>Burnt House</span> Bermuda</h1>

		<section class="main-menu">
			<?php wp_nav_menu( array( 'menu' => 'Project Nav' ) ); ?>
		</section>

		<iframe class="tour" src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/flash/tour.html"></iframe>
	<?php endwhile; ?>
<?php endif; ?>

<?php get_footer();

