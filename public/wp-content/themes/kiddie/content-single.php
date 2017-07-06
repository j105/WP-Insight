<?php
/**
 * Content template part for displaying single post
 *
 * @package Kiddie
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content ztl-single">
		<div class="entry-meta centered">
			<span class="entry-title"><?php the_title(); ?></span>
			<div class="ztl-post">
				<div class="date">
					<?php kiddie_posted_on(); ?>
				</div>
				<div class="image">
					<?php the_post_thumbnail( 'kiddie-full' ); ?>
				</div>

				<div class="info">
					<?php
					$tags = get_the_tags();
					if ( $tags ) {
						echo '<span><i class="flaticon-tag36"></i>';
						the_tags( '' );
						echo '</span>';
					}
					?>
					<span>
					<i class="flaticon-squares36"></i>
						<?php
						$categories = get_the_category();
						foreach ( $categories as $key => $category ) {
							echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_html__( 'View all posts filed under ', 'kiddie' ) . esc_attr( $category->name ) . '">';
							echo esc_attr( $category->name );
							echo '</a>';
							if ( $key >= 0 && $key + 1 < count( $categories ) ) {
								echo ', ';
							}
						}
						?>
					</span>
					<span class="author vcard">
						<span class="fn">
							<i class="flaticon-avatar26"></i>
							<?php the_author_posts_link(); ?>
						</span>
					</span>
					<span>
						<i class="flaticon-note10"></i>
						<a href="<?php the_permalink(); ?>#comments">
							<?php echo esc_html( get_comments_number() ); ?>
							<?php echo esc_html__( 'Comments', 'kiddie' ); ?>
						</a>
					</span>
				</div>
			</div>

		</div><!-- .entry-meta -->
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
