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

				// sets link for 'quit' button
				$link = get_permalink( $post = $origin_id ); 

				// resets data to allow a custom loop 
				wp_reset_postdata();

				// queries the post by id, sets results to be just 1 post
				$query = new WP_Query( array( 
					'p' => $origin_id, 
					'posts_per_page' => 1
					) );

								
				// get tagged content from wpdb 
				global $wpdb;
				$table_name = $wpdb->prefix . 'gg_tagged';
				$sql = "SELECT tagged_content FROM (
					SELECT *
					FROM $table_name
				    WHERE post_ID= $origin_id
				    ORDER BY time DESC LIMIT 1) as tpost";
				$tagged_post = $wpdb->get_var( $sql ); // database query 
				$decoded = json_decode($tagged_post); // decode the json encoded array

				$taggedSpans = "";

				// create spans with tag as class
				foreach ($decoded as $element) {
					$text = $element[0];
					$tag = $element[1];
					
					// skip any <p> tags with p> 
					if ( strpos($text, "p>")) {
						continue;
					}

				    // if text is punctuation, do not add class
				    $punct = array(".", ",", ";", ":", "!", "?", "(", ")", "[", "]", "{", "}", "'", "`", "\"");
				    if (in_array ( $text , $punct)){
				        $span = ("<span>" . $text . "</span>");

				    }
					else{ // add class and a space 
						$span = ('<span class="' . $tag . '"> ' . $text . '</span>');
					}
					$taggedSpans .= $span; 
				}
				

				// Start the custom loop.

				// ** Here is the main content of the page ** //

				if ( have_posts() ) : 
					while ( $query->have_posts() ) : $query->the_post(); ?>

						<div id="ggmain">			
							<h1>Grammar Guru</h1>
							<div id="challenge-view" class="side-view">


								<h2>Your challenge:</h2>
								<h2>Find <span class="findThis">three <?php echo $game; ?></span> in this article.</h2>
								<h3>Click on a word to select it;</h3>
								<h3>To remove it, click again</h3>
								<input class="helpButton" type="button" value="Help!" /> 
								<input class="doneButton" type="button" name="done" value="I'm Done" />
							</div>  <!-- .challenge-view -->

							<div id="help-view" class="side-view">
								<?php 
								switch ($game) {
									case "nouns": ?>
											<h3><span class="mark">Nouns</span> are words that name an object or person</h3>
											<br>
											<p>The broad <span class="mark">river</span> is flowing swiftly.</p>
										<?php ;
										break;

									case "verbs": ?>
											<h3><span class="mark">Verbs</span> are words that tell the state or action of the subject.</h3>
											<br>
											<p>The broad river is <span class="mark">flowing</span> swiftly.</p>
										<?php ;
										break;

									case "adjectives": ?>
											<h3><span class="mark">Adjectives</span> are words used to describe and give more information about a noun, which could be a person, place or object.</h3>
											<br>
											<p>The <span class="mark">large</span> box is on the shelf.</p>
											<p>She held the <span class="mark">shiny</span> penny.</p>
											<p>The sun shone <span class="mark">bright</span> in the <span class="mark">blue</span> sky.</p>
											<p>I have <span class="mark">five</span> books.</p>
											<p>The <span class="mark">broad</span> river is flowing swiftly.</p>
											<?php ;
										break;

									case "adverbs": ?>
											<h3><span class="mark">Adverbs</span> are words that describe or give more information about a verb.</h3>
											<br>
											<p>The broad river is flowing <span class="mark">swiftly</span>.</p>
										<?php ;
										break;
								}
								?>
								<input class="closehelpButton" type="button" value="close" />
								<input class="doneButton" type="button" name="done" value="I'm Done" />
							</div>  <!-- .help-view -->

							<div id="almost-view" class="side-view">
								<h1>Nice effort!</h1>
								<h2><span id="numCorrect"></span> correct out of 3</h2>
								<ul class="matched-words"></ul>
								<ul class="unmatched-words"></ul>
								<p>You need all 3 words correct to earn a star</p>
								<p>Would you like to try again?</p>
								<input class="tryagainButton" type="button" value="Try Again" />
								<a href="<?php echo $link ?>"><input class="quitButton" type="button" value="Quit" /></a>
							</div>  <!-- .almost-view -->

							<div id="success-view" class="side-view">
								<h1>Well Done! </h1>
								<h2>All of your words are <?php $game ?></h2>
								<ul class="matched-words"></ul>
								<p>You have earned a STAR! </p>
								<a href="<?php echo $link ?>"><input class="quitButton" type="button" value="Quit" /></a>
							</div>  <!-- .success-view -->

							<div id="article-view" class="">
								<h2><?php the_title(); ?></h2>	
								<br>
								<p id="text" class="news-content"><?php echo $taggedSpans ?></p>
								<!-- What's up with this path ??  FIX LATER 
								<img src= "<?php echo get_stylesheet_directory(); ?>\assets\yellowhighlighter.png"> -->
								<img id="highlighter" src="http://www.iainball.com/psd-yellow-highlighter-pen-icon.png"/>
								

							</div>  <!-- .article-view -->

						</div> <!-- .ggmain -->

					<?php endwhile; else: ?>
				
					<p>No content available</p>

				<?php endif; ?>


		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>


<?php 	
	/*
	if(isset($_POST['submit'])){
		$name_entered = $_POST['name'];
		gg_save_record(); 	
	}

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
	*/
?>