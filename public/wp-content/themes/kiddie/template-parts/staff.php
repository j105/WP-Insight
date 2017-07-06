<?php
/**
 * Kiddie staff template part
 *
 * @package Kiddie
 */

$paged = get_query_var( 'paged', 1 );
$args = array(
	'post_type' => 'kiddie_staff',
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

        <div class="ztl-staff-item ztl-staff-item-v-2">
            <div class="variation-2">
                <div class="<?php kiddie_bc( '6', '6' ); ?>">
                    <div class="item-left">
                        <div class="image"
                             style="border-color: <?php if ( get_post_meta( get_the_ID(), 'kiddie_staff_color', true ) ) {
									echo esc_attr( get_post_meta( get_the_ID(), 'kiddie_staff_color', true ) );
} else {
	echo '#ffd823';
} ?>">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                <?php if ( has_post_thumbnail() ) {
									the_post_thumbnail( 'kiddie-square-big' );
} ?>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="<?php kiddie_bc( '6', '6' ); ?>">
                    <div class="item-right">
                        <div class="staff-title"><?php the_title(); ?></div>
                        <div class="staff-position"
                             style="color: <?php echo esc_attr( get_post_meta( get_the_ID(), 'kiddie_staff_color', true ) ); ?>;"><?php echo esc_html( get_post_meta( get_the_ID(), 'kiddie_staff_position', true ) ); ?>
                        </div>
                        <div class="social">
                            <?php if ( get_post_meta( get_the_ID(), 'kiddie_staff_member_facebook', true ) ) { ?><a
                                href="<?php echo esc_url( get_post_meta( get_the_ID(), 'staff_member_facebook', true ) ); ?>"
                                target="_blank"><i class="fa fa-facebook"></i></a> <?php } ?>
                            <?php if ( get_post_meta( get_the_ID(), 'kiddie_staff_member_twitter', true ) ) { ?><a
                                href="<?php echo esc_url( get_post_meta( get_the_ID(), 'staff_member_twitter', true ) ); ?>"
                                target="_blank"><i class="fa fa-twitter"></i></a> <?php } ?>
                            <?php if ( get_post_meta( get_the_ID(), 'kiddie_staff_member_google', true ) ) { ?><a
                                href="<?php echo esc_url( get_post_meta( get_the_ID(), 'staff_member_google', true ) ); ?>"
                                target="_blank"><i class="fa fa-google-plus"></i></a> <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="<?php kiddie_bc_all( '12' ); ?>">
                    <div class="staff-description">
	                        <?php
	                            echo wp_kses( get_post_meta( get_the_ID(), 'kiddie_staff_description', true ),
		                            array( 'div' => array(), 'span' => array( 'class' => array() ), 'i' => array( 'class' => array() ) )
	                            );
	                        ?>
                    </div>
                    <div class="staff-excerpt"><?php kiddie_excerpt(40); ?></div>
                </div>
                <div class="clear"></div>
                <div class="staff-more">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"
                       class="ztl-button"><?php esc_html_e( 'More About Me', 'kiddie' ); ?></a>
                </div>
            </div>
        </div>

        <?php if ( 0 == $counter % 2 ) { ?>
            <div class="clearfix visible-md visible-sm"></div>
        <?php } ?>

        <?php

	}
} else {
	get_template_part( 'content', 'none' );
}?>
<div class="ztl-line-delimiter"></div>
<?php if ( $query->max_num_pages > 1 ) { ?>
    <div class="clear40"></div>
<?php } ?>
<?php get_template_part( 'template-parts/pagination' ); ?>
<?php if ( $query->max_num_pages > 1 ) { ?>
    <div class="clear40"></div>
<?php } ?>
