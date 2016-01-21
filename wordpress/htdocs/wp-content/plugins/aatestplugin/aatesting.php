<?php
/*
Plugin Name: _AA test area
Plugin URI: 
Description:  Testing zone. 
Version: 1.
Author: Lisa
Author URI: 
*/

global $aa_db_version;
$aa_db_version = '1.0';

function aa_install() {
	global $wpdb;
	global $aa_db_version;

	$table_name = $wpdb->prefix . 'aatest';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		post_ID mediumint(9) NOT NULL,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		post_title VARCHAR(100) NOT NULL,
		post_content LONGTEXT NOT NULL,
		tagged_content LONGTEXT NOT NULL,
		nouns LONGTEXT NOT NULL,
		verbs LONGTEXT NOT NULL,
		adjectives LONGTEXT NOT NULL,
		adverbs LONGTEXT NOT NULL,

		UNIQUE KEY id (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'aa_db_version', $aa_db_version );
}

register_activation_hook( __FILE__, 'aa_install' );

// ********* LATER *************
// need function to run on activation that will schedule all posts to be added to the table 


// set this function inside a scheduled task  ///
/*
function to run whenever a post is saved 
*/
function aa_get_pos_data( $post_id ) {
	global $wpdb;
	$table_name = $wpdb->prefix . 'aatest';

	// get the content and prepare it for the tagger 
	$content_post = get_post($post_id);
	$content = $content_post->post_content;
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]&gt;', $content);

	// run tagger
	include 'tagger.php';
	$tagged_text = aa_tag_the_content( $content );
	$posArrays = aa_build_pos_arrays( $tagged_text );

	//var_dump($tagged_text);
	//var_dump($posArrays);

	// save results to db 
	$wpdb->replace( 
		$table_name, 
		array( 
		// data goes here 
			'post_ID' => $post_id, 
			'time' => current_time( 'mysql' ),
			'post_title' => get_the_title( $post_id ), 
			'post_content' => $content,
			'tagged_content' => json_encode($tagged_text),
			'nouns' => json_encode($posArrays[0]),
			'verbs' => json_encode($posArrays[1]),
			'adjectives' => json_encode($posArrays[2]),
			'adverbs' => json_encode($posArrays[3]),
			)
		);
}
add_action( 'save_post', 'aa_get_pos_data' );

