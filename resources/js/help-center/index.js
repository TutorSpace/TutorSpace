$(".help-center__card").click(function() {
    $(".help-center__section").addClass("hidden-2");
    $('#' + $(this).attr('data-section-id')).removeClass("hidden-2");
});
