// The tags should be always be the same as in the school_year table! Need to manully update the fields/array!
$(function () {
    var majorTags = [
        'Computer Science',
        'Business',
        'Economics',
        'International Relations',
        'Mathematics',
        'CSBA',
        'Physics'
    ];
    $("#major").autocomplete({
        source: majorTags
    });


    var schoolYearTags = [
        'Freshman',
        'Sophomore',
        'Junior',
        'Senior',
        'Graduate'
    ];
    $("#schoolYear").autocomplete({
        source: schoolYearTags
    });
});


$("input[type=file]").change(function() {
    var fileInput = $(this)[0];
    var filename = fileInput.files[0].name;

    $('#file-input-text').html(filename);
});



