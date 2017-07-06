<?php
/**
 * Kiddie pagination template part used everywhere the pagination is needed for custom queries
 *
 * @package Kiddie
 */

global $query;
$big = 999999999; // Need an unlikely integer.

echo '<div class="pagination">';
echo wp_kses( paginate_links( array(
	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	'format' => '?paged=%#%',
	'current' => max( 1, get_query_var( 'paged' ) ),
	'total' => $query->max_num_pages ? (int) $query->max_num_pages : 1,
	'prev_text' => esc_html__( 'Previous','kiddie' ),
	'next_text' => esc_html__( 'Next','kiddie' ),
) ), array( 'span' => array( 'class' => array() ), 'a' => array( 'href' => array(), 'class' => array(), 'name' => array() ) ) );
echo '</div>';
