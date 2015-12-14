<?php

/******************
* script control
*******************/

// loads css
function gg_load_scripts() { // loads on all pages by default

	// use if is_single() is_page() etc to limit where css is applied
	if(is_single() ) {
			wp_enqueue_style('gg-styles', plugin_dir_url( __FILE__ ) . 'css/plugin_styles.css');
	}

}

add_action('wp_enqueue_scripts', 'gg_load_scripts');