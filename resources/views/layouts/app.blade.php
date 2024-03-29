<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>@yield('title')</title>

    {{-- google services --}}
    <meta name="google-signin-client_id" content="{{ env('GOOGLE_CLIENT_ID') }}">

    <link rel = "icon" href =
    "{{ asset('assets/images/tutorspace_logo.png') }}"
            type = "image/x-icon">


    <!-- my css -->
    <link rel="stylesheet" href="{{asset('css/main.css')}}" />
    @yield('links-in-head')
</head>
<body class="@yield('body-class')">
    @if (Route::current()->getName() != 'index')
    @include('partials.report-box')
    @endif

    @yield('content')


    {{-- my js --}}
    <script>
        // ============== STRIPE =======================
        var stripeApiKey;
        if ("{{env('APP_ENV')}}" == "local"){
            stripeApiKey = "{{ env('STRIPE_PUBLISHABLE_TEST_KEY') }}";
        }else if ("{{env('APP_ENV')}}" == "production"){
            stripeApiKey = "{{ env('STRIPE_PUBLISHABLE_LIVE_KEY') }}";
        }

    </script>
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

            JsLoadingOverlay.show(jsLoadingOverlayOptions);
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
                },
                complete: () => {
                    JsLoadingOverlay.hide();
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
            JsLoadingOverlay.show(jsLoadingOverlayOptions);
            $.ajax({
                type:requestType,
                url: `/bookmark/${userId}`,
                success: (data) => {
                    @if(isset($useBookmarkSidebar) && $useBookmarkSidebar)
                    $.ajax({
                        type: 'GET',
                        url: "{{ route('home.get.bookmark.sidebar') }}",
                        success: (data) => {
                            $('.home__side-bar__bookmarked-users').html(data.view);
                        },
                        error: function(error) {
                            toastr.error('Something went wrong. Please contact tutorspacehelp@gmail.com for more details.');
                            console.log(error);
                        }
                    });
                    @endif
                },
                error: function(error) {
                    toastr.error('Something went wrong. Please contact tutorspacehelp@gmail.com for more details.');
                    console.log(error);
                },
                complete: () => {
                    JsLoadingOverlay.hide();
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

            $('nav .profile-img-dropdown').hide();

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
            JsLoadingOverlay.show(jsLoadingOverlayOptions);
            $.ajax({
                type: 'POST',
                url: "{{ route('switch-account.register') }}",
                success: (data) => {
                    if(data.errorMsg) {
                        toastr.error(data.errorMsg);
                    } else {
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
                    }
                },
                error: function(error) {
                    toastr.error('Something went wrong. Please try again.');
                    console.log(error);
                },
                complete: () => {
                    JsLoadingOverlay.hide();
                }
            });
            @else
            window.location.href = "{{ route('switch-account.register-to-be-tutor') }}";

            @endif
        }

        function callbackHaveDualIdentity() {
            JsLoadingOverlay.show(jsLoadingOverlayOptions);
            $.ajax({
                type: 'GET',
                url: "{{ route('switch-account.switch') }}",
                success: (data) => {
                    @if(Illuminate\Support\Str::of(url()->current())->contains('switch-account'))
                    window.location.href = "{{ route('home.profile') }}";
                    @else
                    window.location.reload();
                    @endif
                },
                error: function(error) {
                    toastr.error('Something went wrong. Please try again.');
                    console.log(error);
                },
                complete: () => {
                    JsLoadingOverlay.hide();
                }
            })
        }
        @endauth

        @if (session()->get('toSwitchAccount') || (isset($toSwitchAccount) && $toSwitchAccount))
            $('.nav__item__svg--switch-account').click();
        @endif

        // onboarding
        @auth
        function getOnboarding(num) {
            @if(Auth::user()->is_tutor)
            if(num == 7) dialog.modal('hide');
            @else
            if(num == 5) dialog.modal('hide');
            @endif

            JsLoadingOverlay.show(jsLoadingOverlayOptions);
            $.ajax({
                type: 'GET',
                url: "{{ url('/onboarding') }}" + `/${num}`,
                complete: () => {
                    JsLoadingOverlay.hide();
                },
                success: (data) => {
                    let dialog = bootbox.dialog({
                        message: data.view,
                        centerVertical: true,
                        closeButton: false,
                        className: 'modal-onboarding-container',
                    });
                    $('.btn-next').click(function() {
                        dialog.modal('hide');
                        getOnboarding(num + 1);
                    })
                },
                error: (error) => {
                    console.log(error);
                }
            });
        };
        @endauth

        @if(Auth::check() && Auth::user()->unnotifiedOnboardingUsers()->exists())
        getOnboarding(1);
        @endif
    </script>
    @yield('js')

</body>
</html>
