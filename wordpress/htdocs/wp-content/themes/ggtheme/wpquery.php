<?php
/**

Template Name: WP_Query Template
This is the template for the Grammar Guru game 

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

		// ** Here is the main content of the page ** //

		if ( have_posts() ) : 
			while ( $query->have_posts() ) : $query->the_post(); ?>

			<div class="ggmain">			

			<h1>Grammar Guru</h1>
			<h2>Your challenge: Find <span class="findThis">three <?php echo $game; ?></span> in this article.</h2>
			<div class="article-view">
				<p>Click on a word to select it.</p>
				<br>
				<h2><?php the_title(); ?></h2>	
				<br>
				<div class="news-content">
					<p class="news-content"><?php the_content(); ?></p>

				</div>

				<input type="button" value="Help!" /> 
				<input class="doneButton" type="button" value="I'm Done" /> 
			</div>

			<div class="results-view">
				<h2>You selected these words: </h2>
				<ul class="selected-words"></ul>
			</div>

			<!-- 
			<p>You came here from post # <?php echo $origin_id; ?>	</p>
			<p>You chose <?php echo $game; ?>	</p>

			<form method="post" action=<?php gg_save_record() ?> >
			Enter your name: <input type="text" name="name"/> 
			<input type="submit" value="Click Me"/> 
			</form>
			-->

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
	///echo "Saved!";
}

?>
