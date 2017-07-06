<?php
/**
 * Kiddie default post item template part
 *
 * @package Kiddie
 */
?>

<div class="item">
    <article class="common-blog clearfix">
    	<div class="title">
    		<h5 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
    	</div>
    	<div class="date">
			<span class="date-tag">
				<span class="flaticon-calendar64 ztl-post-info"></span>
				<a href="<?php the_permalink(); ?>"> <?php the_date(); ?> </a>
			</span>
		</div>
    	<div class="image">
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail( 'kiddie-full' ); ?>
			</a>
		</div>
		<div class="info">
			<?php if ( is_sticky() ) :  ?>
				<span class="sticky-tag"><i class="flaticon-book122"></i>
					<?php esc_html_e( 'Sticky','kiddie' ); ?>
				</span>
			<?php endif; ?>

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
					echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_html__( 'View all posts filed under ','kiddie' ) . esc_attr( $category->name ) . '">';
					echo esc_attr( $category->name );
					echo '</a>';
					if ( $key >= 0 && $key + 1 < count( $categories ) ) {
						echo ', ';
					}
				}
				?>
			</span>
			<span>
                <i class="flaticon-avatar26"></i>
                <?php the_author_posts_link(); ?>
            </span>
            <span>
                <i class="flaticon-note10"></i>
                <a href="<?php the_permalink(); ?>#comments">
                    <?php echo esc_attr( get_comments_number() ); ?>
                    <?php echo esc_html__( 'Comments','kiddie' );?>
                </a>
            </span>
		</div>
        <div class="text-content"> 
        	<?php kiddie_excerpt( 40 ); ?>
        </div>
        <div class="read-more">
        	<a href="<?php the_permalink(); ?>"><?php echo esc_html__( 'Read more','kiddie' );?></a>
        </div>
    </article>
</div>
