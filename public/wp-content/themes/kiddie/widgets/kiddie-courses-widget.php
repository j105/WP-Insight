<?php
/**
 * Kiddie courses widget
 *
 * @package Kiddie
 */

// Load and register widget
add_action('widgets_init', function(){
	register_widget( 'Kiddie_Courses_Widget' );
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_script( 'underscore' );
});


// Kiddie courses widget
class Kiddie_Courses_Widget extends WP_Widget {

	/**
	 * Sets up the widget
	 */
	function __construct() {
		parent::__construct(
			'kiddie_courses_widget', // Base ID
			esc_html__( 'Kiddie Courses Widget', 'kiddie' ), // Name
			array( 'description' => esc_html__( 'Courses widget for homepage and above footer sidebar.', 'kiddie' ) ) // Args
		);

		if ( is_active_widget( '', '', 'kiddie_courses_widget' ) ) {

			add_action( 'wp_enqueue_scripts', function(){
				// make sure you get all widget settings
				$courses_widget = new Kiddie_Courses_Widget();
				$settings = $courses_widget->get_settings();
				if ( $settings ) {
					foreach ( $settings as $setting ) {
						if ( isset( $setting['widget_id'] ) && ! empty( $setting['widget_id'] ) ) {
							$css = '.ztl-widget-courses-' . esc_attr( $setting['widget_id'] ) . ' .item-course-title { color:' . esc_attr( $setting['course_name_color'] ) . '; }
                                    .ztl-widget-courses-' . esc_attr( $setting['widget_id'] ) . ' .item-course-1 .item-get-in-touch a:hover{color:' . esc_attr( $setting['color_bottom_course_1'] ) . ';}
                                    .ztl-widget-courses-' . esc_attr( $setting['widget_id'] ) . ' .item-course-2 .item-get-in-touch a:hover{color:' . esc_attr( $setting['color_bottom_course_2'] ) . ';}
                                    .ztl-widget-courses-' . esc_attr( $setting['widget_id'] ) . ' .item-course-3 .item-get-in-touch a:hover{color:' . esc_attr( $setting['color_bottom_course_3'] ) . ';}
                                    .ztl-widget-courses-' . esc_attr( $setting['widget_id'] ) . ' .item-course-1 .item-get-in-touch a{color:#fff; background-color:' . esc_attr( $setting['color_top_course_1'] ) . ';}
                                    .ztl-widget-courses-' . esc_attr( $setting['widget_id'] ) . ' .item-course-2 .item-get-in-touch a{color:#fff; background-color:' . esc_attr( $setting['color_top_course_2'] ) . ';}
                                    .ztl-widget-courses-' . esc_attr( $setting['widget_id'] ) . ' .item-course-3 .item-get-in-touch a{color:#fff; background-color:' . esc_attr( $setting['color_top_course_3'] ) . ';}';
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

		// these are our widget options, all data must is escaped before print.
		// we allow only a few html tags on description
		$title = apply_filters( 'widget_title', isset( $instance['title'] ) ? ($instance['title']) : '' );
		$description = isset( $instance['description'] ) ? ($instance['description']) : '';
		$course_name_color = isset( $instance['course_name_color'] ) ? ($instance['course_name_color']) : '';

		$name_course_1 = isset( $instance['name_course_1'] ) ? ($instance['name_course_1']) : '';
		$age_course_1 = isset( $instance['age_course_1'] ) ? ($instance['age_course_1']) : '';
		$color_top_course_1 = isset( $instance['color_top_course_1'] ) ? ($instance['color_top_course_1']) : '';
		$color_bottom_course_1 = isset( $instance['color_bottom_course_1'] ) ? ($instance['color_bottom_course_1']) : '';
		$image_course_1 = isset( $instance['image_course_1'] ) ? ($instance['image_course_1']) : '';
		$description_course_1 = isset( $instance['description_course_1'] ) ? ($instance['description_course_1']) : '';
		$get_in_touch_text_1 = isset( $instance['get_in_touch_text_1'] ) ? ($instance['get_in_touch_text_1']) : '';
		$get_in_touch_link_1 = isset( $instance['get_in_touch_link_1'] ) ? ($instance['get_in_touch_link_1']) : '';

		$name_course_2 = isset( $instance['name_course_2'] ) ? ($instance['name_course_2']) : '';
		$age_course_2 = isset( $instance['age_course_2'] ) ? ($instance['age_course_2']) : '';
		$color_top_course_2 = isset( $instance['color_top_course_2'] ) ? ($instance['color_top_course_2']) : '';
		$color_bottom_course_2 = isset( $instance['color_bottom_course_2'] ) ? ($instance['color_bottom_course_2']) : '';
		$image_course_2 = isset( $instance['image_course_2'] ) ? ($instance['image_course_2']) : '';
		$description_course_2 = isset( $instance['description_course_2'] ) ? ($instance['description_course_2']) : '';
		$get_in_touch_text_2 = isset( $instance['get_in_touch_text_2'] ) ? ($instance['get_in_touch_text_2']) : '';
		$get_in_touch_link_2 = isset( $instance['get_in_touch_link_2'] ) ? ($instance['get_in_touch_link_2']) : '';

		$name_course_3 = isset( $instance['name_course_3'] ) ? ($instance['name_course_3']) : '';
		$age_course_3 = isset( $instance['age_course_3'] ) ? ($instance['age_course_3']) : '';
		$color_top_course_3 = isset( $instance['color_top_course_3'] ) ? ($instance['color_top_course_3']) : '';
		$color_bottom_course_3 = isset( $instance['color_bottom_course_3'] ) ? ($instance['color_bottom_course_3']) : '';
		$image_course_3 = isset( $instance['image_course_3'] ) ? ($instance['image_course_3']) : '';
		$description_course_3 = isset( $instance['description_course_3'] ) ? ($instance['description_course_3']) : '';
		$get_in_touch_text_3 = isset( $instance['get_in_touch_text_3'] ) ? ($instance['get_in_touch_text_3']) : '';
		$get_in_touch_link_3 = isset( $instance['get_in_touch_link_3'] ) ? ($instance['get_in_touch_link_3']) : '';

		$widget_id = isset( $instance['widget_id'] ) ? (int) ($instance['widget_id']) : 0;

		echo wp_kses( $before_widget, array( 'aside' => array( 'class' => array(), 'id' => array() ) ) );
		?>
		<div class="container ztl-courses-wrapper ztl-widget-courses-<?php echo esc_attr( $widget_id ); ?>">
	     	<div class="row">
	     		<div class="col-xs-12 ztl-widget-title ztl-widget-title-dark">
	     			<h2 class="widget-title"><?php echo esc_html( $title ); ?></h2>
	     		</div>
	     		<div class="col-xs-12 ztl-widget-description ztl-widget-description-dark"><?php echo esc_html( $description ); ?></div>

	     		<div class="col-sm-4 col-xs-12">
	     			<div class="item item-course-1" <?php if ( $color_bottom_course_1 ) :  ?>style="background-color:<?php echo esc_attr( $color_bottom_course_1 ); ?>;"<?php endif; ?>>
	     				<div class="item-circle-top" <?php if ( $color_top_course_1 ) :  ?>style="background-color:<?php echo esc_attr( $color_top_course_1 ); ?>;"<?php endif; ?>>
	     					<img src="<?php echo esc_url( $image_course_1 ); ?>" alt="<?php esc_attr_e( 'Course','kiddie' ); ?>"/>
	     				</div>
	     				<div class="item-course-title"><?php echo esc_html( $name_course_1 ); ?></div>
	     				<div class="item-course-sub-title"><?php echo esc_html( $age_course_1 ); ?></div>
	     				<div class="item-course-description"><?php echo esc_html( $description_course_1 ); ?></div>
	     				<div class="item-footer-content">
	     				    <img class="item-footer-phantom" src="<?php echo esc_url( $image_course_1 ); ?>" alt="<?php esc_attr_e( 'Course','kiddie' ); ?>"/>
	     					<div class="item-get-in-touch">
	     						<a href="<?php echo esc_url( $get_in_touch_link_1 );?>" title="<?php echo esc_attr( $get_in_touch_text_1 ); ?>">
	     							<?php echo esc_html( $get_in_touch_text_1 ); ?>
	     						</a>
	     					</div>
	     				</div>
	     			</div>
	     		</div>

	     		<div class="col-sm-4 col-xs-12">
	     			<div class="item item-course-2" <?php if ( $color_bottom_course_2 ) :  ?>style="background-color:<?php echo esc_attr( $color_bottom_course_2 ); ?>;"<?php endif; ?>>
	     				<div class="item-circle-top" <?php if ( $color_top_course_2 ) :  ?>style="background-color:<?php echo esc_attr( $color_top_course_2 ); ?>;"<?php endif; ?>>
	     					<img src="<?php echo esc_url( $image_course_2 ); ?>" alt="<?php esc_attr_e( 'Course','kiddie' ); ?>"/>
	     				</div>
	     				<div class="item-course-title"><?php echo esc_html( $name_course_2 ); ?></div>
	     				<div class="item-course-sub-title"><?php echo esc_html( $age_course_2 ); ?></div>
	     				<div class="item-course-description"><?php echo esc_html( $description_course_2 ); ?></div>
	     				<div class="item-footer-content">
	     				    <img class="item-footer-phantom" src="<?php echo  esc_url( $image_course_2 ); ?>" alt="<?php esc_attr_e( 'Course','kiddie' ); ?>"/>
	     					<div class="item-get-in-touch">
	     						<a href="<?php echo esc_url( $get_in_touch_link_2 );?>" title="<?php echo esc_attr( $get_in_touch_text_2 ); ?>">
	     							<?php echo esc_html( $get_in_touch_text_2 ); ?>
	     						</a>
	     					</div>
	     				</div>
	     			</div>
	     		</div>

	     		<div class="col-sm-4 col-xs-12">
	     			<div class="item item-course-3" <?php if ( $color_bottom_course_3 ) :  ?>style="background-color:<?php echo esc_attr( $color_bottom_course_3 ); ?>;"<?php endif; ?>>
	     				<div class="item-circle-top" <?php if ( $color_top_course_3 ) :  ?>style="background-color:<?php echo esc_attr( $color_top_course_3 ); ?>;"<?php endif; ?>>
	     					<img src="<?php echo esc_url( $image_course_3 ); ?>" alt="<?php esc_attr_e( 'Course','kiddie' ); ?>"/>
	     				</div>
	     				<div class="item-course-title"><?php echo esc_html( $name_course_3 ); ?></div>
	     				<div class="item-course-sub-title"><?php echo esc_html( $age_course_3 ); ?></div>
	     				<div class="item-course-description"><?php echo esc_html( $description_course_3 ); ?></div>
	     				<div class="item-footer-content">
	     				    <img class="item-footer-phantom" src="<?php echo esc_url( $image_course_3 ); ?>" alt="<?php esc_attr_e( 'Course','kiddie' ); ?>"/>
	     					<div class="item-get-in-touch">
	     						<a href="<?php echo esc_url( $get_in_touch_link_3 );?>" title="<?php echo esc_attr( $get_in_touch_text_3 ); ?>">
	     							<?php echo esc_html( $get_in_touch_text_3 ); ?>
	     						</a>
	     					</div>
	     				</div>
	     			</div>
	     		</div>

	     	</div>
	    </div>

		<?php
		echo wp_kses( $after_widget,  array( 'aside' => array( 'class' => array(), 'id' => array() ) ) );
	}


	/**
	 * Processing widget options on save and sanitize all data
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['description'] = strip_tags( $new_instance['description'] );
		$instance['course_name_color'] = strip_tags( $new_instance['course_name_color'] );

		// first course
		$instance['name_course_1'] = strip_tags( $new_instance['name_course_1'] );
		$instance['age_course_1'] = strip_tags( $new_instance['age_course_1'] );
		$instance['color_top_course_1'] = strip_tags( $new_instance['color_top_course_1'] );
		$instance['color_bottom_course_1'] = strip_tags( $new_instance['color_bottom_course_1'] );
		$instance['image_course_1'] = strip_tags( $new_instance['image_course_1'] );
		$instance['description_course_1'] = strip_tags( $new_instance['description_course_1'],'<i><a><strong>' );
		$instance['get_in_touch_text_1'] = strip_tags( $new_instance['get_in_touch_text_1'],'<br>' );
		$instance['get_in_touch_link_1'] = strip_tags( $new_instance['get_in_touch_link_1'] );

		$instance['name_course_2'] = strip_tags( $new_instance['name_course_2'] );
		$instance['age_course_2'] = strip_tags( $new_instance['age_course_2'] );
		$instance['color_top_course_2'] = strip_tags( $new_instance['color_top_course_2'] );
		$instance['color_bottom_course_2'] = strip_tags( $new_instance['color_bottom_course_2'] );
		$instance['image_course_2'] = strip_tags( $new_instance['image_course_2'] );
		$instance['description_course_2'] = strip_tags( $new_instance['description_course_2'],'<i><a><strong>' );
		$instance['get_in_touch_text_2'] = strip_tags( $new_instance['get_in_touch_text_2'],'<br>' );
		$instance['get_in_touch_link_2'] = strip_tags( $new_instance['get_in_touch_link_2'] );

		$instance['name_course_3'] = strip_tags( $new_instance['name_course_3'] );
		$instance['age_course_3'] = strip_tags( $new_instance['age_course_3'] );
		$instance['color_top_course_3'] = strip_tags( $new_instance['color_top_course_3'] );
		$instance['color_bottom_course_3'] = strip_tags( $new_instance['color_bottom_course_3'] );
		$instance['image_course_3'] = strip_tags( $new_instance['image_course_3'] );
		$instance['description_course_3'] = strip_tags( $new_instance['description_course_3'],'<i><a><strong>' );
		$instance['get_in_touch_text_3'] = strip_tags( $new_instance['get_in_touch_text_3'],'<br>' );
		$instance['get_in_touch_link_3'] = strip_tags( $new_instance['get_in_touch_link_3'] );

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
			'title' => 'Our Popular Courses',
					'description' => 'Adipiscing signiferumque vix et. No alii docendi usu, pri graeco possim percipit ne. Affert nostro volumus id pri. Has purto mutat equidem ad. Istarum impulsu moralis videmus gi da.',
					'name_course_1' => 'Baby Kiddie',
					'course_name_color' => '#ffffff',
					'age_course_1' => 'Age 1 to 2',
					'color_top_course_1' => '#ff614f',
					'color_bottom_course_1' => '#f25141',
					'image_course_1' => get_template_directory_uri() . '/images/babyclothing2.png',
					'description_course_1' => 'Da natum timeam ius. Sed mazim essent sim recusabo eim, eum et senserit reformi. Eos legere aperiri facilisi in.',
					'get_in_touch_text_1' => 'More',
					'get_in_touch_link_1' => '#',

					'name_course_2' => 'Mini Kiddie',
					'age_course_2' => 'Age 2 to 4',
					'color_top_course_2' => '#a4d638',
					'color_bottom_course_2' => '#93c524',
					'image_course_2' => get_template_directory_uri() . '/images/toy56.png',
					'description_course_2' => 'Da natum timeam ius. Sed mazim essent sim recusabo eim, eum et senserit reformi. Eos legere aperiri facilisi in.',
					'get_in_touch_text_2' => 'More',
					'get_in_touch_link_2' => '#',

					'name_course_3' => 'Super Kiddie',
					'age_course_3' => 'Age 4 to 6',
					'color_top_course_3' => '#42b7f3',
					'color_bottom_course_3' => '#28a8e3',
					'image_course_3' => get_template_directory_uri() . '/images/teddybear1.png',
					'description_course_3' => 'Da natum timeam ius. Sed mazim essent sim recusabo eim, eum et senserit reformi. Eos legere aperiri facilisi in.',
					'get_in_touch_text_3' => 'More',
					'get_in_touch_link_3' => '#',
					)
		);

		$title = isset( $instance['title'] ) ? ($instance['title']) : '';
		$description = isset( $instance['description'] ) ? ($instance['description']) : '';
		$course_name_color = isset( $instance['course_name_color'] ) ? ($instance['course_name_color']) : '';

		$name_course_1 = isset( $instance['name_course_1'] ) ? ($instance['name_course_1']) : '';
		$age_course_1 = isset( $instance['age_course_1'] ) ? ($instance['age_course_1']) : '';
		$color_top_course_1 = isset( $instance['color_top_course_1'] ) ? ($instance['color_top_course_1']) : '';
		$color_bottom_course_1 = isset( $instance['color_bottom_course_1'] ) ? ($instance['color_bottom_course_1']) : '';
		$image_course_1 = isset( $instance['image_course_1'] ) ? ($instance['image_course_1']) : '';
		$description_course_1 = isset( $instance['description_course_1'] ) ? strip_tags( $instance['description_course_1'],'<i><a><br><p>' ) : '';
		$get_in_touch_text_1 = isset( $instance['get_in_touch_text_1'] ) ? strip_tags( $instance['get_in_touch_text_1'],'<br>' ) : '';
		$get_in_touch_link_1 = isset( $instance['get_in_touch_link_1'] ) ? ($instance['get_in_touch_link_1']) : '';

		$name_course_2 = isset( $instance['name_course_2'] ) ? ($instance['name_course_2']) : '';
		$age_course_2 = isset( $instance['age_course_2'] ) ? ($instance['age_course_2']) : '';
		$color_top_course_2 = isset( $instance['color_top_course_2'] ) ? ($instance['color_top_course_2']) : '';
		$color_bottom_course_2 = isset( $instance['color_bottom_course_2'] ) ? ($instance['color_bottom_course_2']) : '';
		$image_course_2 = isset( $instance['image_course_2'] ) ? ($instance['image_course_2']) : '';
		$description_course_2 = isset( $instance['description_course_2'] ) ? strip_tags( $instance['description_course_2'],'<i><a><br><p>' ) : '';
		$get_in_touch_text_2 = isset( $instance['get_in_touch_text_2'] ) ? strip_tags( $instance['get_in_touch_text_2'],'<br>' ) : '';
		$get_in_touch_link_2 = isset( $instance['get_in_touch_link_2'] ) ? ($instance['get_in_touch_link_2']) : '';

		$name_course_3 = isset( $instance['name_course_3'] ) ? ($instance['name_course_3']) : '';
		$age_course_3 = isset( $instance['age_course_3'] ) ? ($instance['age_course_3']) : '';
		$color_top_course_3 = isset( $instance['color_top_course_3'] ) ? ($instance['color_top_course_3']) : '';
		$color_bottom_course_3 = isset( $instance['color_bottom_course_3'] ) ? ($instance['color_bottom_course_3']) : '';
		$image_course_3 = isset( $instance['image_course_3'] ) ? ($instance['image_course_3']) : '';
		$description_course_3 = isset( $instance['description_course_3'] ) ? strip_tags( $instance['description_course_3'],'<i><a><br><p>' ) : '';
		$get_in_touch_text_3 = isset( $instance['get_in_touch_text_3'] ) ? strip_tags( $instance['get_in_touch_text_3'],'<br>' ) : '';
		$get_in_touch_link_3 = isset( $instance['get_in_touch_link_3'] ) ? ($instance['get_in_touch_link_3']) : '';

		?>
		
		<script type="text/javascript">
			(function($){
				'use strict';

				function initColorPicker (widget){
					widget.find('.color-picker').wpColorPicker({
						change: _.throttle(function(){
							$(this).trigger('change');
						}, 3000)
					});
				}

				function onFormUpdate(event, widget) {
					initColorPicker(widget);
				}

				$(document).on('widget-added widget-updated', onFormUpdate);

				$(document).ready(function(){
					$('#widgets-right .widget:has(.color-picker)').each(function(){
						initColorPicker($(this));
					});
				});
			}(jQuery));
		</script>

		<p><strong><?php esc_html_e( 'General widget settings','kiddie' ) ?></strong></p>
		

		<p>
      		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Widget Title','kiddie' ); ?></label>
      		<input course="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    	</p>
    	<p>
      		<label for="<?php echo esc_attr( $this->get_field_id( 'course_name_color' ) ); ?>" style="display:block;"><?php esc_html_e( 'Courses name color','kiddie' ); ?></label>
      		<input class="widefat color-picker" id="<?php echo esc_attr( $this->get_field_id( 'course_name_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'course_name_color' ) ); ?>" type="text" value="<?php echo esc_attr( $course_name_color ); ?>" />
    	</p>
    	<hr />

    	<p>
      		<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php esc_html_e( 'Widget Description','kiddie' ); ?></label>
      		<textarea rows="5" cols="10" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>"><?php echo esc_textarea( $description ); ?></textarea>
    	</p>
    	<hr />

		<p><strong><?php esc_html_e( 'First course','kiddie' ) ?></strong></p>
    	<p>
      		<label for="<?php echo esc_attr( $this->get_field_id( 'name_course_1' ) ); ?>"><?php esc_html_e( 'Course name','kiddie' ); ?></label>
      		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'name_course_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'name_course_1' ) ); ?>" type="text" value="<?php echo esc_attr( $name_course_1 ); ?>" />
    	</p>
    	<p>
      		<label for="<?php echo esc_attr( $this->get_field_id( 'age_course_1' ) ); ?>"><?php esc_html_e( 'Course age','kiddie' ); ?></label>
      		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'age_course_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'age_course_1' ) ); ?>" type="text" value="<?php echo esc_attr( $age_course_1 ); ?>" />
    	</p>
    	
    	<p>
      		<label for="<?php echo esc_attr( $this->get_field_id( 'color_top_course_1' ) ); ?>" style="display:block;"><?php esc_html_e( 'Top circle color','kiddie' ); ?></label>
      		<input class="widefat color-picker" id="<?php echo esc_attr( $this->get_field_id( 'color_top_course_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'color_top_course_1' ) ); ?>" type="text" value="<?php echo esc_attr( $color_top_course_1 ); ?>" />
    	</p>
    	<p>
      		<label for="<?php echo esc_attr( $this->get_field_id( 'color_bottom_course_1' ) ); ?>" style="display:block;"><?php esc_html_e( 'Content box color','kiddie' ); ?></label>
      		<input class="widefat color-picker" id="<?php echo esc_attr( $this->get_field_id( 'color_bottom_course_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'color_bottom_course_1' ) ); ?>" type="text" value="<?php echo esc_attr( $color_bottom_course_1 ); ?>" />
    	</p>

    	<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'image_course_1' ) ); ?>"><?php esc_html_e( 'Course image', 'kiddie' ); ?>:</label>
			<br>
			<!-- Image Thumbnail -->
			<img class="custom_media_image" src="<?php echo esc_url( $image_course_1 ); ?>" style="max-width:100px; float:left; margin: 0px 10px 0px 0px; display:inline-block;" />
			<input class="custom_media_url" id="" type="text" name="<?php echo esc_attr( $this->get_field_name( 'image_course_1' ) ); ?>" value="<?php echo esc_attr( $image_course_1 ); ?>" style="margin-bottom:10px; clear:right;">
			<a href="#" class="button widget_img"><?php esc_html_e( 'Add Image', 'kiddie' ); ?></a>
			<div style=" clear:both;"></div>
		</p>
		<p>
      		<label for="<?php echo esc_attr( $this->get_field_id( 'description_course_1' ) ); ?>"><?php esc_html_e( 'Course description','kiddie' ); ?></label>
      		<textarea rows="5" cols="10" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'description_course_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description_course_1' ) ); ?>"><?php echo esc_textarea( $description_course_1 ); ?></textarea>
    	</p>
    	<p>
      		<label for="<?php echo esc_attr( $this->get_field_id( 'get_in_touch_text_1' ) ); ?>"><?php esc_html_e( 'Link name','kiddie' ); ?></label>
      		<textarea rows="5" cols="10" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'get_in_touch_text_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'get_in_touch_text_1' ) ); ?>"><?php echo esc_textarea( $get_in_touch_text_1 ); ?></textarea>
    	</p>
    	<p>
      		<label for="<?php echo esc_attr( $this->get_field_id( 'get_in_touch_link_1' ) ); ?>"><?php esc_html_e( 'Link URL','kiddie' ); ?></label>
      		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'get_in_touch_link_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'get_in_touch_link_1' ) ); ?>" type="text" value="<?php echo esc_attr( $get_in_touch_link_1 ); ?>" />
    	</p>
    	<hr />



    	<p><strong><?php esc_html_e( 'Second course','kiddie' ) ?></strong></p>
    	<p>
      		<label for="<?php echo esc_attr( $this->get_field_id( 'name_course_2' ) ); ?>"><?php esc_html_e( 'Course name','kiddie' ); ?></label>
      		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'name_course_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'name_course_2' ) ); ?>" type="text" value="<?php echo esc_attr( $name_course_2 ); ?>" />
    	</p>
    	<p>
      		<label for="<?php echo esc_attr( $this->get_field_id( 'age_course_2' ) ); ?>"><?php esc_html_e( 'Course age','kiddie' ); ?></label>
      		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'age_course_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'age_course_2' ) ); ?>" type="text" value="<?php echo esc_attr( $age_course_2 ); ?>" />
    	</p>
    	
    	<p>
      		<label for="<?php echo esc_attr( $this->get_field_id( 'color_top_course_2' ) ); ?>" style="display:block;"><?php esc_html_e( 'Top circle color','kiddie' ); ?></label>
      		<input class="widefat color-picker" id="<?php echo esc_attr( $this->get_field_id( 'color_top_course_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'color_top_course_2' ) ); ?>" type="text" value="<?php echo esc_attr( $color_top_course_2 ); ?>" />
    	</p>
    	<p>
      		<label for="<?php echo esc_attr( $this->get_field_id( 'color_bottom_course_2' ) ); ?>" style="display:block;"><?php esc_html_e( 'Content box color','kiddie' ); ?></label>
      		<input class="widefat color-picker" id="<?php echo esc_attr( $this->get_field_id( 'color_bottom_course_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'color_bottom_course_2' ) ); ?>" type="text" value="<?php echo esc_attr( $color_bottom_course_2 ); ?>" />
    	</p>

    	<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'image_course_2' ) ); ?>"><?php esc_html_e( 'Course image', 'kiddie' ); ?>:</label>
			<br>
			<!-- Image Thumbnail -->
			<img class="custom_media_image" src="<?php echo esc_url( $image_course_2 ); ?>" style="max-width:100px; float:left; margin: 0px 10px 0px 0px; display:inline-block;" />
			<input class="custom_media_url" id="" type="text" name="<?php echo esc_attr( $this->get_field_name( 'image_course_2' ) ); ?>" value="<?php echo esc_attr( $image_course_2 ); ?>" style="margin-bottom:10px; clear:right;">
			<a href="#" class="button widget_img"><?php esc_html_e( 'Add Image', 'kiddie' ); ?></a>
			<div style=" clear:both;"></div>
		</p>
		<p>
      		<label for="<?php echo esc_attr( $this->get_field_id( 'description_course_2' ) ); ?>"><?php esc_html_e( 'Course description','kiddie' ); ?></label>
      		<textarea rows="5" cols="10" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'description_course_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description_course_2' ) ); ?>"><?php echo esc_textarea( $description_course_2 ); ?></textarea>
    	</p>
    	<p>
      		<label for="<?php echo esc_attr( $this->get_field_id( 'get_in_touch_text_2' ) ); ?>"><?php esc_html_e( 'Link name','kiddie' ); ?></label>
      		<textarea rows="5" cols="10" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'get_in_touch_text_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'get_in_touch_text_2' ) ); ?>"><?php echo esc_textarea( $get_in_touch_text_2 ); ?></textarea>
    	</p>
    	<p>
      		<label for="<?php echo esc_attr( $this->get_field_id( 'get_in_touch_link_2' ) ); ?>"><?php esc_html_e( 'Link URL','kiddie' ); ?></label>
      		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'get_in_touch_link_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'get_in_touch_link_2' ) ); ?>" type="text" value="<?php echo esc_attr( $get_in_touch_link_2 ); ?>" />
    	</p>
    	<hr />



    	<p><strong><?php esc_html_e( 'Third course','kiddie' ) ?></strong></p>
    	<p>
      		<label for="<?php echo esc_attr( $this->get_field_id( 'name_course_3' ) ); ?>"><?php esc_html_e( 'Course name','kiddie' ); ?></label>
      		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'name_course_3' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'name_course_3' ) ); ?>" type="text" value="<?php echo esc_attr( $name_course_3 ); ?>" />
    	</p>
    	<p>
      		<label for="<?php echo esc_attr( $this->get_field_id( 'age_course_3' ) ); ?>"><?php esc_html_e( 'Course age','kiddie' ); ?></label>
      		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'age_course_3' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'age_course_3' ) ); ?>" type="text" value="<?php echo esc_attr( $age_course_3 ); ?>" />
    	</p>
    	
    	<p>
      		<label for="<?php echo esc_attr( $this->get_field_id( 'color_top_course_3' ) ); ?>" style="display:block;"><?php esc_html_e( 'Top circle color','kiddie' ); ?></label>
      		<input class="widefat color-picker" id="<?php echo esc_attr( $this->get_field_id( 'color_top_course_3' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'color_top_course_3' ) ); ?>" type="text" value="<?php echo esc_attr( $color_top_course_3 ); ?>" />
    	</p>
    	<p>
      		<label for="<?php echo esc_attr( $this->get_field_id( 'color_bottom_course_3' ) ); ?>" style="display:block;"><?php esc_html_e( 'Content box color','kiddie' ); ?></label>
      		<input class="widefat color-picker" id="<?php echo esc_attr( $this->get_field_id( 'color_bottom_course_3' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'color_bottom_course_3' ) ); ?>" type="text" value="<?php echo esc_attr( $color_bottom_course_3 ); ?>" />
    	</p>

    	<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'image_course_3' ) ); ?>"><?php esc_html_e( 'Course image', 'kiddie' ); ?>:</label>
			<br>
			<!-- Image Thumbnail -->
			<img class="custom_media_image" src="<?php echo esc_url( $image_course_3 ); ?>" style="max-width:100px; float:left; margin: 0px 10px 0px 0px; display:inline-block;" />
			<input class="custom_media_url" id="" type="text" name="<?php echo esc_attr( $this->get_field_name( 'image_course_3' ) ); ?>" value="<?php echo  esc_attr( $image_course_3 ); ?>" style="margin-bottom:10px; clear:right;" >
			<a href="#" class="button widget_img"><?php esc_html_e( 'Add Image', 'kiddie' ); ?></a>
			<div style=" clear:both;"></div>
		</p>
		<p>
      		<label for="<?php echo esc_attr( $this->get_field_id( 'description_course_3' ) ); ?>"><?php esc_html_e( 'Course description','kiddie' ); ?></label>
      		<textarea rows="5" cols="10" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'description_course_3' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description_course_3' ) ); ?>"><?php echo esc_textarea( $description_course_3 ); ?></textarea>
    	</p>
    	<p>
      		<label for="<?php echo esc_attr( $this->get_field_id( 'get_in_touch_text_3' ) ); ?>"><?php esc_html_e( 'Link name','kiddie' ); ?></label>
      		<textarea rows="5" cols="10" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'get_in_touch_text_3' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'get_in_touch_text_3' ) ); ?>"><?php echo esc_textarea( $get_in_touch_text_3 ); ?></textarea>
    	</p>
    	<p>
      		<label for="<?php echo esc_attr( $this->get_field_id( 'get_in_touch_link_3' ) ); ?>"><?php esc_html_e( 'Link URL','kiddie' ); ?></label>
      		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'get_in_touch_link_3' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'get_in_touch_link_3' ) ); ?>" type="text" value="<?php echo esc_attr( $get_in_touch_link_3 ); ?>" />
    	</p>
    	<hr />
	
    <?php
	}
}
