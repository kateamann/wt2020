<?php
/**
 * Standard Page
 *
 * @package 	WT2020
 * @author  	Kate Amann
 * @since  		1.0.0
 * @license 	GPL-2.0+
**/



add_action( 'genesis_before_sidebar_widget_area', 'wt2020_add_sidebar_cta' );

function wt2020_sidebar_child_menu() {
	global $post;
	$section_head = $post->post_parent;
	$current_page = get_the_ID();
	$children = get_pages(array('child_of' => $section_head, 'sort_column' => 'menu_order', 'exclude' => array($current_page) ) );

	if ( $children && $section_head ) { ?>
		<div class="child-menu">

			<?php
			foreach ($children as $child) { ?>
				<div class="image-menu">
					<a href="<?php echo get_permalink($child->ID); ?>">
						<?php echo get_the_post_thumbnail( $child->ID, 'medium' ); ?>
						<div class="title-block">
							<h3><?php echo $child->post_title; ?></h3>
							<button class="arrow-right">Read More</button>
						</div>
					</a>
				</div>
			<?php } ?>

		</div>
	<?php
	}  ?>

<?php
}
add_action( 'genesis_before_sidebar_widget_area', 'wt2020_sidebar_child_menu' );


add_action( 'genesis_before_footer', 'wt2020_add_callback_cta', 2 );


add_action( 'genesis_before_footer', 'wt2020_add_featured_case_studies', 2 );

add_action( 'genesis_before_footer', 'wt2020_add_certifications_block', 2 );



genesis();