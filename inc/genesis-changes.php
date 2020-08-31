<?php
/**
 * Genesis Changes
 *
 * @package 	WT2020
 * @author  	Kate Amann
 * @since  		1.0.0
 * @license 	GPL-2.0+
 */

// Theme Supports
add_theme_support( 'html5', array( 
	'search-form', 
	'comment-form', 
	'comment-list', 
	'gallery', 
	'caption' 
) );

add_theme_support( 'genesis-responsive-viewport' );

add_theme_support( 'genesis-footer-widgets', 4 );

add_theme_support( 'genesis-structural-wraps', array( 
	'header', 
	'menu-secondary', 
	'site-inner', 
	'footer-widgets', 
	'footer' 
) );

add_theme_support( 'genesis-menus', array( 
	'primary' => 'Primary Navigation Menu', 
	'secondary' => 'Footer Menu', 
) );

// Adds support for accessibility.
add_theme_support( 'genesis-accessibility', array(
	'404-page',
//	'drop-down-menu',
	'headings',
	'rems',
	'search-form',
	'skip-links',
	'screen-reader-text',
) );

// Remove Genesis Layout Settings
// remove_theme_support( 'genesis-inpost-layouts' );

// Remove Genesis Scripts Settings
add_action( 'admin_menu' , 'remove_genesis_page_post_scripts_box' );
function remove_genesis_page_post_scripts_box() {

	$types = array( 'post','page' );

	remove_meta_box( 'genesis_inpost_scripts_box', $types, 'normal' ); 
}

//* Remove Genesis in-post SEO Settings
remove_action( 'admin_menu', 'genesis_add_inpost_seo_box' );



// Remove admin bar styling
// add_theme_support( 'admin-bar', array( 'callback' => '__return_false' ) );

// Remove Edit link
add_filter( 'genesis_edit_post_link', '__return_false' );

// Remove Genesis Favicon (use site icon instead)
remove_action( 'wp_head', 'genesis_load_favicon' );

// Remove Header Description
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

// Removes site layouts.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

// Remove sidebar layouts
unregister_sidebar( 'header-right' );
// unregister_sidebar( 'sidebar' );
unregister_sidebar( 'sidebar-alt' );

// Adds support for after entry widget.
// add_theme_support( 'genesis-after-entry-widget-area' );



// Add New Sidebars
// genesis_register_widget_area( array( 'id' => 'blog-sidebar', 'name' => 'Blog Sidebar' ) );

/**
 * Remove Genesis Templates
 *
 */
function wt2020_remove_genesis_templates( $page_templates ) {
	unset( $page_templates['page_archive.php'] );
	unset( $page_templates['page_blog.php'] );
	return $page_templates;
}
add_filter( 'theme_page_templates', 'wt2020_remove_genesis_templates' );




/**
 * Display featured image (if present) before entry on single Posts
 */
function wt2020_hero_image() {
	if ( is_singular() && ! is_front_page() ) {
		// if we do not have a featured image, abort.
	    if ( ! has_post_thumbnail() ) {
	        return;
	    }

	    // Remove post title from main content
	    remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

	    // get the URL of featured image.
	    $image = genesis_get_image( 'format=url&size=wt2020_hero' );

	    // get the alt text of featured image.
	    $thumb_id = get_post_thumbnail_id( get_the_ID() );
	    $alt = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );

	    // if no alt text is present for featured image, set it to Post title.
	    if ( '' === $alt ) {
	        $alt = the_title_attribute( 'echo=0' );
	    }

	   
	    // display the featured image
	    echo '<div class="hero">';
	    printf( '<figure class="single-post-image"><img src="%s" alt="%s" /></figure>', esc_url( $image ), $alt );

	    echo '<div class="hero-overlay">';
	    echo '<div class="wrap">';
	    genesis_do_post_title();

	    if ( ! has_excerpt() ) {
		    echo '';
		} else { 
		    the_excerpt();
		}
		echo '</div>';
		echo '</div>';
		echo '</div>';
	}
}
add_action( 'genesis_after_header', 'wt2020_hero_image' );


// Remove post info
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );


/**
 * Archive Post Class
 *
 * Breaks the posts into two columns
 * @link http://www.billerickson.net/code/grid-loop-using-post-class
 *
 * @param array $classes
 * @return array
 */
function wt2020_archive_post_class( $classes ) {

	// Don't run on single posts or pages
	if( is_singular() )
		return $classes;

	$classes[] = 'one-half';
	global $wp_query;
	if( 0 == $wp_query->current_post || 0 == $wp_query->current_post % 2 )
		$classes[] = 'first';
	return $classes;
}
add_filter( 'post_class', 'wt2020_archive_post_class' );


// Archive layouts
function wt2020_post_layout() {
	if ( !is_front_page() && !is_singular() ) {
		remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
		add_action( 'genesis_entry_header', 'genesis_do_post_image', 5 );
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
	}
}
add_action( 'genesis_header', 'wt2020_post_layout' );



/**
 * Add Read More button below post excerpts/content on archives.
 */
function wt2020_custom_add_read_more() {
    // if this is a singular page, abort.
    if ( is_singular() ) {
        return;
    }

    printf( '<a href="%s" class="more-link button">%s</a>', get_permalink(), esc_html__( 'Read More' ) );
}
add_action( 'genesis_entry_content', 'wt2020_custom_add_read_more' );