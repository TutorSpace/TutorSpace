$(function () {
    var majorTags = [
        'Computer Science',
        'Communication'
    ];
    $("#major").autocomplete({
        source: majorTags
    });
});
