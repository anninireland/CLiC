<?php
/*
Plugin Name: Grammar Guru
Plugin URI: http://
Description: Grammar Guru helps students practice basic grammar in context
Author: Lisa Cavern
Version: 1.0
*/

/******************
* global variables
*******************/

$gg_plugin_name = 'Grammar Guru';

// declares settings and allows it to be retreived by the plugin
$gg_options = get_option('gg_settings');


/******************
* includes
*******************/

define( 'GG_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
/* see PD101 video 10 after 10:00 for more info and instructions */
if( is_admin() ) {
	include( GG_PLUGIN_PATH . 'includes/admin-page.php'); // admin page

}
else {
	include( GG_PLUGIN_PATH . 'includes/scripts.php'); // this controls all JS / CSS 
}

include('includes/data-processing.php'); // this controls all saving of data
include('includes/display-functions.php');  // content display functions


/******************
* database set up 
*******************/


global $gg_db_version;
$gg_db_version = '1.0';

function gg_activate() {
	global $wpdb;
	global $gg_db_version;

	$table_name = $wpdb->prefix . 'gg_tagged';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		post_ID mediumint(9) NOT NULL,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		post_title VARCHAR(100) NOT NULL,
		post_content TEXT NOT NULL,
		tagged_content TEXT NOT NULL,

		UNIQUE KEY id (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'gg_db_version', $gg_db_version );
}

register_activation_hook( __FILE__, 'gg_activate' );



/******************
* test area
*******************/

class GG_test {
	function __construct() {
		// $this->load();
	}
	function load() {
		add_action( 'admin_notices', array( $this, 'notice' ) );
	}
	function notice() {
		echo '<div class="updated"><p>This is my admin notice. my plugin works!!</p></div>';
	}
}

$gg_test = new GG_test;

$gg_test->load();

