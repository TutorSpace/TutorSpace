$('#cancel-edit-profile').click(function() {
    alert('TODO: cancel should update the form with all the data that is inside the database. Use AJAX for this.');
})

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
