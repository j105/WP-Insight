<?php
/**
 *
 * Contains metaboxex definitions
 *
 * @package Kiddie
 */


//
// Custom color -> staff
//
function kiddie_staff_color_add_meta_box() {

	$screens = array( 'kiddie_staff' );

	foreach ( $screens as $screen ) {
		add_meta_box( 'kiddie_color_box_staff_id',  esc_html__( 'Representative Color', 'kiddie' ), 'kiddie_staff_color_add_meta_box_callback', $screen, 'side' );
	}
}
add_action( 'add_meta_boxes', 'kiddie_staff_color_add_meta_box' );



function kiddie_staff_color_add_meta_box_callback( $post ) {
	wp_nonce_field( 'kiddie_meta_box', 'kiddie_meta_box_nonce' );
	$kiddie_staff_color = get_post_meta( $post->ID, 'kiddie_staff_color', true );
	if ( empty( $kiddie_staff_color ) ) {
		$kiddie_staff_color = '#ffd823'; // theme yellow
	}
	?>
	<div class="custom_meta_box">
	<p>
	<label> <?php echo esc_html__( 'Select representative color:','kiddie' ); ?> </label> <br />
	<input class="color-field" type="text" name="kiddie_staff_color" value="<?php echo esc_attr( $kiddie_staff_color ); ?>"/>
	</p>
	<div class="clear"></div> 
	</div> 
	<script>
	(function( $ ) {
		'use strict';
		// Add Color Picker to all inputs that have 'color-field' class
		$(function() {
		$('.color-field').wpColorPicker();
		});
	})( jQuery );

	</script>
	<?php
}



function kiddie_save_meta_box_staff_color_data( $post_id ) {
	if ( ! isset( $_POST['kiddie_meta_box_nonce'] ) ) { // Input var okay.
		return;
	}

	if ( ! wp_verify_nonce( sanitize_key( $_POST['kiddie_meta_box_nonce'] ), 'kiddie_meta_box' ) ) { // Input var okay.
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['kiddie_staff_color'] ) ) { // Input var okay.
		$kiddie_staff_color = kiddie_sanitize_hex_color( sanitize_text_field( wp_unslash( $_POST['kiddie_staff_color'] ) ) ); // Input var okay.
	}

	update_post_meta( $post_id, 'kiddie_staff_color', $kiddie_staff_color );
}
add_action( 'save_post', 'kiddie_save_meta_box_staff_color_data' );



//
// Sidebar options-> post/page
//
function kiddie_sidebar_options_add_meta_box() {

	$screens = array( 'post' );

	foreach ( $screens as $screen ) {
		add_meta_box( 'kiddie_sidebar_options_id', esc_html__( 'Sidebar options', 'kiddie' ), 'kiddie_sidebar_options_meta_box_callback', $screen , 'side' );
	}

}
add_action( 'add_meta_boxes', 'kiddie_sidebar_options_add_meta_box' );




function kiddie_sidebar_options_meta_box_callback( $post ) {
	wp_nonce_field( 'kiddie_meta_box', 'kiddie_meta_box_nonce' );
	$kiddie_sidebar_option = get_post_meta( $post->ID, 'kiddie_sidebar_option', true );
	if ( empty( $kiddie_sidebar_option ) ) {
		$kiddie_sidebar_option = 'right'; // default right if nothing has been set
	}
	?>
	<div class="custom_meta_box">
	<p>
	<label><?php echo esc_html__( 'Select sidebar position:','kiddie' ); ?> </label> <br />
	<input type="radio" name="kiddie_sidebar_option" <?php if ( 'right' == $kiddie_sidebar_option  ) {echo 'checked'; } ?> value="right">Right<br />
	<input type="radio" name="kiddie_sidebar_option" <?php if ( 'disabled' == $kiddie_sidebar_option  ) {echo 'checked'; } ?> value="disabled">Disabled
	</p>
	<div class="clear"></div> 
	</div> 
	<?php
}


function kiddie_save_sidebar_options( $post_id ) {
	if ( ! isset( $_POST['kiddie_meta_box_nonce'] ) ) { // Input var okay.
		return;
	}

	if ( ! wp_verify_nonce( sanitize_key( $_POST['kiddie_meta_box_nonce'] ), 'kiddie_meta_box' ) ) { // Input var okay.
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$kiddie_sidebar_option = '';
	if ( isset( $_POST['kiddie_sidebar_option'] ) && in_array( wp_unslash( $_POST['kiddie_sidebar_option'] ), array( 'right', 'disabled' ) ) ) { // Input var okay.
		$kiddie_sidebar_option = sanitize_text_field( wp_unslash( $_POST['kiddie_sidebar_option'] ) ); // Input var okay.
	}

	update_post_meta( $post_id, 'kiddie_sidebar_option', $kiddie_sidebar_option );
}
add_action( 'save_post', 'kiddie_save_sidebar_options' );


//
// Header image option
//
function kiddie_header_image_options_add_meta_box() {

	$screens = array( 'page','post' );
	global $post;

	foreach ( $screens as $screen ) {
		if ( ! empty( $post ) ) {
			$page_template = get_post_meta( $post->ID, '_wp_page_template', true );

			if ( 'template-contact-1.php' != $page_template
				&& 'template-contact-2.php' != $page_template
				) {
				add_meta_box( 'kiddie_header_image_options_id', esc_html__( 'Header image', 'kiddie' ), 'kiddie_header_image_options_meta_box_callback', $screen, 'side' );
			}
		}
	}

}
add_action( 'add_meta_boxes', 'kiddie_header_image_options_add_meta_box' );




function kiddie_header_image_options_meta_box_callback( $post ) {
	wp_nonce_field( 'kiddie_meta_box', 'kiddie_meta_box_nonce' );
	$kiddie_header_image_option = get_post_meta( $post->ID, 'kiddie_header_image_option', true );
	if ( empty( $kiddie_header_image_option ) ) {
		$kiddie_header_image_option = 'hidden'; // default right if nothing has been set
	}
	?>
	<div class="custom_meta_box">
		<p>
			<label><?php echo esc_html__( 'Select sidebar position:','kiddie' ); ?> </label> <br />
			<input type="radio" name="kiddie_header_image_option" <?php if ( 'visible' == $kiddie_header_image_option  ) {echo 'checked'; } ?> value="visible">Visible<br />
			<input type="radio" name="kiddie_header_image_option" <?php if ( 'hidden' == $kiddie_header_image_option  ) {echo 'checked'; } ?> value="hidden">Hidden<br />
		</p>
		<div class="clear"></div>
	</div>
	<?php
}


function kiddie_save_header_image_options( $post_id ) {
	if ( ! isset( $_POST['kiddie_meta_box_nonce'] ) ) { // Input var okay.
		return;
	}

	if ( ! wp_verify_nonce( sanitize_key( $_POST['kiddie_meta_box_nonce'] ), 'kiddie_meta_box' ) ) { // Input var okay.
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$kiddie_header_image_option = '';
	if ( isset( $_POST['kiddie_header_image_option'] ) && in_array( wp_unslash( $_POST['kiddie_header_image_option'] ), array( 'visible', 'hidden' ) ) ) { // Input var okay.
		$kiddie_header_image_option = sanitize_text_field( wp_unslash( $_POST['kiddie_header_image_option'] ) ); // Input var okay.

	}

	update_post_meta( $post_id, 'kiddie_header_image_option', $kiddie_header_image_option );
}
add_action( 'save_post', 'kiddie_save_header_image_options' );


//
// Custom color -> courses
//
function kiddie_course_color_add_meta_box() {
	add_meta_box( 'kiddie_color_box_course_id', esc_html__( 'Representative Color', 'kiddie' ), 'kiddie_course_color_add_meta_box_callback', 'kiddie_course', 'side' );
}
add_action( 'add_meta_boxes', 'kiddie_course_color_add_meta_box' );



function kiddie_course_color_add_meta_box_callback( $post ) {
	wp_nonce_field( 'kiddie_meta_box', 'kiddie_meta_box_nonce' );
	$kiddie_course_color = esc_attr( get_post_meta( $post->ID, 'kiddie_course_color', true ) );
	if ( empty( $kiddie_course_color ) ) {
		$kiddie_course_color = '#ffd823'; // theme yellow
	}
	?>
	<div class="custom_meta_box">
	<p>
	<label> <?php esc_html__( 'Select representative color:','kiddie' ); ?> </label> <br />
	<input class="color-field" type="text" name="kiddie_course_color" value="<?php echo esc_attr( $kiddie_course_color ); ?>"/>
	</p>
	<div class="clear"></div> 
	</div> 
	<script>
	(function( $ ) {
		'use strict';
		// Add Color Picker to all inputs that have 'color-field' class
		$(function() {
		$('.color-field').wpColorPicker();
		});
	})( jQuery );

	</script>
	<?php
}



function kiddie_save_meta_box_course_color_data( $post_id ) {
	if ( ! isset( $_POST['kiddie_meta_box_nonce'] ) ) { // Input var okay.
		return;
	}

	if ( ! wp_verify_nonce( sanitize_key( $_POST['kiddie_meta_box_nonce'] ), 'kiddie_meta_box' ) ) { // Input var okay.
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$kiddie_course_color = '';
	if ( isset( $_POST['kiddie_course_color'] ) ) { // Input var okay.
		$kiddie_course_color = kiddie_sanitize_hex_color( sanitize_text_field( wp_unslash( $_POST['kiddie_course_color'] ) ) ); // Input var okay.
	}

	update_post_meta( $post_id, 'kiddie_course_color', $kiddie_course_color );
}
add_action( 'save_post', 'kiddie_save_meta_box_course_color_data' );
