$( document ).ready(function($) {

    $('#topbar').waypoint('sticky', {offset:9} ); 
    
    causeRepaintsOn = $("h1, h2, h3, p, a");

    $(window).resize(function() {
      causeRepaintsOn.css("z-index", 1);
    }); 
    
    $('.mobile-icon A').click(function(){
        $('UL#menu-main-menu').slideToggle(); 
    });
 
});


var notify = function(message) {
      var $message = $('<p style="display:none;">' + message + '</p>');

      $('.notifications').append($message);
      $message.slideDown(300, function() {
        window.setTimeout(function() {
          $message.slideUp(300, function() {
            $message.remove();
          });
        }, 2000);
      });
      
    };