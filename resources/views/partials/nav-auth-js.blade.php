<script>
    @auth
        let loggedIn = true;
    @else
        let loggedIn = false;
    @endauth

    // ===================== Google Auth ==========================
    let googleBtnWidth = 240,
        googleBtnHeight = 50,
        longTitle = true;
    adjustGoogleBtnSize();

    $(window).resize(function () {
        adjustGoogleBtnSize();
        renderButton();
    });

    $('#btn-google-student-sm, #btn-google-student-lg').click(function (e) {
        e.stopPropagation();
        window.location.href = '{{ route('login.google.student', ['backUrl' => URL::current()]) }}';
    });

    $('#btn-google-tutor-sm, #btn-google-tutor-lg').click(function (e) {
        e.stopPropagation();
        window.location.href = '{{ route('login.google.tutor', ['backUrl' => URL::current()]) }}';
    });

    function renderButton() {
        gapi.signin2.render('btn-google-student-sm', {
            'scope': 'profile email',
            'width': googleBtnWidth,
            'height': googleBtnHeight,
            'longtitle': longTitle,
            'theme': 'light'
        });

        gapi.signin2.render('btn-google-tutor-sm', {
            'scope': 'profile email',
            'width': googleBtnWidth,
            'height': googleBtnHeight,
            'longtitle': longTitle,
            'theme': 'light'
        });

        gapi.signin2.render('btn-google-student-lg', {
            'scope': 'profile email',
            'width': googleBtnWidth,
            'height': googleBtnHeight,
            'longtitle': true,
            'theme': 'light'
        });

        gapi.signin2.render('btn-google-tutor-lg', {
            'scope': 'profile email',
            'width': googleBtnWidth,
            'height': googleBtnHeight,
            'longtitle': true,
            'theme': 'light'
        });

        let checkBtnAddedInterval = setInterval(() => {
            _.forEach($('.abcRioButtonContents').children(), function (ele) {
                if ($(ele).html() == 'Signed in with Google') {
                    $(ele).html('Sign in with Google');
                    clearInterval(checkBtnAddedInterval);
                }
                else if ($(ele).html() == 'Signed in') {
                    $(ele).html('Sign in');
                    clearInterval(checkBtnAddedInterval);
                }
            });
        }, 1);
    }

    function adjustGoogleBtnSize() {
        if ($(window).width() < 400) {
            googleBtnWidth = 120;
            googleBtnHeight = 28;
            longTitle = false;
        } else if ($(window).width() < 576) {
            googleBtnWidth = 140;
            googleBtnHeight = 30;
            longTitle = false;
        } else {
            googleBtnWidth = 240;
            googleBtnHeight = 50;
            longTitle = true
        }
    }

    $('.btn-add-post, .btn-add-post-scroll').click(function() {
        if(loggedIn)
            window.location.href = "{{ route('posts.create') }}";
        else {
            $('.overlay-student').show();
        }
    });

</script>

{{-- google services --}}
<script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
