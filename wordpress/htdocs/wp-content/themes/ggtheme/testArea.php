<?php
/**

Template Name: TestArea Template
This is the TESTING template for the Grammar Guru game 

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
				'p' => 29, 
				'posts_per_page' => 1
				) );

		?>

		<?php
		// Start the custom loop.

		// ** Here is the main content of the page ** //

		if ( have_posts() ) : 
			while ( $query->have_posts() ) : $query->the_post(); ?>

			<div class="test">			


				<h1>Grammar Guru</h1>
				<h2>Your challenge: Find <span class="findThis">three words</span> in this article.</h2>
				<div class="article-view">
					<p>Click on a word to select it.</p>
					<br>
					<h2><?php the_title(); ?></h2>	
					<br>
					<div class="news-content">
						<p class="news-content"><?php the_content(); ?></p>

					</div>

					<input class="helpButton" type="button" value="Help!" /> 
					<form method="post" action="">
						<input class="doneButton" type="submit" value="I'm Done" /> 
					</form>

					<button id="load" onclick="sendAJAX()" class="button">Bring it!</button>
					<ul id="ajax">
						<li>page load ajax is done</li>

					</ul>
				</div>

				<div class="results-view">
					<h2>You selected these words: </h2>
					<ul class="selected-words"></ul>
				</div>

  <script>
  var xhr = new XMLHttpRequest(); // create xhr object (new xhr object required for each request) 
  xhr.open('GET', 'testfunctions.php'); // open the request ( include method and url of file for request) 
  xhr.onreadystatechange = function () {  // create the callback function 
    if (xhr.readyState === 4) {  // if page is ready (response has returned)
      document.getElementById('ajax').show();  // show done message 
    }
  };
    xhr.send(); // send the request 

  </script>


			</div> 

		<?php endwhile; else: ?>
			
			<p>No content available</p>

		<?php endif; ?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>


<?php 	



?>

