<?php
/**
 * The template for displaying the footer.
 * Contains the closing of the #content div and all content after
 *
 * @package Kiddie
 */
?>
		<div class="ztl-sidebar-area">		
			<?php if ( is_active_sidebar( 'sidebar-footer-pricing-plans' ) ) : ?>
					<?php if ( (is_page_template( 'template-pricing-plans.php' )) ) { dynamic_sidebar( 'sidebar-footer-pricing-plans' ); } ?>
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'sidebar-footer-about-us' ) ) : ?>
					<?php if ( (is_page_template( 'template-about-us.php' )) ) { dynamic_sidebar( 'sidebar-footer-about-us' ); } ?>
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'sidebar-footer-staff' ) ) : ?>
					<?php if ( (is_page_template( 'template-staff.php' )) ) { dynamic_sidebar( 'sidebar-footer-staff' ); } ?>
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'sidebar-footer-contact' ) ) : ?>
				<?php if ( (is_page_template( 'template-contact-1.php' )) ) { dynamic_sidebar( 'sidebar-footer-contact' ); } ?>
			<?php endif; ?>
		</div>
	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<?php if ( is_active_sidebar( 'sidebar-footer' ) ) : ?>
		<div class="sidebar-footer">
			<div class="container">
				<div class="row">
						<?php dynamic_sidebar( 'sidebar-footer' ); ?>
				</div>
			</div>
		</div>
		<?php endif; ?>

		<div class="site-info">			
			<div class="container">
				<div class="row">
					<div class="col-sm-6 col-xs-12">
						<?php
							$allowed_tags = array(
								'i' => array(
									'class' => array(),
									'style' => array(),
									),
								'a' => array(
									'style' => array(),
									'href'=> array(),
									),
								'strong' => array(),
							);
						?>
						<div id="ztl-copyright">
						<?php
							// we allow some nice tags for this area
							if ( get_theme_mod( 'copyright_textbox' ) ) {
								echo wp_kses( get_theme_mod( 'copyright_textbox' ),$allowed_tags );							
							} else { 
						?>
							&copy; <?php echo date('Y'); ?>  <a href="<?php echo esc_url( home_url() ); ?>/"><?php esc_html( bloginfo( 'name' ) ); ?></a>
						<?php } ?>
						</div>
					</div>
					<div class="col-sm-6 col-xs-12">
						<?php if ( get_theme_mod( 'show_footer_social','show' ) == 'show' ) {?>
							<ul id="ztl-social">
								<?php if ( get_theme_mod( 'facebook_social_link','#' ) ) { ?>
									<li> <a href="<?php echo esc_url( get_theme_mod( 'facebook_social_link','#' ) ); ?>" title="Facebook"><i class="fa fa-facebook"></i></a></li>
								<?php } ?>
								<?php if ( get_theme_mod( 'google_social_link','#' ) ) { ?>
									<li> <a href="<?php echo esc_url( get_theme_mod( 'google_social_link','#' ) ); ?>" title="Google +"><i class="fa fa-google-plus"></i></a></li>
								<?php } ?>
								<?php if ( get_theme_mod( 'twitter_social_link','#' ) ) { ?>
									<li> <a href="<?php echo esc_url( get_theme_mod( 'twitter_social_link','#' ) ); ?>" title="Twitter"><i class="fa fa-twitter"></i></a></li>
								<?php } ?>
								<?php if ( get_theme_mod( 'youtube_social_link','#' ) ) { ?>
									<li> <a href="<?php echo esc_url( get_theme_mod( 'youtube_social_link','#' ) );?>" title="Youtube"><i class="fa fa-youtube"></i></a></li>
								<?php } ?>
								<?php if ( get_theme_mod( 'pinterest_social_link','#' ) ) { ?>
									<li> <a href="<?php echo esc_url( get_theme_mod( 'pinterest_social_link','#' ) );?>" title="Pinterest"><i class="fa fa-pinterest"></i></a></li>
								<?php } ?>
							</ul>
						<?php } ?>
					</div>
				</div>
			</div>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->
<?php wp_footer(); ?>

<?php if ( 'yes' == get_theme_mod( 'scroll_to_top' ) ) :  ?>
	<a href="#" class="ztl-scroll-top"><i class="fa fa-angle-up"></i></a>
<?php endif; ?>
</body>
</html>
