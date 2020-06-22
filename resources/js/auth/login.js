$('svg').click(function() {
    let route = $(this).attr('data-back-href');
    if(route)
        window.location.href = route;
});
