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
        'position' 	 => '3.1',
        'capability' => 'edit_posts',
        'redirect'   => false
    ));

    acf_add_options_page(array(
		'page_title' => 'Certifications',
		'menu_title' => 'Certifications',
		'menu_slug'  => 'certifications',
		'position'   => '6.1',
        'capability' => 'edit_posts',
        'redirect'   => false
	));
}


/**
 * Certifications shortcode
 */
function wt2020_certifications_shortcode() {
	ob_start(); 
	if( have_rows('certifications', 'options') ) {?>
	<div class="certifications clearfix">
		<?php while( have_rows('certifications', 'options') ): the_row(); 
	        $logo = get_sub_field('logo');
	        $link = get_sub_field('link');
	        $name = get_sub_field('name');
	        ?>
	        <div class="certification">
	            <?php echo wp_get_attachment_image( $logo, 'full' ); ?>
	            <a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $name ); ?></a>
	        </div>
	    <?php endwhile; ?>
	</div>
	<?php $certifications = ob_get_clean();
    return $certifications;
    } 
}
add_shortcode( 'certifications', 'wt2020_certifications_shortcode' );



/**
 * Child menu shortcode
 */
function wt2020_child_menu_shortcode() {
	global $post;

	ob_start();
	$children = get_pages(array('child_of' => $post->ID, 'sort_column' => 'menu_order'));
	if ( $children ) { ?>
		<div class="featured-menu clearfix">
		    <?php foreach( $children as $child ): 

	    	$permalink = get_permalink( $child->ID );
	        $title = get_the_title( $child->ID );
	        $excerpt = get_the_excerpt( $child->ID );
	        ?>

	        <div class="featured-item entry">
	        	<header class="entry-header">
	            	<a href="<?php echo esc_url( $permalink ); ?>">
	            	<?php echo get_the_post_thumbnail( $child->ID, 'wt2020_featured' ); ?></a>
	            	<h2 class="entry-title" itemprop="headline"><a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $title ); ?></a></h2>
	            </header>
	            	<div class="entry-content" itemprop="text">
		            	<p><?php echo wp_trim_words( esc_html( $excerpt ), 15, '...' ); ?></p>
		            	<a href="<?php echo esc_url( $permalink ); ?>" class="more-link button arrow-right">Read More</a>
	        		</div>
	        </div>
		    <?php endforeach; ?>
		</div>
	<?php $child_menu = ob_get_clean();
    return $child_menu;
    } 
}
add_shortcode( 'child_menu', 'wt2020_child_menu_shortcode' );



/**
 * Adds full-width callback CTA
 */
function wt2020_add_callback_cta() { 
	if( get_field('callback_toggle') ) { ?>
	    <div class="cta-callback clearfix">
			<div class="wrap">
			<h3 class="black">Request a Call Back</h3>
			<?php echo do_shortcode('[ninja_form id=3]'); ?>
			</div>
		</div> 
		<?php
	}
}



/**
 * Adds featured case studies
 */
function wt2020_add_featured_case_studies() {
	$case_studies = get_field('case_studies');
	if( $case_studies ){ ?>
		<div class="pre-footer-section clearfix">
			<h6>Case Studies</h6>
			<div class="featured-menu clearfix">
			    <?php foreach( $case_studies as $case_study ): 

			    	$permalink = get_permalink( $case_study->ID );
			        $title = get_the_title( $case_study->ID );
			        $excerpt = get_the_excerpt( $case_study->ID );
			        ?>

			        <div class="featured-item entry">
			        	<header class="entry-header">
			            	<a href="<?php echo esc_url( $permalink ); ?>">
			            	<?php echo get_the_post_thumbnail( $case_study->ID, 'wt2020_featured' ); ?></a>
			            	<h2 class="entry-title" itemprop="headline"><a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $title ); ?></a></h2>
			            </header>
			            	<div class="entry-content" itemprop="text">
				            	<p><?php echo wp_trim_words( esc_html( $excerpt ), 15, '...' ); ?></p>
				            	<a href="<?php echo esc_url( $permalink ); ?>" class="more-link button arrow-right">Read More</a>
			        		</div>
			        </div>
			    <?php endforeach; ?>
			</div>
		</div>
	<?php }
}



/**
 * Adds Certifications block
 */
function wt2020_add_certifications_block() { 
	if( get_field('certifications_toggle') ) { 
		if( have_rows('certifications', 'options') ){ ?>
			<div class="pre-footer-section clearfix">
				<h6>Certifications</h6>

				<?php echo do_shortcode( '[certifications]' ); ?>

			</div>
		<?php
		}
	}
}



/**
 * Adds sidebar CTA
 */
function wt2020_add_sidebar_cta() { 
	$cta_2_link = get_field('cta_second_button_link', 'options');
	$cta_2_text = get_field('cta_second_button_text', 'options'); ?>

	<div class="cta-sidebar clearfix">
		<h3 class="black">Request a Call Back</h3>
		<?php echo do_shortcode('[ninja_form id=3]'); ?>
		<p>Other ways to get in touch</p>
		<a class="InfinityNumber call-us visible-xs button" href="tel:+443458537010" data-ict-discovery-number="+443458537010" data-ict-silent-replacements="true"><span class="InfinityNumber">0345 853 7010</span></a>
		<?php if ( $cta_2_link ) { ?>
			<a class="button" href="<?php echo esc_url( $cta_2_link ); ?>"><?php echo esc_html( $cta_2_text ); ?></a>
		<?php } ?>
	</div>
	<?php
}



/**
 * Footer CTA buttons
 */
function wt2020_footer_buttons() { 

	$cta_1_link = get_field('cta_first_button_link', 'options');
	$cta_1_text = get_field('cta_first_button_text', 'options');
	$cta_2_link = get_field('cta_second_button_link', 'options');
	$cta_2_text = get_field('cta_second_button_text', 'options');
	?>
	<div class="footer-ctas">
		<div class="wrap">
			<h6>Get In Touch</h6>
			<div class="footer-cta-area">
				<?php if ( $cta_1_link ) { ?>
					<a class="button solid" href="<?php echo esc_url( $cta_1_link ); ?>"><?php echo esc_html( $cta_1_text ); ?></a>
				<?php } ?>
				<a class="InfinityNumber call-us visible-xs button solid" href="tel:+443458537010" data-ict-discovery-number="+443458537010" data-ict-silent-replacements="true"><span class="InfinityNumber">0345 853 7010</span></a>
				<?php if ( $cta_2_link ) { ?>
					<a class="button solid" href="<?php echo esc_url( $cta_2_link ); ?>"><?php echo esc_html( $cta_2_text ); ?></a>
				<?php } ?>
			</div>
		</div>
	</div>

<?php
}
add_action( 'genesis_before_footer', 'wt2020_footer_buttons', 9 );



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