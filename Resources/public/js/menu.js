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