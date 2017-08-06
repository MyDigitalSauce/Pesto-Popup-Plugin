<?php
/***************************
* Display Content Functions
***************************/

function pestopp_modal_btn(){

	global $pestopp_options;

	$button_text = $pestopp_options['button_text']; ?>
	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pestopp_modal">
	  <?php if ($button_text) {  esc_html_e( $button_text ); } ?>
	</button>

	<?php
}

function pestopp_modal(){

	global $pestopp_options;

	$modal_style_theme = 'dark-style-theme';
	$modal_title = $pestopp_options['modal_title'];
	$modal_body = $pestopp_options['modal_body']; ?>

	<div id="pestopp_modal" class="<?php if ($modal_style_theme) { echo $modal_style_theme; } ?> modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
		  <div class="modal-content">
		  	<?php if ($modal_title): ?>
			    <div class="modal-header">
			      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			      <h4 class="modal-title" id="myModalLabel"><?php esc_html_e( $modal_title, 'pestopp_domain'); ?></h4>
			    </div>
		    <?php endif; ?>
		    <div class="modal-body">
		    	<?php
		    	if ($modal_body) {
			    	esc_html_e( $modal_body, 'pestopp_domain'); 		
		    	}
			    ?>
		    </div>
		    <div class="modal-footer">
		    </div>
		  </div><!-- end of <div class="modal-content"> -->
		</div>
	</div><!-- end of <div id="pesto_modal" -->

	<?php
}

function pestopp_add_content($content){
	
	global $pestopp_options;

	$how_should_it_appear = $pestopp_options['how_should_it_appear'];

	$extra_content = do_shortcode('[pesto_popup_plugin]');

	if ( $how_should_it_appear == "button") {

		if ( is_main_query() ) {
			return $content . $extra_content;
		}

	} else {
 
		$pestopp_enabled_after_time = false;

		$args = array(
		   'public'   => true,
		);				  
		$post_types = get_post_types( $args, 'names', 'and' );

		if ( isset ( $pestopp_options['sitewide_enabled'] ) ) {
			$pestopp_enabled_after_time = true;
		} else if ( $post_types ) { // If there are any custom public post types.
		    foreach ( $post_types  as $post_type ) {

		    	// return content if enable_$post_type is true
		    	if ( isset( $pestopp_options[$post_type.'_enabled'] ) ) {
		    		if ( is_singular( $post_type ) ) {
		    			$pestopp_enabled_after_time = true;
		    		}
		    	}

		    } // end foreach
		}

		if ( $pestopp_enabled_after_time && is_main_query() ) {
			return $content . $extra_content;
		}

	}

	return $content;
	
}
add_filter('the_content', 'pestopp_add_content');

function pestopp_custom_css() {
	
	global $pestopp_options; ?>
	    <style type="text/css">
		/* Pesto Popup Plugin Custom CSS */
		<?php echo $pestopp_options['custom_css']; ?>
	    </style>
	    <?php
}
add_action('wp_head', 'pestopp_custom_css');

function pestopp_set_timeout_set_cookie() {
	
	global $pestopp_options;

	$how_should_it_appear = $pestopp_options['how_should_it_appear'];
	$timeout_duration = $pestopp_options['timeout_duration'];

	if ( $how_should_it_appear == "after_time" ) { ?>
	    <script type="text/javascript">
	    function pestopp_open_modal() {
	    	jQuery('#pestopp_modal').modal({show:true});/* Requires a $ sign */
	    }
	    jQuery(document).ready(function($){
			setTimeout(pestopp_open_modal, <?php echo $timeout_duration; ?>);
	    });
	    </script>
	<?php }

}
add_action('wp_footer', 'pestopp_set_timeout_set_cookie');