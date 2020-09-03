<?php
/**
 * Case Studies archive
 *
 * @package 	WT2020
 * @author  	Kate Amann
 * @since  		1.0.0
 * @license 	GPL-2.0+
**/

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );


/**
 * Display featured image (if present) before entry on single Posts
 */
function wt2020_case_study_hero() {
	$image = get_field('case_studies_header_image', 'options');
    if ( $image ) {

    	// Remove Archive Title and description from main content
    	remove_action( 'genesis_before_loop', 'genesis_do_cpt_archive_title_description' );
	    

	    // display the featured image
	    echo '<div class="hero">';
	    echo wp_get_attachment_image( $image, 'wt2020_hero' );

	    echo '<div class="hero-overlay">';
	    echo '<div class="wrap">';
	    genesis_do_cpt_archive_title_description();

		echo '</div>';
		echo '</div>';
		echo '</div>';
        
    }
}
add_action( 'genesis_after_header', 'wt2020_case_study_hero' );




function wt2020_case_study_filters() {
	do_action('show_beautiful_filters');
}
add_action( 'genesis_before_content', 'wt2020_case_study_filters' );


genesis();