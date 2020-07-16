var picker = new Pikaday({ field: $('#start-date')[0] });
var picker = new Pikaday({ field: $('#end-date')[0] });
$('#start-time').timepicker();
$('#end-time').timepicker();


$('#checkbox-specify-detail-time').change(function() {
    if($(this).is(':checked')) {
        $('#select-detail-time').removeClass('hidden');

        $('.checkbox-range').prop('checked', false);
        $('#checkbox-any-time').prop('checked', false);
    }
    else {
        $('#select-detail-time').addClass('hidden');
    }
});

$('#checkbox-any-time').change(function() {
    if($(this).is(':checked')) {
        $('#select-detail-time').addClass('hidden');

        $('#checkbox-specify-detail-time').prop('checked', false);
        $('.checkbox-range').prop('checked', false);
    }
});

$('.checkbox-range').change(function() {
    if($(this).is(':checked')) {
        $('#select-detail-time').addClass('hidden');

        $('#checkbox-any-time').prop('checked', false);
        $('#checkbox-specify-detail-time').prop('checked', false);
    }
});

$("#price-range-input")
    .slider({
        min: 10,
        max: 50,
        value: [15, 35],
        tooltip: "hide",
        labelledby: ['price-low', 'price-high']
    }).on('slide', (slideEvt) => {
        $('#price-low').val(slideEvt.value[0]);
        $('#price-high').val(slideEvt.value[1]);
    });

$('#price-low, #price-high').on('input', function() {

    $("#price-range-input").slider('setValue', [
        parseInt($('#price-low').val()),
        parseInt($('#price-high').val())
    ]);
})

$('#price-low, #price-high').change(function() {
    if($(this).val() < 10) {
        $(this).val(10);
    }
    if($(this).val() > 50) {
        $(this).val(50);
    }
    if($('#price-low').val() > $('#price-high').val()) {
        let temp = $('#price-low').val();
        $('#price-low').val($('#price-high').val());
        $('#price-high').val(temp);
    }
});
