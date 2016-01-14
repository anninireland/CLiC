jQuery(document).ready(function($) {

// set up variables 
var text = $('div.news-content').text();
var $words = text.split(" ");
var $newText = "";
// Separate each word into a span.
$.each($words, function(i, val) {
  $newText = $newText + '<span>' + val + '</span> ';
})
$('.news-content').html($newText);
// Toggle highlight when a word is clicked.
$('span').click(function() {
  $(this).toggleClass('highlighted');
});

// When doneButton is clicked, create POST array containing each highlighted word.
$('.doneButton').click(function() {
  var $selectedWords = [];
  $('.highlighted').each(function() {
    var $word = $(this).text();
    if ($word.substr(-1) === '.') {
      $word = $word.slice(0, -1)
    }
    $selectedWords.push($word);
  });
    console.log('selectedWords:')
    console.log($selectedWords);

  // hide the content and the button
  $('.article-view').hide();
  
  // show selected words in a list 
  $.each($selectedWords, function(i, val) {
    $('.selected-words').append('<li>' + val + '</li>');
  })
  $('.results-view').show();

  // calls the tagger to run
  $.ajax({
    type: "POST",
    url: "run-the-tagger.php",
    data: {
      action: 'tag_the_content'
    },
    success: function(){
      console.log('tagger has run');
    }

  })

})


// When helpButton is clicked, show the matching help box below the buttons
$('.helpButton').click(function() {
  $('.help-view').show();
})

// When closeButton is clicked, show the matching help box below the buttons
$('.closeButton').click(function() {
  $('.help-view').hide();
})

});