<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * @package Kiddie
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses kiddie_header_style()
 * @uses kiddie_admin_header_style()
 * @uses kiddie_admin_header_image()
 */
function kiddie_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'kiddie_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '000000',
		'width'                  => 1920,
		'height'                 => 240,
		'flex-height'            => true,
		'flex-width'   			 => true,
		'wp-head-callback'       => 'kiddie_header_style',
		'header-text'			 => false,
	) ) );
}
add_action( 'after_setup_theme', 'kiddie_custom_header_setup' );

if ( ! function_exists( 'kiddie_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog
	 *
	 * @see kiddie_custom_header_setup().
	 */
	function kiddie_header_style() {
		$header_text_color = get_header_textcolor();

		// If no custom options for text are set, let's bail.
		// Get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value.
		if ( HEADER_TEXTCOLOR === $header_text_color ) {
			return;
		}

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php
		// Has the text been hidden?
		if ( 'blank' === $header_text_color ) :
	?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that.
		else :
	?>
		.site-title a,
		.site-description {
			color: #<?php echo esc_attr( $header_text_color ); ?>;
		}
	<?php endif; ?>
	</style>
	<?php
	}
endif;
