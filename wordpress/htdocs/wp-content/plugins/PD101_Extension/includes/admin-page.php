<?php 

// this is the code for the options page 
function PD101_options_page() {
	
	global $PD101_options;
	
	ob_start();  ?>
	<div class="wrap">
		<h2>PD101 Options</h2>
		
		<form method='post' action='options.php'>
			
			<?php settings_fields('PD101_settings_group'); ?> 

			<h4><?php _e('Enable', 'PD101_domain'); ?></h4>
			<p>
				<input id="PD101_settings[enable]" name="PD101_settings[enable]" type="checkbox" value="1" <?php checked(1, $PD101_options['enable']); ?> />
				<label class="description" for="PD101_settings[enable]"><?php _e('Display the Follow Me on Twitter link', 'PD101_domain'); ?></label>
			</p>
			
			<h4><?php _e('Twitter Information', 'PD101_domain'); ?></h4>
			<p>
				<input id="PD101_settings[twitter_url]" name="PD101_settings[twitter_url]" type="text" value="<?php echo $PD101_options['twitter_url']; ?>"/>
				<label class="description" for="PD101_settings[twitter_url]"><?php _e('Enter your Twitter URL', 'PD101_domain'); ?></label>
			</p>
			
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Save Options', 'PD101_domain'); ?>" />
			</p>
			
		</form>
		
	</div>
	<?php
	echo ob_get_clean();
}

// adds options link to the settings menu 
function PD101_add_options_link() {
	add_options_page('PD101 Options', 'PD101', 'manage_options', 'PD101_options', 'PD101_options_page');
}
add_action('admin_menu', 'PD101_add_options_link');

// this registers the setting to the database
function PD101_register_settings() {
	register_setting('PD101_settings_group', 'PD101_settings');
}
add_action('admin_init', 'PD101_register_settings');