<?php
 /*
 Plugin Name: Hello World Ajax Frontend
 Plugin URI: http://rainrain.com
 Description: A simplified ajax front end
 Version: 2
 Author: Bob Murphy
 Author URI: http://rainrain.com
 */
 
 function loadMyScripts()
{
    wp_register_script( 'my-ajax-handle', plugins_url( '/ajax.js', __FILE__ ));
    wp_enqueue_script( 'my-ajax-handle' );
    wp_localize_script( 'my-ajax-handle', 'the_ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts','loadMyScripts' );

 // THE AJAX ADD ACTIONS
 add_action( 'wp_ajax_the_ajax_hook', 'the_action_function' );
 add_action( 'wp_ajax_nopriv_the_ajax_hook', 'the_action_function' ); // need this to serve non logged in users
 // THE FUNCTION
 function the_action_function(){
 /* this area is very simple but being serverside it affords the possibility of retreiving data from the server and passing it back to the javascript function */
 $name = $_POST['name'];
 echo"Hello World, " . $name;// this is passed back to the javascript function
 die();// wordpress may print out a spurious zero without this - can be particularly bad if using json
 }
 // ADD EG A FORM TO THE PAGE
 function hello_world_ajax_frontend(){
 $the_form = '
 <form id="theForm">
 <input id="name" name="name" value = "name" type="text" />
 <input name="action" type="hidden" value="the_ajax_hook" /> <!-- this puts the action the_ajax_hook into the serialized form -->
 <input id="submit_button" value = "Click This" type="button" onClick="submit_me();" />
 </form>
 <div id="response_area">
 This is where we\'ll get the response
 </div>';
 return $the_form;
 }
 add_shortcode("hw_ajax_frontend", "hello_world_ajax_frontend");
 ?>