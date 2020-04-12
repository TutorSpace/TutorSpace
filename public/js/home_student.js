// select view session
$('.home__container__notifications__sessions .session__container > button:last-child').click(function () {
    window.location.href = '/view_session_before';
});


// select cancel session
$('.home__container__notifications__sessions .session__container > button:not(:last-child)').click(function () {
    alert('session cancelled');
});



// select view profile
$('.tutor-container .btn-view-profile').click(function () {
    window.location.href = '/expanded_view';
});

// select past session
$('.tutor-container .btn-view-past-session').click(function () {
    window.location.href = '/view_session_after';
});


$('#filter-form').submit((e) => {
    e.preventDefault();
    
    alert('TODO: use AJAX to put the corresponding posts into the dashboard');
});

$('svg.bookmark').click(() => {
    alert('TODO: ADD/REMOVE tutor to/from bookmarked table, and use AJAX to update the page');
})



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




// console.log(document.documentElement.scrollHeight);
// console.log($(window).height());


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
