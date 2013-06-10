$(document).ready(function () {
    
    // Colorbox link
    $('.colorbox').colorbox();
    
    // Popup box
    $('.popup').each(function(){
        $(this).html('<div class="popup_content">' + $(this).html() + '</div>');
        $(this).prepend('<div class="popup_arrow"></div>');
        $(this).addClass('popup_ready');
    })
    $('.popup .popup_arrow').click(function(){
        $(this).parent('div.popup').toggleClass('popup_active');
        $('.popup').not($(this).parent('div.popup')).removeClass('popup_active');
    });
    
        // Convert object action buttons into POST requests
    $(".admin_list td.actions a").click(function(e) {
        e.preventDefault();
        
        // Create hidden form
        var form = $('<form />').attr({
            method: 'POST',
            action: $(this).data('action'),
            style:  'visibility: hidden'
        }).appendTo($('body'));
        
        if($(this).data('csrf-token')) {
            // Add csrf protection token
            $('<input />').attr({
                type:   'hidden',
                name:   '_csrf_token',
                value:  $(this).data('csrf-token')
            }).appendTo(form);
        }
        
        // Submit POST request, if required promt for confirmation
        if(!$(this).data('confirm') || confirm($(this).data('confirm'))) {
            form.submit();
        }
    });
});


// Общие функции
function common() {
    this.flash = flash;
    
    // Вывод флеш-сообщения
    function flash (message, type) {
       
        if(!message) return;
        
        type = type || 'warning';
        
        $('.notification_box').remove();
        
        $('.content').before('<div class="notification_box ' + type + '">' + message + '</div>');
   }
}
(function(){
    common = new common();
})();