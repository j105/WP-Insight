<?php
/**
 * The template for displaying all pages.
 * Template Name: Pricing Plans Page
 * This is the template that displays pages with header image and no title.
 *
 * @package Kiddie
 */

get_header();
get_template_part( 'template-parts/header' ); ?>


	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<div class="container">
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'template-parts/page' ); ?>

				<?php endwhile; // end of the loop. ?>
				</div>
		</main><!-- #main -->
	</div><!-- #primary -->
<?php get_footer(); ?>
