$("#search-timezone").val(moment.tz.guess());


var picker = new Pikaday({
    field: $('#start-date')[0],
    minDate: moment().toDate(),
    onSelect: () => {
        if($('#end-date').val()) {
            $('.filter__checkboxes--available-time').show(300);
        }
    }
});

var picker = new Pikaday({
    field: $('#end-date')[0],
    minDate: moment().toDate(),
    onSelect: () => {
        if($('#start-date').val()) {
            $('.filter__checkboxes--available-time').show(300);
        }
    }
});

$('#start-time').timepicker({
    'scrollDefault': 'now',
    'setp' : 15,
    'minTime': '0:00am',
	'maxTime': '11:30pm',
});

$('#end-time').timepicker({
    'scrollDefault': 'now',
    'setp' : 15,
    'minTime': '0:00am',
	'maxTime': '11:30am',
});


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
    if($('#price-low').val() && $('#price-high').val() && $('#price-low').val() > $('#price-high').val()) {
        let temp = $('#price-low').val();
        $('#price-low').val($('#price-high').val());
        $('#price-high').val(temp);
    }
});

$(window).resize(function () {
    if($(window).width() >= 992 && $('.flex__content').is(":hidden")) {
        $('.flex__content').show();
        $('.filter .btn-hide').html('hide')
    }
});

$('.filter .btn-hide').click(function() {
    if($(this).html() == 'show') {
        $('.flex__content').toggle(300);
        $(this).html('hide');
    }
    else {
        $('.flex__content').toggle(300);
        $(this).html('show');
    }
})


$('form.filter').submit(function() {
    $('#search-content').val($('#nav-search-content').val());
});

$('.nav__form').submit(function(e) {
    e.preventDefault();
    $('#search-content').val($('#nav-search-content').val());
    $('form.filter').submit();
});


$('.btn-clear').click(function() {
    if($('#checkbox-specify-detail-time').prop('checked')) {
        $('#select-detail-time').addClass('hidden');
    }

    $('input[tpye=text], input[type=number]').val('');
    $('input:checkbox').prop('checked', false);
    $("#price-range-input").slider('setValue', [
        parseInt(15),
        parseInt(35)
    ]);

    $('input[name=available-start-date]').val('');
    $('input[name=available-end-date]').val('');
    $('input[name=available-start-time]').val('');
    $('input[name=available-end-time]').val('');
});

if($('#checkbox-specify-detail-time').prop('checked')) {
    $('#select-detail-time').addClass('hidden');
}
