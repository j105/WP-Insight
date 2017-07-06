<?php
/**
 * Kiddie contact 2 template part
 *
 * @package Kiddie
 */

if ( is_page_template( 'template-contact-2.php' ) ) {
	//get default API key
	$api_key = get_theme_mod('maps_api_key','AIzaSyAfz_ozFC-3PLVYL2GZmz60TWsikGuPdUY');
	wp_enqueue_script( 'kiddie-js-google-maps', '//maps.googleapis.com/maps/api/js?key='.$api_key, array(), VERSION, true );
}
?>

<script type="text/javascript">
	(function($){
		'use strict';
		var map;
		var mapId = 'kiddie_style';

		<?php $map_color = get_theme_mod( 'contact_page_map_color','#b8d478' ); ?>
		
		function initialize() {

			var featureOpts = [
			   {
			      "featureType":"landscape.man_made",
			      "elementType":"geometry",
			      "stylers":[
			         {
			            "visibility":"on"
			         },
			         {
			            "color":"<?php echo esc_js( $map_color );?>"
			         }
			      ]
			   },
			   {
			   	"featureType": "poi",
			   	"elementType": "labels",
			   	"stylers": [
				   	{
				   		"visibility": "off"
				   	}
			   	]
			   },
			]
							
			var mapOptions = {
				zoom: <?php echo intval( get_theme_mod( 'contact_page_zoom','16' ) ); ?>,
				center: new google.maps.LatLng(<?php echo esc_js( get_theme_mod( 'contact_page_coordinates','51.497360, -0.163348' ) ); ?>),
				mapTypeId: mapId,
				scaleControl: true,
				streetViewControl: false,
				mapTypeControl: false,
				panControl: false,
				zoomControl: true,
				scrollwheel: false,
			};
			map = new google.maps.Map(document.getElementById('map-canvas-contact'), mapOptions);
			
			var customMapType = new google.maps.StyledMapType(featureOpts);

			map.mapTypes.set(mapId, customMapType);

			var mapImage =  "<?php echo esc_js( get_theme_mod( 'contact_page_pin', get_template_directory_uri() . '/images/pin.png' ) ); ?>";
			
			//add custom marker
			var marker = new google.maps.Marker({
			  position: map.getCenter(),
			  map: map,
			  icon: mapImage
			});
			
			google.maps.event.addDomListener(window, 'resize', function() {
				map.setCenter(mapOptions.center);
			});
			
		}	
		$(document).ready(function(){
			google.maps.event.addDomListener(window, 'load', initialize);
		});

		
	}(jQuery));
</script>
<?php while ( have_posts() ) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="container">
			<div class="entry-content">
				<?php the_content(); ?>
			</div><!-- .entry-content -->
		</div>

		<footer class="entry-footer">
			<div class="container">
			<?php edit_post_link( esc_html__( 'Edit', 'kiddie' ), '<span class="edit-link">', '</span>' ); ?>
			</div>
		</footer><!-- .entry-footer -->
	</article><!-- #post-## -->



<?php endwhile; // end of the loop. ?>
<div id="map-canvas-contact"></div>
