<?php
/***************************
* Enqueue Scripts
***************************/

function pestopp_load_scripts(){
	global $pestopp_options;

	wp_enqueue_style('pestopp-modal-only-bootstrap', plugin_dir_url(__FILE__). 'src/css/modal-only-bootstrap.css');
	wp_enqueue_style('pestopp-styles', plugin_dir_url(__FILE__). 'src/css/plugin-style.css');
	wp_enqueue_script( 'pestopp-scripts', plugin_dir_url(__FILE__). 'dist/js/bundle-scripts.min.js', array( 'jquery'), '1.0.0', true );

}
add_action('wp_enqueue_scripts', 'pestopp_load_scripts');
