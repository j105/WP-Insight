<?php
/**
 * Kiddie additional functions and definitions
 *
 * @package Kiddie
 *
 * @param array  $form_fields
 * @param object $post
 * @return array
 */
function kiddie_image_attachment_fields_to_edit( $form_fields, $post ) {
	$form_fields['gallery_filters'] = array(
		'label' => esc_html__( 'Gallery filters','kiddie' ),
		'input' => 'text', // this is default if "input" is omitted
		'value' => get_post_meta( $post->ID, '_gallery_filters', true ),
	);
	// if you will be adding error messages for your field,
	// then in order to not overwrite them, as they are pre-attached
	// to this array, you would need to set the field up like this:
	$form_fields['gallery_filters']['label'] = esc_html__( 'Gallery filters','kiddie' );
	$form_fields['gallery_filters']['input'] = 'text';
	$form_fields['gallery_filters']['value'] = get_post_meta( $post->ID, '_gallery_filters', true );

	return $form_fields;
}
// attach our function to the correct hook
add_filter( 'attachment_fields_to_edit', 'kiddie_image_attachment_fields_to_edit', null, 2 );
/**
 * @param array $post
 * @param array $attachment
 * @return array
 */
function kiddie_image_attachment_fields_to_save( $post, $attachment ) {
	if ( isset( $attachment['gallery_filters'] ) ) {
		update_post_meta( $post['ID'], '_gallery_filters', $attachment['gallery_filters'] );
	}

	return $post;
}
add_filter( 'attachment_fields_to_save','kiddie_image_attachment_fields_to_save', null, 2 );
