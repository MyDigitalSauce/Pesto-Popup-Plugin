<?php
/***************************
* Shortcodes
* Creates shortcode [pesto_popup_plugin] 
***************************/

function pestopp_shortcode_func(){

  global $pestopp_options;

  // var_dump($pestopp_options);

  /* Shortcode usable options */
  $logged_out_users = ( isset( $pestopp_options['logged_out_users'] ) ? true : false );
  $logged_in_users = ( isset( $pestopp_options['logged_in_users'] ) ? true : false );
  $how_should_it_appear = $pestopp_options['how_should_it_appear'];

  ob_start();

  // logged out options = true && user is not logged in
  if ( $logged_out_users && ( ! is_user_logged_in() ) ) {

      /* Button Func*/
      if ( $how_should_it_appear == "button" ) { 
        pestopp_modal_btn();
      }
      /* Modal Func*/
      pestopp_modal();  

  } else if ( $logged_in_users && is_user_logged_in() ) {

      /* Button Func*/
      if ( $how_should_it_appear == "button" ) { 
        pestopp_modal_btn();
      }
      /* Modal Func*/
      pestopp_modal();  
  }



  $output_string = ob_get_contents();
  ob_get_clean();
  return $output_string;
}

add_shortcode('pesto_popup_plugin', 'pestopp_shortcode_func');