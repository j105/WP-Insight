<?php
/**
 * The template for displaying all single posts.
 *
 * @package Kiddie
 */

get_header();
get_template_part( 'template-parts/header' );
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
		<div class="container">
			<div class="row">
				<?php
				// get post sidebar options
				$sidebar_option = get_post_meta( get_the_ID(), 'kiddie_sidebar_option', true );

				if ( 'disabled' == $sidebar_option ) {
					$bootstrap_container_left_classes = kiddie_get_bc( '12', '12', '12', '' );
					$bootstrap_container_right_classes = '';

				} elseif ( empty( $sidebar_option ) || 'right' == $sidebar_option ) {
					$bootstrap_container_left_classes = kiddie_get_bc( '8', '8', '8', '' );
					$bootstrap_container_right_classes = kiddie_get_bc( '4', '4', '4', '' );
				}
				?>
				<div class="clearfix <?php echo esc_attr( $bootstrap_container_left_classes ); ?>">
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'single' ); ?>

					<?php kiddie_post_nav(); ?>

					<?php
						// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || get_comments_number() ) :
						comments_template();
						endif;
					?>

				<?php endwhile; // end of the loop. ?>
				</div>

				<?php if ( isset( $sidebar_option ) && ( 'disabled' != $sidebar_option ) ) :  ?>
				<div class="clearfix post-sidebar-right <?php echo esc_attr( $bootstrap_container_right_classes ); ?>">
						<?php if ( is_active_sidebar( 'sidebar' ) ) : ?>
							<?php dynamic_sidebar( 'sidebar' ); ?>
						<?php endif; ?>
				</div>
				<?php endif; ?>
			</div>
		</div>
		</main><!-- #main -->
	</div><!-- #primary -->
<?php get_footer(); ?>
