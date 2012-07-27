$(document).ready(function(){
    $('.main_menu > ul > li').click(function(){
        $(this).addClass('active').siblings('li.active').removeClass('active');  
        // add class if menu has no children
        if ($(this).children('ul').length > 0) {
            $('body').removeClass('special');
        } else {
            $('body').addClass('special');
        }
    })
})