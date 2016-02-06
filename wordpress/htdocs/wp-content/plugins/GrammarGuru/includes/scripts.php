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

// loads scripts for template 
function add_gg_js() {
	
	wp_register_script( 'gg_page_js', plugin_dir_url( __FILE__ ) . '/js/ggFunctions.js', array( 'jquery' ), true );

	wp_enqueue_script( 'gg_page_js');
}
add_action('wp_enqueue_scripts', 'add_gg_js');

/*
add_action('wp_enqueue_scripts', 'enqueue_my_jquery');

function enqueue_my_jquery() {
    wp_enqueue_script('jquery');
}
*/


function add_all_gg_scripts() {
	
	wp_register_script( 'gg_page_js', plugin_dir_url( __FILE__ ) . '/js/ggFunctions.js', array( 'jquery' ), true );
	wp_enqueue_script( 'gg_page_js' );
	wp_enqueue_script( 'jquery' );

	wp_register_style( 'gg-style', plugin_dir_url( __FILE__ ) . 'css/gg-style.css' );
	wp_enqueue_style( 'gg-style' );

}
add_action('wp_enqueue_scripts', 'add_all_gg_scripts');

