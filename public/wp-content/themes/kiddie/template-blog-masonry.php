<?php
/**
 * Template Name: Blog Masonry
 * Description: Template to display blog posts
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

                        <?php get_template_part( 'template-parts/page' ); ?>

                    <?php endwhile; // end of the loop. ?>
                </div>
        </div>
    </main><!-- #main -->
</div><!-- #primary -->
<?php get_footer(); ?>
