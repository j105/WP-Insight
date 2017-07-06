<?php
/**
 * Plugin Name: Kiddie Custom Content
 * Plugin URI: http://zoutula.com
 * Description: This plugin handles Kiddie Theme custom content like staff, testimonials and more. It's activated/deactivated with the theme.
 * Version: 1.1.0
 * Author: Zoutula
 * Author URI: http://zoutula.com
 * Text Domain: kiddie
 * Domain Path: /locale/
 */


function kiddie_custom_data() {

	//Staff custom taxonomy

	$labels = array(
		'name'                       => esc_html(_x( 'Staff','Category name', 'kiddie' )),
		'singular_name'              => esc_html(_x( 'Staff member','Category item', 'kiddie' )),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'add_new_item'               => esc_html__( 'Add Staff Member','kiddie' ),
		'menu_name'                  => esc_html__( 'Staff','kiddie' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => false,
		'show_admin_column'     => true,
		'update_count_callback' => '',
		'query_var'             => true,
	);


	//Staff custom post

	register_post_type( 'kiddie_staff',
	    array(
	      'labels' => $labels,
	      'public' => true,
	      'has_archive' => 'false', //we use a custom template to display the listing
	      'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'excerpt'),
	      'rewrite' => array('slug' => 'staff'),
	      'taxonomies' => array( 'staff'),
	      'menu_icon' =>'dashicons-groups',
	      'exclude_from_search' => 'true',
	    )
	 );

	register_taxonomy('staff','kiddie_staff', $args );


	//Courses custom taxonomy
	
	$labels = array(
		'name'                       => esc_html(_x( 'Courses','Category name', 'kiddie' )),
		'singular_name'              => esc_html(_x( 'Course','Category item', 'kiddie' )),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'add_new_item'               => esc_html__( 'Add Course','kiddie' ),
		'menu_name'                  => esc_html__( 'Courses','kiddie' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => false,
		'show_admin_column'     => true,
		'update_count_callback' => '',
		'query_var'             => true,
	);


	//Course custom post

	register_post_type( 'kiddie_course',
	    array(
	      'labels' => $labels,
	      'public' => true,
	      'has_archive' => 'false', //we use a custom template to display the listing
	      'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields','excerpt'),
	      'rewrite' => array('slug' => 'course'),
	      'taxonomies' => array( 'course'),
	      'menu_icon' =>'dashicons-id-alt',
	      'exclude_from_search' => 'true',
	    )
	 );

	register_taxonomy('course','kiddie_course', $args );
	



	//Testimonials items

	$labels = array(
		'name'                       => esc_html(_x( 'Testimonials','Category name', 'kiddie' )),
		'singular_name'              => esc_html(_x( 'Testimonial','Category item', 'kiddie' )),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'add_new_item'               => esc_html__( 'Add Testimonial','kiddie' ),
		'menu_name'                  => esc_html__( 'Testimonials','kiddie' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => false,
		'show_admin_column'     => true,
		'update_count_callback' => '',
		'query_var'             => true,
		
	);
	

	//Testimonial custom post

	register_post_type( 'kiddie_testimonial',
	    array(
	      'labels' => $labels,
	      'public' => true,
	      'has_archive' => true,
	      'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields'),
	      'rewrite' => array('slug' => 'testimonials'),
	      'taxonomies' => array( 'testimonials'),
	      'menu_icon' =>'dashicons-format-status',
	      'exclude_from_search' => 'true',
	    )
	 );

	register_taxonomy('testimonial','kiddie_testimonial', $args );

}

add_action('init','kiddie_custom_data');
