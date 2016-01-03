<?php 
/**
 * ggtheme functions and definitions
 *
 */

function add_gg_js() {
	wp_register_script( 'gg_theme_js', get_stylesheet_directory_uri() . '/js/jsFunctions.js', array( 'jquery' ), true );
	wp_enqueue_script( 'gg_theme_js');
}
add_action('wp_enqueue_scripts', 'add_gg_js');