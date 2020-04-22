
// show/hide filter
$('.filter-box > button:first-child').click(function() {
    $('.filter-box > button:first-child').each((idx, e) => {
        if($(this)[0] !== e) {
            $(e).next().hide();
        }
    })
    $(this).next().toggle();
});

// save button
$('.filter-box .button-container > button:last-child').click(function() {
    $(this).parent().parent().hide();
});


// change value of range inputs on change
$('#price-range-low').on('change', function() {
    $('#price-range-low-value').html($(this).val());
});
$('#price-range-high').on('change', function() {
    $('#price-range-high-value').html($(this).val());
});
$('#rating-range-low').on('change', function() {
    $('#rating-range-low-value').html($(this).val());
});
$('#rating-range-high').on('change', function() {
    $('#rating-range-high-value').html($(this).val());
});



// clear inputs
$('#clear-year').click(function() {
    $('.filter-year input').each(function() {
        console.log($(this).prop('checked', false));
    });
});

$('#clear-price').click(function() {
    $('#price-range-low-value').html('10');
    $('#price-range-high-value').html('25');
    $('#price-range-low').val(10);
    $('#price-range-high').val(25);
});

$('#clear-rating').click(function() {
    $('#rating-range-low-value').html('2');
    $('#rating-range-high-value').html('4');
    $('#rating-range-low').val(2);
    $('#rating-range-high').val(4);
});



$('.search-card-flex-container img').click(function() {
    window.location.href = '/view_profile/' + $(this).attr('data-user-id') + '?from=search';
})
