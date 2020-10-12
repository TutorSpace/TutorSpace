<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>@yield('title')</title>

    @guest
    {{-- google services --}}
    <meta name="google-signin-client_id" content="{{ env('GOOGLE_CLIENT_ID') }}">
    @endguest

    <link rel = "icon" href =
    "{{ asset('assets/images/tutorspace_logo.png') }}"
            type = "image/x-icon">


    <!-- my css -->
    <link rel="stylesheet" href="{{asset('css/main.css')}}" />
    @yield('links-in-head')
</head>
<body class="@yield('body-class')">
    @yield('content')


    {{-- my js --}}
    <script src="{{asset('js/app.js')}}"></script>
    <script>
        @if(session('errorMsg'))
            toastr.error('{{ session('errorMsg') }}');
            @php
                session()->forget('errorMsg');
            @endphp
        @endif
        @if(session('successMsg'))
            toastr.success('{{ session('successMsg') }}');
            @php
                session()->forget('successMsg');
            @endphp
        @endif
        // for footer subscribe button
        $('#footer__form-subscribe').submit(function(e) {
            e.preventDefault();
            if(!$(this).find('input[type=email]').val()) {
                toastr.error('Please enter your email!');
                return;
            }
            $.ajax({
                type:'POST',
                url: "{{ route('subscription.store') }}",
                data: {
                    email: $(this).find('input[type=email]').val()
                },
                success: (data) => {
                    let { successMsg } = data;
                    toastr.success(successMsg);
                    $(this).find('input[type=email]').val('');
                },
                error: function(error) {
                    if(error.responseJSON.errors) {
                        toastr.error(error.responseJSON.errors.email[0]);
                    }
                    if(error.errorMsg) {
                        toastr.error(error.errorMsg);
                    }
                }
            });
        });
        // nav icons
        $('nav .svg-message').click(function() {
            window.location.href = "{{ route('chatting.index') }}";
        });
        $('nav .svg-notification').click(function() {
            window.location.href = "{{ route('notifications.index') }}";
        });
        @if(Auth::check() && !Auth::user()->is_tutor)
        // ===================== bookmark =================
        $(document).on('click', '.svg-bookmark', function() {
            if($(this).find('use.hidden').hasClass('bookmarked')) {
                var requestType = 'POST';
            }
            else {
                var requestType = 'DELETE';
            }
            let userId = $(this).attr('data-user-id');
            $.ajax({
                type:requestType,
                url: `/bookmark/${userId}`,
                success: (data) => {
                    @if(Route::current()->getName() == 'home')
                    if($(this).parent().parent().hasClass('recommended-tutors')) {
                        if(requestType == 'POST') {
                            $.ajax({
                                type:'GET',
                                url: `/bookmark/${userId}`,
                                success: (data) => {
                                    if($('.bookmarked-tutors .no-results').is(":visible")) {
                                        $('.bookmarked-tutors .no-results').remove();
                                    }
                                    let userCard = $(`.bookmarked-tutors .user-card[data-user-id=${userId}]`)
                                    // if the user card already exists in bookmarked tutors, then simply toggle its svg
                                    if(userCard[0]) {
                                        userCard.find('use').toggleClass('hidden');
                                    }
                                    else {
                                        $('.bookmarked-tutors').append(data);
                                    }
                                },
                                error: function(error) {
                                    console.log(error);
                                }
                            });
                        }
                        else {
                            $('.bookmarked-tutors').find(`.user-card[data-user-id=${userId}]`).find('.svg-bookmark').find('use').toggleClass('hidden');
                            if(!$('.bookmarked-tutors .user-card')[0]) {
                                $('.bookmarked-tutors').append(`
                                <h6 class="no-results">No bookmarked tutors yet</h6>
                                `)
                            }
                        }
                    }
                    else if($(this).parent().parent().hasClass('bookmarked-tutors')){
                        $(`.recommended-tutors .user-card[data-user-id=${userId}]`).find('.svg-bookmark').find('use').toggleClass('hidden');
                    }
                    @endif
                },
                error: function(error) {
                    toastr.error('Something went wrong. Please try again.');
                    console.log(error);
                }
            });
            $(this).find('use').toggleClass('hidden');
        });
        @endif
        @guest
        $('.svg-bookmark').click(function() {
            $('.overlay-student').show();
        })
        @endguest

        @auth
        // nav bar switch account
        $('.nav__item__svg--switch-account').on('click',function() {
            if($('.modal-switch-account')[0]) return;

            $('.nav-right__profile-img').click();

            @php
                $currUser = Auth::user();

                if($currUser->hasDualIdentities()) {
                    $declineLabel = "Cancel";

                    if($currUser->is_tutor) $submitLabel = "Switch to Student Account";
                    else $submitLabel = "Switch to Tutor Account";

                    $callbackFuncName = "callbackHaveDualIdentity";
                } else {
                    $declineLabel = "Not Now";
                    if($currUser->is_tutor) $submitLabel = "Become a Student";
                    else $submitLabel = "Become a Tutor";

                    $callbackFuncName = "callbackNotHaveDualIdentity";
                }
            @endphp


            bootbox.dialog({
                @if($currUser->hasDualIdentities())
                message: `@include('switch-account.partials.switch-account-modal-dual', [
                    'currUser' => $currUser
                ])`,
                @else
                message: `@include('switch-account.partials.switch-account-modal-not-dual')`,
                @endif
                backdrop: true,
                centerVertical: true,
                buttons: {
                    Decline: {
                        label: "{{ $declineLabel }}",
                        className: 'btn btn-outline-primary mr-3 py-2 px-4'
                    },
                    Submit: {
                        label: '{{ $submitLabel }}',
                        className: 'btn btn-primary py-2 px-4',
                        callback: {{ $callbackFuncName }}
                    },
                }
            });
        });

        function callbackNotHaveDualIdentity() {
            @if($currUser->is_tutor)
            $.ajax({
                type: 'POST',
                url: "{{ route('switch-account.register') }}",
                success: (data) => {
                    bootbox.dialog({
                        message: data.successMsg,
                        backdrop: true,
                        centerVertical: true,
                        buttons: {
                            Decline: {
                                label: "Cancel",
                                className: 'btn btn-outline-primary mr-3 py-2 px-4',
                            },
                            Submit: {
                                label: 'Switch Account Now',
                                className: 'btn btn-primary py-2 px-4',
                                callback: function(){
                                    window.location.href = "{{ route('home') }}";
                                }
                            },
                        }
                    });
                },
                error: function(error) {
                    toastr.error('Something went wrong. Please try again.');
                    console.log(error);
                }
            });
            @else

            @endif
        }

        function callbackHaveDualIdentity() {
            $.ajax({
                type: 'GET',
                url: "{{ route('switch-account.switch') }}",
                success: (data) => {
                    window.location.reload();
                },
                error: function(error) {
                    toastr.error('Something went wrong. Please try again.');
                    console.log(error);
                }
            })
        }
        @endauth

    </script>
    @yield('js')

</body>
</html>
