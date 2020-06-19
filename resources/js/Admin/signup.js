$('input').on('input', function() {
    if($(this).val()) {
        $(this).next().addClass('fill-color-blue-secondary');
    }
    else {
        $(this).next().removeClass('fill-color-blue-secondary');
    }
});

$('input').filter('[required]').on('input', function() {
    let allFilled = true;
    $.each($('input').filter('[required]'), (idx, el) => {
        if(!$(el).val())
            allFilled = false;
    });
    // alert(allFilled);
    if(allFilled) {
        $('.button-next').addClass('button-next-animation');
        $('.button-next').removeClass('bg-grey');
    }
    else {
        $('.button-next').removeClass('button-next-animation');
        $('.button-next').addClass('bg-grey');
    }
});

$('#btn-google-signup').click(function(e) {
    e.preventDefault();
});





// // The tags should be always be the same as in the school_year table! Need to manully update the fields/array!
// $(function () {

//     $("#major").autocomplete({
//         source: majorTags
//     });

//     $("#schoolYear").autocomplete({
//         source: schoolYearTags
//     });
// });


// $("input[type=file]").change(function() {
//     var fileInput = $(this)[0];
//     var filename = fileInput.files[0].name;

//     $('#file-input-text').html(filename);
// });



