<?php
/**
 * Case Study Page
 *
 * @package 	WT2020
 * @author  	Kate Amann
 * @since  		1.0.0
 * @license 	GPL-2.0+
**/


add_action( 'genesis_before_sidebar_widget_area', 'wt2020_add_sidebar_cta' );

function wt2020_sidebar_case_study_menu() {
	$recent_posts = wp_get_recent_posts(array(
        'numberposts' => 4, 
        'post_type'   => 'case-studies',
        'post_status' => 'publish',
    ));

	if ( $recent_posts ) { ?>
		<div class="child-menu">

			<?php
			foreach ($recent_posts as $post) { ?>
				<div class="image-menu">
					<a href="<?php echo get_permalink($post['ID']); ?>">
						<?php echo get_the_post_thumbnail($post['ID'], 'medium'); ?>
						<div class="title-block">
							<h3><?php echo $post['post_title'] ?></h3>
							<button class="arrow-right">Read More</button>
						</div>
					</a>
				</div>
			<?php } 
			wp_reset_query();?>

		</div>
	<?php
	}  ?>

<?php
}
add_action( 'genesis_before_sidebar_widget_area', 'wt2020_sidebar_case_study_menu' );

genesis();