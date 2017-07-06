<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label>
        <span class="screen-reader-text"><?php echo esc_attr_x( 'Search for:', 'label', 'kiddie' ) ?></span>
        <input type="search" class="search-field"
            placeholder="<?php echo esc_attr_x( 'Search ...', 'placeholder', 'kiddie' ) ?>"
            value="<?php echo get_search_query() ?>" name="s" id="s"
            title="<?php echo esc_attr_x( 'Search for:', 'label', 'kiddie' ) ?>" />
    </label>
    <input type="submit" class="search-submit"
        value="<?php echo esc_attr_x( 'Search', 'submit button', 'kiddie' ) ?>" />
</form>
