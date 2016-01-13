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
	
	if($gg_options['enable'] == true && is_single() ) { 

		$ID = get_the_ID();

		$gg_menu = '
			<div class="gg-menu">
			<h3 class="ggtext">Grammar Guru</h3>
			<h5 class="ggtext">What would you like to practice? </h5>
			<form id="gg_menu">

			<a class="click" id="nouns" href="http://grammarguru.xyz/wpquery/?origin_id=' .$ID. '&game=nouns">Nouns</a> 
			<a class="click" id="verbs" href="http://grammarguru.xyz/wpquery/?origin_id=' .$ID. '&game=verbs">Verbs</a> 
			<a class="click" id="adjectives" href="http://grammarguru.xyz/wpquery/?origin_id=' .$ID. '&game=adjectives">Adjectives</a> 
			<a class="click" id="adverbs" href="http://grammarguru.xyz/wpquery/?origin_id=' .$ID. '&game=adverbs">Adverbs</a> 
			<br>'
			;

		// $postIDnote = strval(echoPostID());
		// $gg_menu .= $postIDnote;
		$content .= $gg_menu;
	}
	return $content ;
}

// this filter is essential to employ the function above! 
add_filter('the_content', 'gg_add_content');




