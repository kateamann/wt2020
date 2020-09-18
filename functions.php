<?php
/**
 * WT2020.
 *
 * This file adds functions to the WT2020 Theme.
 *
 * @package 	WT2020
 * @author  	Kate Amann
 * @since  		1.0.0
 * @license 	GPL-2.0+
 */


/**
 * Theme setup.
 *
 * Attach all of the site-wide functions to the correct hooks and filters. All
 * the functions themselves are defined below this setup function.
 *
 * @since 1.0.0
 */
function wt2020_child_theme_setup() {

	// Defines the child theme
	$child_theme = wp_get_theme();
	
	define( 'CHILD_THEME_NAME', $child_theme->get( 'Name' ) );
	define( 'CHILD_THEME_URL', $child_theme->get( 'ThemeURI' ) );
	define( 'CHILD_THEME_VERSION', $child_theme->get( 'Version' ) );
	define( 'CHILD_TEXT_DOMAIN', $child_theme->get( 'TextDomain' ) );

	// Includes
	include_once( get_stylesheet_directory() . '/inc/genesis-changes.php' );
	include_once( get_stylesheet_directory() . '/inc/helper-functions.php' );
	include_once( get_stylesheet_directory() . '/inc/custom-login.php' );
	include_once( get_stylesheet_directory() . '/inc/navigation.php' );
	include_once( get_stylesheet_directory() . '/inc/custom-logo.php' );

	// Editor Styles
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor-style.css' );

	// Image Sizes
	add_image_size( 'wt2020_hero', 1280, 400, true );
	add_image_size( 'wt2020_featured', 640, 384, true );

	// Gutenberg

	// -- Wide Images
	add_theme_support( 'align-wide' );

	// -- Make media embeds responsive.
	add_theme_support( 'responsive-embeds' );

	// -- Disable custom font sizes
	add_theme_support( 'disable-custom-font-sizes' );

	// -- Editor Font Styles
	add_theme_support( 'editor-font-sizes', array(
		array(
			'name'      => __( 'Small', CHILD_TEXT_DOMAIN ),
			'shortName' => __( 'S', CHILD_TEXT_DOMAIN ),
			'size'      => 12,
			'slug'      => 'small',
		),
		array(
			'name'      => __( 'Normal', CHILD_TEXT_DOMAIN ),
			'shortName' => __( 'M', CHILD_TEXT_DOMAIN ),
			'size'      => 16,
			'slug'      => 'normal',
		),
		array(
			'name'      => __( 'Large', CHILD_TEXT_DOMAIN ),
			'shortName' => __( 'L', CHILD_TEXT_DOMAIN ),
			'size'      => 20,
			'slug'      => 'large',
		),
		array(
			'name'      => __( 'Larger', CHILD_TEXT_DOMAIN ),
			'shortName' => __( 'XL', CHILD_TEXT_DOMAIN ),
			'size'      => 24,
			'slug'      => 'larger',
		),
	) );

	// -- Disable Custom Colors
	add_theme_support( 'disable-custom-colors' );

	// -- Editor Color Palette
	add_theme_support( 'editor-color-palette', array(
		array(
			'name'  => __( 'Black', CHILD_TEXT_DOMAIN ),
			'slug'  => 'black',
			'color' => '#000000',
		),
		array(
			'name'  => __( 'Yellow', CHILD_TEXT_DOMAIN ),
			'slug'  => 'yellow',
			'color' => '#ffd100',
		),
		array(
			'name'  => __( 'White', CHILD_TEXT_DOMAIN ),
			'slug'  => 'white',
			'color' => '#ffffff',
		),
		array(
			'name'  => __( 'Black Overlay', CHILD_TEXT_DOMAIN ),
			'slug'  => 'black-overlay',
			'color' => 'rgba(0,0,0,0.85)',
		),
	) );

}
add_action( 'genesis_setup', 'wt2020_child_theme_setup', 15 );

//* Replace default style sheet
add_filter( 'stylesheet_uri', 'replace_default_style_sheet', 10, 2 );
function replace_default_style_sheet() {
	return get_stylesheet_directory_uri() . '/style.min.css';
}


/**
 * Global enqueues
 *
 * @since  1.0.0
 * @global array $wp_styles
 */
function wt2020_global_enqueues() {

	// css
    wp_enqueue_style( 'dashicons' );

	
	// javascript
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script(
		CHILD_TEXT_DOMAIN . '-responsive-menu',
		get_stylesheet_directory_uri() . "/js/responsive-menus{$suffix}.js",
		array( 'jquery' ),
		CHILD_THEME_VERSION,
		true
	);

	wp_localize_script(
		CHILD_TEXT_DOMAIN . '-responsive-menu',
		'genesis_responsive_menu',
		responsive_menu_settings()
	);

}
add_action( 'wp_enqueue_scripts', 'wt2020_global_enqueues' );



// Enable exceprts on pages
add_post_type_support( 'page', 'excerpt' );


/**
 * Sets localization (do not remove).
 *
 * @since 1.0.0
 */
function wt2020_localization_setup() {

	load_child_theme_textdomain( CHILD_TEXT_DOMAIN, get_stylesheet_directory() . '/languages' );

}
add_action( 'after_setup_theme', 'wt2020_localization_setup' );