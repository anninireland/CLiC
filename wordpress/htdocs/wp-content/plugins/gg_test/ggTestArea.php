<?php
/*
Plugin Name: GG test area
Plugin URI: 
Description: Super simple GG starting point 
Version: 1.
Author: Lisa
Author URI: 
*/

function gg_loadMyScripts()
{
    wp_register_script( 'ggscript', plugins_url( '/ajax.js', __FILE__ ));
    wp_enqueue_script( 'ggscript' );
    wp_localize_script( 'ggscript', 'the_ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}

add_action( 'wp_enqueue_scripts','gg_loadMyScripts' );

 // THE AJAX ADD ACTIONS
 add_action( 'wp_ajax_the_ajax_hook', 'gg_action_function' );
 add_action( 'wp_ajax_nopriv_the_ajax_hook', 'gg_action_function' ); // need this to serve non logged in users
 

// THE FUNCTION
function gg_action_function(){
	// echos back the entered word 
	$noun = $_POST['noun'];
	echo"You entered " . $noun . ". Thank You! ";// this is passed back to the javascript function
	die();
}

 // ADD gg menu TO THE POST 
 function gg_menu($content){
 	if( is_single() ) {
 		$gg_start = '
		<form id="gg_start">
		<p>Enter a noun </p>
		<input id="noun" name="noun" value = "" type="text" />
		<input name="action" type="hidden" value="the_ajax_hook" /> <!-- this puts the action the_ajax_hook into the serialized form -->
		<input id="submit_button" value = "Click Me" type="button" onClick=" gg_noun();" />
		</form>

		<div id="noun_area">
		This is where your noun will be shown
		</div>
		<br>

		<a href="http://localhost/wordpress/grammar-guru/">Click Here for GG</a>

		';

		$content .= $gg_start;
	}
	return $content;
}

add_filter('the_content', "gg_menu");
?>