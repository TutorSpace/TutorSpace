//  ========================= for all register page ===========================
$('input').on('input', function () {
    if ($(this).val()) {
        $(this).next().addClass('fill-color-blue-secondary');
    } else {
        $(this).next().removeClass('fill-color-blue-secondary');
    }
});

$('input').filter('[required]').on('input', function () {
    let allFilled = true;
    $.each($('input').filter('[required]'), (idx, el) => {
        if (!$(el).val())
            allFilled = false;
    });

    if (allFilled) {
        $('.btn-next').addClass('btn-next-animation');
        if (isStudent)
            $('.btn-next').addClass('btn-student');
        else
            $('.btn-next').addClass('btn-tutor');
        $('.btn-next').removeClass('bg-grey');
    } else {
        $('.btn-next').removeClass('btn-next-animation');
        if (isStudent)
            $('.btn-next').removeClass('btn-student');
        else
            $('.btn-next').removeClass('btn-tutor');
        $('.btn-next').addClass('bg-grey');
    }
});


//  ========================= register student 1 ===========================
(function () {
    $('#btn-google-signup').click(function (e) {
        e.preventDefault();
    });


    // ===================== Google Admin ==========================
    let googleBtnWidth = 240,
        googleBtnHeight = 50;
    adjustGoogleBtnSize();

    renderButton();

    $(window).resize(function () {
        adjustGoogleBtnSize();
        renderButton();
    });


    function renderButton() {
        gapi.signin2.render('btn-google-signup', {
            'scope': 'profile email',
            'width': googleBtnWidth,
            'height': googleBtnHeight,
            'longtitle': true,
            'theme': 'dark',
            'onsuccess': onSuccess,
            'onfailure': onFailure
        });
    }

    function adjustGoogleBtnSize() {
        if ($(window).width() < 400) {
            googleBtnWidth = 165;
            googleBtnHeight = 36;
        } else if ($(window).width() < 576) {
            googleBtnWidth = 200;
            googleBtnHeight = 40;
        } else {
            googleBtnWidth = 240;
            googleBtnHeight = 50;
        }
    }

    function onSuccess(googleUser) {
        console.log('Logged in as: ' + googleUser.getBasicProfile().getName());
        // Useful data for your client-side scripts:
        var profile = googleUser.getBasicProfile();
        console.log("======================== User Profile =======================");
        console.log(profile);
        console.log("===============================================");

        // Do not use the Google IDs returned by getId() or the user's profile information to communicate the currently signed in user to your backend server. Instead, send ID tokens, which can be securely validated on the server.
        console.log("ID: " + profile.getId());

        console.log('Full Name: ' + profile.getName());
        console.log('Given Name: ' + profile.getGivenName());
        console.log('Family Name: ' + profile.getFamilyName());
        console.log("Image URL: " + profile.getImageUrl());
        console.log("Email: " + profile.getEmail());

        // The ID token you need to pass to your backend:
        var id_token = googleUser.getAuthResponse().id_token;
        console.log("ID Token: " + id_token);

    }

    function onFailure(error) {
        console.log(error);
    }

    function signOut() {
        var auth2 = gapi.auth2.getAuthInstance();

        // if not signed in
        if (!auth2.isSignedIn.get()) {
            var profile = auth2.currentUser.get().getBasicProfile();
            alert("You are not signed in!");
        } else {
            var auth2 = gapi.auth2.getAuthInstance();
            auth2.signOut().then(function () {
                console.log('User signed out.');
            });
        }
    }


})();


//  ========================= register student 2 ===========================
(function () {
    let totalSeconds = 30;
    let currentTimeInterval;

    // adjusting email input size
    // $(window).resize(function() {
    //     adjustInputEmailSize();
    // });

    // let adjustInputEmailSize = () => {
    //     $.each($('.form-group-4 input'), (idx, el) => {
    //         // alert($(el).height());
    //         $(el).height($(el).width() + 'px');
    //     });
    // };

    $('#resend-code').click(function () {
        // TODO: using ajax to send the email

        if (!currentTimeInterval) {
            $('#timeLabel').html(pad(totalSeconds));
            currentTimeInterval = setInterval(setTime, 1000);
            $(this).prop('disabled', true);
        }

    });

    function setTime() {
        --totalSeconds;
        if (totalSeconds > 0)
            $('#timeLabel').html(pad(totalSeconds));
        else {
            totalSeconds = 30;
            $('#timeLabel').html('');
            clearInterval(currentTimeInterval);
            currentTimeInterval = null;
            $('#resend-code').prop('disabled', false);
        }
    }

    function pad(val) {
        let pre = " in ";
        let suffix = ' s';
        var valString = val + "";
        if (valString.length < 2) {
            return pre + "0" + valString + suffix;
        } else {
            return pre + valString + suffix;
        }
    }
})();


// ======================== register student 3 ====================
(function () {

})();

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
