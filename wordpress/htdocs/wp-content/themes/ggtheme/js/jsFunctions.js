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
// This is done in the HTML via a link, no js needed. 


// *** Done Button ***
// When doneButton is clicked, create array containing each highlighted word.
$('.doneButton').click(function() {
  // check if there are 3 answers 
  if ( $('.highlighted').length != 3) {
    // alert to get 3 exactly 
    alert( "Be sure you selected exactly 3 words!");
  }
  else {

    // *** Runs the tagger *** 

    var url = "c:xampp/apps/wordpress/htdocs/wp-content/themes/ggtheme/js/tagger.php";
    //var url = "/tagger.php";
    var callback = function(response){
      console.log("calling the tagger");
      // when tagger is  finished
      var posArrays = response;
      console.log("tagger is done");
      // console.log( posArrays );

      // process answers into array
      var selectedWords = [];


      $('.highlighted').each(function() {
        var $word = $(this).text();
        var punct = [ '.', ',', ';', ':', '!', '?', '(', ')', '[', ']', '{', '}' ] ;
        if( jQuery.inArray( $word.substr(-1), punct) !== -1){ // remove punctuation 
          $word = $word.slice(0, -1);
        }
        selectedWords.push($word); // add word to selectedwords array
      });

      // compare answers to pos array 
      // select pos array based on game 
      // for now, just nouns 

      var allPOSarrays =  JSON.parse(posArrays);
      var nounsArray = $(allPOSarrays).get(0);
      console.log( nounsArray);

      var matchedWords = [];
      var unmatchedWords = [];

      $.each( selectedWords, function(i, word) { // iterate over selectedwords
        if($.inArray( word, nounsArray) > -1){ // check if match found in answer array
          // match found 
          matchedWords.push(word);
        }
        else {
          // not matched 
          unmatchedWords.push(word);
        }
      });

      $.each(matchedWords, function(i, val) {
        $('.matched-words').append('<li>' + val + '</li>');
      })

      $.each(unmatchedWords, function(i, val) {
        $('.unmatched-words').append('<li>' + val + '</li>');
      })

      console.log(matchedWords);
      console.log(unmatchedWords);

      var countMatched = $(matchedWords).length;
      $('#numCorrect').empty;
      $('#numCorrect').append(countMatched);

      if($(matchedWords).length == 3){
        // all correct - Yay! 
        $('.doneButton').parent().hide(); // hide the current view
        $('#success-view').show(); // show resutls view 
      }
      else {
        // display almost view 
        $('.doneButton').parent().hide(); // hide the current view
        $('#almost-view').show(); // show resutls view 
      }

      }; // end tagger function

    } // end else for done 

    $.get(url, callback);



}); // end done function




}); // end jQuery ready function