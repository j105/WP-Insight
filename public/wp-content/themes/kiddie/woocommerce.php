<?php
/**
 * The template for displaying all WooCommerce pages
 *
 * This is the template that displays all WooCommerce pages by default.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package kiddie
 */

get_header();
get_template_part('template-parts/header');

/**
 * Decide the layout
 */
$shop_sidebar = get_theme_mod('shop_sidebar_option');

if (empty($shop_sidebar) || $shop_sidebar=='right') {
	$bootstrap_container_left_classes = kiddie_get_bc( '8', '8', '8', '' );
	$bootstrap_container_right_classes = kiddie_get_bc( '4', '4', '4', '' );
}else{
	$bootstrap_container_left_classes = kiddie_get_bc( '12', '12', '12', '' );
	$bootstrap_container_right_classes = '';
}
?>


<div id="primary" class="content-area">
	<main id="main" class="site-main">
		<div class="container woocommerce-container">
			<div class="row">
				<div class="clearfix <?php echo esc_attr( $bootstrap_container_left_classes ); ?>">
					<?php woocommerce_content(); ?>
				</div>
				<?php if ( ! empty( $bootstrap_container_right_classes ) ) { ?>
					<div class="shop-sidebar-right sidebar-right <?php echo esc_attr( $bootstrap_container_right_classes ); ?>">
						<?php if ( is_active_sidebar( 'sidebar-shop' ) ) : ?>
							<?php dynamic_sidebar( 'sidebar-shop' ); ?>
						<?php endif; ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</main><!-- #main -->
</div><!-- #primary -->
<?php get_footer(); ?>
