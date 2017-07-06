<?php
/**
 * Template Name: Homepage
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Kiddie
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<!-- Nothing here for homepage -->
		</main><!-- #main -->

		<?php if ( is_active_sidebar( 'sidebar-homepage' ) ) : ?>
			<?php dynamic_sidebar( 'sidebar-homepage' ); ?>
		<?php endif; ?>
		
	</div><!-- #primary -->
<?php get_footer(); ?>
