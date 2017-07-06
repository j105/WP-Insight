<?php
/**
 * Kiddie info circles widget
 *
 * @package Kiddie
 */

// Load and register widget
add_action( 'widgets_init', function() {
	register_widget( 'Kiddie_Circles_Widget' );
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_script( 'underscore' );
	wp_enqueue_style( 'admin_custom', get_template_directory_uri() . '/css/widgets.css' );
});

// Kiddie circles widget
class Kiddie_Circles_Widget extends WP_Widget {

	/**
	 * Sets up the widget
	 */
	function __construct() {
		parent::__construct(
			'kiddie_circles_widget',
			esc_html__( 'Kiddie Circles Widget', 'kiddie' ),
			array(
				'description' => esc_html__( 'Info boxes (4 items) for homepage and above footer sidebar.', 'kiddie' ),
			)
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

		// these are our widget options, everything is escaped before print also default is set
		$title = apply_filters( 'widget_title', isset( $instance['title'] ) ? ( $instance['title']) : '' );

		$title_circle_1 = isset( $instance['title_circle_1'] ) ? ( $instance['title_circle_1'] ) : '';
		$title_circle_2 = isset( $instance['title_circle_2'] ) ? ( $instance['title_circle_2'] ) : '';
		$title_circle_3 = isset( $instance['title_circle_3'] ) ? ( $instance['title_circle_3'] ) : '';
		$title_circle_4 = isset( $instance['title_circle_4'] ) ? ( $instance['title_circle_4'] ) : '';

		$color_circle_1 = isset( $instance['color_circle_1'] ) ? ( $instance['color_circle_1'] ) : '';
		$color_circle_2 = isset( $instance['color_circle_2'] ) ? ( $instance['color_circle_2'] ) : '';
		$color_circle_3 = isset( $instance['color_circle_3'] ) ? ( $instance['color_circle_3'] ) : '';
		$color_circle_4 = isset( $instance['color_circle_4'] ) ? ( $instance['color_circle_4'] ) : '';

		$image_circle_1 = isset( $instance['image_circle_1'] ) ? ( $instance['image_circle_1'] ) : '';
		$image_circle_2 = isset( $instance['image_circle_2'] ) ? ( $instance['image_circle_2'] ) : '';
		$image_circle_3 = isset( $instance['image_circle_3'] ) ? ( $instance['image_circle_3'] ) : '';
		$image_circle_4 = isset( $instance['image_circle_4'] ) ? ( $instance['image_circle_4'] ) : '';

		$description_circle_1 = isset( $instance['description_circle_1'] ) ? ( $instance['description_circle_1'] ) : '';
		$description_circle_2 = isset( $instance['description_circle_2'] ) ? ( $instance['description_circle_2'] ) : '';
		$description_circle_3 = isset( $instance['description_circle_3'] ) ? ( $instance['description_circle_3'] ) : '';
		$description_circle_4 = isset( $instance['description_circle_4'] ) ? ( $instance['description_circle_4'] ) : '';

		echo wp_kses( $before_widget, array( 'aside' => array( 'class' => array(), 'id' => array() ) ) );
		?>
		<div class="container ztl-widget-circles">
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
				<div class="col-sm-3 col-xs-12 item">
					<div class="ztl-widget-circle" <?php if ( $color_circle_1 ) : ?>style="background-color:<?php echo esc_attr( $color_circle_1 ); ?>; color:<?php echo esc_attr( $color_circle_1 ); ?>;"<?php endif; ?>>
						<img src="<?php echo esc_url( $image_circle_1 ); ?>" alt="circle image"/>
						<div class="ztl-item-circle-edge" style="box-shadow: 0 0 0 4px <?php echo esc_attr( $color_circle_1 ); ?>;">
						</div>
					</div>
					<div class="ztl-widget-circle-title" style="color:<?php echo esc_attr( $color_circle_1 ); ?>">
						<?php echo esc_html( $title_circle_1 ); ?>
					</div>
					<div class="ztl-widget-circle-description">
						<?php echo esc_html( $description_circle_1 ); ?>
					</div>
				</div>

				<div class="col-sm-3 col-xs-12 item">
					<div class="ztl-widget-circle" <?php if ( $color_circle_2 ) : ?>style="background-color:<?php echo esc_attr( $color_circle_2 ); ?>; color:<?php echo esc_attr( $color_circle_2 ); ?>;"<?php endif; ?>>
						<img src="<?php echo esc_url( $image_circle_2 ); ?>" alt="circle image"/>
						<div class="ztl-item-circle-edge" style="box-shadow: 0 0 0 4px <?php echo esc_attr( $color_circle_2 ); ?>;">
						</div>
					</div>
					<div class="ztl-widget-circle-title" style="color:<?php echo esc_attr( $color_circle_2 ); ?>">
						<?php echo esc_html( $title_circle_2 ); ?>
					</div>
					<div class="ztl-widget-circle-description">
						<?php echo esc_html( $description_circle_2 ); ?>
					</div>
				</div>

				<div class="col-sm-3 col-xs-12 item">
					<div class="ztl-widget-circle"
					    <?php if ( $color_circle_3 ) : ?>style="background-color:<?php echo esc_attr( $color_circle_3 ); ?>; color:<?php echo esc_attr( $color_circle_3 ); ?>;"<?php endif; ?>>
						<img src="<?php echo esc_url( $image_circle_3 ); ?>" alt="circle image"/>
						<div class="ztl-item-circle-edge" style="box-shadow: 0 0 0 4px <?php echo esc_attr( $color_circle_3 ); ?>;">
						</div>
					</div>
					<div class="ztl-widget-circle-title" style="color:<?php echo esc_attr( $color_circle_3 ); ?>">
						<?php echo esc_html( $title_circle_3 ); ?>
					</div>
					<div class="ztl-widget-circle-description">
						<?php echo esc_html( $description_circle_3 ); ?>
					</div>
				</div>
				<div class="col-sm-3 col-xs-12 item">
					<div class="ztl-widget-circle" <?php if ( $color_circle_4 ) : ?>style="background-color:<?php echo esc_attr( $color_circle_4 ); ?>; color:<?php echo  esc_attr( $color_circle_4 ); ?>;"<?php endif; ?>>
						<img src="<?php echo esc_url( $image_circle_4 ); ?>" alt="circle image"/>
						<div class="ztl-item-circle-edge" style="box-shadow: 0 0 0 4px <?php echo esc_attr( $color_circle_4 ); ?>;">
						</div>
					</div>
					<div class="ztl-widget-circle-title" style="color:<?php echo esc_attr( $color_circle_4 ); ?>">
						<?php echo esc_html( $title_circle_4 ); ?>
					</div>
					<div class="ztl-widget-circle-description">
						<?php echo esc_html( $description_circle_4 ); ?>
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
		$instance['title_circle_1'] = strip_tags( $new_instance['title_circle_1'] );
		$instance['color_circle_1'] = strip_tags( $new_instance['color_circle_1'] );
		$instance['image_circle_1'] = strip_tags( $new_instance['image_circle_1'] );
		$instance['description_circle_1'] = strip_tags( $new_instance['description_circle_1'] );

		$instance['title_circle_2'] = strip_tags( $new_instance['title_circle_2'] );
		$instance['color_circle_2'] = strip_tags( $new_instance['color_circle_2'] );
		$instance['image_circle_2'] = strip_tags( $new_instance['image_circle_2'] );
		$instance['description_circle_2'] = strip_tags( $new_instance['description_circle_2'] );

		$instance['title_circle_3'] = strip_tags( $new_instance['title_circle_3'] );
		$instance['color_circle_3'] = strip_tags( $new_instance['color_circle_3'] );
		$instance['image_circle_3'] = strip_tags( $new_instance['image_circle_3'] );
		$instance['description_circle_3'] = strip_tags( $new_instance['description_circle_3'] );

		$instance['title_circle_4'] = strip_tags( $new_instance['title_circle_4'] );
		$instance['color_circle_4'] = strip_tags( $new_instance['color_circle_4'] );
		$instance['image_circle_4'] = strip_tags( $new_instance['image_circle_4'] );
		$instance['description_circle_4'] = strip_tags( $new_instance['description_circle_4'] );
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
				'title' => 'Why Love Us',
				'title_circle_1' => 'Great Teachers',
				'title_circle_2' => 'Delicious Meals',
				'title_circle_3' => 'Excellent Programmes',
				'title_circle_4' => 'Funny Games',
				'color_circle_1' => '#f25141',
				'color_circle_2' => '#ffd823',
				'color_circle_3' => '#93c524',
				'color_circle_4' => '#28a8e3',
				'image_circle_1' => get_template_directory_uri() . '/images/valentines16.png',
				'image_circle_2' => get_template_directory_uri() . '/images/baby152.png',
				'image_circle_3' => get_template_directory_uri() . '/images/kids2.png',
				'image_circle_4' => get_template_directory_uri() . '/images/babytoy14.png',
				'description_circle_1' => 'Da natum timeam ius. Sed mazim essent recusabo ei, eum et senserit reformi. Eos legere aperiri facilisi in.',
				'description_circle_2' => 'Da natum timeam ius. Sed mazim essent recusabo ei, eum et senserit reformi. Eos legere aperiri facilisi in.',
				'description_circle_3' => 'Da natum timeam ius. Sed mazim essent recusabo ei, eum et senserit reformi. Eos legere aperiri facilisi in.',
				'description_circle_4' => 'Da natum timeam ius. Sed mazim essent recusabo ei, eum et senserit reformi. Eos legere aperiri facilisi in',

			)
		);

		$title = isset( $instance['title'] ) ? ( $instance['title'] ) : '';
		$title_circle_1 = isset( $instance['title_circle_1'] ) ? ( $instance['title_circle_1'] ) : '';
		$color_circle_1 = isset( $instance['color_circle_1'] ) ? ( $instance['color_circle_1'] ) : '';
		$image_circle_1 = isset( $instance['image_circle_1'] ) ? ( $instance['image_circle_1'] ) : '';
		$description_circle_1 = isset( $instance['description_circle_1'] ) ? ( $instance['description_circle_1'] ) : '';

		$title_circle_2 = isset( $instance['title_circle_2'] ) ? ( $instance['title_circle_2'] ) : '';
		$color_circle_2 = isset( $instance['color_circle_2'] ) ? ( $instance['color_circle_2'] ) : '';
		$image_circle_2 = isset( $instance['image_circle_2'] ) ? ( $instance['image_circle_2'] ) : '';
		$description_circle_2 = isset( $instance['description_circle_2'] ) ? ($instance['description_circle_2']) : '';

		$title_circle_3 = isset( $instance['title_circle_3'] ) ? ( $instance['title_circle_3'] ) : '';
		$color_circle_3 = isset( $instance['color_circle_3'] ) ? ( $instance['color_circle_3'] ) : '';
		$image_circle_3 = isset( $instance['image_circle_3'] ) ? ( $instance['image_circle_3'] ) : '';
		$description_circle_3 = isset( $instance['description_circle_3'] ) ? ( $instance['description_circle_3'] ) : '';

		$title_circle_4 = isset( $instance['title_circle_4'] ) ? ( $instance['title_circle_4'] ) : '';
		$color_circle_4 = isset( $instance['color_circle_4'] ) ? ( $instance['color_circle_4'] ) : '';
		$image_circle_4 = isset( $instance['image_circle_4'] ) ? ( $instance['image_circle_4'] ) : '';
		$description_circle_4 = isset( $instance['description_circle_4'] ) ? ( $instance['description_circle_4'] ) : '';
		?>

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
					$('#widgets-right .widget:has(.color-picker)').each(function() {
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

				$(document).on('widget-added widget-updated', onFormUpdate);

			}(jQuery));

		</script>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Widget Title','kiddie' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>

		<hr />

		<p><strong><?php esc_html_e( 'First circle settings','kiddie' )?></strong></p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title_circle_1' ) ); ?>"><?php esc_html_e( 'Title:','kiddie' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_circle_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_circle_1' ) ); ?>" type="text" value="<?php echo esc_attr( $title_circle_1 ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'description_circle_1' ) ); ?>"><?php esc_html_e( 'Description:','kiddie' ); ?></label>
			<textarea rows="5" cols="10" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'description_circle_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description_circle_1' ) ); ?>"><?php echo esc_textarea( $description_circle_1 ); ?></textarea>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'color_circle_1' ) ); ?>" style="display:block;"><?php esc_html_e( 'Color:','kiddie' ); ?></label>
			<input class="widefat color-picker" id="<?php echo esc_attr( $this->get_field_id( 'color_circle_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'color_circle_1' ) ); ?>" type="text" value="<?php echo esc_attr( $color_circle_1 ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'image_circle_1' ) ); ?>"><?php esc_html_e( 'Image', 'kiddie' ); ?>:</label>
			<br>
			<!-- Image Thumbnail -->
			<img class="custom_media_image" src="<?php echo esc_url( $image_circle_1 ); ?>" style="max-width:100px; float:left; margin: 0 10px 0 0; display:inline-block;" />
			<input class="custom_media_url" id="" type="text" name="<?php echo esc_attr( $this->get_field_name( 'image_circle_1' ) ); ?>" value="<?php echo esc_url( $image_circle_1 ); ?>" style="margin-bottom:10px; clear:right;">
			<a href="#" class="button widget_img"><?php esc_html_e( 'Add Image', 'kiddie' ); ?></a>
		<div style=" clear:both;"></div>
		</p>

		<hr />
		<!-- 2 -->
		<p><strong><?php esc_html_e( 'Second circle settings','kiddie' )?></strong></p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title_circle_2' ) ); ?>"><?php esc_html_e( 'Title:','kiddie' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_circle_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_circle_2' ) ); ?>" type="text" value="<?php echo esc_attr( $title_circle_2 ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'description_circle_2' ) ); ?>"><?php esc_html_e( 'Description:','kiddie' ); ?></label>
			<textarea rows="5" cols="10" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'description_circle_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description_circle_2' ) ); ?>"><?php echo esc_textarea( $description_circle_2 ); ?></textarea>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'color_circle_2' ) ); ?>" style="display:block;"><?php esc_html_e( 'Color:','kiddie' ); ?></label>
			<input class="widefat color-picker" id="<?php echo esc_attr( $this->get_field_id( 'color_circle_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'color_circle_2' ) ); ?>" type="text" value="<?php echo esc_attr( $color_circle_2 ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'image_circle_2' ) ); ?>"><?php esc_html_e( 'Image', 'kiddie' ); ?>:</label>
			<br>
			<!-- Image Thumbnail -->
			<img class="custom_media_image" src="<?php echo esc_url( $image_circle_2 ); ?>" style="max-width:100px; float:left; margin: 0px     10px 0px 0px; display:inline-block;" />
			<input class="custom_media_url" id="" type="text" name="<?php echo esc_attr( $this->get_field_name( 'image_circle_2' ) ); ?>" value="<?php echo esc_attr( $image_circle_2 ); ?>" style="margin-bottom:10px; clear:right;">
			<a href="#" class="button widget_img"><?php esc_html_e( 'Add Image', 'kiddie' ); ?></a>
		<div style=" clear:both;"></div>
		</p>

		<hr />
		<!-- 3 -->
		<p><strong><?php esc_html_e( 'Third circle settings','kiddie' )?></strong></p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title_circle_3' ) ); ?>"><?php esc_html_e( 'Title:','kiddie' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_circle_3' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_circle_3' ) ); ?>" type="text" value="<?php echo esc_attr( $title_circle_3 ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'description_circle_3' ) ); ?>"><?php esc_html_e( 'Description:','kiddie' ); ?></label>
			<textarea rows="5" cols="10" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'description_circle_3' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description_circle_3' ) ); ?>"><?php echo esc_textarea( $description_circle_3 ); ?></textarea>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'color_circle_3' ) ); ?>" style="display:block;"><?php esc_html_e( 'Color:', 'kiddie' ); ?></label>
			<input class="widefat color-picker" id="<?php echo esc_attr( $this->get_field_id( 'color_circle_3' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'color_circle_3' ) ); ?>" type="text" value="<?php echo esc_attr( $color_circle_3 ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'image_circle_3' ) ); ?>"><?php esc_html_e( 'Image', 'kiddie' ); ?>:</label>
			<br>
			<!-- Image Thumbnail -->
			<img class="custom_media_image" src="<?php echo  esc_url( $image_circle_3 ); ?>" style="max-width:100px; float:left; margin: 0px 10px 0px 0px; display:inline-block;" />
			<input class="custom_media_url" id="" type="text" name="<?php echo esc_attr( $this->get_field_name( 'image_circle_3' ) ); ?>" value="<?php echo esc_attr( $image_circle_3 ); ?>" style="margin-bottom:10px; clear:right;">
			<a href="#" class="button widget_img"><?php esc_html_e( 'Add Image', 'kiddie' ); ?></a>
		<div style=" clear:both;"></div>
		</p>

		<hr />
		<!-- 4 -->
		<p><strong><?php esc_html_e( 'Fourth circle settings','kiddie' )?></strong></p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title_circle_4' ) ); ?>"><?php esc_html_e( 'Title:','kiddie' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_circle_4' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_circle_4' ) ); ?>" type="text" value="<?php echo esc_attr( $title_circle_4 ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'description_circle_4' ) ); ?>"><?php esc_html_e( 'Description:','kiddie' ); ?></label>
			<textarea rows="5" cols="10" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'description_circle_4' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description_circle_4' ) ); ?>"><?php echo esc_textarea( $description_circle_4 ); ?></textarea>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'color_circle_4' ) ); ?>" style="display:block;"><?php esc_html_e( 'Color:', 'kiddie' ); ?></label>
			<input class="widefat color-picker" id="<?php echo esc_attr( $this->get_field_id( 'color_circle_4' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'color_circle_4' ) ); ?>" type="text" value="<?php echo esc_attr( $color_circle_4 ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'image_circle_4' ) ); ?>"><?php esc_html_e( 'Image', 'kiddie' ); ?>:</label>
			<br>
			<!-- Image Thumbnail -->
			<img class="custom_media_image" src="<?php echo esc_url( $image_circle_4 ); ?>" style="max-width:100px; float:left; margin: 0px 10px 0px 0px; display:inline-block;" />
			<input class="custom_media_url" id="" type="text" name="<?php echo esc_attr( $this->get_field_name( 'image_circle_4' ) ); ?>" value="<?php echo esc_attr( $image_circle_4 ); ?>" style="margin-bottom:10px; clear:right;">
			<a href="#" class="button widget_img"><?php esc_html_e( 'Add Image', 'kiddie' ); ?></a>
		<div style=" clear:both;"></div>
		</p>
		<hr />
		<br />

		<?php
	}
}
