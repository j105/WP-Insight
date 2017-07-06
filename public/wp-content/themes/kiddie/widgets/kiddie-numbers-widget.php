<?php
/**
 * Kiddie running numbers widget
 *
 * @package Kiddie
 */


// Load and register widget
add_action( 'widgets_init', function() {
	register_widget( 'Kiddie_Numbers_Widget' );
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_script( 'underscore' );
});

// Kiddie numbers widget
class Kiddie_Numbers_Widget extends WP_Widget {

	/**
	 * Sets up the widget
	 */
	function __construct() {
		parent::__construct(
			'kiddie_numbers_widget',
			esc_html__( 'Kiddie Numbers Widget', 'kiddie' ),
			array( 'description' => esc_html__( 'Info boxes (4 numbers) for homepage and above footer sidebar.', 'kiddie' ) )
		);

		if ( is_active_widget( '', '', 'kiddie_numbers_widget' ) ) {
			// add carousel js and css
			add_action( 'wp_enqueue_scripts', function() {
				$numbers_widget = new Kiddie_Numbers_Widget();
				$settings = $numbers_widget->get_settings();
				if ( $settings ) {
					foreach ( $settings as $setting ) {
						if ( isset( $setting['widget_id'] ) && ! empty( $setting['widget_id'] ) ) {
							$overlay_color = kiddie_hex2rgba( $setting['overlay_color'], '0.6' );
							$css = '.ztl-widget-numbers-' . $setting['widget_id'] . ' .overlay { background-color: ' . $overlay_color . '; }';
							wp_add_inline_style( 'kiddie-style', wp_strip_all_tags( $css ) );
						}
					}
				}
				
				wp_enqueue_script( 'kiddie-js-count-up', get_template_directory_uri() . '/js/countUp.min.js', array(), VERSION, true );
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
		$title = apply_filters( 'widget_title', isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '' );
		$title_circle_1 = isset( $instance['title_circle_1'] ) ? ( $instance['title_circle_1'] ) : '';
		$title_circle_2 = isset( $instance['title_circle_2'] ) ? ( $instance['title_circle_2'] ) : '';
		$title_circle_3 = isset( $instance['title_circle_3'] ) ? ( $instance['title_circle_3'] ) : '';
		$title_circle_4 = isset( $instance['title_circle_4'] ) ? ( $instance['title_circle_4'] ) : '';
		$value_circle_1 = isset( $instance['value_circle_1'] ) ? ( $instance['value_circle_1'] ) : '';
		$value_circle_2 = isset( $instance['value_circle_2'] ) ? ( $instance['value_circle_2'] ) : '';
		$value_circle_3 = isset( $instance['value_circle_3'] ) ? ( $instance['value_circle_3'] ) : '';
		$value_circle_4 = isset( $instance['value_circle_4'] ) ? ( $instance['value_circle_4'] ) : '';

		$background_image = isset( $instance['background_image'] ) ? ( $instance['background_image'] ) : '';

		$widget_id = isset( $instance['widget_id'] ) ? (int) ($instance['widget_id']) : '0';

		echo wp_kses( $before_widget, array( 'aside' => array( 'class' => array(), 'id' => array() ) ) );
		?>
		<div class="ztl-widget-numbers ztl-widget-numbers-<?php echo esc_attr( $widget_id ); ?>" id="ztl-widget-numbers-id-<?php echo esc_attr( $widget_id ); ?>" data-count_up="0">
			<div class="ztl-widget-numbers-parallax ztl-parallax-container" style="background-image:url('<?php echo esc_url( $background_image ); ?>')"></div>
			<div class="overlay"></div>
			<div class="container">
		      	<div class="row">
			      	<div class="col-xs-12 ztl-widget-title-light ztl-widget-title clearfix">
				        <?php
				        if ( $title ) {
					        echo wp_kses( $before_title, array( 'h2' => array( 'class' => array() ) ) );
					        echo esc_html( $title );
					        echo wp_kses( $after_title, array( 'h2' => array( 'class' => array() ) ) );
				        }
				        ?>
			        </div>
		      	    <div class="col-sm-3 col-xs-12 item">
		      	    	<div class="ztl-widget-number" id="item-number-<?php echo esc_attr( $widget_id ); ?>1" data-value_no="<?php echo esc_attr( $value_circle_1 ); ?>">
		      	    		0
		      	    	</div>
		      	    	<div class="ztl-widget-number-title">
		      	    		<?php echo esc_html( $title_circle_1 ); ?>
		      	    	</div>
		   
		      	    </div>
			        <div class="col-sm-3 col-xs-12 item">
			        	<div class="ztl-widget-number" id="item-number-<?php echo esc_attr( $widget_id ); ?>2" data-value_no="<?php echo esc_attr( $value_circle_2 ); ?>">
			        		0
			        	</div>
			        	<div class="ztl-widget-number-title">
		      	    		<?php echo esc_html( $title_circle_2 ); ?>
		      	    	</div>

			        </div>

			        <div class="col-sm-3 col-xs-12 item">
			        	<div class="ztl-widget-number" id="item-number-<?php echo esc_attr( $widget_id ); ?>3" data-value_no="<?php echo esc_attr( $value_circle_3 ); ?>">
			        		0						
			        	</div>
			        	<div class="ztl-widget-number-title">
		      	    		<?php echo esc_html( $title_circle_3 ); ?>
		      	    	</div>
	
			        </div>
			        <div class="col-sm-3 col-xs-12 item">
			        	<div class="ztl-widget-number" id="item-number-<?php echo esc_attr( $widget_id ); ?>4" data-value_no="<?php echo esc_attr( $value_circle_4 ); ?>">
			        		0
			        	</div>
			        	<div class="ztl-widget-number-title">
		      	    		<?php echo esc_html( $title_circle_4 ); ?>
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

					$(window).resize(function(){
						addParallax('.ztl-widget-numbers-parallax');
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
		$instance['overlay_color'] = strip_tags( $new_instance['overlay_color'] );

		$instance['title_circle_1'] = strip_tags( $new_instance['title_circle_1'] );
		$instance['value_circle_1'] = (int) ( $new_instance['value_circle_1'] );

		$instance['title_circle_2'] = strip_tags( $new_instance['title_circle_2'] );
		$instance['value_circle_2'] = (int) ( $new_instance['value_circle_2'] );

		$instance['title_circle_3'] = strip_tags( $new_instance['title_circle_3'] );
		$instance['value_circle_3'] = (int) ( $new_instance['value_circle_3'] );

		$instance['title_circle_4'] = strip_tags( $new_instance['title_circle_4'] );
		$instance['value_circle_4'] = (int) ( $new_instance['value_circle_4'] );

		$instance['background_image'] = strip_tags( $new_instance['background_image'] );

		$instance['widget_id'] = isset( $this->number ) ? (int) ( $this->number ) : 0;
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
				'title' => 'Kiddie Numbers',
				'overlay_color' => '#736357',
				'title_circle_1' => 'Fun Activities',
				'title_circle_2' => 'Happy Kiddies',
				'title_circle_3' => 'Thankful Testimonials',
				'title_circle_4' => 'Loving Teachers',
				'value_circle_1' => 126,
				'value_circle_2' => 564,
				'value_circle_3' => 876,
				'value_circle_4' => 332,
				'background_image' => get_template_directory_uri() . '/images/widget_numbers_bg.jpg',
			)
		);

		$title = isset( $instance['title'] ) ? esc_html( $instance['title'] ) : '';
		$overlay_color = isset( $instance['overlay_color'] ) ? esc_attr( $instance['overlay_color'] ) : '';

		$title_circle_1 = isset( $instance['title_circle_1'] ) ? esc_html( $instance['title_circle_1'] ) : '';
		$value_circle_1 = isset( $instance['value_circle_1'] ) ? (int) ( $instance['value_circle_1'] ) : '';

		$title_circle_2 = isset( $instance['title_circle_2'] ) ? esc_html( $instance['title_circle_2'] ) : '';
		$value_circle_2 = isset( $instance['value_circle_2'] ) ? (int) ( $instance['value_circle_2'] ) : '';

		$title_circle_3 = isset( $instance['title_circle_3'] ) ? esc_html( $instance['title_circle_3'] ) : '';
		$value_circle_3 = isset( $instance['value_circle_3'] ) ? (int) ( $instance['value_circle_3'] ) : '';

		$title_circle_4 = isset( $instance['title_circle_4'] ) ? esc_html( $instance['title_circle_4'] ) : '';
		$value_circle_4 = isset( $instance['value_circle_4'] ) ? (int) ( $instance['value_circle_4'] ) : '';

		$background_image = isset( $instance['background_image'] ) ? esc_attr( $instance['background_image'] ) : '';
	?>

	<p>
      	<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Widget Title','kiddie' ); ?></label>
      	<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>

    <p>
    	<label for="<?php echo esc_attr( $this->get_field_id( 'overlay_color' ) ); ?>" style="display:block;"><?php esc_html_e( 'Overlay Color: (transparent 40%)','kiddie' ); ?></label>
    	<input class="widefat color-picker" id="<?php echo esc_attr( $this->get_field_id( 'overlay_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'overlay_color' ) ); ?>" type="text" value="<?php echo esc_attr( $overlay_color ); ?>" />
	</p>

    <hr />

    <p><strong><?php esc_html_e( 'First circle settings','kiddie' )?></strong></p>
    <p>
      	<label for="<?php echo esc_attr( $this->get_field_id( 'title_circle_1' ) ); ?>"><?php esc_html_e( 'Title:','kiddie' ); ?></label>
      	<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_circle_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_circle_1' ) ); ?>" type="text" value="<?php echo esc_attr( $title_circle_1 ); ?>" />
    </p>

    <p>
      	<label for="<?php echo esc_attr( $this->get_field_id( 'value_circle_1' ) ); ?>"><?php esc_html_e( 'Number:','kiddie' ); ?></label>
      	<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'value_circle_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'value_circle_1' ) ); ?>" value="<?php echo esc_attr( $value_circle_1 ); ?>" />
    </p>


    <hr />
    <!-- 2 -->
    <p><strong><?php esc_html_e( 'Second circle settings','kiddie' )?></strong></p>

     <p>
      	<label for="<?php echo esc_attr( $this->get_field_id( 'title_circle_2' ) ); ?>"><?php esc_html_e( 'Title:','kiddie' ); ?></label>
      	<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_circle_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_circle_2' ) ); ?>" type="text" value="<?php echo esc_attr( $title_circle_2 ); ?>" />
    </p>
    <p>
      	<label for="<?php echo esc_attr( $this->get_field_id( 'value_circle_2' ) ); ?>"><?php esc_html_e( 'Number:','kiddie' ); ?></label>
      	<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'value_circle_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'value_circle_2' ) ); ?>" value="<?php echo esc_attr( $value_circle_2 ); ?>"/>
    </p>


    <hr />
    <!-- 3 -->
    <p><strong><?php esc_html_e( 'Third circle settings','kiddie' )?></strong></p>
     <p>
      	<label for="<?php echo esc_attr( $this->get_field_id( 'title_circle_3' ) ); ?>"><?php esc_html_e( 'Title:','kiddie' ); ?></label>
      	<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_circle_3' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_circle_3' ) ); ?>" type="text" value="<?php echo esc_attr( $title_circle_3 ); ?>" />
    </p>
    <p>
      	<label for="<?php echo esc_attr( $this->get_field_id( 'value_circle_3' ) ); ?>"><?php esc_html_e( 'Number:','kiddie' ); ?></label>
      	<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'value_circle_3' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'value_circle_3' ) ); ?>" value="<?php echo esc_attr( $value_circle_3 ); ?>" />
    </p>


    <hr />
    <!-- 4 -->
    <p><strong><?php esc_html_e( 'Fourth circle settings','kiddie' )?></strong></p>
     <p>
      	<label for="<?php echo esc_attr( $this->get_field_id( 'title_circle_4' ) ); ?>"><?php esc_html_e( 'Title:','kiddie' ); ?></label>
      	<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_circle_4' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_circle_4' ) ); ?>" type="text" value="<?php echo esc_attr( $title_circle_4 ); ?>" />
    </p>
    <p>
      	<label for="<?php echo esc_attr( $this->get_field_id( 'value_circle_4' ) ); ?>"><?php esc_html_e( 'Number:','kiddie' ); ?></label>
      	<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'value_circle_4' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'value_circle_4' ) ); ?>" value="<?php echo esc_attr( $value_circle_4 ); ?>" />
    </p>

    <p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'background_image' ) ); ?>"><?php esc_html_e( 'Background Image (parallax)', 'kiddie' ); ?>:</label>
		<br>
		<!-- Image Thumbnail -->
		<img class="custom_media_image" src="<?php echo esc_url( $background_image ); ?>" style="max-width:100%; float:left; margin: 0 10px 0px 0px; display:inline-block;" />
		<input class="custom_media_url" id="" type="text" name="<?php echo esc_attr( $this->get_field_name( 'background_image' ) ); ?>" value="<?php echo esc_attr( $background_image ); ?>" style="margin-bottom:10px; clear:right;">
		<a href="#" class="button widget_img"><?php esc_html_e( 'Add Image', 'kiddie' ); ?></a>
		<div style=" clear:both;"></div>
	</p>

	<hr />
	<br />

	<script>
		(function($){
			'use strict';
				
			$(document).ready(function($){
				
				//upload file to widget area
				$('.widget_img').on ('click', function(){
			        var send_attachment_bkp = wp.media.editor.send.attachment;
			        var button = $(this);
			        wp.media.editor.send.attachment = function(props, attachment) {
			            $(button).prev().prev().attr('src', attachment.url);
			            $(button).prev().val(attachment.url);
			            wp.media.editor.send.attachment = send_attachment_bkp;
			        }
			        wp.media.editor.open(button);
			        return false;       
			    });


				//color picker
				$('#widgets-right .widget:has(.color-picker)').each(function(){
						initColorPicker($(this));
				});
			});

			function initColorPicker(widget){
				widget.find('.color-picker').wpColorPicker({
					change: _.throttle(function(){ 
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
    <?php
	}
}
