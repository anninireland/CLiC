<?php

/******************
* data processing
*******************/

/*
function to run whenever a post is saved 
*/
function gg_get_pos_data( $post_id ) {

	if ( get_post_status ( $post_id ) == 'publish' ) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'gg_tagged';

		// get the content and prepare it for the tagger 
		$content_post = get_post($post_id);
		$content = $content_post->post_content;
		$content = apply_filters('the_content', $content);
		$content = str_replace(']]>', ']]&gt;', $content);

		$text_content = preg_replace('(\[.*?\]|\<.*?\>)', '', $content); // removes characters between and including [] and <> 
		$sentenceArray = preg_split('/(?<=[.?!])\s+(?=[a-z])/i', $text_content); // splits content into and array of sentences

		$resultTagged = array();

		// for each sentence,
		foreach ($sentenceArray as $sentence){
			$this_result = gg_tag_the_content( $sentence ); // run the tagger
			//$this_result = $pos->tag(explode(' ', $sentence ));
			set_time_limit(40); // extends time limit to allow processing 

			$resultTagged = array_merge( $resultTagged, $this_result);
		}
		$jsonTagged = json_encode($resultTagged);


		// save results to db 
		$wpdb->replace( 
			$table_name, 
			array( 
			// data goes here 
				'post_ID' => $post_id, 
				'time' => current_time( 'mysql' ),
				'post_title' => get_the_title( $post_id ), 
				'post_content' => "$content",
				'tagged_content' => $jsonTagged,
				)
			);
	}


}
add_action( 'save_post', 'gg_get_pos_data' );



function gg_tag_the_content( $sentence ){
	// sets DIR path variable
	$dir = dirname(__FILE__);
	// loads tagger
	include($dir.'/PHP-Stanford-NLP/autoload.php');
	// creates tagger
	$pos = new \StanfordNLP\POSTagger(
	  ($dir.'/PHP-Stanford-NLP/stanford-postagger-2015-04-20/models/english-left3words-distsim.tagger'), 
	  ($dir.'/PHP-Stanford-NLP/stanford-postagger-2015-04-20/stanford-postagger.jar'));

	// calls tagger to tag the_content 
	// $result = $pos->tag(explode(' ', get_the_content() )); //  *** change back to this in production *** 

	$result = $pos->tag(explode(' ', $sentence ));
	return $result;
}

// ********* LATER *************
// need function to run on activation that will schedule all posts to be added to the table 
// set this function inside a scheduled task  ///