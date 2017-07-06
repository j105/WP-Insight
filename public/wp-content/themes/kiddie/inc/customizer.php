<?php
/**
 * Kiddie Theme Customizer
 *
 * @package Kiddie
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function kiddie_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'kiddie_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function kiddie_customize_preview_js() {
	wp_enqueue_script( 'kiddie_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'kiddie_customize_preview_js' );

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
function kiddie_customizer( $wp_customize ) {

	// Add Theme General Settings *************************
	$wp_customize->add_section(
		'options_general_kiddie',
		array(
			'title' => esc_html__( 'General Settings', 'kiddie' ),
			'description' => esc_html__( 'Structure Settings', 'kiddie' ),
			'priority' => 15,
		)
	);

	/* boxed layout / full width */
	$wp_customize->add_setting(
		'layout_mode' ,
		array(
			'default' => 'full',
			'sanitize_callback' => 'kiddie_sanitize_text',
		)
	);

	$wp_customize->add_control(
		'layout_mode',
		array(
			'label' => esc_html__( 'Site Layout', 'kiddie' ),
			'section' => 'options_general_kiddie',
			'type' => 'radio',
			'choices' => array(
				'full' => esc_html__( 'Full width layout','kiddie' ),
				'boxed' => esc_html__( 'Boxed layout','kiddie' ),
			),
			'priority'   => 10,
		)
	);

	/* boxed layout / full width */
	$wp_customize->add_setting(
		'scroll_to_top' ,
		array(
			'default' => 'yes',
			'sanitize_callback' => 'kiddie_sanitize_text',
		)
	);

	$wp_customize->add_control(
		'scroll_to_top',
		array(
			'label' => esc_html__( 'Scroll to Top Button', 'kiddie' ),
			'section' => 'options_general_kiddie',
			'type' => 'radio',
			'choices' => array(
				'yes' => esc_html__( 'Yes','kiddie' ),
				'no' => esc_html__( 'No','kiddie' ),
			),
			'priority'   => 15,
		)
	);

	// Blog sidebar layout
	$wp_customize->add_setting(
		'category_sidebar_option' ,
		array(
			'default' => 'right',
			'sanitize_callback' => 'kiddie_sanitize_text',
		)
	);

	$wp_customize->add_control(
		'category_sidebar_option',
		array(
			'label' => esc_html__( 'Blog Sidebar Layout', 'kiddie' ),
			'section' => 'options_general_kiddie',
			'type' => 'radio',
			'choices'  => array(
				'right' => 'Right',
				'none' => 'None (full width)',
			),
			'priority'   => 25,
		)
	);

	// Main website font
	$wp_customize->add_setting(
		'main_font_google' ,
		array(
			'default' => 'Open Sans',
			'sanitize_callback' => 'kiddie_sanitize_text',
		)
	);

	$wp_customize->add_control(
		'main_font_google',
		array(
			'label' => esc_html__( 'Font', 'kiddie' ),
			'section' => 'options_general_kiddie',
			'type' => 'text',
			'priority'   => 30,
		)
	);

	// Main website font
	$wp_customize->add_setting(
		'main_font_google_weight' ,
		array(
			'default' => '400',
			'sanitize_callback' => 'kiddie_sanitize_text',
		)
	);

	$wp_customize->add_control(
		'main_font_google_weight',
		array(
			'label' => esc_html__( 'Font Weight', 'kiddie' ),
			'section' => 'options_general_kiddie',
			'type' => 'text',
			'priority'   => 40,
		)
	);

	// Add Theme Header Section *************************
	$wp_customize->add_section(
		'options_header_kiddie',
		array(
			'title' => esc_html__( 'Header', 'kiddie' ),
			'description' => esc_html__( 'Site Header Settings', 'kiddie' ),
			'priority' => 20,
		)
	);

	// Add Logo Settings
	$wp_customize->add_setting(
		'logo_upload' ,
		array(
			'default' => get_template_directory_uri() . '/images/logo.png',
			'sanitize_callback' => 'kiddie_sanitize_text',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'logo_upload',
			array(
				'label' => esc_html__( 'Logo Image', 'kiddie' ),
				'section' => 'options_header_kiddie',
				'settings' => 'logo_upload',
				'priority'   => 5,
			)
		)
	);

	// Add Logo Settings
	$wp_customize->add_setting(
		'hires_logo_upload' ,
		array(
			'default' => get_template_directory_uri() . '/images/logo@2x.png',
			'sanitize_callback' => 'kiddie_sanitize_text',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'hires_logo_upload',
			array(
				'label' => esc_html__( 'High Resolution Logo Image', 'kiddie' ),
				'description' => esc_html__( 'Image should be twice as large as logo above with "@2x" added to filename.', 'kiddie' ),
				'section' => 'options_header_kiddie',
				'settings' => 'hires_logo_upload',
				'priority'   => 6,
			)
		)
	);

	// Logo width setting/control
	$wp_customize->add_setting(
		'logo_width' ,
		array(
			'default' => '140',
			'sanitize_callback' => 'kiddie_sanitize_text',
		)
	);

	$wp_customize->add_control(
		'logo_width',
		array(
			'label' => esc_html__( 'Logo Width (max)', 'kiddie' ),
			'section' => 'options_header_kiddie',
			'type' => 'number',
			'priority'   => 10,
		)
	);

	// Menu background color
	$wp_customize->add_setting(
		'menu_background_color',
		array(
			'default' => '#ffffff', // white
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'menu_background_color',
			array(
				'label' => esc_html__( 'Header Background Color', 'kiddie' ),
				'section' => 'options_header_kiddie',
				'settings' => 'menu_background_color',
				'priority' => 15,
			)
		)
	);

	// Menu Fonts Setting
	$wp_customize->add_setting(
		'menu_google_font' ,
		array(
			'default' => 'Open Sans',
			'sanitize_callback' => 'kiddie_sanitize_text',
		)
	);

	$wp_customize->add_control(
		'menu_google_font',
		array(
			'label' => esc_html__( 'Menu Font','kiddie' ),
			'description' => esc_html__( 'Find more on  http://google.com/fonts', 'kiddie' ),
			'section' => 'options_header_kiddie',
			'settings' => 'menu_google_font',
			'priority' => 20,
		)
	);

	// Menu Fonts Weight
	$wp_customize->add_setting(
		'menu_google_font_weight' ,
		array(
			'default' => '400',
			'sanitize_callback' => 'kiddie_sanitize_text',
		)
	);

	$wp_customize->add_control(
		'menu_google_font_weight',
		array(
			'label' => esc_html__( 'Menu Font Weight','kiddie' ),
			'section' => 'options_header_kiddie',
			'settings' => 'menu_google_font_weight',
			'type' => 'text',
			'priority' => 22,

		)
	);

	// Menu Fonts Size
	$wp_customize->add_setting(
		'menu_font_size',
		array(
			'default' => 16,
			'sanitize_callback' => 'kiddie_sanitize_text',
		)
	);

	$wp_customize->add_control(
		'menu_font_size',
		array(
			'label' => esc_html__( 'Menu Font Size (px)', 'kiddie' ),
			'section' => 'options_header_kiddie',
			'settings' => 'menu_font_size',
			'priority' => 25,
			'type' => 'number',
		)
	);

	// Menu hover color
	$wp_customize->add_setting(
		'menu_hover_color',
		array(
			'default' => '#93c524',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'menu_hover_color',
			array(
				'label' => esc_html__( 'Menu Hover Color', 'kiddie' ),
				'section' => 'options_header_kiddie',
				'settings' => 'menu_hover_color',
				'priority' => 35,
			)
		)
	);

	// Menu third color
	$wp_customize->add_setting(
		'menu_third_color',
		array(
			'default' => '#707070',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'menu_third_color',
			array(
				'label' => esc_html__( 'Menu Text Color', 'kiddie' ),
				'section' => 'options_header_kiddie',
				'settings' => 'menu_third_color',
				'priority' => 37,
			)
		)
	);

	// Colors section ******************************
	// Theme second color
	$wp_customize->add_setting(
		'theme_first_color',
		array(
			'default' => '#ffd823', // yellow
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'theme_first_color',
			array(
				'label' => esc_html__( 'Theme First Color', 'kiddie' ),
				'section' => 'colors',
				'settings' => 'theme_first_color',
				'priority' => 5,
			)
		)
	);

	// Theme second color
	$wp_customize->add_setting(
		'theme_second_color',
		array(
			'default' => '#704825', // brown
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'theme_second_color',
			array(
				'label' => esc_html__( 'Theme Second Color', 'kiddie' ),
				'section' => 'colors',
				'settings' => 'theme_second_color',
				'priority' => 5,
			)
		)
	);

	// Theme third color
	$wp_customize->add_setting(
		'theme_third_color',
		array(
			'default' => '#f25141', // pink
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'theme_third_color',
			array(
				'label' => esc_html__( 'Theme Third Color', 'kiddie' ),
				'section' => 'colors',
				'settings' => 'theme_third_color',
				'priority' => 5,
			)
		)
	);

	// Theme fourth color
	$wp_customize->add_setting(
		'theme_fourth_color',
		array(
			'default' => '#93c524', // green
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'theme_fourth_color',
			array(
				'label' => esc_html__( 'Theme Fourth Color', 'kiddie' ),
				'section' => 'colors',
				'settings' => 'theme_fourth_color',
				'priority' => 5,
			)
		)
	);

	// Theme fifth color
	$wp_customize->add_setting(
		'theme_fifth_color',
		array(
			'default' => '#28a8e3', // blue
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'theme_fifth_color',
			array(
				'label' => esc_html__( 'Theme Fifth Color', 'kiddie' ),
				'section' => 'colors',
				'settings' => 'theme_fifth_color',
				'priority' => 6,
			)
		)
	);

	// Post details color
	$wp_customize->add_setting(
		'post_details_color',
		array(
			'default' => '#a0a0a0', // light grey
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'post_details_color',
			array(
				'label' => esc_html__( 'Detail Text Color', 'kiddie' ),
				'section' => 'colors',
				'settings' => 'post_details_color',
				'priority' => 7,
			)
		)
	);

	// Links colors
	$wp_customize->add_setting(
		'link_color',
		array(
			'default' => '#704825', // brown
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'link_color',
			array(
				'label' => esc_html__( 'Links Color', 'kiddie' ),
				'section' => 'colors',
				'settings' => 'link_color',
				'priority' => 34,
			)
		)
	);

	$wp_customize->add_setting(
		'title_dark_color',
		array(
			'default' => '#704825',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'title_dark_color',
			array(
				'label'      => esc_html__( 'Title Dark Color', 'kiddie' ),
				'section'    => 'colors',
				'settings'   => 'title_dark_color',
				'priority'   => 50,
			)
		)
	);

	$wp_customize->add_setting(
		'title_light_color',
		array(
			'default' => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'title_light_color',
			array(
				'label'      => esc_html__( 'Title Light Color', 'kiddie' ),
				'section'    => 'colors',
				'settings'   => 'title_light_color',
				'priority'   => 60,
			)
		)
	);

	// Buttons background-color
	$wp_customize->add_setting(
		'buttons_background_color',
		array(
			'default' => '#ffd823', // yellow
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'buttons_background_color',
			array(
				'label'      => esc_html__( 'Buttons Background Color', 'kiddie' ),
				'section'    => 'colors',
				'settings'   => 'buttons_background_color',
				'priority'   => 90,
			)
		)
	);

	// Buttons text-color
	$wp_customize->add_setting(
		'buttons_text_color',
		array(
			'default' => '#704825', // brown
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'buttons_text_color',
			array(
				'label'      => esc_html__( 'Buttons Text Color', 'kiddie' ),
				'section'    => 'colors',
				'settings'   => 'buttons_text_color',
				'priority'   => 100,
			)
		)
	);


	// Add Footer Section
	$wp_customize->add_section(
		'options_footer_kiddie',
		array(
			'title' => esc_html__( 'Footer', 'kiddie' ),
			'description' => esc_html__( 'Settings for colors, text and social links visibility in footer', 'kiddie' ),
			'priority' => 25,
		)
	);

	// Footer background color
	$wp_customize->add_setting(
		'footer_sidebar_background_color',
		array(
			'default' => '#704825', // brown
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'footer_sidebar_background_color',
			array(
				'label'      => esc_html__( 'Footer Widget Area Background Color', 'kiddie' ),
				'section'    => 'options_footer_kiddie',
				'settings'   => 'footer_sidebar_background_color',
				'priority'   => 5,
			)
		)
	);

	// Footer background color
	$wp_customize->add_setting(
		'footer_background_color',
		array(
			'default' => '#56371b', // dark brown
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'footer_background_color',
			array(
				'label'      => esc_html__( 'Footer Belt Background Color', 'kiddie' ),
				'section'    => 'options_footer_kiddie',
				'settings'   => 'footer_background_color',
				'priority'   => 10,
			)
		)
	);

	// Copyright text color
	$wp_customize->add_setting(
		'copyright_color',
		array(
			'default' => '#ffd823', // yellow
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'copyright_color',
			array(
				'label'      => esc_html__( 'Copyright Font Color', 'kiddie' ),
				'section'    => 'options_footer_kiddie',
				'settings'   => 'copyright_color',
				'priority'   => 15,
			)
		)
	);

	// Copyright text
	$wp_customize->add_setting(
		'copyright_textbox',
		array(
			'default' => '2016 Kiddie Theme crafted with love by Zoutula',
			'sanitize_callback' => 'kiddie_sanitize_text',
		)
	);

	$wp_customize->add_control(
		'copyright_textbox',
		array(
			'label' => esc_html__( 'Copyright Text','kiddie' ),
			'section' => 'options_footer_kiddie',
			'type' => 'text',
			'priority'   => 20,
		)
	);

	// Option to show social in footer
	$wp_customize->add_setting(
		'show_footer_social',
		array(
			'default' => 'show',
			'sanitize_callback' => 'kiddie_sanitize_text',
		)
	);

	$wp_customize->add_control(
		'show_footer_social',
		array(
			'type' => 'radio',
			'label' => esc_html__( 'Show/Hide Social Icons','kiddie' ),
			'section' => 'options_footer_kiddie',
			'choices' => array(
				'show' => 'Show',
				'hide' => 'Hide',
			),
			'priority' => '30',
		)
	);


	// Add Section Social Links
	$wp_customize->add_section(
		'options_social_kiddie',
		array(
			'title' => esc_html__( 'Social Links', 'kiddie' ),
			'description' => esc_html__( 'Social links for your site', 'kiddie' ),
			'priority' => 30,
		)
	);

	// Facebook social link
	$wp_customize->add_setting(
		'facebook_social_link',
		array(
			'default' => '#',
			'sanitize_callback' => 'kiddie_sanitize_text',
		)
	);

	$wp_customize->add_control(
		'facebook_social_link',
		array(
			'label' => esc_html__( 'Facebook Link','kiddie' ),
			'section' => 'options_social_kiddie',
			'type' => 'text',
			'priority'   => 10,
		)
	);

	// Google + link
	$wp_customize->add_setting(
		'google_social_link',
		array(
			'default' => '#',
			'sanitize_callback' => 'kiddie_sanitize_text',
		)
	);

	$wp_customize->add_control(
		'google_social_link',
		array(
			'label' => esc_html__( 'Google+ Link','kiddie' ),
			'section' => 'options_social_kiddie',
			'type' => 'text',
			'priority'   => 20,
		)
	);

	// Twitter link
	$wp_customize->add_setting(
		'twitter_social_link',
		array(
			'default' => '#',
			'sanitize_callback' => 'kiddie_sanitize_text',
		)
	);

	$wp_customize->add_control(
		'twitter_social_link',
		array(
			'label' => esc_html__( 'Twitter Link','kiddie' ),
			'section' => 'options_social_kiddie',
			'type' => 'text',
			'priority'   => 30,
		)
	);

	// Youtube link
	$wp_customize->add_setting(
		'youtube_social_link',
		array(
			'default' => '#',
			'sanitize_callback' => 'kiddie_sanitize_text',
		)
	);

	$wp_customize->add_control(
		'youtube_social_link',
		array(
			'label' => esc_html__( 'Youtube Link','kiddie' ),
			'section' => 'options_social_kiddie',
			'type' => 'text',
			'priority'   => 40,
		)
	);

	// Pinterest link
	$wp_customize->add_setting(
		'pinterest_social_link',
		array(
			'default' => '#',
			'sanitize_callback' => 'kiddie_sanitize_text',
		)
	);

	$wp_customize->add_control(
		'pinterest_social_link',
		array(
			'label' => esc_html__( 'Pinterest Link','kiddie' ),
			'section' => 'options_social_kiddie',
			'type' => 'text',
			'priority'   => 50,
		)
	);

	// Add Shop Section only in case WooCommerce is active
	if ( class_exists( 'WooCommerce' ) ) {
		$wp_customize->add_section(
			'options_shop_kiddie',
			array(
				'title' => esc_html__('Shop', 'kiddie'),
				'description' => esc_html__('Settings for WooCommerce pages', 'kiddie'),
				'priority' => 32,
			)
		);

		//Shop sidebar layout
		$wp_customize->add_setting(
			'shop_sidebar_option',
			array(
				'default' => 'right',
				'sanitize_callback' => 'kiddie_sanitize_text',
			)
		);

		$wp_customize->add_control(
			'shop_sidebar_option',
			array(
				'label' => esc_html__('Shop Sidebar Layout', 'kiddie'),
				'section' => 'options_shop_kiddie',
				'type' => 'radio',
				'choices' => array(
					'right' => 'Right',
					'none' => 'None (full width)',
				),
				'priority' => 10,
			)
		);


		// Shop products per page
		$wp_customize->add_setting(
			'shop_products_per_page',
			array(
				'default' => '9',
				'sanitize_callback' => 'kiddie_sanitize_text',
			)
		);

		$wp_customize->add_control(
			'shop_products_per_page',
			array(
				'label' => esc_html__('Products per Page', 'kiddie'),
				'section' => 'options_shop_kiddie',
				'type' => 'number',
				'priority' => 20,
			)
		);
	}


	// Add Section Contact
	$wp_customize->add_section(
		'options_contact_kiddie',
		array(
			'title' => esc_html__( 'Contact Page', 'kiddie' ),
			'description' => esc_html__( 'Map coordinates and settings', 'kiddie' ),
			'priority' => 35,
		)
	);

	// Map coordinates
	$wp_customize->add_setting(
		'contact_page_coordinates',
		array(
			'default' => '51.497360, -0.163348', // london
			'sanitize_callback' => 'kiddie_sanitize_text',
		)
	);

	$wp_customize->add_control(
		'contact_page_coordinates',
		array(
			'label' => esc_html__( 'Google Coordinates','kiddie' ),
			'section' => 'options_contact_kiddie',
			'type' => 'text',
			'priority'   => 10,
		)
	);


	// Map Api Key
	$wp_customize->add_setting(
		'maps_api_key',
		array(
			'default' => 'AIzaSyAfz_ozFC-3PLVYL2GZmz60TWsikGuPdUY', // Kiddie
			'sanitize_callback' => 'kiddie_sanitize_text',
		)
	);

	$wp_customize->add_control(
		'maps_api_key',
		array(
			'label' => esc_html__( 'Google Maps Api Key','kiddie' ),
			'section' => 'options_contact_kiddie',
			'description' => esc_html__( 'Please generate yours Google API Key (http://goo.gl/SDGkDf)', 'kiddie' ),
			'type' => 'text',
			'priority'   => 15,
		)
	);


	// Custom pin
	$wp_customize->add_setting(
		'contact_page_pin' ,
		array(
			'default' => get_template_directory_uri() . '/images/pin.png',
			'sanitize_callback' => 'kiddie_sanitize_text',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'contact_page_pin',
			array(
				'label' => esc_html__( 'Map Pin (image)', 'kiddie' ),
				'section' => 'options_contact_kiddie',
				'settings' => 'contact_page_pin',
				'priority'   => 20,
			)
		)
	);

	// Map zoom
	$wp_customize->add_setting(
		'contact_page_zoom',
		array(
			'default' => '16',
			'sanitize_callback' => 'kiddie_sanitize_text',
		)
	);

	$wp_customize->add_control(
		'contact_page_zoom',
		array(
			'label' => esc_html__( 'Map Zoom (default 16)','kiddie' ),
			'section' => 'options_contact_kiddie',
			'type' => 'number',
			'priority'   => 30,
		)
	);

	// Map color
	$wp_customize->add_setting(
		'contact_page_map_color',
		array(
			'default' => '#B1D363', // green
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'contact_page_map_color',
			array(
				'label' => esc_html__( 'Map Color', 'kiddie' ),
				'section' => 'options_contact_kiddie',
				'settings' => 'contact_page_map_color',
				'priority' => 40,
			)
		)
	);

	// Send message button background color
	$wp_customize->add_setting(
		'contact_page_button_background',
		array(
			'default' => '#ffd823', // yellow
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'contact_page_button_background',
			array(
				'label' => esc_html__( 'Send Button Background Color', 'kiddie' ),
				'section' => 'options_contact_kiddie',
				'settings' => 'contact_page_button_background',
				'priority' => 60,
			)
		)
	);

	// Send message button text color
	$wp_customize->add_setting(
		'contact_page_button_text',
		array(
			'default' => '#704f32', // brown
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'contact_page_button_text',
			array(
				'label' => esc_html__( 'Send Button Text Color', 'kiddie' ),
				'section' => 'options_contact_kiddie',
				'settings' => 'contact_page_button_text',
				'priority' => 70,
			)
		)
	);

	// Add Section Custom Code
	$wp_customize->add_section(
		'custom_code_kiddie',
		array(
			'title' => esc_html__( 'Custom Code', 'kiddie' ),
			'description' => esc_html__( 'Custom CSS', 'kiddie' ),
			'priority' => 120,
		)
	);

	// CSS Code
	$wp_customize->add_setting(
		'css_custom_code_kiddie',
		array(
			'default' => '',
			'sanitize_callback' => 'kiddie_sanitize_text',
		)
	);

	$wp_customize->add_control(
		'css_custom_code_kiddie',
		array(
			'label' => esc_html__( 'CSS Code','kiddie' ),
			'section' => 'custom_code_kiddie',
			'type' => 'textarea',
			'priority'   => 10,
		)
	);

	// customizer styles
	wp_register_style( 'customizer_custom', get_template_directory_uri() . '/css/customizer.css' );
	wp_enqueue_style( 'customizer_custom' );

}
add_action( 'customize_register', 'kiddie_customizer' );



function kiddie_add_needed_google_fonts() {

	// get default menu font
	$protocol = is_ssl() ? 'https' : 'http';
	$google_keyword_font_menu = esc_attr( get_theme_mod( 'menu_google_font','Open Sans' ) );

	if ( ! empty( $google_keyword_font_menu ) ) {
		$google_weight_font_menu = esc_attr( get_theme_mod( 'menu_google_font_weight','400' ) );
		$google_keyword_font_menu_edited = str_replace( ' ', '+', $google_keyword_font_menu );
		wp_enqueue_style( 'kiddie-fonts-' . $google_keyword_font_menu_edited, $protocol . '://fonts.googleapis.com/css?family=' . $google_keyword_font_menu_edited . ':' . $google_weight_font_menu );
	}

	// get main theme font
	$google_keyword_font_main = esc_attr( get_theme_mod( 'main_google_font','Open Sans' ) );

	if ( ! empty( $google_keyword_font_main ) ) {
		$google_weight_font_main = esc_attr( get_theme_mod( 'main_font_google_weight','300' ) );
		$google_keyword_font_main_edited = str_replace( ' ', '+', $google_keyword_font_main );
		wp_enqueue_style( 'kiddie-fonts-' . $google_keyword_font_main_edited, $protocol . '://fonts.googleapis.com/css?family=' . $google_keyword_font_main_edited . ':' . $google_weight_font_main );
	}

}

add_action( 'wp_enqueue_scripts', 'kiddie_add_needed_google_fonts' );



function kiddie_add_css_to_stylesheet() {
	// get menu font
	$styles['menu_font'] = esc_attr( get_theme_mod( 'menu_google_font', 'Open Sans' ) );
	$styles['menu_font_weight'] = esc_attr( get_theme_mod( 'menu_google_font_weight', '400' ) ); // normal weight for google

	$styles['main_font'] = esc_attr( get_theme_mod( 'main_font_google', 'Open Sans' ) );
	$styles['main_font_weight'] = esc_attr( get_theme_mod( 'main_font_google_weight', '400' ) ); // main theme font

	$styles['theme_first_color'] = esc_attr( get_theme_mod( 'theme_first_color','#ffd823' ) ); // first theme color yellow
	$styles['theme_second_color'] = esc_attr( get_theme_mod( 'theme_second_color','#704825' ) ); // second theme color brown
	$styles['theme_third_color'] = esc_attr( get_theme_mod( 'theme_third_color','#f25141' ) ); // third color red
	$styles['theme_fourth_color'] = esc_attr( get_theme_mod( 'theme_fourth_color','#93c524' ) ); // fourth color green
	$styles['theme_fifth_color'] = esc_attr( get_theme_mod( 'theme_fifth_color','#28a8e3' ) ); // fifth color blue

	// menu font size
	$styles['menu_font_size'] = intval( get_theme_mod( 'menu_font_size',16 ) );
	// menu hover color
	$styles['menu_hover_color'] = esc_attr( get_theme_mod( 'menu_hover_color','#93c524' ) );
	// menu third color
	$styles['menu_third_color'] = esc_attr( get_theme_mod( 'menu_third_color','#707070' ) );
	// menu icon color
	$styles['menu_icon_color'] = esc_attr( get_theme_mod( 'menu_icon_color','#ffd823' ) );

	// widget title dark color
	$styles['title_dark_color'] = esc_attr( get_theme_mod( 'title_dark_color','#704825' ) ); // brown default
	// widget title dark color
	$styles['title_light_color'] = esc_attr( get_theme_mod( 'title_light_color','#ffffff' ) ); // white default
	// footer bg color
	$styles['footer_background_color'] = esc_attr( get_theme_mod( 'footer_background_color','#56371b' ) ); // dark brown default
	// copyright text color
	$styles['copyright_color'] = esc_attr( get_theme_mod( 'copyright_color','#ffd823' ) ); // yellow
	// social icons color
	$styles['footer_social_icons_color'] = esc_attr( get_theme_mod( 'footer_social_icons_color','#93c524' ) ); // green
	// header background-color
	$styles['menu_background_color'] = esc_attr( get_theme_mod( 'menu_background_color','#fdfdfd' ) ); // milk

	// buttons text color
	$styles['buttons_text_color'] = esc_attr( get_theme_mod( 'buttons_text_color','#704825' ) ); // brown
	// buttons background color
	$styles['buttons_background_color'] = esc_attr( get_theme_mod( 'buttons_background_color','#ffd823' ) ); // yellow

	// contact colors
	$styles['contact_page_button_background'] = esc_attr( get_theme_mod( 'contact_page_button_background', '#ffd823' ) ); // yellow
	// send message text color
	$styles['contact_page_button_text'] = esc_attr( get_theme_mod( 'contact_page_button_text', '#704f32' ) ); // brown

	// link colors
	$styles['link_color'] = esc_attr( get_theme_mod( 'link_color', '#704f32' ) ); // brown

	$styles['footer_sidebar_background_color'] = esc_attr( get_theme_mod( 'footer_sidebar_background_color', '#704825' ) ); // brown

	$styles['post_details_color'] = esc_attr( get_theme_mod( 'post_details_color', '#a0a0a0' ) );

	//this should not be escaped as the output must remain untouched
	$css_custom = get_theme_mod( 'css_custom_code_kiddie', '' );

	$css = "
    body, aside a{
        font-family: '{$styles['main_font']}',sans-serif;
        font-weight: {$styles['main_font_weight']};
        }
    a,
    .ztl-link,
    .ztl-title-medium,
    .ztl-staff-item .staff-title,
    .no-results .page-title,
    .category-listing .title a,
    .ztl-masonry h4{
        color: {$styles['link_color']};
     }
    .ztl-widget-recent-posts h6 a:hover{
        color: {$styles['link_color']};
    }
    .post-navigation .nav-previous a:hover,
    .post-navigation .nav-next a:hover{
        color: {$styles['link_color']};
    }
    .ztl-masonry .read-more a:hover{
        background-color: {$styles['link_color']} !important;
        color: {$styles['theme_first_color']} !important;
    }
    a:visited,
    a:active,
    a:focus,
    .sidebar-right .menu a{
        color: {$styles['link_color']};
    }
    a:hover,
    .sidebar-right li>a:hover {
        color: {$styles['link_color']};
    }

    #ztl-social .fa:hover{
        color: {$styles['theme_first_color']};
    }

    #menu-toggle span {
        background-color:{$styles['menu_hover_color']};
    }
    #ztl-copyright{
        color: {$styles['copyright_color']};
    }
    #ztl-copyright a{
	text-decoration:underline;
	cursor:pointer;
	color: {$styles['copyright_color']};
    }
    .main-navigation a{
        font-family: '{$styles['menu_font']}',sans-serif;
        font-size: {$styles['menu_font_size']}px;
        font-weight: {$styles['menu_font_weight']};
     }

    .main-navigation li:nth-child(4n+1) {
        color: {$styles['theme_third_color']};
    }
    .main-navigation li:nth-child(4n+2) {
        color: {$styles['theme_first_color']};
    }
    .main-navigation li:nth-child(4n+3) {
        color: {$styles['theme_fourth_color']};
    }
    .main-navigation li:nth-child(4n+4) {
        color: {$styles['theme_fifth_color']};
    }
    .main-navigation ul ul:before {
        background-color: {$styles['menu_hover_color']};
    }
    .main-navigation ul li:hover{
        background-color: {$styles['menu_hover_color']};
    }
    .main-navigation ul ul li:hover{
        background-color: transparent !important;
    }
    .main-navigation ul ul li:hover a{
        color:#fff;
    }
    .main-navigation ul ul li:hover > a{
        background-color: {$styles['menu_hover_color']};
    }
    .main-navigation a{
        color: {$styles['menu_third_color']} !important;
    }
    .main-navigation li .current_page_item > a,
    .main-navigation li .current_page_ancestor > a,
    .main-navigation li .current-menu-item > a,
    .main-navigation li .current-menu-ancestor > a {
        color: #fff !important;
        background-color: {$styles['menu_hover_color']};
    }
    .main-navigation .current_page_item > a,
    .main-navigation .current_page_ancestor > a,
    .main-navigation .current-menu-item > a,
    .main-navigation .current-menu-ancestor > a {
        color: #fff !important;
    }

    .main-navigation .sub-menu li.current-menu-item > a,
    .main-navigation .sub-menu li.current_page_item > a{
    	color: #fff !important;
    }

    .main-navigation .current_page_item,
    .main-navigation .current_page_ancestor,
    .main-navigation .current-menu-item,
    .main-navigation .current-menu-ancestor {
        background-color: {$styles['menu_hover_color']};
    }

    .main-navigation ul ul .current_page_item,
    .main-navigation ul ul .current_page_ancestor,
    .main-navigation ul ul .current-menu-item,
    .main-navigation ul ul .current-menu-ancestor {
        background-color:{$styles['menu_background_color']};
    }

    .main-navigation ul ul .current_page_item,
    .main-navigation ul ul .current-menu-item{
        background-color: transparent !important;
    }
    .main-navigation .current_page_item ul a,
    .main-navigation .current-menu-item ul a{
        color: {$styles['menu_third_color']} !important;
    }
    .main-navigation ul ul .fa{
        display:none;
    }
    .post-navigation .fa {
        color: {$styles['theme_fourth_color']};
    }
    .custom .tp-bullet, .custom .tp-bullet:after {
		color:" . kiddie_hex2rgba( $styles['theme_third_color'],0.6 ) . " !important;
    }
    .custom .tp-bullet.selected:after{
        color:{$styles['theme_third_color']} !important;
    }

    .tp-leftarrow, .tp-rightarrow{
        background-color:{$styles['theme_first_color']} !important;
    }
    .ztl-widget-title-dark,
    .dark-title,
    .comment-reply-title,
    .ztl-action-title,
    .ztl-contact-form h2{
        color:{$styles['title_dark_color']};
    }
    .ztl-widget-title-light{
        color:{$styles['title_light_color']};
    }
    .site-footer .site-info{
        background-color:{$styles['footer_background_color']};
    }
    .site-header, .main-navigation ul ul{
        background-color:{$styles['menu_background_color']};
    }

     .ztl-widget-title-right h2,
     .sidebar-right h2{
        color:{$styles['title_dark_color']};
     }

    .category-listing .item i,
    .ztl-post i,
    .ztl-widget-recent-posts ul>li>a+h6+span i{
        color: {$styles['theme_fourth_color']};
    }

    .ztl-scroll-top:hover{
        background-color: {$styles['theme_fourth_color']};
    }

    .ztl-button,
    .ztl-button-circle,
    .category-listing .item .read-more a,
    .comment-body .reply a,
    .ztl-contact-form input[type=submit],
    .post-password-form input[type=submit]{
        color:{$styles['buttons_text_color']};
        background-color:{$styles['buttons_background_color']};
    }
    .ztl-button:hover,
    .ztl-button-circle:hover,
    .category-listing .item .read-more a:hover,
    .comment-body .reply a:hover,
    .ztl-contact-form input[type=submit]:hover,
    .post-password-form input[type=submit]:hover {
        background-color:{$styles['buttons_text_color']};
        color:{$styles['buttons_background_color']};
    }
    .pagination .page-numbers {
        color:{$styles['buttons_text_color']};
    }
    .pagination .current,
    .pagination .current:hover,
    .vc_tta-color-white.vc_tta-style-flat .vc_tta-panel .vc_tta-panel-heading:hover {
        color:{$styles['buttons_text_color']} !important;
        background-color:{$styles['buttons_background_color']} !important;
     }
    .pagination .page-numbers:hover {
        background-color: {$styles['buttons_text_color']};
        color:{$styles['buttons_background_color']};
    }
    .pagination .prev:hover,
    .pagination .next:hover {
        color:{$styles['buttons_background_color']};
        background-color:transparent !important;}

    .ztl-contact-form input[type=submit]{
        color:{$styles['contact_page_button_text']};
        background-color: {$styles['contact_page_button_background']};
    }
    .ztl-masonry-buttons li.vc_active,
    .ztl-masonry-buttons .vc_grid-filter-item:hover,
    .ztl-masonry .read-more a{
        background-color:{$styles['buttons_background_color']} !important;
    }
    .ztl-masonry-buttons .vc_grid-filter-item,
    .ztl-masonry .read-more a,
    .ztl-masonry-buttons .vc_active span,
    .ztl-masonry-buttons .vc_grid-filter-item:hover span {
        color:{$styles['buttons_text_color']} !important;
    }
    .ztl-masonry .vc_pageable-load-more-btn a{
        background-color:{$styles['theme_fourth_color']};
    }
    .category-sidebar-right .widget_text li:before,
    .post-sidebar-right .widget_text li:before,
    .ztl-post-info:before{
        color:{$styles['theme_fourth_color']};
    }
    .ztl-masonry .vc_pageable-load-more-btn a:hover{
        color:{$styles['buttons_text_color']} !important;
    }
    .comment-author,
    .comments-title,
    .ztl-course-item .course-title,
    .ztl-course-item .detail{
        color: {$styles['theme_second_color']} !important;
    }
    .sidebar-right .widget-title::after,
    .custom-header-title::after,
    .widget-title::after{
        background-color: {$styles['theme_first_color']};
    }
    .sidebar-footer{
        background-color: {$styles['footer_sidebar_background_color']};
    }
    .ztl-widget-category-container .author a,
    .ztl-widget-category-container .category,
    .ztl-widget-category-container .category a,
    .ztl-widget-category-container .entry-date,
    .ztl-widget-category-container .entry-date a,
    .category-listing .item .date,
    .category-listing .item .date a,
    .category-listing .info a,
    .category-listing .info,
    .posted-on a, .byline,
    .byline .author a,
    .ztl-masonry .vc_gitem-post-data,
    .entry-footer, .comment-form,
    .entry-footer a,
    .ztl-recent-post-date,
    .ztl-recent-post-date a,
    .ztl-post .info,
    .comment-metadata a,
    .ztl-post .info a{
        color:{$styles['post_details_color']};
    }
    {$css_custom}
";

	//In case WooCommerce is activated we append custom styles
if ( class_exists( 'WooCommerce' ) ) {
	$css .= "
		.widget.woocommerce ul li .quantity,
		.widget.woocommerce ul li .amount,
		.woocommerce .widget_shopping_cart .total,
		.woocommerce.widget_shopping_cart .total,
		.woocommerce .product .amount,
		.price_slider_amount .price_label,
		.widget.woocommerce  .reviewer{
			color:{$styles['post_details_color']};
		}
		.woocommerce a.button.added:after,
		.woocommerce div.product form.cart .variations label{
        	color: {$styles['theme_second_color']} !important;
    	}
    	.woocommerce #respond input#submit:hover,
    	.woocommerce a.button:hover,
    	.woocommerce button.button:hover,
    	.woocommerce input.button:hover,
    	.woocommerce a.button.alt:hover,
		.woocommerce button.button.alt:hover,
		.woocommerce input.button.alt:hover,
		.woocommerce .single_add_to_cart_button:hover{
        	background-color:{$styles['buttons_text_color']};
        	color:{$styles['buttons_background_color']};
    	}
    	.woocommerce #respond input#submit,
		.woocommerce a.button,
		.woocommerce button.button,
		.woocommerce input.button,
		.woocommerce a.button.alt,
		.woocommerce button.button.alt,
		.woocommerce input.button.alt{
			color:{$styles['buttons_text_color']};
			background-color:{$styles['buttons_background_color']};
		}

		.woocommerce #respond input#submit.alt.disabled,
		.woocommerce #respond input#submit.alt.disabled:hover,
		.woocommerce #respond input#submit.alt:disabled,
		.woocommerce #respond input#submit.alt:disabled:hover,
		.woocommerce #respond input#submit.alt:disabled[disabled],
		.woocommerce #respond input#submit.alt:disabled[disabled]:hover,
		.woocommerce a.button.alt.disabled,
		.woocommerce a.button.alt.disabled:hover,
		.woocommerce a.button.alt:disabled,
		.woocommerce a.button.alt:disabled:hover,
		.woocommerce a.button.alt:disabled[disabled],
		.woocommerce a.button.alt:disabled[disabled]:hover,
		.woocommerce button.button.alt.disabled,
		.woocommerce button.button.alt.disabled:hover,
		.woocommerce button.button.alt:disabled,
		.woocommerce button.button.alt:disabled:hover,
		.woocommerce button.button.alt:disabled[disabled],
		.woocommerce button.button.alt:disabled[disabled]:hover,
		.woocommerce input.button.alt.disabled,
		.woocommerce input.button.alt.disabled:hover,
		.woocommerce input.button.alt:disabled,
		.woocommerce input.button.alt:disabled:hover,
		.woocommerce input.button.alt:disabled[disabled],
		.woocommerce input.button.alt:disabled[disabled]:hover{
			color:{$styles['buttons_text_color']};
			background-color:{$styles['buttons_background_color']};
		}

		.woocommerce p.stars a,
		.woocommerce .star-rating:before,
		.woocommerce .star-rating {
			color:{$styles['buttons_background_color']};
		}
		.woocommerce span.onsale,
		.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
		.woocommerce .widget_price_filter .ui-slider .ui-slider-range{
			background-color: {$styles['theme_fourth_color']};
		}

		.woocommerce .widget_price_filter .price_slider_wrapper .ui-widget-content{
			background-color:" . kiddie_hex2rgba( $styles['theme_fourth_color'],0.5 ) . ";
		}
		.woocommerce-page #content h1,
		.woocommerce-page #content h2,
		.woocommerce-page #content h3,
		.woocommerce-thankyou-order-received,
		.woocommerce form .form-row label{
			color:{$styles['title_dark_color']};
		}
	";
}



	wp_add_inline_style( 'kiddie-style', wp_strip_all_tags( $css ) );
}

add_action( 'wp_enqueue_scripts', 'kiddie_add_css_to_stylesheet' );


// Sanitize text function
function kiddie_sanitize_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}
