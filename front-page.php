<?php
/**
 * Front Page
 *
 * @package 	WT2020
 * @author  	Kate Amann
 * @since  		1.0.0
 * @license 	GPL-2.0+
**/

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

/**
 * Display home hero feature
 */
function wt2020_home_hero() {
	
	$header = get_field('header');
	if( $header ) { ?>
	    <div class="hero">
	        <?php echo wp_get_attachment_image( $header['image'], 'full' ); ?>
	        <div class="home-hero-overlay">
	        	<div class="wrap">
	        		<h2 class="black entry-title" itemprop="headline"><?php echo $header['text']; ?></h2>
		            <a class="button arrow-right solid" href="<?php echo esc_url( $header['button_link'] ); ?>"><?php echo esc_html( $header['button_text'] ); ?></a>
	        	</div>
	        </div>
	    </div>
	<?php } 
	
}
add_action( 'genesis_after_header', 'wt2020_home_hero' );


/**
 * Display featured links
 */
function wt2020_home_featured_links() {
	if( have_rows('featured_links') ) { ?>
    <section class="featured-links clearfix">
    <?php while( have_rows('featured_links') ): the_row(); 
        $image = get_sub_field('image');
        ?>
        <a href="<?php the_sub_field('link'); ?>">
	        <div class="feature">
		        <?php echo wp_get_attachment_image( $image, 'full' ); ?>

	            <div class="feature-overlay">
	            	<h6><?php the_sub_field('link_title'); ?></h6>
	            	<p><?php the_sub_field('link_text'); ?></p>
	            	<a href="<?php the_sub_field('link'); ?>" class="button arrow-right">Read More</a>
	        	</div>
		    	
		    </div>
	    </a>
    <?php endwhile; ?>
    </section>
<?php } 
}
add_action( 'genesis_before_footer', 'wt2020_home_featured_links', 1 );

add_action( 'genesis_before_footer', 'wt2020_add_featured_case_studies', 2 );

add_action( 'genesis_before_footer', 'wt2020_add_callback_cta', 2 );

add_action( 'genesis_before_footer', 'wt2020_add_certifications_block', 2 );

genesis();