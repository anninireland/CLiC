jQuery(document).ready(function($) {


// *** Split text into spans ***
// set up variables 
var text = $('div.news-content').text();
var $words = text.split(" ");
var $newText = "";
// put each word into a span.
$.each($words, function(i, val) {
  $newText = $newText + '<span>' + val + '</span> ';
})
$('.news-content').html($newText);
// Toggle highlight when a word is clicked.
$('span').click(function() {
  $(this).toggleClass('highlighted');
});



// *** Runs the tagger *** 
//
/*
var url = "/tagger.php";
var callback = function(response){
  // do something after it is finished
  console.log("tagger is done");
}
$.get(url, callback);
*/

/*
$.ajax( "/xampp/apps/wordpress/htdocs/wp-content/themes/ggtheme/tagger.php" )
.done(function(){
  alert( "tagger done");
})
.fail(function () {
  alert( "fail");
})
*/


// *** HELP button *** 
// When helpButton is clicked, show the matching help box below the buttons
$('.helpButton').click(function() {
  $('#challenge-view').hide();
  $('#help-view').show();
})

// *** CloseHelp Button *** 
// When closehelpButton is clicked, show the matching help box below the buttons
$('.closehelpButton').click(function() {
  $('#help-view').hide();
  $('#challenge-view').show();
})

// *** TryAgain Button *** 
// When tryagain Button is clicked, show challenge, hide results 
//    ***  - possibly clear the highlights?? 
$('.tryagainButton').click(function() {
  $('#results-view').hide();
  $('#challenge-view').show();
})


// *** QUIT Button *** 
// When QUIT Button is clicked, redirect to the origin post
$('.quitButton').click(function() {
  // ??? How to redirect in js? 
  // ? call php ? 

})

// *** Done Button ***
// When doneButton is clicked, create array containing each highlighted word.
$('.doneButton').click(function() {
  var $selectedWords = [];
  $('.highlighted').each(function() {
    var $word = $(this).text();
    // remove punctuation 
    if ($word.substr(-1) === '.') {
      $word = $word.slice(0, -1)
    }
    $selectedWords.push($word);
  });
    console.log('selectedWords:')
    console.log($selectedWords);

  // show selected words in a list 
  $.each($selectedWords, function(i, val) {
    $('.selected-words').append('<li>' + val + '</li>');
  })
  $('.doneButton').parent().hide();
  $('#results-view').show();

  // run the tagger HERE?
  /*
  jQuery.get( "C:/xampp/apps/wordpress/htdocs/wp-content/themes/ggtheme/tagger.php",
    { action: 'my_action' },
    alert( "ajax start"))
  .fail( function () {
    alert( "fail")
  })
  .done( function () {
    alert( "tagger DONE!!")
  });
  */

})



});