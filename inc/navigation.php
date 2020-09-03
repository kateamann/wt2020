<?php
/**
 * Navigation
 *
 * @package 	WT2020
 * @author  	Kate Amann
 * @since  		1.0.0
 * @license 	GPL-2.0+
 */



// CTA button in Header
function wt2020_menu_cta() {
	$button_link = get_field('menu_button_link', 'options');
	$button_text = get_field('menu_button_text', 'options'); 
	if ( $button_link ) { ?>
			<div class="menu-cta">
			<a class="button solid" href="<?php echo esc_url( $button_link ); ?>"><?php echo esc_html( $button_text ); ?></a>
			</div>
	<?php } 
}
add_action( 'genesis_header_right', 'wt2020_menu_cta', 11 );


// Primary Nav in Header
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header_right', 'genesis_do_nav', 11 );


// Secondary Nav in Footer.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 10 );

add_filter( 'wp_nav_menu_args', 'wt2020_secondary_menu_args' );
/**
 * Reduces secondary navigation menu to one level depth.
 *
 * @since 2.2.3
 *
 * @param array $args Original menu options.
 * @return array Menu options with depth set to 1.
 */
function wt2020_secondary_menu_args( $args ) {

	if ( 'secondary' !== $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;
	return $args;

}



// Mobile logo
function wt2020_mobile_logo() {
	$mobile_logo = get_field('mobile_logo', 'option');

	if ($mobile_logo) { ?>
		<a href="<?php get_bloginfo('url'); ?>" class="mobile-logo-link" rel="home" itemprop="url">
			<img class="mobile-logo" src="<?php echo $mobile_logo['url']; ?>" />
		</a>
	<?php
	}
}
add_action( 'genesis_site_title', 'wt2020_mobile_logo', 1 );


/**
 * Defines responsive menu settings.
 *
 * @since 1.0.0
 */
function responsive_menu_settings() {

	$settings = array(
		'mainMenu'         => __( '<span class="hamburger-box"><span class="hamburger-inner"></span></span>' ),
		'menuIconClass'    => 'hamburger hamburger--elastic',
		'subMenu'          => __( 'Submenu', CHILD_TEXT_DOMAIN ),
		'subMenuIconClass' => 'icon icon-arrow-down',
		'menuClasses'      => array(
			'combine' => array(
				'.nav-primary',
			),
			'others'  => array(),
		),
	);
	return $settings;
}