<?php
// enqueue parent styles
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}

// load the translations from child theme languages folder.
add_action( 'after_setup_theme', 'my_kiddie_child_setup' );
function my_kiddie_child_setup() {
    load_child_theme_textdomain( 'kiddie', get_stylesheet_directory() . '/languages' );
}


add_action( 'widgets_init', 'override_sidebar_footer', 25);
function override_sidebar_footer() {
  unregister_sidebar('sidebar-footer');
  register_sidebar( array(
    'name'          => esc_html__( 'Footer', 'kiddie' ),
    'id'            => 'sidebar-footer',
    'description'   => esc_html__( 'Add widgets here to appear in footer.', 'kiddie' ),
    'before_widget' => '<aside id="%1$s" class="widget col-sm-3 %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
  ));
}

// add search box to main navigation menu
add_filter( 'wp_nav_menu_items','add_search_box', 10, 2 );
function add_search_box( $items, $args ) {
  if( $args->theme_location == 'primary' )
    $items .= '<li>' . get_search_form() . '</li>';
  return $items;
}

add_action( 'customize_register', 'kiddie_customizer_custom' );
function kiddie_customizer_custom( $wp_customize ) {

  // Instagram link
  $wp_customize->add_setting(
    'instagram_social_link',
    array(
      'default' => '#',
      'sanitize_callback' => 'kiddie_sanitize_text',
    )
  );

  $wp_customize->add_control(
    'instagram_social_link',
    array(
      'label' => esc_html__( 'Instagram Link','kiddie' ),
      'section' => 'options_social_kiddie',
      'type' => 'text',
      'priority'   => 50,
    )
  );

  // Wechat link
  $wp_customize->add_setting(
    'wechat_social_link',
    array(
      'default' => '#',
      'sanitize_callback' => 'kiddie_sanitize_text',
    )
  );

  $wp_customize->add_control(
    'wechat_social_link',
    array(
      'label' => esc_html__( 'Wechat Link','kiddie' ),
      'section' => 'options_social_kiddie',
      'type' => 'text',
      'priority'   => 50,
    )
  );

}

?>
