$('#logo').click(function() {
    window.location.href = '/';
});

$('nav.nav .user-photo-container>img').click(function() {
    window.location.href = '/profile';
});

let dropdownShowed = false;
$('nav .user-photo-container img').click(() => {
    if(dropdownShowed)
        $('.nav__dropdown-container').hide();
    else
        $('.nav__dropdown-container').show();

    dropdownShowed = !dropdownShowed;
    
});


$('nav .user-photo-container .profile-container').click(() => {
    window.location.href = '/profile';
});

$('nav .user-photo-container .log-out-container').click(() => {
    window.location.href = '/logout';
});
