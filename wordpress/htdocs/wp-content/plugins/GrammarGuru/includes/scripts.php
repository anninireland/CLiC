<?php

/******************
* script control
*******************/

// loads css for main menu 
function gg_load_scripts() { 
	if( is_single() ) {
		wp_enqueue_style('gg-styles', plugin_dir_url( __FILE__ ) . 'css/plugin_styles.css');
	}
}
add_action('wp_enqueue_scripts', 'gg_load_scripts');

// loads scripts for template 
function add_all_gg_scripts() {
	if( is_page_template ( 'gg-template.php' ) ){

		wp_register_script( 'gg_page_js', plugin_dir_url( __FILE__ ) . '/js/ggFunctions.js', array( 'jquery' ), true );
		wp_enqueue_script( 'gg_page_js' );
		wp_enqueue_script( 'jquery' );

		wp_register_style( 'gg-style', plugin_dir_url( __FILE__ ) . 'css/gg-style.css' );
		wp_enqueue_style( 'gg-style' );
	}
}
add_action('wp_enqueue_scripts', 'add_all_gg_scripts');