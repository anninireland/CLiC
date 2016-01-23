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
				// sets link for 'quit' button
				$link = get_permalink( $post = $origin_id ); 
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

						<div id="ggmain">			

							<h1>Grammar Guru</h1>

							<div id="challenge-view" class="side-view">
								<!-- What's up with this path ??  FIX LATER 
								<img src= "<?php echo get_stylesheet_directory(); ?>\assets\yellowhighlighter.png"> -->
								<img id="highlighter" src="http://www.iainball.com/psd-yellow-highlighter-pen-icon.png"/>
								
								<h2>Your challenge:</h2>
								<h2>Find <span class="findThis">three <?php echo $game; ?></span> in this article.</h2>
								<h3>Click on a word to select it;</h3>
								<h3>To remove it, click again</h3>
								<input class="helpButton" type="button" value="Help!" /> 
								<input class="doneButton" type="button" name="done" value="I'm Done" />
							</div>  <!-- .challenge-view -->



							
							<?php 
							/*
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

								$nouns_list = Array();
								foreach($result as $word){
								     if ( in_array( $word[1], $noun_tags )){
								     	$nouns_list[] = $word[0];
								     }
								}

								$verbs_list = Array();
								foreach($result as $word){
								     if ( in_array( $word[1], $verb_tags )){
								     	$verbs_list[] = $word[0];
								     }
								}

								$adjectives_list = Array();
								foreach($result as $word){
								     if ( in_array( $word[1], $adjective_tags )){
								     	$adjectives_list[] = $word[0];
								     }
								}

								$adverbs_list = Array();
								foreach($result as $word){
								     if ( in_array( $word[1], $adverb_tags )){
								     	$adverbs_list[] = $word[0];
								     }
								}
								/*
								echo "Nouns: ";
								print_r($nouns_list);
								echo "Verbs: ";
								print_r($verbs_list);
								echo "adjectives: ";
								print_r($adjectives_list);
								echo "adverbs: ";
								print_r($adverbs_list);
								*/
							?>

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


							<div id="results-view" class="side-view">
								<?php // if success, show "Well Done!", else show "Almost!" ?>
								<h1>Results! </h1>
								<h2>You selected these words: </h2>
								<ul class="selected-words"></ul>
								<?php // if success, show Star, else show tryagain button ?>
								<input class="tryagainButton" type="button" value="Try Again" />
								<a href="<?php echo $link ?>"><input class="quitButton" type="button" value="Quit" /></a>
								<br>
							</div>  <!-- .results-view -->

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


							<div id="article-view">
								<h2><?php the_title(); ?></h2>	
								<br>
								<?php 

									global $wpdb;
									$table_name = $wpdb->prefix . 'aatest';

									$sql = "SELECT tagged_content FROM (
										SELECT *
										FROM $table_name
									    WHERE post_ID= $origin_id
									    ORDER BY time DESC
									    LIMIT 1) as tpost";

									$tagged_post = $wpdb->get_var( $sql );
									// echo $tagged_post;
									// var_dump($tagged_post);
									// print_r($tagged_post);

									$decoded = json_decode($tagged_post);

									$taggedSpans = "";

									// create spans with tag as class
									foreach ($decoded as $element) {
										$text = $element[0];
										$tag = $element[1];

									    // if text is punctuation, do not add class
									    $punct = array(".", ",", ";", ":", "!", "?", "(", ")", "[", "]", "{", "}", "'", "`", "\"");
									    if (in_array ( $text , $punct)){
									        $span = ("<span>" . $text . "</span>");
									    }
										else{ // add class and a space 
											$span = ('<span class="' . $tag . '"> ' . $text . '</span>');
										}
										// echo $span;
										$taggedSpans .= $span; 

									}

									echo $taggedSpans;
								?>

								</div>
							</div>  <!-- .article-view -->

					<?php 
						/*
						$post_id = $origin_id; // defined above 

						// get the content and prepare it for the tagger 
						$content_post = get_post($post_id);
						$content = $content_post->post_content;

						//print_r($content);

						$content = apply_filters('the_content', $content);
						$content = str_replace(']]>', ']]&gt;', $content);

						//print_r($content);

						// run tagger
						include 'tagger.php';
						$tagged_text = aa_tag_the_content( $content );

						print_r($tagged_text);
						print_r($posArrays);


						global $wpdb;
						$table_name = $wpdb->prefix . 'aatest';

						// save results to db 
						$wpdb->replace( 
							$table_name, 
							array( 
							// data goes here 
								'post_ID' => $post_id, 
								'time' => current_time( 'mysql' ),
								'post_title' => get_the_title( $post_id ), 
								'post_content' => $content,
								'tagged_content' => json_encode($tagged_text),
								'nouns' => json_encode($posArrays[0]),
								'verbs' => json_encode($posArrays[1]),
								'adjectives' => json_encode($posArrays[2]),
								'adverbs' => json_encode($posArrays[3]),
								)
							);
					*/
					?>

							<?php 
								$dirname=  dirname( get_bloginfo('stylesheet_url') ) ;
								// echo $dirname;
								// var_dump($dirname);
							?> 

							<script>
								var templateDir = '<?php dirname( get_bloginfo("stylesheet_url") ) ?>';
							</script>

							<script>
							/*
								jQuery.ajax( "C:/xampp/apps/wordpress/htdocs/wp-content/themes/ggtheme/tagger.php" )
								.done(function(){
								  alert( "tagger done");
								})
								.fail(function () {
								  alert( "fail");
								})

								jQuery.get( templateDir+"/ggtheme/functions.php", 
								{ action: 'wp_ajax_my_action'	},
								alert( "ajax start"))
								.fail( function () {
									alert( "fail")
								})
								.done( function () {
									alert( "tagger DONE!!")
								});
							*/
							</script>


							<!-- 
							<p>You came here from post # <?php echo $origin_id; ?>	</p>
							<p>You chose <?php echo $game; ?>	</p>

							<form method="post" action=<?php gg_save_record() ?> >
							Enter your name: <input type="text" name="name"/> 
							<input type="submit" value="Click Me"/> 
							</form>
							-->
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




