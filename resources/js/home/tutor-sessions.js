$(window).click(function() {
    //Hide the menus if visible
    $('.action--toggle--list').removeClass("d-flex");
    $('.action--toggle--list').addClass("d-none");
});

$('.action--toggle').on('click', function(event) {
    event.stopPropagation();
    $(this).find('.action--toggle--list').removeClass("d-none");
    $(this).find('.action--toggle--list').addClass("d-flex");
});


// function() {
//     $('.action--toggle--list').removeClass("d-flex");
//     $('.action--toggle--list').addClass("d-none");
// }
