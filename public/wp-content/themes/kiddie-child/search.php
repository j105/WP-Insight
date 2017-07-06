<?php
/**
 * The template for displaying search results
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
      $sidebar_option = get_theme_mod( 'category_sidebar_option', 'right' );

      if ( 'none' == $sidebar_option ) {
        $bootstrap_container_left_classes = kiddie_get_bc( '12', '12', '12', '' );
        $bootstrap_container_right_classes = '';
      } elseif ( 'right' == $sidebar_option ) {
        $bootstrap_container_left_classes = kiddie_get_bc( '8', '8', '8', '' );
        $bootstrap_container_right_classes = kiddie_get_bc( '4', '4', '4', '' );
      }

      ?>
            <div class="clearfix <?php echo esc_attr( $bootstrap_container_left_classes ); ?>">
                <?php

          if(have_posts()) :
            while ( have_posts() ) : the_post();
              get_template_part( 'template-parts/post' );
            endwhile;
          else :
            get_template_part( 'content', 'none' );
          endif;
          
          get_template_part( 'template-parts/pagination' );
          wp_reset_query();
        ?>
            </div>
            <?php if ( ! empty( $bootstrap_container_right_classes ) ) { ?>
                <div class="category-sidebar-right  <?php echo esc_attr( $bootstrap_container_right_classes ); ?>">
                    <?php if ( is_active_sidebar( 'sidebar' ) ) : ?>
                        <?php dynamic_sidebar( 'sidebar' ); ?>
                    <?php endif; ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php get_footer() ?>
