$('.action').click(function() {
    if($(this).parent().attr('data-post-id')) {
        alert('post');
    }
    else {
        alert('reply');
    }
})
