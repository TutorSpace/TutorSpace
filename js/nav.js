$('#logo').click(function() {
    window.location.href = '/';
});

$('nav.nav .user-photo-container>img').click(function() {
    // should account for id="tutor-profile-photo"
    if($(this).attr('id') === 'tutor-profile-photo') {
        window.location.href = '/profile_tutor.html';
    }

    else {
        window.location.href = '/profile_student.html';
    }
        
    
});
