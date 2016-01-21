<?php


function aa_tag_the_content( $content ){
	// sets DIR path variable
	$dir = dirname(__FILE__);
	// loads tagger
	include($dir.'/PHP-Stanford-NLP/autoload.php');
	// creates tagger
	$pos = new \StanfordNLP\POSTagger(
	  ($dir.'/PHP-Stanford-NLP/stanford-postagger-2015-04-20/models/english-left3words-distsim.tagger'),
	($dir.'/PHP-Stanford-NLP/stanford-postagger-2015-04-20/stanford-postagger.jar')
	);
	// calls tagger to tag the_content 
	$result = $pos->batchTag(explode(' ', $content ));
	// print_r($result); // prints readable array data 

	// echo json_encode($result);
	return $result;
};

function aa_build_pos_arrays( $result ){
	$noun_tags = Array ( "NN", "NNS", "NNP", "NNPS");
	$verb_tags = Array ( "VB", "VBD", "VBG", "VBN", "VBP", "VBZ");
	$adjective_tags = Array ( "JJ", "JJR", "JJS");
	$adverb_tags = Array ( "RB", "RBR", "RBS");

	$nouns_list = Array();
	foreach($result as $word){
	     if ( in_array( $word[1], $noun_tags )){
	     	$nouns_list[] = $word[0];
	     }
	}
	// echo "Nouns: ";
	// print_r($nouns_list);

	$verbs_list = Array();
	foreach($result as $word){
	     if ( in_array( $word[1], $verb_tags )){
	     	$verbs_list[] = $word[0];
	     }
	}
	// echo "Verbs: ";
	// print_r($verbs_list);

	$adjectives_list = Array();
	foreach($result as $word){
	     if ( in_array( $word[1], $adjective_tags )){
	     	$adjectives_list[] = $word[0];
	     }
	}
	// echo "adjectives: ";
	// print_r($adjectives_list);

	$adverbs_list = Array();
	foreach($result as $word){
	     if ( in_array( $word[1], $adverb_tags )){
	     	$adverbs_list[] = $word[0];
	     }
	}
	// echo "adverbs: ";
	// print_r($adverbs_list);

	return array( $nouns_list, $verbs_list, $adjectives_list, $adverbs_list );
}


?>

