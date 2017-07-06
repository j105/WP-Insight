<?php
/**
 * Kiddie category listing widget
 *
 * @package Kiddie
 */

add_action('widgets_init', function(){
	register_widget( 'Kiddie_Category_Listing_Widget' );
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_script( 'underscore' );
});

// Kiddie gallery widget
class Kiddie_Category_Listing_Widget extends WP_Widget {

	/**
	 * Sets up the widget
	 */
	function __construct() {
		parent::__construct(
			'kiddie_category_listing_widget', // Base ID
			esc_html__( 'Kiddie Category Listing Widget', 'kiddie' ), // Name
			array( 'description' => esc_html__( 'Category listing box.', 'kiddie' ) ) // Args
		);

		if ( is_active_widget( '', '', 'kiddie_category_listing_widget' ) ) {
			add_action('wp_enqueue_scripts', function(){

				$category_listing_widget = new Kiddie_Category_Listing_Widget();
				$settings = $category_listing_widget->get_settings();

				if ( $settings ) {

					foreach ( $settings as $setting ) {
						// keeping the format below to look good in page source
						if ( isset( $setting['widget_id'] ) && ! empty( $setting['widget_id'] ) ) {
							$css = '.ztl-widget-category-' . esc_attr( $setting['widget_id'] ) . ' .category i, .ztl-widget-category-' . esc_attr( $setting['widget_id'] ) . ' .author i  { color:' . esc_attr( $setting['post_info_color'] ) . ';}';
							wp_add_inline_style( 'kiddie-style', wp_strip_all_tags( $css ) );
						}
					}
				}
			});
		}
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	function widget( $args, $instance ) {
	    extract( $args );

		// these are our widget options, all data must is escaped/casted before print
		// we allow only a few html tags on description
		$title = apply_filters( 'widget_title', isset( $instance['title'] ) ? ($instance['title']) : '' );
		$post_info_color = isset( $instance['post_info_color'] ) ? ($instance['post_info_color']) : '';
		$category_id = isset( $instance['category_id'] ) ? (int) ($instance['category_id']) : '';
		$posts_number = isset( $instance['posts_number'] ) ? (int) ($instance['posts_number']) : '';
		$posts_title_color = isset( $instance['posts_title_color'] ) ? ($instance['posts_title_color']) : '';
		$widget_id = isset( $instance['widget_id'] ) ? (int) ($instance['widget_id']) : '';

		echo wp_kses( $before_widget, array( 'aside' => array( 'class' => array(), 'id' => array() ) ) );

		$args = array(
		   				'cat' => $category_id,
		   				'posts_per_page' => $posts_number,
						);
		$the_query = new WP_Query( $args );
		?>

		<div class="ztl-widget-category-container ztl-widget-category-<?php echo esc_attr( $widget_id ); ?>">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 ztl-widget-title-dark ztl-widget-title clearfix">
						<?php
						if ( $title ) {
							echo wp_kses( $before_title, array( 'h2' => array( 'class' => array() ) ) );
							echo esc_html( $title );
							echo wp_kses( $after_title, array( 'h2' => array( 'class' => array() ) ) );
						}
						?>
					</div>
	     		</div>
	     	</div>
			<div class="container">
				<div class="row">
					<?php if ( $the_query->have_posts() ) :  ?>
						<!-- the loop -->
						<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
							<div class="item col-sm-4">
								<div class="date">
									<span class="entry-date">
										<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
											<?php the_date(); ?>
										</a>
									</span>
								</div>
								<div class="image">
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
										<?php the_post_thumbnail( 'kiddie-square-big' ); ?>
									</a>
									<div class="comments-no">
										<i style="color:<?php echo esc_attr( $post_info_color ); ?>;" class="flaticon-black400"></i>
										<span><?php echo esc_attr( get_comments_number() ); ?></span>
									</div>
								</div>
								<div class="title">
									<a style="color:<?php echo esc_attr( $posts_title_color ); ?>;" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
										<?php the_title(); ?>
									</a>
								</div>
								<div class="content">
									<?php kiddie_excerpt( 20 ); // 20 words excerpt + link ?>
								</div>
								<div class="author">
									<i class="flaticon-avatar26"></i> <?php the_author_posts_link(); ?>
								</div>
								<div class="category">
									<?php $categories = get_the_category();?>
									<i class="flaticon-squares36"></i>
									<?php
										$results = array_slice( $categories, 1, 2 );
									foreach ( $results as $key => $category ) {
										echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_html__( 'View all posts filed under ','kiddie' ) . esc_attr( $category->name ) . '">';
										echo esc_attr( $category->name );
										echo '</a>';
										if ( $key >= 0 && $key + 1 < count( $results ) ) {
											echo ', ';
										}
									}
									?>
								</div>

								<div class="clear"></div>
							</div>

						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>
					<?php endif; ?>
				</div>
				<div class="container">
					<div class="row">
						<div class="col-xs-12 clearfix ztl-widget-category-button">
							<a class="ztl-button" title="<?php esc_attr_e( 'Go to Blog','kiddie' ); ?>" href="<?php echo esc_url( get_category_link( $category_id ) ); ?>"><?php esc_html_e( 'Go to Blog','kiddie' ); ?></a>
						</div>
					</div>
				</div>
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
		$instance['post_info_color'] = strip_tags( $new_instance['post_info_color'] );
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
			'title' => 'Our Blog',
				'post_info_color' => '#93c524', // green
				'category_id' => '',
				'posts_number' => '3',
				'posts_title_color' => '#704825',// brown
				)
		);

		$title = (isset( $instance['title'] ) ? ($instance['title']) : '');
		$post_info_color = (isset( $instance['post_info_color'] ) ? ($instance['post_info_color']) : '');
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

    	<p>
    		<label for="<?php echo esc_attr( $this->get_field_id( 'posts_title_color' ) ); ?>" style="display:block;"><?php esc_html_e( 'Post Title', 'kiddie' ); ?></label>
    		<input class="widefat color-picker" id="<?php echo esc_attr( $this->get_field_id( 'posts_title_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts_title_color' ) ); ?>" type="text" value="<?php echo esc_attr( $posts_title_color ); ?>" />
		</p>

    	<p>
    		<label for="<?php echo esc_attr( $this->get_field_id( 'post_info_color' ) ); ?>" style="display:block;"><?php esc_html_e( 'Post Meta and Icons', 'kiddie' ); ?></label>
    		<input class="widefat color-picker" id="<?php echo esc_attr( $this->get_field_id( 'post_info_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_info_color' ) ); ?>" type="text" value="<?php echo esc_attr( $post_info_color ); ?>" />
		</p>
		<hr />

		<script type="text/javascript">
			(function($) {
				'use strict';

				$(document).ready(function(){
					//color picker
					$('#widgets-right .widget:has(.color-picker)').each(function(){
						initColorPicker($(this));
					} );

				});


				function initColorPicker(widget){
					widget.find('.color-picker').wpColorPicker({
						change: _.throttle(function(){ // For Customizer
							$(this).trigger('change');
						}, 3000)
					});
				}

				function onFormUpdate (event, widget) {
					initColorPicker(widget);
				}
				$( document ).on('widget-added widget-updated', onFormUpdate);
			}( jQuery ) );
		</script>
    <?php
	}
}
