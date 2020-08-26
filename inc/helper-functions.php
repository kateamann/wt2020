<?php
/**
 * Helper Functions
 *
 * @package     WT2020
 * @author      Kate Amann
 * @since       1.0.0
 * @license     GPL-2.0+
 */


/**
 * Adds Walker Timber options page 
 * `options_page` is going to be the name of ACF group we use to set up the fields
 * 
 */
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => 'WT Options',
        'menu_title' => 'WT Options',
        'menu_slug'  => 'wt-options',
        'capability' => 'edit_posts',
        'redirect'   => false
    ));
}

/**
 * Move Yoast to the Bottom
 */
function yoast_to_bottom() {
  return 'low';
}
//add_filter( 'wpseo_metabox_prio', 'yoast_to_bottom');


/**
 * Yoast pagination link fix
 */
// add_filter( 'wpseo_genesis_force_adjacent_rel_home', '__return_true' );