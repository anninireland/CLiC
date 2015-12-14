<?php
/**

Template Name: WP_Query Template

 */

get_header(); ?>





	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php 
		// parses the url and takes the query data
		$query_str = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_QUERY);
		// parses the resulting string into variables 
		parse_str($query_str);

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
			<p>You chose <?php echo $game; ?>	</p>
	
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

<?php 	

if(isset($_POST['submit']))	{ 
	$name_entered = $_POST['name'];
	gg_save_record(); }

require_once(ABSPATH . 'wp-settings.php');

	// function for saving to db -- somehow is ruuning on pageload and when form submitted. 
function gg_save_record(){
	
	global $wpdb;
	global $origin_id;
	global $game;
	global $name_entered;
	$wpdb->insert($wpdb->prefix . 'gg_practice_results', 
		array("gg_post" => $origin_id, "type" => $game, "name" => "test"),
		array("%d", "%s", "%s"));
}

?>
