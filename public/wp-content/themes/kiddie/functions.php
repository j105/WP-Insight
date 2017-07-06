<?php
/**
 * Kiddie functions and definitions
 *
 * @package Kiddie
 */

define( 'VERSION', 1.1242 ); //used to force browser cache when new updates appear

/**
 * Zoutula helpers
 */
require get_template_directory() . '/inc/framework.php';

/**
* Kiddie metaboxes
*/
require get_template_directory() . '/inc/metaboxes.php';

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
  $content_width = 1000; /* pixels */
}

if ( ! function_exists( 'kiddie_setup' ) ) :
  /**
   * Sets up theme defaults and registers support for various WordPress features.
   *
   * Note that this function is hooked into the after_setup_theme hook, which
   * runs before the init hook. The init hook is too late for some features, such
   * as indicating support for post thumbnails.
   */
  function kiddie_setup() {

    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on Kiddie, use a find and replace
     * to change 'kiddie' to the name of your theme in all the template files
     */
    load_theme_textdomain( 'kiddie', get_template_directory() . '/languages' );

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded title tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support( 'title-tag' );

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
     */
    add_theme_support( 'post-thumbnails' );
    add_image_size( 'kiddie-square-thumb', 300, 300, true ); // 300 wide by 300 tall, image is cropped due to true setting
    add_image_size( 'kiddie-blog-full',1000,560,true ); // 970 wide by 545 tall, image is cropped due to true setting
    add_image_size( 'kiddie-4-3', 600, 450, true ); // 600 wide by 450 tall, image is cropped due to true setting
    add_image_size( 'kiddie-square-big', 600, 600, true ); // 600 wide by 600 tall, image is cropped due to true setting

    // Addd WooCommmerce support
    add_theme_support( 'woocommerce' );


    // This theme uses wp_nav_menu() in one location.
    register_nav_menus( array(
      'primary' => esc_html__( 'Primary Menu', 'kiddie' ),
    ) );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support( 'html5', array(
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
    ) );

    // Set up the WordPress core custom background feature.
    add_theme_support( 'custom-background', apply_filters( 'kiddie_custom_background_args', array(
      'default-color' => 'ffffff',
      'default-image' => '',
    ) ) );

    /**
   * Load widgets file
   */
    require get_template_directory() . '/widgets/widgets.php';
  }
endif; // kiddie_setup
add_action( 'after_setup_theme', 'kiddie_setup' );


/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function kiddie_widgets_init() {
  register_sidebar( array(
    'name'          => esc_html__( 'Sidebar', 'kiddie' ),
    'id'            => 'sidebar',
    'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'kiddie' ),
    'before_widget' => '<aside id="%1$s" class="widget %2$s sidebar-right">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
  ) );

  // Homepage widget area
  register_sidebar( array(
    'name'          => esc_html__( 'Homepage', 'kiddie' ),
    'id'            => 'sidebar-homepage',
    'description'   => esc_html__( 'Add widgets here to appear on Homepage.', 'kiddie' ),
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
  ) );

  register_sidebar( array(
    'name'          => esc_html__( 'Footer', 'kiddie' ),
    'id'            => 'sidebar-footer',
    'description'   => esc_html__( 'Add widgets here to appear in footer.', 'kiddie' ),
    'before_widget' => '<aside id="%1$s" class="widget col-sm-4 %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
  ) );

  /**
   * Enable Shop sidebar only if WooCommerce is active
   */
  if ( class_exists( 'WooCommerce' ) ) {
    register_sidebar( array(
      'name'          => esc_html__( 'Shop', 'kiddie' ),
      'id'            => 'sidebar-shop',
      'description'   => esc_html__( 'Add widgets here to appear in WooCommerece sidebar.', 'kiddie' ),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget'  => '</aside>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
    ) );
  }

  // Pricing footer widget area
  register_sidebar( array(
    'name'          => esc_html__( 'Pricing Plans > Above Footer', 'kiddie' ),
    'id'            => 'sidebar-footer-pricing-plans',
    'description'   => esc_html__( 'Add widgets here to appear on Pricing Plans page just above the footer.', 'kiddie' ),
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
  ) );

  register_sidebar( array(
    'name'          => esc_html__( 'About Us > Above Footer', 'kiddie' ),
    'id'            => 'sidebar-footer-about-us',
    'description'   => esc_html__( 'Add widgets here to appear on About Us page just above the footer.', 'kiddie' ),
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
  ) );

  register_sidebar( array(
    'name'          => esc_html__( 'Staff > Above Footer', 'kiddie' ),
    'id'            => 'sidebar-footer-staff',
    'description'   => esc_html__( 'Add widgets here to appear on Staff page just above the footer.', 'kiddie' ),
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
  ) );

  register_sidebar( array(
    'name'          => esc_html__( 'Contact I > Above Footer', 'kiddie' ),
    'id'            => 'sidebar-footer-contact',
    'description'   => esc_html__( 'Add widgets here to appear on Contact I page just above the footer.', 'kiddie' ),
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
  ) );


  // unregister some default widgets and recreate them later with a more stylish look and flexible config
  unregister_widget( 'WP_Widget_Recent_Posts' );

}
add_action( 'widgets_init', 'kiddie_widgets_init' );



/**
 * Enqueue scripts and styles.
 */
function kiddie_scripts() {

  wp_enqueue_style( 'kiddie-style', get_stylesheet_uri(), false, VERSION );
  if ( class_exists( 'WooCommerce' ) ) {
    wp_enqueue_style('kiddie-woocommerce', get_template_directory_uri() . '/css/woocommerce.css', false, VERSION);
  }
  wp_enqueue_style( 'kiddie-style-responsive', get_template_directory_uri() . '/css/responsive.css', false, VERSION );
  wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', false, VERSION );
  wp_enqueue_style( 'pretty-photo', get_template_directory_uri() . '/css/prettyPhoto.css', false, VERSION );

  // enqueue Bootstrap JS
  wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), VERSION, true );
  wp_enqueue_script( 'kiddie-mobile', get_template_directory_uri() . '/js/mobile.js', array(), VERSION, true );

  // kiddie custom JS
  wp_enqueue_script( 'kiddie-navigation', get_template_directory_uri() . '/js/navigation.js', array( 'jquery' ), VERSION, true );
  wp_enqueue_script( 'pretty-photo-js', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', array( 'jquery' ), VERSION, true );
  wp_enqueue_script( 'kiddie-js-parallax', get_template_directory_uri() . '/js/jquery.parallax.js', array( 'jquery' ), VERSION, true );

  // waypoints & sticky & inview
  wp_enqueue_script( 'kiddie-waypoints', get_template_directory_uri() . '/js/jquery.waypoints.min.js', array( 'jquery' ), VERSION, true );
  wp_enqueue_script( 'kiddie-inview', get_template_directory_uri() . '/js/inview.min.js',array( 'jquery' ), VERSION, true );

  wp_enqueue_script( 'kiddie-js', get_template_directory_uri() . '/js/general.js', array( 'jquery' ), VERSION, true );
  wp_enqueue_script( 'kiddie-skip-link-focus-js', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), VERSION, true );
  wp_enqueue_script( 'kiddie-retina', get_template_directory_uri() . '/js/retina.min.js', array(), VERSION, true );

  // kiddie default fonts
  wp_enqueue_style( 'kiddie-fonts','//fonts.googleapis.com/css?family=Salsa|Open+Sans:300,400,600' );
  wp_enqueue_style( 'kiddie-flaticon', get_template_directory_uri() . '/css/flaticon.css', false, VERSION );

  if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }
}
add_action( 'wp_enqueue_scripts', 'kiddie_scripts' );


/**
 * Enqueue bootstrap before theme css
 */

function kiddie_bootstrap() {
  // enqueue Bootstrap CSS
  wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css' );
}
add_action( 'wp_enqueue_scripts', 'kiddie_bootstrap', 9 );


function kiddie_remove_sidebars() {
  // unregister timetable sidebars
  unregister_sidebar( 'sidebar-event' );
}
add_action( 'widgets_init', 'kiddie_remove_sidebars', 11 );



// Right time to add media scripts
function kiddie_admin_scripts( $hook ) {
  if ( 'widgets.php' == $hook  ) {
    if ( function_exists( 'wp_enqueue_media' ) ) {
      wp_enqueue_media();
    }
  }
}
add_action( 'admin_enqueue_scripts', 'kiddie_admin_scripts' );


/**
* Add some special google fonts to Visual Composer
*/

add_filter( 'vc_google_fonts_get_fonts_filter','kiddie_add_theme_fonts_to_visual_composer' );

function kiddie_add_theme_fonts_to_visual_composer( $fonts_list ) {
  $kiddie_theme_font = new stdClass;
  $kiddie_theme_font->font_family = 'Salsa';
  $kiddie_theme_font->font_styles = 'regular';
  $kiddie_theme_font->font_types = '400 regular:400:normal';

  $fonts_list = array_merge( $fonts_list, array( $kiddie_theme_font ) );
  return $fonts_list;

}

/**
 *  Remove VC Frontend Link
 */

function kiddie_vc_remove_frontend_links() {
  vc_disable_frontend();
}
add_action( 'vc_after_init', 'kiddie_vc_remove_frontend_links' );


function kiddie_vcSetAsTheme() {
  vc_set_as_theme();
}
add_action( 'vc_before_init', 'kiddie_vcSetAsTheme' );


function kiddie_vc_remove_wp_admin_bar_button() {
  remove_action( 'admin_bar_menu', array( vc_frontend_editor(), 'adminBarEditLink' ), 1000 );
}
add_action( 'vc_after_init', 'kiddie_vc_remove_wp_admin_bar_button' );


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * WooCommerce settings.
 */
require get_template_directory() . '/inc/woocommerce-functions.php';

/**
* Load TGM Plugins activation
*/
require get_template_directory() . '/plugin-activation/activator.php';


