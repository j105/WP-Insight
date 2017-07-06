<?php
/**
 * Kiddie contact widget
 *
 * @package Kiddie
 */

// Load and register widget
add_action('widgets_init', function(){
	register_widget( 'Kiddie_Contact_Widget' );
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_script( 'underscore' );
});


// Kiddie contact widget
class Kiddie_Contact_Widget extends WP_Widget {

	/**
	 * Sets up the widget
	 */
	function __construct() {
		parent::__construct(
			'kiddie_contact_widget', // Base ID
			esc_html__( 'Kiddie Contact', 'kiddie' ), // Name
			array( 'description' => esc_html__( 'Contact box for homepage and above footer sidebar.', 'kiddie' ) ) // Args
		);
		if ( is_active_widget( '', '', 'kiddie_contact_widget' ) ) {
			// add google maps api
			add_action('wp_enqueue_scripts', function(){
				//get default API key
				$api_key = get_theme_mod('maps_api_key','AIzaSyAfz_ozFC-3PLVYL2GZmz60TWsikGuPdUY');
				wp_enqueue_script( 'kiddie-js-google-maps', '//maps.googleapis.com/maps/api/js?key='.$api_key, array(), VERSION, true );

				$contact_widget = new Kiddie_Contact_Widget();
				$settings = $contact_widget->get_settings();

				if ( $settings ) {
					foreach ( $settings as $setting ) {
					    if ( isset( $setting['widget_id'] ) && ! empty( $setting['widget_id'] ) ) {
							$css = '    .ztl-widget-contact-' . esc_attr( $setting['widget_id'] ) . ' input, .ztl-widget-contact-' . esc_attr( $setting['widget_id'] ) . ' textarea { background-color:' . esc_attr( $setting['input_fields_background_color'] ) . ';}
    .ztl-widget-contact-' . esc_attr( $setting['widget_id'] ) . ' input[type=submit] { background-color:' . esc_attr( $setting['placeholder_and_text_color'] ) . '; color:' . esc_attr( $setting['input_fields_background_color'] ) . ' ; }
    .ztl-widget-contact-' . esc_attr( $setting['widget_id'] ) . ' input[type=submit]:hover { color:' . esc_attr( $setting['placeholder_and_text_color'] ) . '; background-color:' . esc_attr( $setting['input_fields_background_color'] ) . ' ; }
    .ztl-widget-contact-' . esc_attr( $setting['widget_id'] ) . ' { background-color:' . esc_attr( $setting['background_color'] ) . '; }';
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
		$contact_form_shortcode = isset( $instance['contact_form_shortcode'] ) ? ($instance['contact_form_shortcode']) : ''; // need this as it is, and it's safe
		$background_color = isset( $instance['background_color'] ) ? ($instance['background_color']) : '';
		$input_fields_background_color = isset( $instance['input_fields_background_color'] ) ? ($instance['input_fields_background_color']) : '';
		$address = isset( $instance['address'] ) ? ($instance['address']) : '';
		$coordinates = isset( $instance['coordinates'] ) ? ($instance['coordinates']) : '';
		$zoom = isset( $instance['zoom'] ) ? (int) ($instance['zoom']) : '';
		$map_color = isset( $instance['map_color'] ) ? ($instance['map_color']) : '';
		$pin_image = isset( $instance['pin_image'] ) ? ($instance['pin_image']) : '';
		$widget_id = isset( $instance['widget_id'] ) ? (int) ($instance['widget_id']) : '';

		echo wp_kses( $before_widget, array( 'aside' => array( 'class' => array(), 'id' => array() ) ) );
		?>


		<div class="ztl-widget-contact-<?php echo esc_attr( $widget_id ); ?> ztl-widget-contact-container">
			<div class="container">
				<div class="row">
					<div class="col-sm-4 col-xs-12">
						<div class="title"><?php echo esc_attr( $title ); ?></div>
						<div class="clear20"></div>
						<?php echo do_shortcode( $contact_form_shortcode ); ?>
						<div class="clear"></div>
					</div>
					<div class="col-sm-8 col-xs-12">
						<div class="address"><span class="flaticon-shapes"></span> <?php echo esc_html( $address ); ?></div>
						<div class="clear20"></div>
						<div id="map-canvas-<?php echo esc_attr( $widget_id );?>" class="ztl-map"></div>
					</div>
				</div>
			</div>
		</div>


	    <script type="text/javascript">
			(function($){
				'use strict';
				var map;
				var mapId = 'kiddie_style';
				
				function initialize() {

					var featureOpts = [
					   {
					      "featureType":"landscape.man_made",
					      "elementType":"geometry",
					      "stylers":[
					         {
					            "visibility":"on"
					         },
					         {
					            "color":"<?php echo esc_js( $map_color ); ?>"
					         }
					      ]
					   },
					   {
					   	"featureType": "poi",
					   	"elementType": "labels",
					   	"stylers": [
						   	{
						   		"visibility": "off"
						   	}
					   	]
					   },
					];
									
					var mapOptions = {
						zoom: <?php echo esc_js( $zoom ); ?>,
						center: new google.maps.LatLng(<?php echo esc_js( $coordinates ); ?>),
						mapTypeId: mapId,
						scaleControl: true,
						streetViewControl: false,
						mapTypeControl: false,
						panControl: false,
						zoomControl: true,
						scrollwheel: false,
						draggable:false,
					};
					map = new google.maps.Map(document.getElementById('map-canvas-<?php echo esc_js( $widget_id ); ?>'), mapOptions);
					
					var customMapType = new google.maps.StyledMapType(featureOpts);

					map.mapTypes.set(mapId, customMapType);

					var mapImage =  "<?php echo esc_js( $pin_image ); ?>";
					
					//add custom marker
					var marker = new google.maps.Marker({
					  position: map.getCenter(),
					  map: map,
					  icon: mapImage
					});
					
					google.maps.event.addDomListener(window, 'resize', function() {
						map.setCenter(mapOptions.center);
					});

					map.addListener('bounds_changed', function() {
                        map.setCenter(mapOptions.center);
                    });
					
				}	
				$(document).ready(function(){
					google.maps.event.addDomListener(window, 'load', initialize);
				});

				
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
		$instance['contact_form_shortcode'] = strip_tags( $new_instance['contact_form_shortcode'] );
		$instance['input_fields_background_color'] = strip_tags( $new_instance['input_fields_background_color'] );
		$instance['placeholder_and_text_color'] = strip_tags( $new_instance['placeholder_and_text_color'] );
		$instance['address'] = strip_tags( $new_instance['address'] );
		$instance['widget_id'] = isset( $this->number ) ? (int) ($this->number) : 0;
		$instance['pin_image'] = strip_tags( $new_instance['pin_image'] );
		$instance['coordinates'] = strip_tags( $new_instance['coordinates'] );
		$instance['zoom'] = strip_tags( $new_instance['zoom'] );
		$instance['map_color'] = strip_tags( $new_instance['map_color'] );

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
			'title' => 'Quick Contact',
				  'background_color' => '#87572D', // light brown
				  'contact_form_shortcode' => '[contact-form-7 id="5" title="Contact form 1"]',
				  'input_fields_background_color' => '#704825',
				  'placeholder_and_text_color' => '#ffd823',
				  'address' => '12-14 Greenwich Road SE10 8JA London',
				  'pin_image' => get_template_directory_uri() . '/images/pin.png',
				  'coordinates' => '51.497360, -0.163348',
				  'zoom' => 16,
				  'map_color' => '#b8d478',
				  )
		);

		$title = isset( $instance['title'] ) ? ( $instance['title'] ) : '';
		$background_color = isset( $instance['background_color'] ) ? ( $instance['background_color'] ) : '';
		$contact_form_shortcode = isset( $instance['contact_form_shortcode'] ) ? ( $instance['contact_form_shortcode'] ) : '';
		$input_fields_background_color = isset( $instance['input_fields_background_color'] ) ? ( $instance['input_fields_background_color'] ) : '';
		$placeholder_and_text_color = isset( $instance['placeholder_and_text_color'] ) ? ( $instance['placeholder_and_text_color'] ) : '';
		$address = isset( $instance['address'] ) ? ( $instance['address'] ) : '';
		$pin_image = isset( $instance['pin_image'] ) ? ( $instance['pin_image'] ) : '';
		$coordinates = isset( $instance['coordinates'] ) ? ( $instance['coordinates'] ) : '';
		$zoom = isset( $instance['zoom'] ) ? ( $instance['zoom'] ) : '';
		$map_color = isset( $instance['map_color'] ) ? ( $instance['map_color'] ) : '';

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
      		<label for="<?php echo esc_attr( $this->get_field_id( 'contact_form_shortcode' ) ); ?>"><?php esc_html_e( 'Contact form 7 shortcode','kiddie' ); ?></label>
      		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'contact_form_shortcode' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'contact_form_shortcode' ) ); ?>" type="text" value="<?php echo esc_attr( $contact_form_shortcode ); ?>" />
    	</p>

    	<p>
      		<label for="<?php echo esc_attr( $this->get_field_id( 'address' ) ); ?>"><?php esc_html_e( 'Address','kiddie' ); ?></label>
      		<textarea rows="5" cols="10" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'address' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'address' ) ); ?>"><?php echo esc_textarea( $address ); ?></textarea>
    	</p>

    	<p>
    		<label for="<?php echo esc_attr( $this->get_field_id( 'background_color' ) ); ?>" style="display:block;"><?php esc_html_e( 'Widget background color', 'kiddie' ); ?></label>
    		<input class="widefat color-picker" id="<?php echo esc_attr( $this->get_field_id( 'background_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'background_color' ) ); ?>" type="text" value="<?php echo esc_attr( $background_color ); ?>" />
		</p>

		<p>
    		<label for="<?php echo esc_attr( $this->get_field_id( 'placeholder_and_text_color' ) ); ?>" style="display:block;"><?php esc_html_e( 'Send button color', 'kiddie' ); ?></label>
    		<input class="widefat color-picker" id="<?php echo esc_attr( $this->get_field_id( 'placeholder_and_text_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'placeholder_and_text_color' ) ); ?>" type="text" value="<?php echo esc_attr( $placeholder_and_text_color ); ?>" />
		</p>

		<p>
    		<label for="<?php echo esc_attr( $this->get_field_id( 'input_fields_background_color' ) ); ?>" style="display:block;"><?php esc_html_e( 'Input fields background color', 'kiddie' ); ?></label>
    		<input class="widefat color-picker" id="<?php echo esc_attr( $this->get_field_id( 'input_fields_background_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'input_fields_background_color' ) ); ?>" type="text" value="<?php echo esc_attr( $input_fields_background_color ); ?>" />
		</p>

		<p>
      		<label for="<?php echo esc_attr( $this->get_field_id( 'coordinates' ) ); ?>"><?php esc_html_e( 'Google coordinates: latitude, longitude','kiddie' ); ?></label>
      		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'coordinates' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'coordinates' ) ); ?>" type="text" value="<?php echo esc_attr( $coordinates ); ?>" />
    	</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'pin_image' ) ); ?>"><?php esc_html_e( 'Pin image', 'kiddie' ); ?>:</label>
			<br>
			<!-- Image Thumbnail -->
			<img class="custom_media_image" src="<?php echo esc_url( $pin_image ); ?>" style="max-width:100px; float:left; margin: 0px 10px 0px 0px; display:inline-block;" />
			<input class="custom_media_url" id="" type="text" name="<?php echo esc_attr( $this->get_field_name( 'pin_image' ) ); ?>" value="<?php echo esc_attr( $pin_image ); ?>" style="margin-bottom:10px; clear:right;">
			<a href="#" class="button widget_img"><?php esc_html_e( 'Add Image', 'kiddie' ); ?></a>
			<div style=" clear:both;"></div>
		</p>

		<p>
      		<label for="<?php echo esc_attr( $this->get_field_id( 'zoom' ) ); ?>"><?php esc_html_e( 'Map zoom (default 16)','kiddie' ); ?></label>
      		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'zoom' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'zoom' ) ); ?>" type="text" value="<?php echo esc_attr( $zoom ); ?>" />
    	</p>

    	<p>
    		<label for="<?php echo esc_attr( $this->get_field_id( 'map_color' ) ); ?>" style="display:block;"><?php esc_html_e( 'Map color', 'kiddie' ); ?></label>
    		<input class="widefat color-picker" id="<?php echo esc_attr( $this->get_field_id( 'map_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'map_color' ) ); ?>" type="text" value="<?php echo esc_attr( $map_color ); ?>" />
		</p>
		<hr />
		
    <?php
	}
}
