$(".help-center__card").click(function() {
    $(".help-center__section").addClass("hidden-2");
    let el = $('#' + $(this).attr('data-section-id'));
    el.removeClass("hidden-2");

    $('html, body').animate({
        scrollTop: el.offset().top - 100
    }, 700);
});
