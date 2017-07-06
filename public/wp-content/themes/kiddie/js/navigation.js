/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens an return to big screens.
 */
( function( $ ) {
	'use strict';

	var mobile;
	var reset = false; // reset some elements when desktop/mobile browser resize

	
	//reset some elements when window resize and no refresh
	function resetMobile () {
		if ( mobile != $( 'html' ).data( 'mobile' ) ){
			reset = true;	
		} else {
			reset = false;
		}

		if (mobile){
			$( 'html' ).data( 'mobile' ,true );
		}else{
			$( 'html' ).data( 'mobile' ,false );	
		}
	}

	// check if resolution fit mobile device
    function isMobile () {
        var viewPortWidth = getWidth(); 
        if ( viewPortWidth < 768 ){
            return true;
        } else {
            return false;
        }
    }

    // get view port width. Used as it is for compatibility :)
    function getWidth(){
        return window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;  
    }

	$( document ).ready( function () {
		//make sure you populate mobile
		mobile = isMobile();	

		//menu 
		$( '#menu-toggle' ).on( 'click' , function () {
			$( '#nav-mobile-wrapper' ).slideToggle('500','linear', function () {
				$( '#menu-toggle' ).toggleClass( 'toggled open' );
			});		
		});

	});


	$( window ).resize( function () {

		mobile = isMobile();	
		resetMobile();

		if ( reset ){
			 if ($('#menu-toggle').hasClass('toggled')){
				$('#menu-toggle span').trigger( "click ");

			}
		}
	});
	
} ( jQuery ) );
