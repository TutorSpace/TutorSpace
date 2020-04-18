// select view session
$('.home__container__notifications__sessions .session__container > button:last-child').click(function () {
    window.location.href = '/view_session_before';
});


// select cancel session
$('.home__container__notifications__sessions .session__container > button:not(:last-child)').click(function () {
    alert('TODO: cancel session');
});




// for adding post
$('#add-post').click(() => {
    showAddPost();
});

// cancel button for post
$('#add-post-container .btn-cancel').click(() => {
    $('#background-cover').hide();
});

// save button for
$('#add-post-container .btn-post').click(() => {
    alert('TODO: add the post to the database!');

});


$('#filter-form').submit(function(e) {
    e.preventDefault();

    let inputCourseSubject = $('#search-courses-subjects option:selected').val();
    let inputTutorStudent = $('#search-posts option:selected').val();

    console.log(inputCourseSubject);
    console.log(inputTutorStudent);
    $.ajax({
        type:'GET',
        url: '/dashboard',
        data: {
            courseSubject: inputCourseSubject,
            tutorStudent: inputTutorStudent
        },
        success: (data) => {
            let { successMsg } = data;
            toastr.success(successMsg);
        },
        error: function(error) {
            toastr.error(error);
        }
    });

});




function showAddPost() {
    $('#background-cover').height(document.documentElement.scrollHeight);
    $('#background-cover').width(document.documentElement.scrollWidth);
    $('#background-cover').show();

    let centerOffset = (document.documentElement.scrollHeight - $(window).height()) / 2;
    $('html,body').animate({
            scrollTop: centerOffset
        },
        'slow'
    );

    $('#add-post-container').height($(window).height() / 2);
}




