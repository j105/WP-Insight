<?php

/**
 * Kiddie  special functions and definitions
 *
 * @package Kiddie
 */

/*
 -----------------------------------------------------------------------------------*/
/*
   Function to output different bootstrap classes
/*-----------------------------------------------------------------------------------*/

function kiddie_get_bc( $col_lg = null, $col_md = null, $col_sm = null, $col_xs = null ) {
	$bootstrap_classes = '';
	if ( ! empty( $col_lg ) ) {
		$bootstrap_classes .= "col-lg-$col_lg ";
	}
	if ( ! empty( $col_md ) ) {
		$bootstrap_classes .= "col-md-$col_md ";
	}
	if ( ! empty( $col_sm ) ) {
		$bootstrap_classes .= "col-sm-$col_sm ";
	}
	if ( ! empty( $col_xs ) ) {
		$bootstrap_classes .= "col-xs-$col_xs ";
	}
	return $bootstrap_classes;
}

function kiddie_bc( $col_lg = null, $col_md = null, $col_sm = null, $col_xs = null ) {
	echo esc_attr( kiddie_get_bc( $col_lg, $col_md, $col_sm, $col_xs ) );
}


function kiddie_get_bc_all( $column ) {
	return "col-lg-$column col-md-$column col-sm-$column";
}

function kiddie_bc_all( $column ) {
	echo esc_attr( kiddie_get_bc_all( $column ) );
}



/*
 -----------------------------------------------------------------------------------*/
/*
   Function to convert HEX code to RGBA
/*-----------------------------------------------------------------------------------*/
function kiddie_hex2rgba( $color, $opacity = false ) {

	$default = 'rgb(0,0,0)';

	// Return default if no color provided
	if ( empty( $color ) ) {
		  return $default; }

	// Sanitize $color if "#" is provided
	if ( '#' == $color[0] ) {
		$color = substr( $color, 1 );
	}

	// Check if color has 6 or 3 characters and get values
	if ( strlen( $color ) == 6 ) {
			$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	} elseif ( strlen( $color ) == 3 ) {
			$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
	} else {
			return $default;
	}

	// Convert hexadec to rgb
	$rgb = array_map( 'hexdec', $hex );

	// Check if opacity is set(rgba or rgb)
	if ( $opacity ) {
		if ( abs( $opacity ) > 1 ) {
			$opacity = 1.0; }
		$output = 'rgba(' . implode( ',',$rgb ) . ',' . $opacity . ')';
	} else {
		$output = 'rgb(' . implode( ',',$rgb ) . ')';
	}

	// Return rgb(a) color string
	return $output;
}



/*
 -----------------------------------------------------------------------------------*/
/*
   Excerpt functions
/*-----------------------------------------------------------------------------------*/
function kiddie_excerpt( $len = 20 ) {
	$limit = $len + 1;
	$excerpt = explode( ' ', get_the_excerpt(), $limit );
	$num_words = count( $excerpt );
	if ( $num_words >= $len ) {
		array_pop( $excerpt );
	}
	$excerpt = implode( ' ', $excerpt );

	echo apply_filters( 'kiddie_excerpt_more',$excerpt ); // WPCS: XSS OK.
}

function kiddie_excerpt_more_link( $excerpt ) {
	return esc_attr( $excerpt ) . ' <a class="read-more" href="' . esc_url( get_permalink( get_the_ID() ) ) . '"> [&hellip;]</a>';
}
add_filter( 'kiddie_excerpt_more', 'kiddie_excerpt_more_link' );



/*
 -----------------------------------------------------------------------------------*/
/*
   Make subcategories to use parent category
/*-----------------------------------------------------------------------------------*/

function kiddie_load_cat_parent_template( $template ) {

	$cat_id = absint( get_query_var( 'cat' ) );
	$category = get_category( $cat_id );

	$templates = array();

	if ( ! is_wp_error( $category ) ) {
		$templates[] = "category-{$category->slug}.php"; }

	$templates[] = "category-$cat_id.php";

	// trace back the parent hierarchy and locate a template
	if ( ! is_wp_error( $category ) ) {
		$category = $category->parent ? get_category( $category->parent ) : '';

		if ( ! empty( $category ) ) {
			if ( ! is_wp_error( $category ) ) {
				$templates[] = "category-{$category->slug}.php"; }

			$templates[] = "category-{$category->term_id}.php";
		}
	}

	$templates[] = 'category.php';
	$template = locate_template( $templates );

	return $template;
}
add_action( 'category_template', 'kiddie_load_cat_parent_template' );



/*
 -----------------------------------------------------------------------------------*/
/*
   If category show only the category name
/*-----------------------------------------------------------------------------------*/
function kiddie_get_the_archive_title( $title ) {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'kiddie_get_the_archive_title' );



/*
 -----------------------------------------------------------------------------------*/
/*
   Sanitize a hex color containing #
/*-----------------------------------------------------------------------------------*/
function kiddie_sanitize_hex_color( $color ) {

	if ( '' === $color ) {
		return ''; }

	// 3 or 6 hex digits, or the empty string.
	if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
		return $color; }
}
