<?php
/**
 * Kiddie staff widget
 *
 * @package Kiddie
 */

add_action('widgets_init', function(){
	register_widget( 'Kiddie_Staff_Widget' );
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_script( 'underscore' );
});


// Kiddie staff widget
class Kiddie_Staff_Widget extends WP_Widget {

	/**
	 * Sets up the widget
	 */
	function __construct() {
		parent::__construct(
			'kiddie_staff_widget', // Base ID
			esc_html__( 'Kiddie Staff Widget', 'kiddie' ), // Name
			array( 'description' => esc_html__( 'Staff box slider for homepage and above footer sidebar.', 'kiddie' ) ) // Args
		);

		if ( is_active_widget( '', '', 'kiddie_staff_widget' ) ) {
			// add carousel js and css
			add_action('wp_enqueue_scripts', function(){
				wp_enqueue_script( 'kiddie-js-owl-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array( 'jquery' ), VERSION, true );
				wp_enqueue_style( 'kiddie-style-owl-carousel', get_template_directory_uri() . '/css/owl.carousel.css', false, VERSION );

				// make sure you get all widget settings
				$staff_widget = new Kiddie_Staff_Widget();
				$settings = $staff_widget->get_settings();
				if ( $settings ) {
					foreach ( $settings as $setting ) {
						if ( isset( $setting['widget_id'] ) && ! empty( $setting['widget_id'] ) ) {
							// overlay color need to be transformed
							$rgba_top_overlayer_color = kiddie_hex2rgba( $setting['top_overlayer_color'], '0.75' );
							$staff_overlayer_color = kiddie_hex2rgba( $setting['staff_member_overlayer_color'], '0.35' );
							$kiddie_navigation_color = kiddie_hex2rgba( $setting['staff_name_color'], '0.7' );
							// keeping the format below to look good in page source
							$css = '    .ztl-widget-staff-' . esc_attr( $setting['widget_id'] ) . ' .owl-dots .owl-dot span{ color:' . esc_attr( $setting['navigation_color'] ) . ';}
    .ztl-widget-staff-' . esc_attr( $setting['widget_id'] ) . ' .owl-buttons{ color:' . esc_attr( $setting['navigation_color'] ) . ';}
    .ztl-widget-staff-' . esc_attr( $setting['widget_id'] ) . ' .ztl-staff-upper { background-color:' . esc_attr( $rgba_top_overlayer_color ) . ';}
    .ztl-widget-staff-' . esc_attr( $setting['widget_id'] ) . ' .ztl-circle-staff-contact{ background-color: ' . esc_attr( $staff_overlayer_color ) . ';}
    .ztl-widget-staff-' . esc_attr( $setting['widget_id'] ) . ' .ztl-staff-navigation{background-color:' . esc_attr( $kiddie_navigation_color ) . ';}
    .ztl-widget-staff-' . esc_attr( $setting['widget_id'] ) . ' .ztl-staff-navigation:hover{background-color:' . esc_attr( $setting['staff_name_color'] ) . ';}
    ';
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

		// these are our widget options
		$title = apply_filters( 'widget_title', isset( $instance['title'] ) ? ($instance['title']) : '' );
		$description = isset( $instance['description'] ) ? ($instance['description']) : '';
		$navigation_color = isset( $instance['navigation_color'] ) ? ($instance['navigation_color']) : '';
		$staff_name_color = isset( $instance['staff_name_color'] ) ? ($instance['staff_name_color']) : '';
		$staff_position_color = isset( $instance['staff_position_color'] ) ? ($instance['staff_position_color']) : '';
		$widget_id = isset( $instance['widget_id'] ) ? (int) ($instance['widget_id']) : 0;

		echo wp_kses( $before_widget, array( 'aside' => array( 'class' => array(), 'id' => array() ) ) );
		?>
		<div class="ztl-widget-staff-<?php echo esc_attr( $widget_id ); ?> ztl-widget-staff-wrapper">
			<div class="ztl-widget-staff-parallax ztl-parallax-container"></div>
			<div class="ztl-staff-upper">
				<div class="container">
					<div class="row">
						<div class="col-xs-12 ztl-widget-title-light ztl-widget-title">
							<?php
							if ( $title ) {
								echo wp_kses( $before_title, array( 'h2' => array( 'class' => array() ) ) );
								echo esc_html( $title );
								echo wp_kses( $after_title, array( 'h2' => array( 'class' => array() ) ) );
							}
							?>
						</div>
						<div class="col-xs-12 ztl-widget-description ztl-widget-description-light"><?php echo esc_html( $description ); ?></div>
						<div class="ztl-staff-delimiter"></div>
					</div>
				</div>

				<?php
				   $args = array(
				   		'post_type' => 'kiddie_staff',
				   		'posts_per_page' => 10,
						);
					$the_query = new WP_Query( $args );
				?>
				<div class="container ztl-widget-staff-container">
					<div class="row">
						<div class="col-xs-12">				
							<div class="ztl-staff-carousel-wrapper" >
                                <div class="ztl-staff-navigation-left ztl-staff-navigation"></div>
                                <div class="ztl-staff-navigation-right ztl-staff-navigation"></div>
								<div class="ztl-staff-carousel">
									<?php if ( $the_query->have_posts() ) : ?>
									<!-- the loop -->
									<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
										<div class="item">
											<div class="circle-portrait">
												<?php the_post_thumbnail(); ?>
												<div class="ztl-circle-staff-contact">
													<?php if ( get_post_meta( get_the_ID(), 'kiddie_staff_member_facebook', true ) ) { ?><a href="<?php echo esc_url( get_post_meta( get_the_ID(), 'kiddie_staff_member_facebook', true ) );?>" target="_blank"><i class="fa fa-facebook"></i></a> <?php } ?>
													<?php if ( get_post_meta( get_the_ID(), 'kiddie_staff_member_twitter', true ) ) { ?><a href="<?php echo esc_url( get_post_meta( get_the_ID(), 'kiddie_staff_member_twitter', true ) );?>" target="_blank"><i class="fa fa-twitter"></i></a> <?php } ?>
													<?php if ( get_post_meta( get_the_ID(), 'kiddie_staff_member_google', true ) ) { ?><a href="<?php echo esc_url( get_post_meta( get_the_ID(), 'kiddie_staff_member_google', true ) );?>" target="_blank"><i class="fa fa-google-plus"></i></a> <?php } ?>

												</div>
											</div>
											<div class="staff-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" style="color: <?php echo esc_attr( $staff_name_color ); ?>;"><?php the_title(); ?></a></div>
											<div class="staff-position" style="color: <?php echo esc_attr( $staff_position_color ); ?>;"><?php echo esc_html( get_post_meta( get_the_ID(), 'kiddie_staff_position', true ) ); ?></div>
										</div>
									<?php endwhile; ?>
									<!-- end of the loop -->
									<?php wp_reset_postdata(); ?>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
		</div>
			<div class="ztl-staff-lower"></div>
			
		</div>

		<script type="text/javascript">
			(function($) {
				'use strict';

				function addParallax(element){
					if(  !kiddieIsMobile.any() ) {
						$(element).parallax("50%", "0.5");
					}
				}
			
				$(document).ready(function(){ 
					//owl carousel

                    $(".ztl-widget-staff-<?php echo esc_js( $widget_id ); ?> .ztl-staff-carousel").owlCarousel({
					  	autoPlay: 3000, //Set AutoPlay to 3 seconds
                        loop:true,
						<?php if (is_rtl()) echo esc_js('rtl:true,'); ?>
				        responsive:{
                            0:{
                                items:1
                            },
                            600:{
                                items:2
                            },
                            768:{
                                items:3
                            },
                            1000:{
                                items:4
                            }
                        },
						stopOnHover : true,
						lazyLoad : true,
						navigation : true,
						navigationText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
					});

                    var owl = $(".ztl-widget-staff-<?php echo esc_js( $widget_id ); ?> .ztl-staff-carousel").data('owlCarousel');

                    $(".ztl-widget-staff-<?php echo esc_js( $widget_id ); ?> .ztl-staff-navigation-right").click(function(){
                        owl.next();
                    });

                    $(".ztl-widget-staff-<?php echo esc_js( $widget_id ); ?> .ztl-staff-navigation-left").click(function(){
                        owl.prev();
                    });

					$(window).resize(function(){
						addParallax('.ztl-widget-staff-parallax');
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
		$instance['description'] = strip_tags( $new_instance['description'] );
		$instance['top_overlayer_color'] = strip_tags( $new_instance['top_overlayer_color'] );
		$instance['navigation_color'] = strip_tags( $new_instance['navigation_color'] );
		$instance['staff_name_color'] = strip_tags( $new_instance['staff_name_color'] );
		$instance['staff_position_color'] = strip_tags( $new_instance['staff_position_color'] );
		$instance['staff_member_overlayer_color'] = strip_tags( $new_instance['staff_member_overlayer_color'] );
		$instance['widget_id'] = isset( $this->number ) ? (int) ($this->number) : 0;
	    return $instance;
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance
	 */
	function form( $instance ) {

		$instance = wp_parse_args( (array) $instance,
			array(
			'title' => 'Our Teachers',
					'description' => ' An nam erant offendit vulputate. Vim id eros gubergren adipiscing, cu vel impetus pertinax disputando, mei at dicam audiam referrentur. Consul noluisse delectus vis at.',
					'navigation_color' => '#f25141', // pink/red default
					'staff_name_color' => '#704825', // brown default
					'staff_position_color' => '#93c524', // green default
					'top_overlayer_color' => '#93c524', // green default
					'staff_member_overlayer_color' => '#000000', // brown default
					)
		);

		$title = isset( $instance['title'] ) ? esc_html( $instance['title'] ) : '';
		$description = isset( $instance['description'] ) ? esc_textarea( $instance['description'] ) : '';
		$navigation_color = isset( $instance['navigation_color'] ) ? esc_attr( $instance['navigation_color'] ) : '';
		$staff_name_color = isset( $instance['staff_name_color'] ) ? esc_attr( $instance['staff_name_color'] ) : '';
		$staff_position_color = isset( $instance['staff_position_color'] ) ? esc_attr( $instance['staff_position_color'] ) : '';
		$top_overlayer_color = isset( $instance['top_overlayer_color'] ) ? esc_attr( $instance['top_overlayer_color'] ) : '';
		$staff_member_overlayer_color = isset( $instance['staff_member_overlayer_color'] ) ? esc_attr( $instance['staff_member_overlayer_color'] ) : '';

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


				function initColorPicker(widget){
					widget.find('.color-picker').wpColorPicker({
						change: _.throttle(function(){ // For Customizer
							$(this).trigger('change');
						}, 3000)
					});
				}

				function onFormUpdate(event, widget){
					initColorPicker(widget);
				}

				$( document ).on('widget-added widget-updated', onFormUpdate);

			}(jQuery));
		</script>



		<p>
      		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Widget Title','kiddie' ); ?></label>
      		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    	</p>
    	<hr />

    	<p>
      		<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php esc_html_e( 'Widget Description','kiddie' ); ?></label>
      		<textarea rows="5" cols="10" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>"><?php echo esc_textarea( $description ); ?></textarea>
    	</p>
    	<hr />

    	<p>
    		<label for="<?php echo esc_attr( $this->get_field_id( 'top_overlayer_color' ) ); ?>" style="display:block;"><?php esc_html_e( 'Top Box Overlayer Color: (transparent 35%)', 'kiddie' ); ?></label>
    		<input class="widefat color-picker" id="<?php echo esc_attr( $this->get_field_id( 'top_overlayer_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'top_overlayer_color' ) ); ?>" type="text" value="<?php echo esc_attr( $top_overlayer_color ); ?>" />
		</p>
		<hr />

		<p>
    		<label for="<?php echo esc_attr( $this->get_field_id( 'staff_member_overlayer_color' ) ); ?>" style="display:block;"><?php esc_html_e( 'Staff Overlayer Color: (transparent 65%)','kiddie' ); ?></label>
    		<input class="widefat color-picker" id="<?php echo esc_attr( $this->get_field_id( 'staff_member_overlayer_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'staff_member_overlayer_color' ) ); ?>" type="text" value="<?php echo esc_attr( $staff_member_overlayer_color ); ?>" />
		</p>
		<hr />

    	<p>
    		<label for="<?php echo esc_attr( $this->get_field_id( 'staff_name_color' ) ); ?>" style="display:block;"><?php esc_html_e( 'Staff Name Color:','kiddie' ); ?></label>
    		<input class="widefat color-picker" id="<?php echo esc_attr( $this->get_field_id( 'staff_name_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'staff_name_color' ) ); ?>" type="text" value="<?php echo esc_attr( $staff_name_color ); ?>" />
		</p>
		<hr />

		<p>
    		<label for="<?php echo esc_attr( $this->get_field_id( 'staff_position_color' ) ); ?>" style="display:block;"><?php esc_html_e( 'Staff Position Color:','kiddie' ); ?></label>
    		<input class="widefat color-picker" id="<?php echo esc_attr( $this->get_field_id( 'staff_position_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'staff_position_color' ) ); ?>" type="text" value="<?php echo esc_attr( $staff_position_color ); ?>" />
		</p>
		<hr />

    	<p>
    		<label for="<?php echo esc_attr( $this->get_field_id( 'navigation_color' ) ); ?>" style="display:block;"><?php esc_html_e( 'Navigation Bullets Color:','kiddie' ); ?></label>
    		<input class="widefat color-picker" id="<?php echo esc_attr( $this->get_field_id( 'navigation_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'navigation_color' ) ); ?>" type="text" value="<?php echo esc_attr( $navigation_color ); ?>" />
		</p>
		<hr />

		
    <?php
	}
}
