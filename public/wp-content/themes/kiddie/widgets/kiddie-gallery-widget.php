<?php
/**
 * Kiddie gallery widget
 *
 * @package Kiddie
 */

add_action('widgets_init', function(){
	register_widget( 'Kiddie_Gallery_Widget' );
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_script( 'underscore' );
});

// Kiddie gallery widget
class Kiddie_Gallery_Widget extends WP_Widget {
	/**
	 * Sets up the widget
	 */
	function __construct() {
		parent::__construct(
			'kiddie_gallery_widget', // Base ID
			esc_html__( 'Kiddie Gallery Widget', 'kiddie' ), // Name
			array( 'description' => esc_html__( 'Gallery box for homepage and above footer sidebar.', 'kiddie' ) ) // Args
		);

		if ( is_active_widget( '', '', 'kiddie_gallery_widget' ) ) {
			// add carousel js and css
			add_action('wp_enqueue_scripts', function(){
				$gallery_widget = new Kiddie_Gallery_Widget();
				$settings = $gallery_widget->get_settings();
				if ( $settings ) {
					foreach ( $settings as $setting ) {
						if ( isset( $setting['widget_id'] ) && ! empty( $setting['widget_id'] ) ) {
							$css = '    .ztl-widget-gallery-' . $setting['widget_id'] . ' .item-isotope a .icon-gallery{color: ' . $setting['overlay_gallery_icon_color'] . '}';
							wp_add_inline_style( 'kiddie-style', wp_strip_all_tags ( $css ) );
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
		$overlay_gallery_icon_color = isset( $instance['overlay_gallery_icon_color'] ) ? ($instance['overlay_gallery_icon_color']) : '';
		$gallery_ids = explode( ',',isset( $instance['product_gallery_ids'] ) ? ($instance['product_gallery_ids']) : '' );
		$widget_id = isset( $instance['widget_id'] ) ? (int) ($instance['widget_id']) : 0;

		echo wp_kses( $before_widget, array( 'aside' => array( 'class' => array(), 'id' => array() ) ) );
		?>
		<div class="ztl-widget-gallery-container ztl-widget-gallery-<?php echo esc_attr( $widget_id ); ?>">
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
					<div class="col-xs-12 ztl-widget-description ztl-widget-description-dark"><?php echo esc_html( $description ); ?></div>
                </div>
            </div>
            <div class="clear"></div>
            <div class="container">
				<?php
				if ( ! empty( $gallery_ids ) ) {
					foreach ( $gallery_ids as $id ) {
						$img_src = wp_get_attachment_image_src( $id, 'full' );
						echo '<div class="item-isotope col-sm-3">';
						echo '<a class="grouped_elements" href="' . esc_url( $img_src['0'] ) . '" data-rel="prettyPhoto[' . esc_attr( $widget_id ) . ']">';
						echo '<div class="item-isotope-cover"></div>';
						echo '<span class="icon-gallery"><span class="flaticon-picture31"></span></span>';
						echo wp_get_attachment_image( $id, 'kiddie-4-3' );
						echo '</a>';
						echo '</div>';
					}
				}
				?>
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
		$instance['description'] = strip_tags( $new_instance['description'] );
		$instance['overlay_gallery_icon_color'] = strip_tags( $new_instance['overlay_gallery_icon_color'] );
		$instance['product_gallery_ids'] = strip_tags( $new_instance['product_gallery_ids'] );
		$all_img_ids = explode( ',',$instance['product_gallery_ids'] );
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
			'title' => 'Our Gallery',
					'description' => 'Saperet scriptorem at duo. Erat maiorum quo ut. Te est sint pertinacia. Nec ceteros corpora no, mundi blandit ullamcorper ex pri. Aperiam abhorreant mei te, has dicta fierent eu.',
					'overlay_gallery_icon_color' => '#fff', // white default
					'product_gallery_ids' => '0',
					)
		);

		$title = isset( $instance['title'] ) ? ($instance['title']) : '';
		$description = isset( $instance['description'] ) ? ($instance['description']) : '';
		$overlay_gallery_icon_color = isset( $instance['overlay_gallery_icon_color'] ) ? ($instance['overlay_gallery_icon_color']) : '';
		$product_gallery_ids = isset( $instance['product_gallery_ids'] ) ? $instance['product_gallery_ids'] : '';
		?>

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
    		<label for="<?php echo esc_attr( $this->get_field_id( 'overlay_gallery_icon_color' ) ); ?>" style="display:block;"><?php esc_html_e( 'Gallery icon color:', 'kiddie' ); ?></label>
    		<input class="widefat color-picker" id="<?php echo esc_attr( $this->get_field_id( 'overlay_gallery_icon_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'overlay_gallery_icon_color' ) ); ?>" type="text" value="<?php echo esc_attr( $overlay_gallery_icon_color ); ?>" />
        </p>
        <hr />

        <p>
			<strong><?php esc_html_e( 'Gallery','kiddie' ); ?></strong>
        </p>
        <p>
			<?php
				$all_img_ids = explode( ',',$product_gallery_ids );

				// delete dummy data if needed
			if ( 0 == $all_img_ids[0] ) {
				unset( $all_img_ids[0] );
			}

			foreach ( $all_img_ids as $id ) {

				${'image_' . $id . '_filters'} = isset( $instance[ 'image_' . $id . '_filters' ] ) ? $instance[ 'image_' . $id . '_filters' ] : '';
				echo '<p>';
				echo '<center>' . wp_get_attachment_image( $id ) . '</center>'; ?>
				<?php
				echo '</p>';
			}
			?>
        </p>

        <p> 
			<a href="#" class="button manage_widget_gallery"><?php esc_html_e( 'Add/Edit gallery', 'kiddie' ); ?></a>
			<input type="hidden" id="<?php echo esc_attr( $this->get_field_id( 'product_gallery_ids' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'product_gallery_ids' ) ); ?>" class="product_gallery_ids" value="<?php echo esc_attr( $product_gallery_ids ); ?>" />
        </p>        
        <hr />

        <script type="text/javascript">
            (function($){
                'use strict';

                $(document).ready(function(){ 

                    //color picker
                    $('#widgets-right .widget:has(.color-picker)').each(function(){
                        initColorPicker($( this ));
                    });                 
        
                    //gallery manager
                    $('#widgets-right .manage_widget_gallery').unbind('click').bind('click', function () {
                 
                        // Create the shortcode from the current ids in the hidden field
                        var gallerysc = '[gallery ids="' + $('#widgets-right .product_gallery_ids').val() + '"]';
                        // Open the gallery with the shortcode and bind to the update event
                        wp.media.gallery.edit(gallerysc).on('update', function(g) {
                            // We fill the array with all ids from the images in the gallery
                            var id_array = [];
                            $.each(g.models, function(id, img) { id_array.push(img.id); });
                           // Make comma separated list from array and set the hidden value
                            $('#widgets-right .product_gallery_ids').val(id_array.join(","));
                            // On the next post this field will be send to the save hook in WP
                        });                         
                    });
            
                });


                function initColorPicker (widget) {
                    widget.find('.color-picker').wpColorPicker({
                        change: _.throttle(function(){ // For Customizer
                            $(this).trigger('change');
                        }, 3000)
                    });
                }

                function onFormUpdate (event, widget) {
                    initColorPicker(widget);
                }

                $(document).on('widget-added widget-updated', onFormUpdate);

            }(jQuery));
        </script>       
    <?php
	}
}
