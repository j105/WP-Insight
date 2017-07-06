<?php
/**
 * The header for Kiddie theme.
 * Displays all of the <head> section and everything up till <div id="content"> *
 *
 * @package Kiddie
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site <?php if ( get_theme_mod( 'layout_mode' ) == 'boxed' ) {  echo 'wrapper';} ?>">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'kiddie' ); ?></a>
	<div id="head-frame">
	<header id="masthead" class="site-header">		
		<div class="container">
			<div id="logo" style="width:<?php echo esc_attr( get_theme_mod( 'logo_width', '140' ) ); ?>px;">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<img class="logo-img" src="<?php echo esc_url( get_theme_mod( 'logo_upload', get_template_directory_uri() . '/images/logo.png' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>" data-rjs="2" />
				</a>
			</div>
			<div id="menu-toggle">
				<!-- navigation hamburger -->
				<span></span>
				<span></span>
				<span></span>
				<span></span>
			</div>
			<div id="nav-mobile-wrapper">
				<nav id="site-navigation" class="main-navigation">
					<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
				</nav><!-- #site-navigation -->
				<div class="clear"></div>
			</div>
			
		</div>
	</header><!-- #masthead -->
	</div>
	<div id="content" class="site-content">
