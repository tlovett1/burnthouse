<?php
namespace TenUp\Burnthouse_Theme\Core;

/**
 * Set up theme defaults and register supported WordPress features.
 *
 * @since 0.1.0
 *
 * @uses add_action()
 *
 * @return void
 */
function setup() {
	$n = function( $function ) {
		return __NAMESPACE__ . "\\$function";
	};

	add_action( 'after_setup_theme',  $n( 'i18n' )        );
	add_action( 'wp_head',            $n( 'header_meta' ) );
	add_action( 'wp_enqueue_scripts', $n( 'scripts' )     );
	add_action( 'wp_enqueue_scripts', $n( 'styles' )      );
	add_action( 'after_setup_theme',  $n( 'menus' ) );
	add_action( 'comments_open',  $n( 'filter_media_comment_status' ), 10, 2 );
	add_action( 'wp_ajax_bh_switch_to_page', $n( 'switch_to_page' ) );
	add_action( 'wp_ajax_nopriv_bh_switch_to_page', $n( 'switch_to_page' ) );
	add_filter( 'template_include', $n( 'override_template' ) );
	add_action('init', $n( 'api_add_rewrite' ) );
	add_action( 'parse_request', $n( 'api_rewrite' ) );
}

function override_template( $template ) {
	if ( is_home() || is_404() || is_front_page() ) {
		return $template;
	}

	return get_stylesheet_directory() . '/index.php';
}

/**
 * Makes WP Theme available for translation.
 *
 * Translations can be added to the /lang directory.
 * If you're building a theme based on WP Theme, use a find and replace
 * to change 'wptheme' to the name of your theme in all template files.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 *
 * @since 0.1.0
 *
 * @return void
 */
function i18n() {
	load_theme_textdomain( 'bh', BH_PATH . '/languages' );
 }

/**
 * Enqueue scripts for front-end.
 *
 * @uses wp_enqueue_script() to load front end scripts.
 *
 * @since 0.1.0
 *
 * @param bool $debug Whether to enable loading uncompressed/debugging assets. Default false.
 * @return void
 */
function scripts( $debug = false ) {
	if ( is_home() || is_front_page() ) {
		return;
	}
	$min = ( $debug || defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	wp_register_script( 'bh-maps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCmdez2yY9r7mp2aaZxsWL4HgAGePMmeXY', array(), true );

	wp_enqueue_script(
		'bh-main',
		BH_TEMPLATE_URL . "/assets/js/burnthouse-theme{$min}.js",
		array( 'jquery', 'bh-maps' ),
		BH_VERSION,
		true
	);

	wp_localize_script( 'bh-main', 'bh', array( 'ajaxurl' => esc_url( home_url( 'ajax' ) ) ) );

	$carousel = new \Jetpack_Carousel;
	$carousel->enqueue_assets( '' );
}

/**
 * Register menus
 */
function menus() {
	register_nav_menu( 'primary', __( 'Primary Menu', 'bh' ) );
}

/**
 * Enqueue styles for front-end.
 *
 * @uses wp_enqueue_style() to load front end styles.
 *
 * @since 0.1.0
 *
 * @param bool $debug Whether to enable loading uncompressed/debugging assets. Default false.
 * @return void
 */
function styles( $debug = false ) {
	$min = ( $debug || defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	wp_enqueue_style(
		'bh',
		BH_URL . "/assets/css/burnthouse-theme{$min}.css",
		array(),
		BH_VERSION
	);
}

/**
 * Add humans.txt to the <head> element.
 *
 * @uses apply_filters()
 *
 * @since 0.1.0
 *
 * @return void
 */
function header_meta() {
	$humans = '<link type="text/plain" rel="author" href="' . BH_TEMPLATE_URL . '/humans.txt" />';

	echo apply_filters( 'bh_humans', $humans );
}

function filter_media_comment_status( $open, $post_id ) {
	$post = get_post( $post_id );
	if( $post->post_type === 'attachment' ) {
		return false;
	}
	return $open;
}

/** 
 * Setup API endpoint
 */
function api_add_rewrite() {
	add_rewrite_tag( '%ajax%', '([^&]+)' );
	add_rewrite_rule( '^ajax/?', 'index.php?ajax=1', 'top' );
}

/**
 * Rewrite our API endpoint
 */
function api_rewrite( $wp ) {
	if ( 'ajax' === $wp->request && ! empty( $_POST['path'] ) ) {

		$path = str_replace( home_url(), '', $_POST['path'] );

		global $post;

		$post = get_page_by_path( $path );

		setup_postdata( $post );

		$template = get_post_meta( $post->ID, '_wp_page_template', true );

		if ( 'default' !== $template ) {
			include( get_stylesheet_directory() . '/' . $template );
		} else {
			include( get_stylesheet_directory() . '/templates/default.php' );
		}

		exit;
	}
}


