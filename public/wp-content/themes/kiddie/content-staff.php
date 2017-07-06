<?php
/**
 * Content template part for displaying staff person
 *
 * @package Kiddie
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header page-title">
		<div class="staff-position" style="color: <?php echo esc_attr( get_post_meta( get_the_ID(), 'kiddie_staff_color', true ) ); ?>;"><?php echo esc_html( get_post_meta( get_the_ID(), 'kiddie_staff_position', true ) ); ?></div>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		the_content( sprintf(
			/* translators: %s: Name of current post. */
			wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'kiddie' ), array( 'span' => array( 'class' => array() ) ) ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		) );

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'kiddie' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php kiddie_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
