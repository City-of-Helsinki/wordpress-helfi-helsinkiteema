(function( $ ) {

$(document).ready(function(){

    var links = $(".table-of-contents a");
  
    links.on("click", function(){
        var target = $($(this).attr("href"));
        target[0].setAttribute('tabindex', -1);
        target[0].focus();
    });

  });

})(jQuery);