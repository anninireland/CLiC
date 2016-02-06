<?php

/******************
* display
*******************/



function echoPostID(){
	$ID = get_the_ID();
	return "Post ID: " .$ID;
 }


// adds content to posts/pages 
function gg_add_content($content) {
	
	global $gg_options;
	global $post;
	$url = site_url();

	if($gg_options['enable'] == true && is_single() ) { 


		$ID = get_the_ID();

		// menu info 
		$gg_menu = '
		<div class="gg-menu">
		<h3 class="ggtext">Grammar Guru</h3>
		<h5 class="ggtext">What would you like to practice? </h5>
		<form id="gg_menu">

		<a class="click" id="nouns" href="' .$url. '/grammar-guru/?origin_id=' .$ID. '&game=nouns">Nouns</a> 
		<a class="click" id="verbs" href="' .$url. '/grammar-guru/?origin_id=' .$ID. '&game=verbs">Verbs</a> 
		<a class="click" id="adjectives" href="' .$url. '/grammar-guru/?origin_id=' .$ID. '&game=adjectives">Adjectives</a> 
		<a class="click" id="adverbs" href="' .$url. '/grammar-guru/?origin_id=' .$ID. '&game=adverbs">Adverbs</a> 
		<br>'
		;

		// database info 
		global $wpdb;
		$table_name = $wpdb->prefix . 'gg_tagged';
		$sql = "SELECT tagged_content FROM (
		SELECT *
		FROM $table_name
	    WHERE post_ID= $ID
	    ORDER BY time DESC LIMIT 1) as tpost";
		$has_tagged_info = $wpdb->get_results ( $sql ); // database query 


		// add menu ONLY if post has tagged info in database
		if (count ($has_tagged_info) >0){
			$content .= $gg_menu;
		}
	}
	return $content ;
}

// this filter is essential to employ the function above! 
add_filter('the_content', 'gg_add_content');




