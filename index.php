<?php
/**
 * The main template file
 *
 * @package Burnthouse Theme
 * @since 0.1.0
 */

get_header(); ?>

<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ): the_post(); ?>
		<h1><span>Burnt House</span> Bermuda</h1>

		<section class="main-menu">
			<?php wp_nav_menu( array( 'menu' => 'Project Nav' ) ); ?>
		</section>

		<section class="content loading">
		</section>
	<?php endwhile; ?>
<?php endif; ?>

<audio controls autoplay>
 	<source src="<?php echo get_stylesheet_directory_uri(); ?>/assets/mp3s/bermuda-moon.mp3" type="audio/mpeg">
</audio>

<?php get_footer();
