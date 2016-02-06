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

function gg_test_activate() {

	// do this when plugin is activated 


	/******************
	* create custom page  
	*******************/
	$gg_custom_page = array(
		'post_title' => 'Grammar Guru TEST PAGE',
		'post_content' => 'Our filler text for the post.',
		'post_status' => 'publish',
		'post_type' => 'page',
	);
	$postID = wp_insert_post($gg_custom_page);

    //if ( $postID && ! is_wp_error( $postID ) ){
        
        update_post_meta( $postID, '_wp_page_template', 'gg-template.php' );
        
    //}

}
register_activation_hook( __FILE__, 'gg_test_activate' );





?>