<?php
	
	//wp_reset_postdata();

	$args = array(
		
		'post_type' => 'post',
		'posts_per_page' => 1

	);

	$the_query = new WP_Query( $args );				

	//wp_reset_postdata();

?>