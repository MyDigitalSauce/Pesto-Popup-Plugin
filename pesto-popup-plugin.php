<?php
/*
Plugin Name: Pesto Popup Plugin
Plugin URI: https://mydigitalsauce.com
Description: Pesto Popup Plugin allows you to show popups with contact or email subscriber forms, age verification notices, basically anything; anywhere on your WordPress site via a shortcode or having the popup appear on pages, posts or any custom post type.
Author: MyDigitalSauce
Author URI: https://mydigitalsauce.com/author/mydigitalsauce
Version: 1.0
*/

/***************************
* Global Variables
***************************/
$pestopp_prefix = 'pestopp_';
$pestopp_plugin_name = 'Pesto Popup Plugin';

// retrieve our plugin settings from the options table
$pestopp_options = get_option('pestopp_settings');

/***************************
* Constants
***************************/
if ( ! defined( 'PESTOPP_DIR' ) ) {
	define( 'PESTOPP_DIR', dirname( __FILE__ ) );
}
if( ! defined( 'PESTOPP_URL' ) ) {
	define( 'PESTOPP_URL', plugin_dir_url( __FILE__ ) );
}
/***************************
* Internalization
***************************/
/**
 * Loads plugin text domain
 *
 * Used for internationalization
 *
 * @access      private
 * @since       1.0 
 * @return      void
*/
function pestopp_textdomain() {
	load_plugin_textdomain( 'pestopp_domain', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action('init', 'pestopp_textdomain');

/***************************
* Includes
***************************/
/* Admin Area - Back End */
include( 'includes/admin-page.php'); // admin page
/* Front End */
include( 'includes/enqueue-scripts.php'); // enqueues js and css
include( 'includes/functions.php'); // display content functions
include( 'includes/shortcodes.php'); // shortcodes

