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

				<input class="helpButton" type="button" value="Help!" /> 
				<input class="doneButton" type="button" value="I'm Done" /> 
			</div>

			<div class="results-view">
				<h2>You selected these words: </h2>
				<ul class="selected-words"></ul>
			</div>



			<?php 
			switch ($game) {
				case "nouns": ?>
					<div class="help-view">
						<h3><span class="mark">Nouns</span> are words that name an object or person</h3>
						<br>
						<p>The broad <span class="mark">river</span> is flowing swiftly.</p>
						<input class="closeButton" type="button" value="close" />
					</div>
					<?php ;
					break;

				case "verbs": ?>
					<div class="help-view">
						<h3><span class="mark">Verbs</span> are words that tell the state or action of the subject.</h3>
						<br>
						<p>The broad river is <span class="mark">flowing</span> swiftly.</p>
					</div>
					<?php ;
					break;

				case "adjectives": ?>
					<div class="help-view">
						<h3><span class="mark">Adjectives</span> are words used to describe and give more information about a noun, which could be a person, place or object.</h3>
						<br>
						<p>The <span class="mark">large</span> box is on the shelf.</p>
						<p>She held the <span class="mark">shiny</span> penny.</p>
						<p>The sun shone <span class="mark">bright</span> in the <span class="mark">blue</span> sky.</p>
						<p>I have <span class="mark">five</span> books.</p>
						<p>The <span class="mark">broad</span> river is flowing swiftly.</p>
					</div> <?php ;
					break;

				case "adverbs": ?>
					<div class="help-view">
						<h3><span class="mark">Adverbs</span> are words that describe or give more information about a verb.</h3>
						<br>
						<p>The broad river is flowing <span class="mark">swiftly</span>.</p>
					</div>
					<?php ;
					break;
			}

			?>


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

<?php




$time_start = microtime(true);

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
$result = $pos->tag(explode(' ', get_the_content() ));
// print_r($result); // prints readable array data 

$time_now = microtime(true);

$noun_tags = Array ( "NN", "NNS", "NNP", "NNPS");
$verb_tags = Array ( "VB", "VBD", "VBG", "VBN", "VBP", "VBZ");
$adjective_tags = Array ( "JJ", "JJR", "JJS");
$adverb_tags = Array ( "RB", "RBR", "RBS");

echo "Nouns: ";
$nouns_list = Array();

foreach($result as $word){
     if ( in_array( $word[1], $noun_tags )){
     	$nouns_list[] = $word[0];
     }
}
foreach($result as $word){
     if ( in_array( $word[1], $verb_tags )){
     	$nouns_list[] = $word[0];
     }
}
foreach($result as $word){
     if ( in_array( $word[1], $adjective_tags )){
     	$nouns_list[] = $word[0];
     }
}
foreach($result as $word){
     if ( in_array( $word[1], $adverb_tags )){
     	$nouns_list[] = $word[0];
     }
}

$time_end = microtime(true);
$time_to_tag = $time_now - $time_start;
$time_to_arrays = $time_end - $time_now;
$time_elapsed = $time_end - $time_start;
echo "Tagged in: $time_to_tag seconds\n ";
echo "Arrays in: $time_to_arrays seconds\n ";
echo "All done in: $time_elapsed seconds\n ";
?>