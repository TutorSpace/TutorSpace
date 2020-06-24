$('svg').click(function() {
    let route = $(this).attr('data-back-href');
    if(route)
        window.location.href = route;
});

$('input').on('input', function () {
    if ($(this).val()) {
        if(isStudent)
            $(this).next().addClass('fill-color-blue-primary');
        else
            $(this).next().addClass('fill-color-purple-primary');
    } else {
        if(isStudent)
            $(this).next().removeClass('fill-color-blue-primary');
        else
            $(this).next().removeClass('fill-color-purple-primary');
    }
});
