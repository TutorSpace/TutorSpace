// show/hide 
$('.filter-box>button').click(function() {
    $(this).next().toggle();

    $(this).next().find('button:last-child').click(() => {
        $(this).next().css('display', 'none');
    });
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
    $('#price-range-low-value').html('20');
    $('#price-range-high-value').html('45');
    $('#price-range-low').val(20);
    $('#price-range-high').val(45);
});

$('#clear-rating').click(function() {
    $('#rating-range-low-value').html('1');
    $('#rating-range-high-value').html('4');
    $('#rating-range-low').val(1);
    $('#rating-range-high').val(4);
});

