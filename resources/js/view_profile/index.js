$('#intro-toggle--before').click(function() {
    $(this).toggleClass('hover-animation--before');
    $("[data-target='intro-toggle']").toggle(100,
        () => {
        $(this).toggleClass('hover-animation--before');
        $(this).toggle();
        $('#intro-toggle--after').toggle();
    });
});

$('#intro-toggle--after').click(function() {
    $(this).toggleClass('hover-animation--after');
    $("[data-target='intro-toggle']").toggle(100,
        () => {
        $(this).toggleClass('hover-animation--after');
        $(this).toggle();
        $('#intro-toggle--before').toggle();
    });
});
