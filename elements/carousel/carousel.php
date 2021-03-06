<?php
/*
Plugin Name: Cornerstone Library: Carousel
Plugin URI:  http://bigwilliam.com/
Description: Adds a carousel element to the Cornerstone Page builder. Download plugin at <a href="http://cornerstonelibrary.com" target="_blank">Cornerstone Library</a>.
Version:     3.1.3
Author:      BigWilliam
Author URI:  http://bigwilliam.com
Author Email: hello@bigwilliam.com
Text Domain: __x__

*/


/* Prevent direct access */
if ( ! defined( 'WPINC' ) ) die;

/* Paths */
define( 'CSL_CAROUSEL_PATH', plugin_dir_path( __FILE__ ) );
define( 'CSL_CAROUSEL_URL', plugin_dir_url( __FILE__ ) );


/* Add element to Cornerstone */
add_action( 'cornerstone_register_elements', 'cspp_carousel_register_elements', 100 );

/* Add Icon Map */
add_filter( 'cornerstone_icon_map', 'cornerstone_library_icon_map');

/* scripts */
add_action( 'wp_enqueue_scripts', 'cspp_carousel_scripts');


/*
 * => FUNCTIONS
 * ---------------------------------------------------------------------------*/

if ( !function_exists( 'cspp_carousel_scripts' ) ) {
	function cspp_carousel_scripts() {
  	$v = '20170515';
  	// $v = time();
	  wp_enqueue_style( 'owl-main-css',  CSL_CAROUSEL_URL . 'bower_components/owl.carousel/dist/assets/owl.carousel.css', array(), '1.2' );
	  wp_enqueue_style( 'owl-theme-css', CSL_CAROUSEL_URL . 'bower_components/owl.carousel/dist/assets/owl.theme.default.css', array(), '1.2' );
	  wp_enqueue_style( 'cspp-carousel', CSL_CAROUSEL_URL . 'assets/css/cornerstone-carousel.css', array(), $v );
	  wp_enqueue_script( 'owlcarousel-js', CSL_CAROUSEL_URL . 'bower_components/owl.carousel/dist/owl.carousel.js', array('jquery'), null, true );
	}
}

if ( !function_exists( 'cspp_carousel_register_elements' ) ) {
	function cspp_carousel_register_elements() {
		cornerstone_remove_element( 'csl-carousel' );
		cornerstone_register_element( 'CSL_Carousel', 'csl-carousel', CSL_CAROUSEL_PATH . 'includes/csl-carousel' );
		cornerstone_remove_element( 'csl-carousel-item' );
		cornerstone_register_element( 'CSL_Carousel_Item', 'csl-carousel-item', CSL_CAROUSEL_PATH . 'includes/csl-carousel-item' );
	}
}

if ( !function_exists( 'cornerstone_library_icon_map' ) ) {
	function cornerstone_library_icon_map() {
		$icon_map['default'] = CSL_CAROUSEL_URL . '/assets/svg/icons.svg';
		return $icon_map;
	}
}