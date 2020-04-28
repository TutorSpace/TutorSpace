$('#cancel-edit-profile').click(function() {
    window.location.href = "/edit_profile";

})

// The tags should be always be the same as in the school_year table! Need to manully update the fields/array!
$(function () {
    var majorTags = [
        'Computer Science',
        'Business Administration',
        'Economics',
        'International Relations',
        'Mathematics',
        'Chemistry',
        'Physics',
        'Biology',
        'Linguistics',
        'Electrical Engineering',
        'Mechanical Engineering',
        'Astronautical Engineering',
        'Chemical Engineering',
        'Human Biology',
        'Design',
        'English',
        'Communication',
        'French',
        'Italian',
        'Screenwriting',
        'Narrative Studies',
        'Classics',
        'Psychology',
        'Cognitive Science'
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



