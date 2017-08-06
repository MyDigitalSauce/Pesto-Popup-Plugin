<?php
/***************************
* Admin Page
***************************/
// Pesto Popup Plugin Settings
// Free version create one Popup, Premium version create multiple Popups

// Functional Popup Settings

/* ======================== = How should this popup appear? = ======================== */
// Input type - Radio - After a button is clicked? - $pestopp_options['how_should_it_appear'])
// Input type - Radio - After a set amount of time? - $pestopp_options['how_should_it_appear'])

// if ( how_should_it_appear == "clicked" ) {

	// Input type - Text - Button Text
	// Show shortcode

// } else {
	
	/* ======================== = When should this popup appear? = ======================== */
	// Input type - Select - 15 seconds, 30 seconds, 60 seconds, 2 minutes, 5 minutes?

	/* ======================== = Where should this popup appear? = ======================== */
	// Input type - Checkbox - Enable popup sitewide
	// Input type - Checkbox - Check to select what pages or post types to enable the popup

	/* ======================== = Who should it appear for? = ======================== */
	// Input type - Checkbox - Logged in Users Only (?) Only displays for users who are logged in
	// Input type - Radio Button (Who) - Selected - Everyone, Everytime
	// Input type - Radio Button (Who) - First time New Visitors (?) Will not appear for returning users // Input type - Select - Resets after 1 day, 3 days, 1 week, 2 weeks, 1 month?

// }

/* ======================== = What content should the popup have? = ======================== */
// Input type - Text - Title
// Input type - TextArea - WYSWYG Editor (Enable shortcodes)

// Styling Popup Settings
// Input type - Color Selector - Title, Footer background
// Input type - Color Selector - Content background
// Input type - TextArea - Custom CSS



function pestopp_add_options_link(){
	add_options_page('Pesto Popup Plugin Options', 'Pesto Popup Plugin', 'manage_options', 'saucyss-options', 'pestopp_options_page');
}
add_action('admin_menu', 'pestopp_add_options_link');

function pestopp_register_settings(){
	register_setting('pestopp_settings_group', 'pestopp_settings');
}
add_action('admin_init', 'pestopp_register_settings');

function pestopp_options_page(){

	global $pestopp_options;

	ob_start(); ?>
	<div class="wrap">

		<h2><?php _e('Pesto Popup Plugin Options', 'pestopp_domain'); ?></h2>

		<form method="post" action="options.php">

			<?php settings_fields('pestopp_settings_group'); ?>

			<h3><?php _e('Functional Popup Settings', 'pestopp_domain'); ?></h3>

			<h4><?php _e('How should this popup appear?', 'pestopp_domain'); ?></h4>
			<p>
				<input id="radio-after-time" class="radio-how-should-it-appear" type="radio" name="pestopp_settings[how_should_it_appear]" value="after_time" <?php checked('after_time', $pestopp_options['how_should_it_appear']); ?> >
				<label class="description" for="radio-after-time" class="radio-label">After a set Time Duration</label>
				<br/>
				<input id="radio-button" class="radio-how-should-it-appear" type="radio" name="pestopp_settings[how_should_it_appear]" value="button" <?php checked('button', $pestopp_options['how_should_it_appear']); ?> >
				<label class="description" for="radio-button" class="radio-label">After a Button is Clicked</label>

			</p>

			<div class="radio-after-time-set-wrapper">				
				<h4><?php _e('When should this popup appear?', 'pestopp_domain'); ?></h4>
				<p>
					<?php
					$pestopp_timeout_durations = array(
						'15 sec' => 15000,
						'30 sec' => 30000,
						'1 min' => 60000,
						'2 min' => 120000,
						'3 min' => 180000
					);
					?>

					<select name="pestopp_settings[timeout_duration]"  id="pestopp_settings[timeout_duration]">
						<?php foreach( $pestopp_timeout_durations as $key => $value ) {
							if ( $pestopp_options['timeout_duration'] == $value ){
								$selected = 'selected';
							} else {
								$selected = '';
							} ?>
							<option value="<?php echo $value; ?>" <?php echo $selected; ?>><?php echo $key; ?></option>
						<?php } ?>
					</select>
					<label class="description" for="pestopp_settings[timeout_duration]"><?php _e('Time duration before the popup appears', 'saucyss_domain'); ?></label>
				</p>

				<h4><?php _e('Where should this popup appear?', 'pestopp_domain'); ?></h4>
				<p>
			        <input id="pestopp_settings[sitewide_enabled]" class="sitewide-enabled-checkbox" type="checkbox" name="pestopp_settings[sitewide_enabled]" value="1" <?php checked('1', isset($pestopp_options['sitewide_enabled'])); ?> />
			        <label class="description" for="pestopp_settings[sitewide_enabled]">Enable across the whole <?php bloginfo('name'); ?> site</label>
				</p>

				<div class="sitewide-enabled-set-wrapper">
					<h4><?php _e('What post types should this popup appear?', 'pestopp_domain'); ?></h4>
					<p>
						<?php
						$args = array(
						   'public'   => true,
						);				  
						$post_types = get_post_types( $args, 'names', 'and' );
						  
						if ( $post_types ) { // If there are any custom public post types.
						    foreach ( $post_types  as $post_type ) { ?>
						        <input id="pestopp_settings[<?php echo $post_type; ?>_enabled]" class="" type="checkbox" name="pestopp_settings[<?php echo $post_type; ?>_enabled]" value="1" <?php checked('1', isset($pestopp_options[$post_type.'_enabled'])); ?> />
						        <label class="description" for="pestopp_settings[<?php echo $post_type; ?>_enabled]"><?php echo $post_type; ?></label>
						    <?php }
						} ?>
					</p>
				</div><!-- end of <div class="sitewide-enabled-set-wrapper"> -->

<?php/* ======================== = Who should it appear for? = ======================== */
// Input type - Radio Button (Who) - Selected - Everyone, Everytime
// Input type - Radio Button (Who) - First time New Visitors (?) Will not appear for returning users // Input type - Select - Resets after 1 day, 3 days, 1 week, 2 weeks, 1 month? ?>

				<h4><?php _e('Who should this popup appear for?', 'pestopp_domain'); ?></h4>
				<p>
			        <input id="pestopp_settings[logged_out_users]" class="" type="checkbox" name="pestopp_settings[logged_out_users]" value="1" <?php checked('1', isset($pestopp_options['logged_out_users'])); ?> />
			        <label class="description" for="pestopp_settings[logged_out_users]">Display popup for logged out users.</label> 
			        <br/>
			        <input id="pestopp_settings[logged_in_users]" class="" type="checkbox" name="pestopp_settings[logged_in_users]" value="1" <?php checked('1', isset($pestopp_options['logged_in_users'])); ?> />
			        <label class="description" for="pestopp_settings[logged_in_users]">Display popup for logged in users.</label>
			        <br/>
			        <small>Check both to display for logged in &amp; logged out users (everyone).</small>
				</p>
				<p>
			        <input id="pestopp_settings[new_users]" class="" type="checkbox" name="pestopp_settings[new_users]" value="1" <?php checked('1', isset($pestopp_options['new_users'])); ?> />
			        <label class="description" for="pestopp_settings[new_users]">Display popup for new users visiting the site for the first time.</label> 
			        <br/>
			        <input id="pestopp_settings[returning_users]" class="" type="checkbox" name="pestopp_settings[returning_users]" value="1" <?php checked('1', isset($pestopp_options['returning_users'])); ?> />
			        <label class="description" for="pestopp_settings[returning_users]">Display popup for returning users visiting the site again.</label>
			        <br/>
			        <small>Check both to display for new &amp; returning users (everyone).</small>
				</p>



			</div><!-- end of <div class="radio-after-time-set-wrapper"> -->

			<div class="radio-button-set-wrapper">
				<h4><?php _e('How should this button look?', 'pestopp_domain'); ?></h4>
				<p>
					<input id="pestopp_settings[button_text]" name="pestopp_settings[button_text]" type="text" value="<?php if (isset($pestopp_options['button_text'])) { echo $pestopp_options['button_text']; } ?>"/>
					<label class="description" for="pestopp_settings[button_text]" class=""><?php _e('Button Text', 'pestopp_domain'); ?></label>					
				</p>
		        <pre>[pesto_popup_plugin]</pre>
		    </div>

			<h4><?php _e('What content should the popup have?', 'pestopp_domain'); ?></h4>
			<p>
				<input id="pestopp_settings[modal_title]" name="pestopp_settings[modal_title]" type="text" value="<?php echo $pestopp_options['modal_title']; ?>"/>
				<label class="description" for="pestopp_settings[modal_title]" class=""><?php _e('Modal Title', 'pestopp_domain'); ?></label>					
			</p>
			<p>
				<label class="description" for="pestopp_settings[modal_body]"><?php _e('Modal Body (WYSIWYG Editor)', 'pestopp_domain'); ?></label>
				<br/>
				<textarea id="pestopp_settings[modal_body]" name="pestopp_settings[modal_body]" cols="80" rows="10"><?php if (isset($pestopp_options['modal_body'])) { echo $pestopp_options['modal_body']; } ?></textarea>
			</p>

			<h3><?php _e('Styling Popup Settings', 'pestopp_domain'); ?></h3>
			<p>
				<label class="description" for="pestopp_settings[custom_css]"><?php _e('Custom CSS', 'pestopp_domain'); ?></label>
				<br/>
				<textarea id="pestopp_settings[custom_css]" name="pestopp_settings[custom_css]" cols="80" rows="10"><?php if (isset($pestopp_options['custom_css'])) { echo $pestopp_options['custom_css']; } ?></textarea>
			</p>

			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Save Options', 'pestopp_domain'); ?>"/>
			</p>

			<?php settings_errors( 'pestopp_settings_group' ); ?>

		</form>

		<div class="popup-settings-summary">
			<h3><?php _e('Popup Settings Summary', 'pestopp_domain'); ?></h3>
			<p>This Popup will appear after a set time duration of 15 seconds across the entire website for logged out &amp; logged in users who are returning to the site.</p>
		</div>
	</div>
<script>
function howShouldThePopupAppear() {
	if ( jQuery('input#radio-after-time').is(':checked') ) {
		jQuery('.radio-after-time-set-wrapper').slideDown();
		jQuery('.radio-button-set-wrapper').slideUp();
	} else {
		jQuery('.radio-after-time-set-wrapper').slideUp();
		jQuery('.radio-button-set-wrapper').slideDown();
	}
}
function isSitewidePopupEnabled() {
	if ( jQuery('.sitewide-enabled-checkbox').is(':checked') ) {
		jQuery('.sitewide-enabled-set-wrapper').slideUp();
	} else {
		jQuery('.sitewide-enabled-set-wrapper').slideDown();
	}
}
jQuery(document).ready(function(){
	howShouldThePopupAppear();
	isSitewidePopupEnabled();
});
jQuery('.radio-how-should-it-appear').on('change', function(){
	howShouldThePopupAppear();
	isSitewidePopupEnabled();
});
jQuery('.sitewide-enabled-checkbox').on('click', function(){
	isSitewidePopupEnabled();
});
</script>
	<?php
	echo ob_get_clean();
}