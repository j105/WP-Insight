<?php
/**
 * Kiddie blog template part
 *
 * @package Kiddie
 */
get_header();
get_template_part( 'template-parts/header' );
?>

<div class="category-listing clearfix">
    <div class="container">
        <div class="row">
        	<?php
			// blog full width
			$thumbnail_size = 'kiddie-blog-full';

			if ( is_page_template( 'template-blog-full.php' ) ) {
				$bootstrap_container_left_classes = kiddie_get_bc( '12', '12', '12', '' );
				$bootstrap_container_right_classes = '';

			} elseif ( is_page_template( 'template-blog-right-sidebar.php' ) ) {
				$bootstrap_container_left_classes = kiddie_get_bc( '8', '8', '8', '' );
				$bootstrap_container_right_classes = kiddie_get_bc( '4', '4', '4', '' );
			}

			?>
            <div class="clearfix <?php echo esc_attr( $bootstrap_container_left_classes ); ?>">
                <?php

					// Protect against arbitrary paged values
					$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
					$args = array(
						'post_type' => 'post',
						'paged' => $paged,
					);

					global $query;
					$query = new WP_Query( $args );

					if ( $query->have_posts() ) {

						while ( $query->have_posts() ) {
							$query->the_post();
							get_template_part( 'template-parts/post' );
						}
						get_template_part( 'template-parts/pagination' );

					} else {
						 get_template_part( 'content', 'none' );
					}
				?>
            </div>
            <?php if ( ! empty( $bootstrap_container_right_classes ) ) { ?>
	            <div class="category-sidebar-right <?php echo esc_attr( $bootstrap_container_right_classes ); ?>">
	            	<?php if ( is_active_sidebar( 'sidebar' ) ) : ?>
						<?php dynamic_sidebar( 'sidebar' ); ?>
					<?php endif; ?>           	
	            </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php get_footer() ?>
