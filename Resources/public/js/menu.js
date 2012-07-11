$(document).ready(function(){
    $('.main_menu > ul > li').click(function(){
        $(this).addClass('active').siblings('li.active').removeClass('active');
    })
})