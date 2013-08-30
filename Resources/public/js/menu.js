// menu item's title for  windows.width < 1366px
(function($){
      $(function() { 
        $('.link').each(function() {
                var el = $(this);
                var title = el.text();
                if (title && title != '') {
                  el.attr('title', '').append('<div class="title">' + title + '</div>');
                  el.hover(              
                    function() {
                    if  (($(window).width()) <= 1310) {      
                      el.find('div')
                        .clearQueue()
                        .delay(200)
                        .fadeIn(200);
                    }
                    },
                    function() {
                    if  (($(window).width()) <= 1310) {      
                      el.find('div')
                        .fadeOut(500);
                    }
                    }
                  ).mouseleave(function() {
                    if (el.children().is(':hidden')) el.find('div').clearQueue();
                  });
                }
              });
      });
    })(jQuery)


$(document).ready(function(){
    //hide sub_menu on click in another place
    jQuery('html').click(function() { 
        $('.main_menu li').children('ul').css('display','none');
        $('.main_menu li').removeClass('active');
    });
    
    $('.main_menu > ul > li').click(function(event){
        event.stopPropagation(); 
        
        if ($(this).children('ul').is(":hidden")) {
            $('.main_menu li').removeClass('active');
            $('.main_menu li').children('ul').css('display','none'); 
            $(this).addClass('active');
            $(this).children('ul').css('display','block');
        }
        else {
            $(this).children('ul').css('display','none');
            $(this).removeClass('active');
        }          
    });
    
});