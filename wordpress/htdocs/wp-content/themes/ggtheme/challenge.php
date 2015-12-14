<?php
/**
 * Template Name: Challenge Template 
 *
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		
		

		<?php
		// Start the loop.

		
		while ( have_posts() ) : the_post();

			// Include the page content template.
			// get_template_part( 'content', 'page' );
			
			
	?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
		// Post thumbnail.
		twentyfifteen_post_thumbnail();
	?>

	<header class="entry-header">
	<h2>Challenge Template</h2>
		<?php
			if ( is_single() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
			endif;
		?>
	</header><!-- .entry-header -->

		<?php 	
		require_once(ABSPATH . 'wp-settings.php');
			
		function gg_save_record(){
			
			global $wpdb;
			
			$wpdb->insert($wpdb->prefix . 'gg_practice_results', array("name" => "newtest", "type" => "nouns", "post_id" => 31), array("%s", "%s", "%d"));
		}
		?>

		<?php if(isset($_POST['submit']))	{ gg_save_record(); } ?>
	
	<div class="entry-content">
	<p>Hello. I'm in entry-content</p>

	<?php 
	
	// $_SERVER['REQUEST_URI_PATH'] = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_FRAGMENT);
	$origin_id = parse_url( $_SERVER['REQUEST_URI'], PHP_URL_QUERY);
	var_dump( $origin_id );

	$test_id = 55;
	var_dump($test_id);

	?>


	<p>You came here from post # <?php echo $test_id; ?>	</p>
	Hello
	<form method="post" action=<?php gg_save_record() ?> >
	Enter your name: <input type="text" name="name"/>
	<input type="submit" value="Click Me"/>
	</form>
	


		<?php
			/* translators: %s: Name of current post */
			the_content( sprintf(
				__( 'Continue reading %s', 'twentyfifteen' ),
				the_title( '<span class="screen-reader-text">', '</span>', false )
			) );
			
			

			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentyfifteen' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		?>
	</div><!-- .entry-content -->

	<?php
		// Author bio.
		if ( is_single() && get_the_author_meta( 'description' ) ) :
			get_template_part( 'author-bio' );
		endif;
	?>

	<footer class="entry-footer">
		
	<p>Hello. I'm in entry-footer</p>

		<?php twentyfifteen_entry_meta(); ?>
		<?php edit_post_link( __( 'Edit', 'twentyfifteen' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->

</article><!-- #post-## -->

		<?php 
		// End the loop.
		endwhile;
		?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
