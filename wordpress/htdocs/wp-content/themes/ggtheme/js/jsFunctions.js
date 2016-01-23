jQuery(document).ready(function($) {


// *** Split text into spans ***
// set up variables 
var text = $('p.news-content').text();
var $words = text.split(" ");
var $newText = "";
// put each word into a span.
// $.each($words, function(i, val) {
//  $newText = $newText + '<span>' + val + '</span> ';
//})
// $('p.news-content').html($newText);
// Toggle highlight when a word is clicked.
$("span").click(function() {
  $(this).toggleClass("highlighted");
});


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
  $('.tryagainButton').parent().hide(); // hide the current view
  //$('#results-view').hide();
  $('#challenge-view').show();
})


// *** QUIT Button *** 
// When QUIT Button is clicked, redirect to the origin post
// This is done in the HTML via a link, no js needed. 


// *** Done Button ***
// When doneButton is clicked, create array containing each highlighted word.
$('.doneButton').click(function() {
  var matchedWords = [];
  var unmatchedWords = [];
  // check if there are 3 answers 
  if ( $('.highlighted').length != 3) {
    alert( "Be sure you selected exactly 3 words!");
  }
  else {


    // check answers and add to appropriate list 
    $('.highlighted').each(function() {
      console.log(this);
      if( $(this).hasClass("NN") ){ 
        // match found 
        matchedWords.push( $(this).text() );
      }
      else {
        // not matched 
        unmatchedWords.push( $(this).text() );
      }
    });

    // empty the word lists ** IMPORTANT ** 
    $('.matched-words').empty(); 
    $('.unmatched-words').empty();
    $('#numCorrect').empty();

    $.each(matchedWords, function(i, val) {
      $('.matched-words').append('<li>'+ val +'</li>');
    })

    $.each(unmatchedWords, function(i, val) {
      $('.unmatched-words').append('<li>' + val + '</li>');
    })

    console.log(matchedWords);
    console.log(unmatchedWords);

    var countMatched = $(matchedWords).length;
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

  }; // end else

}); // end done function

}); // end jQuery ready function