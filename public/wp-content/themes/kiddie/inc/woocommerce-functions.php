<?php
/**
 * WooCommerce behavior and settings
 */

/*
 * Change number or products per row to 3
*/
add_filter('loop_shop_columns', 'kiddie_loop_columns');
function kiddie_loop_columns() {
    return 3; // 3 products per row
}


/**
 * Change Add to cart text to Nothing
 */
add_filter( 'woocommerce_product_add_to_cart_text', 'kiddie_archive_custom_cart_button_text' );    // 2.1 +
function kiddie_archive_custom_cart_button_text()
{
    return;
}


/**
 * Change Add to cart with Add to Cart
 */
add_filter( 'woocommerce_product_single_add_to_cart_text', 'kiddie_custom_cart_button_text' );    // 2.1 +
function kiddie_custom_cart_button_text() {
    return esc_html__( 'Add to Cart', 'kiddie' );
}



/**
 * Set number of products per page
 */

// Display 9 products per page. Goes in functions.php
add_filter( 'loop_shop_per_page','kiddie_products_per_page' , 20 );
function kiddie_products_per_page(){
    $kiddie_products_per_page = get_theme_mod('shop_products_per_page');
    if (!empty($kiddie_products_per_page)){
        return (int) $kiddie_products_per_page;
    }
    return 9;
}




add_filter( 'woocommerce_output_related_products_args', 'kiddie_related_products_columns' );
function kiddie_related_products_columns( $args ) {
    $args['posts_per_page'] = 3; // 3 related products
    $args['columns'] = 3; // arranged in 3 columns
    return $args;
}

/**
 * Remove product title from single product page
 */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );

?>