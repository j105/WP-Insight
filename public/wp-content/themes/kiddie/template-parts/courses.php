<?php
/**
 * Kiddie courses template part
 *
 * @package Kiddie
 */

$paged = get_query_var( 'paged', 1 );
$args = array(
	'post_type' => 'kiddie_course',
	'paged' => $paged,
);
global $query;
$query = new WP_Query( $args );

if ( $query->have_posts() ) {
	$counter = 0;
	while ( $query->have_posts() ) {
		$query->the_post();
		$counter++;
		?>

        <div class="<?php kiddie_bc( '4', '4', '6' ); ?>">
            <div class="ztl-course-item">
                <div class="image"
                     style="border-color: <?php echo esc_attr( (get_post_meta( get_the_ID(), 'kiddie_course_color', true ) ? get_post_meta( get_the_ID(), 'kiddie_course_color', true ) : '#ffd823') ); ?>;">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                        <?php if ( has_post_thumbnail() ) {
							the_post_thumbnail( 'kiddie-4-3' );
} ?>
                    </a>
                </div>

                <div class="course-title"><?php the_title(); ?></div>
                <div class="course-description">
	                <?php
	                    echo wp_kses( get_post_meta( get_the_ID(), 'kiddie_course_description', true ),
		                    array( 'div' => array(), 'span' => array( 'class' => array() ), 'i' => array( 'class' => array() ) ));
	                ?>
                </div>
                <div class="course-more">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"
                       class="ztl-button"><?php esc_html_e( 'More', 'kiddie' ) ?></a>
                </div>
            </div>
            <div class="clear"></div>
        </div>

        <?php if ( 0 == $counter % 3 ) { ?>
            <div class="clearfix visible-md visible-lg"></div>
        <?php } ?>
        <?php if ( 0 == $counter % 2 ) { ?>
            <div class="clearfix visible-sm"></div>
        <?php } ?>

        <?php

	}
} else {
	get_template_part( 'content', 'none' );
} ?>
<div class="ztl-line-delimiter"></div>
<?php if ( $query->max_num_pages > 1 ) { ?>
    <div class="clear40"></div>
<?php } ?>
<?php get_template_part( 'template-parts/pagination' ); ?>
<?php if ( $query->max_num_pages > 1 ) { ?>
    <div class="clear40"></div>
<?php } ?>
