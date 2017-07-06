<?php
/**
 * Kiddie testimonials listing widget
 *
 * @package Kiddie
 */


add_action('widgets_init', function(){
	register_widget( 'Kiddie_Testimonials_Widget' );
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_script( 'underscore' );
});


// Kiddie testimonials widget
class Kiddie_Testimonials_Widget extends WP_Widget {

	/**
	 * Sets up the widget
	 */
	function __construct() {
		parent::__construct(
			'kiddie_testimonials_widget', // Base ID
			esc_html__( 'Kiddie Testimonials Widget', 'kiddie' ), // Name
			array( 'description' => esc_html__( 'Testimonials carousel for homepage and above footer sidebar.', 'kiddie' ) ) // Args
		);

		if ( is_active_widget( '', '', 'kiddie_testimonials_widget' ) ) {
			// add carousel js and css
			add_action('wp_enqueue_scripts', function(){
				wp_enqueue_script( 'kiddie-js-owl-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array( 'jquery' ), VERSION, true );
				wp_enqueue_style( 'kiddie-style-owl-carousel', get_template_directory_uri() . '/css/owl.carousel.css', false, VERSION );
				$testimonials_widget = new Kiddie_Testimonials_Widget();
				$settings = $testimonials_widget->get_settings();
				if ( $settings ) {
					foreach ( $settings as $setting ) {
						if ( isset( $setting['widget_id'] ) && ! empty( $setting['widget_id'] ) ) {
							$css = '    .ztl-widget-testimonials-' . esc_attr( $setting['widget_id'] ) . ' { background-color:' . esc_attr( $setting['background_color'] ) . ';}';
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

		// these are our widget options, all data is escaped/casted before print
		$title = apply_filters( 'widget_title', isset( $instance['title'] ) ? esc_html( $instance['title'] ) : '' );
		$background_color = isset( $instance['background_color'] ) ? esc_attr( $instance['background_color'] ) : '';
		$testimonials_no = isset( $instance['testimonials_no'] ) ? (int) $instance['testimonials_no'] : 0;
		$widget_id = isset( $instance['widget_id'] ) ? (int) $instance['widget_id'] : 0;

		echo wp_kses( $before_widget, array( 'aside' => array( 'class' => array(), 'id' => array() ) ) );
		?>
		<?php
		   $args = array(
		   				'post_type' => 'kiddie_testimonial',
		   				'posts_per_page' => $testimonials_no,
						);
			$the_query = new WP_Query( $args );
		?>

		<div class="ztl-widget-testimonials-container ztl-widget-testimonials-<?php echo esc_attr( $widget_id ); ?>">
			<div class="ztl-widget-testimonials-parallax ztl-parallax-container"></div>
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="ztl-testimonials-carousel">
							<?php if ( $the_query->have_posts() ) :  ?>
								<!-- the loop -->
								<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
									<div class="item">
										<div class="testimonial-content"><?php the_content(); ?></div>
										<div class="clearfix"></div>
										<div class="delimiter"></div>
										<div class="author">
											<?php if ( get_post_meta( get_the_ID(), 'kiddie_testimonial_author', true ) ) { ?><strong> <?php echo esc_attr( get_post_meta( get_the_ID(), 'kiddie_testimonial_author', true ) );?> </strong> <?php } ?>
											<?php if ( get_post_meta( get_the_ID(), 'kiddie_testimonial_additional_info', true ) ) { ?> <?php echo esc_attr( get_post_meta( get_the_ID(), 'kiddie_testimonial_additional_info', true ) );?>, <?php } ?>
										 	<?php if ( get_post_meta( get_the_ID(), 'kiddie_testimonial_date', true ) ) { ?> <?php echo esc_attr( get_post_meta( get_the_ID(), 'kiddie_testimonial_date', true ) );?><?php } ?>
										 </div>
									</div>
								<?php endwhile; ?>
								<?php wp_reset_postdata(); ?>
							<?php endif; ?>

						</div>
					</div>
				</div>
			</div>
		</div>


		<script type="text/javascript">
			(function($){
				'use strict';

				function addParallax(element){
					if(  !kiddieIsMobile.any() ) {
						$(element).parallax("50%", "0.5");
					}
				}

				$(document).ready(function(){
					//owl carousel
					$(".ztl-widget-testimonials-<?php echo esc_js( $widget_id ); ?> .ztl-testimonials-carousel").owlCarousel({
						items:1,
						<?php if (is_rtl()) echo esc_js('rtl:true,'); ?>
						loop:true,
					});

					$(window).resize(function(){
						addParallax('.ztl-widget-testimonials-parallax');
					});
				});

				window.onload = function(){
					$(window).trigger('resize');

				}

			}(jQuery));
		</script>

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
		$instance['background_color'] = strip_tags( $new_instance['background_color'] );
		$instance['testimonials_no'] = (int) $new_instance['testimonials_no'];

		// put some limits on items number
		if ( $instance['testimonials_no'] > 6 ) {
			$instance['testimonials_no'] = 6;
		}
		if ( $instance['testimonials_no'] < 0 ) {
			$instance['testimonials_no'] = 1;
		}

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
			'title' => 'Testimonials',
				'background_color' => '#f25141', // pink default
				'testimonials_no' => 5,
				)
		);

		// everything is escaped/casted before print
		$title = isset( $instance['title'] ) ? esc_html( $instance['title'] ) : '';
		$background_color = isset( $instance['background_color'] ) ? esc_attr( $instance['background_color'] ) : '';
		$testimonials_no = isset( $instance['testimonials_no'] ) ? (int) $instance['testimonials_no'] : 0;

		?>

		<script type="text/javascript">
			(function($){
				'use strict';

				$(document).ready(function(){ 
					//color picker
					$('#widgets-right .widget:has(.color-picker)').each(function(){
						initColorPicker($(this));
					});		 
				});

				function initColorPicker (widget) {
					widget.find( '.color-picker' ).wpColorPicker( {
						change: _.throttle( function () { // For Customizer
							$(this).trigger('change');
						}, 3000)
					});
				}

				function onFormUpdate (event, widget){
					initColorPicker(widget);
				}

				$(document).on('widget-added widget-updated', onFormUpdate);
				
			}( jQuery ) );
		</script>

		<p>
      		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Widget Title','kiddie' ); ?></label>
      		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    	</p>

    	<p>
      		<label for="<?php echo esc_attr( $this->get_field_id( 'testimonials_no' ) ); ?>"><?php esc_html_e( 'Number of testimonials (max 6)','kiddie' ); ?></label>
      		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'testimonials_no' ) ); ?>" type="text" value="<?php echo esc_attr( $testimonials_no ); ?>" />
    	</p>

    	<p>
    		<label for="<?php echo esc_attr( $this->get_field_id( 'background_color' ) ); ?>" style="display:block;"><?php esc_html_e( 'Background color', 'kiddie' ); ?></label>
    		<input class="widefat color-picker" id="<?php echo esc_attr( $this->get_field_id( 'background_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'background_color' ) ); ?>" type="text" value="<?php echo esc_attr( $background_color ); ?>" />
		</p>
		<hr />


		
    <?php
	}
}
