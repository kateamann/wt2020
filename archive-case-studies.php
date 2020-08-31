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


function wt2020_case_study_filters() {
	do_action('show_beautiful_filters');
}



// function wt2020_case_study_filters() {
// 	echo do_shortcode( '[searchandfilter fields="service-tag, product-tag"]' );
// }
add_action( 'genesis_before_loop', 'wt2020_case_study_filters' );


genesis();