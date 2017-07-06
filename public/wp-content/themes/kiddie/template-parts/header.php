<?php
/**
 * Kiddie header image / header title template part
 *
 * @package Kiddie
 */

// In case is page and has option to show header image.
$header_image_option = get_post_meta( get_the_ID(), 'kiddie_header_image_option', true );

if ( (is_page() || is_singular()) && ( 'visible' === $header_image_option ) ) {
    $header_image = get_header_image();
} elseif (!is_page() && !is_singular()) {
    $header_image = get_header_image();
}

?>
<div class="page-top clearfix custom-header <?php if ( ! empty( $header_image ) ) { echo 'ztl-header';}?>"
    <?php if ( ! empty( $header_image ) ) { echo "style='background-image: url(" . esc_url( $header_image ) . ")'";}?> >
    <div class="container header-image">
        <div class="row">
            <div class="<?php kiddie_bc_all( '12' ); ?>">
                <h1 class="custom-header-title dark-title <?php if ( ! empty( $header_image ) ) {  echo 'ztl-background-image'; } ?>"
                    <?php if ( ! empty( $header_image ) ) : ?> style="color:<?php echo esc_attr( get_theme_mod( 'title_light_color','#ffffff' ) ); ?>;"
                    <?php else : ?> style="color:<?php echo esc_attr( get_theme_mod( 'title_dark_color','#704825' ) ); ?>;"<?php endif; ?> >
                    <?php
                    if ( is_category() || is_author() || is_date() || is_tag() ) {
                        the_archive_title();
                    } elseif ( is_page() || is_singular() ) {
                        the_title();
                    } elseif ( is_search() ) {
                        printf( esc_html__( 'Search Results for: %s', 'kiddie' ), '<span>' . get_search_query() . '</span>' );
                    } else{
                        wp_title('',true);
                    }
                    ?>
                </h1>
            </div>
        </div>
    </div>
</div>
