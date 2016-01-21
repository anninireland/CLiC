<?php
/*
Plugin Name: _GG test area
Plugin URI: 
Description: GG Testing zone. 
Version: 1.
Author: Lisa
Author URI: 
*/

 

/*
add db table on activation
*/
global $gg_db_version;
$gg_db_version = '1.0';

function gg_install() {
	global $wpdb;
	global $gg_db_version;

	$table_name = $wpdb->prefix . 'gg_pos_tags';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		post_ID mediumint(9) NOT NULL UNIQUE KEY,
		post_title varchar(100) NOT NULL,
		post_content text NOT NULL,
		tagged_content text NOT NULL,
		nouns text NOT NULL,
		verbs text NOT NULL,
		adjectives text NOT NULL,
		adverbs text NOT NULL,

	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'gg_db_version', $gg_db_version );
}
register_activation_hook( __FILE__, 'gg_install' );


function gg_install_data() {
	global $wpdb;
	
	$table_name = $wpdb->prefix . 'gg_pos_tags';
	
	$wpdb->insert( 
		$table_name, 
		array( 
			'post_ID' => 1, 
			'post_title' => "Sample" , 
			'post_content' => "The enormous broad tires of the chariots and the padded feet of the animals brought forth no sound from the moss-covered sea bottom; and so we moved in utter silence, like some huge phantasmagoria, except when the stillness was broken by the guttural growling of a goaded zitidar, or the squealing of fighting thoats.",
			'tagged_content' => "",
			'nouns' => "noun",
			'verbs' => '["tires", "chariots", "feet", "animals", "sound", "sea", "bottom", "silence", "phantasmagoria", "stillness", "growling", "zitidar", "squealing", "thoats"]',
			'adjectives' => "",
			'adverbs' => "",
		) 
	);
}
register_activation_hook( __FILE__, 'gg_install_data' );

/*
function to run whenever a post is saved 
*/
function gg_get_pos_data( $post_id ) {
	global $wpdb;
	$table_name = $wpdb->prefix . 'gg_pos_tags';

	// run tagger

	// save results to db 
	$wpdb->replace( 
		$table_name, 
		array( 
		// data goes here 
			'post_ID' => $post_id, 
			'post_title' => get_the_title( $post_id ), 
			'post_content' => get_the_content( $post_id ),
			'tagged_content' => "nested array ",
			'nouns' => "noun",
			'verbs' => '["tires", "chariots", "feet", "animals", "sound", "sea", "bottom", "silence", "phantasmagoria", "stillness", "growling", "zitidar", "squealing", "thoats"]',
			'adjectives' => "adjectives",
			'adverbs' => "adverbs",
			)
		);
}
add_action( 'save_post', 'gg_get_pos_data' );

?>