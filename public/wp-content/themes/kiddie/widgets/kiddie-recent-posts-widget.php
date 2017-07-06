<?php
/**
 * Kiddie recent posts listing widget
 *
 * @package Kiddie
 */

add_action('widgets_init', function(){
	register_widget( 'Kiddie_Recent_Posts_Widget' );
});

// Kiddie recent posts widget
class Kiddie_Recent_Posts_Widget extends WP_Widget {

	/**
	 * Sets up the widget
	 */
	function __construct() {
		parent::__construct(
			'kiddie_recent_posts_widget', // Base ID
			esc_html__( 'Recent Posts', 'kiddie' ), // Name
			array( 'description' => esc_html__( 'Your site\'s most recent Posts.', 'kiddie' ) ) // Args
		);
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {
	    extract( $args );

		// these are our widget options
		$title = apply_filters( 'widget_title', isset( $instance['title'] ) ? esc_html( $instance['title'] ) : '' );
		$category_id = isset( $instance['category_id'] ) ? (int) ($instance['category_id']) : '';
		$posts_number = isset( $instance['posts_number'] ) ? (int) ($instance['posts_number']) : '';
		$widget_id = isset( $instance['widget_id'] ) ? (int) ($instance['widget_id']) : '';

		echo wp_kses( $before_widget, array( 'aside' => array( 'class' => array(), 'id' => array() ) ) );

		$args = array(
		   				'cat' => $category_id,
		   				'posts_per_page' => $posts_number,
						);
		$the_query = new WP_Query( $args );

		?>
		<div class="ztl-widget-recent-posts-container ztl-widget-recent-posts-<?php echo esc_attr( $widget_id ); ?>">

			<?php
			if ( $title ) {
				echo wp_kses( $before_title, array( 'h2' => array( 'class' => array() ) ) );
				echo esc_html( $title );
				echo wp_kses( $after_title, array( 'h2' => array( 'class' => array() ) ) );
			}
			?>

			<div class="ztl-widget-recent-posts">
				<ul class="recent-posts ztl-list-reset">
					<?php if ( $the_query->have_posts() ) :  ?>
						<!-- the loop -->
						<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
							<li class="item-post clearfix">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
									<?php the_post_thumbnail( 'kiddie-square-thumb' ); ?>

								</a>
								<h6>
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
										<?php the_title(); ?>
									</a>
								</h6>
								<span class="ztl-recent-post-date">
									<i class="flaticon-calendar64"></i>
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
										<?php the_date( 'M j, Y' ); ?>
									</a>
								</span>
							</li>

						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>
					<?php endif; ?>
				</ul>
			</div>	
			
		</div>
		<?php
		echo wp_kses( $after_widget,  array( 'aside' => array( 'class' => array(), 'id' => array() ) ) );
	}


	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['category_id'] = (int) ($new_instance['category_id']);
		$instance['posts_number'] = (int) ($new_instance['posts_number']);
		$instance['posts_title_color'] = strip_tags( $new_instance['posts_title_color'] );
		$instance['widget_id'] = isset( $this->number ) ? (int) ($this->number) : 0;

	    return $instance;
	}


	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance
	 */
	function form( $instance ) {

		$instance = wp_parse_args( (array) $instance ,
			array(
			'title' => 'Recent Posts',
				'category_id' => '',
				'posts_number' => '3',
				'posts_title_color' => '#704825', // dark brown
				)
		);

		$title = (isset( $instance['title'] ) ? ($instance['title']) : '');
		$category_id = (isset( $instance['category_id'] ) ? (int) ($instance['category_id']) : '');
		$posts_number = (isset( $instance['posts_number'] ) ? (int) ($instance['posts_number']) : '');
		$posts_title_color = (isset( $instance['posts_title_color'] ) ? ($instance['posts_title_color']) : '');

		?>

		<p>
      		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Widget Title','kiddie' ); ?></label>
      		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    	</p>

    	<p>
      		<label for="<?php echo esc_attr( $this->get_field_id( 'category_id' ) ); ?>"><?php esc_html_e( 'Category ID (number)','kiddie' ); ?></label>
      		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'category_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'category_id' ) ); ?>" type="text" value="<?php echo esc_attr( $category_id ); ?>" />
    	</p>

    	<p>
      		<label for="<?php echo esc_attr( $this->get_field_id( 'posts_number' ) ); ?>"><?php esc_html_e( 'Posts Number (max 9)','kiddie' ); ?></label>
      		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'posts_number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts_number' ) ); ?>" type="text" value="<?php echo esc_attr( $posts_number ); ?>" />
    	</p>

		<hr />

    <?php
	}
}
