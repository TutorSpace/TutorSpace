function scrollToBottom() {
    $('.chatting__content__messages').animate({
        scrollTop: $('.chatting__content')[0].scrollHeight
    }, 0);
}

$('.msg:first-child .box').addClass('bg-grey-light');
scrollToBottom();

$('.msg').click(function() {
    $('.msg .box').removeClass('bg-grey-light');
    $(this).find('.box').addClass('bg-grey-light');

    $.ajax({
        type:'GET',
        url: '/chatting/get-messages',
        data: {
            'userId': $(this).attr('data-user-id')
        },
        success: (data) => {
            $('.chatting__content').html(data);
            scrollToBottom();
        }
    });
});


