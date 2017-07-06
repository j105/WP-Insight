<?php
/**
 * The template for displaying all pages.
 * Template Name: Staff Page
 * This is the template that displays staff with header image if wanted.
 *
 * @package Kiddie
 */

get_header();
get_template_part( 'template-parts/header' ); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <div class="container">
                    <div class="row">
                        <?php while ( have_posts() ) : the_post(); ?>
                            <?php get_template_part( 'template-parts/staff' ); ?>
                        <?php endwhile; // end of the loop. ?>
                    </div>
            </div>
        </main><!-- #main -->
    </div><!-- #primary -->
<?php get_footer(); ?>
