<?php
/*
 * Plugin Name: PD101 
 * Description: This is where I try things 
 * Author: Lisa Cavern with tutorials from Pippin Williamson
 * 
 */

/******************
* global variables
*******************/

$PD101_plugin_name = 'PD101';

// declares settings and allows it to be retreived by the plugin admin page
$PD101_options = get_option('PD101_settings');


/******************
* includes
*******************/

define( 'PD101_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
/* see PD101 video 10 after 10:00 for more info and instructions */
if( is_admin() ) {
	include( PD101_PLUGIN_PATH . 'includes/admin-page.php'); // admin page

}
else {
	include( PD101_PLUGIN_PATH . 'includes/scripts.php'); // this controls all JS / CSS 
}

// include( PD101_PLUGIN_PATH . 'includes/data-processing.php'); // this controls all saving of data
// include( PD101_PLUGIN_PATH . 'includes/display-functions.php');  // content display functions



class PD101_Base {

	public function __construct() {
		add_action( 'wp_footer', array( $this, 'footer_text' ) );

	}

	public function footer_text() {
		echo $this->get_footer_text();
	}

	public function get_footer_text() {
		return '<p>Hello! I am in the footer!</p>';
	}

}

class PD101_Extension extends PD101_base {

	public function get_footer_text() {
		return '<p><strong>Oh hey!</strong> This is cool</p>';
	}

}
new PD101_Extension;



// wpcandy_time_ago -- adds time to end of post 
add_filter( 'the_content', 'wpcandy_time_ago');

function wpcandy_time_ago ( $content ) {
	$content .= "<p class='time-message' color:'red'> " . __( 'Posted ', 'wpcandy' ) . human_time_diff( get_the_time('U'), current_time('timestamp') ) . __( ' ago', 'wpcandy' )  . "</p>";
	return $content;
} // End wpcandy_time_ago()


// twitter_link adds 'follow me to end of posts'
add_filter( 'the_content', 'twitter_link' );

function twitter_link ( $content ) {

	$content .=  'Follow me on ' . '<a href=" ' . $PD101_options['twitter_url'] . '">Twitter</a> ';
	return $content;
}


