<?php 

// this is the code for the options page 
function gg_options_page() {
	
	global $gg_options;
	
	ob_start();  ?>
	<div class="wrap">
		<h2>Grammar Guru Options</h2>
		
		<form method='post' action='options.php'>
			
			<?php settings_fields('gg_settings_group'); ?> 

			<h4><?php _e('Enable', 'gg_domain'); ?></h4>
			<p>
				<input id="gg_settings[enable]" name="gg_settings[enable]" type="checkbox" value="1" <?php checked(1, $gg_options['enable']); ?> />
				<label class="description" for="gg_settings[enable]"><?php _e('Enable Grammar Guru', 'gg_domain'); ?></label>
			</p>
			
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Save Options', 'gg_domain'); ?>" />
			</p>
			
		</form>
		
	</div>
	<?php
	echo ob_get_clean();
}

// adds options link to the settings menu 
function gg_add_options_link() {
	add_options_page('Grammar Guru Options', 'Grammar Guru', 'manage_options', 'gg_options', 'gg_options_page');
}
add_action('admin_menu', 'gg_add_options_link');

// this registers the setting to the database
function gg_register_settings() {
	register_setting('gg_settings_group', 'gg_settings');
}
add_action('admin_init', 'gg_register_settings');