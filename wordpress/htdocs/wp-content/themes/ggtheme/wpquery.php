<?php
/**

Template Name: WP_Query Template

 */

get_header(); ?>



<?php 	

if(isset($_POST['submit']))	{ gg_save_record(); }

require_once(ABSPATH . 'wp-settings.php');

	// function for saving to db -- somehow is ruuning on pageload and when form submitted. 
function gg_save_record(){
	
	global $wpdb;
	global $origin_id;
	$wpdb->insert($wpdb->prefix . 'gg_practice_results', 
		array("name" => "newtest", 
			"type" => "nouns", 
			"post_id" => $origin_id), 
		array("%s", "%s", "%d"));
}

?>

<?php 
/**
function save(){
	if(isset($_POST['submit'])) {
		require_once(ABSPATH . 'wp-settings.php');

		global $wpdb;
		global $origin_id;
		$wpdb->insert($wpdb->prefix . 'gg_practice_results', 
			array("name" => "newtest", 
				"type" => "nouns", 
				"post_id" => $origin_id), 
			array("%s", "%s", "%d"));
	}
}
*/
?>


	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php 
		// parses the url and takes the query data. origin_id is the originating post id 
		$origin_id = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_QUERY);

		// add check if query exisits. If not, display message
		?>

		<?php
			// resets data to allow a custom loop 
			wp_reset_postdata();

			// queries the post by id, sets results to be just 1 post
			$query = new WP_Query( array( 
				'p' => $origin_id, 
				'posts_per_page' => 1
				) );
		?>

		<?php
		// Start the custom loop.
		if ( have_posts() ) : 
			while ( $query->have_posts() ) : $query->the_post(); ?>

			<div class="ggmain" style="color:white;background:teal;">
			
			<p>You came here from post # <?php echo $origin_id; ?>	</p>
	
			<h3><?php the_title(); ?></h3>	
			<?php the_content(); ?>

			<form method="post" action=<?php gg_save_record() ?> >
			Enter your name: <input type="text" name="name"/>
			<input type="submit" value="Click Me"/>
			</form>

			</div> 

		<?php endwhile; else: ?>
			
			<p>No content available</p>

		<?php endif; ?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>


