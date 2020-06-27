@extends('layouts.app')
@section('title', 'Login - Tutor')

@section('links-in-head')
{{-- google services --}}
<meta name="google-signin-client_id" content="{{ env('GOOGLE_CLIENT_ID') }}">
@endsection

@section('body-class')
bg-grey-light body-login
@endsection

@section('content')
<div class="container login">
    <div class="login--left login--left-tutor">
        <form action="{{ route('login.store.tutor') }}" method="POST" class="p-relative">
            <svg class="btn-close" width="1em" height="1em" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"
                data-back-href="{{ route('index') }}">
                {{-- for empty --}}
                <path class="btn-close-empty" fill-rule="evenodd"
                    d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path class="btn-close-empty" fill-rule="evenodd"
                    d="M11.854 4.146a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708-.708l7-7a.5.5 0 0 1 .708 0z" />
                <path class="btn-close-empty" fill-rule="evenodd"
                    d="M4.146 4.146a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7a.5.5 0 0 0-.708 0z" />

                {{-- for fill --}}
                <path class="btn-close-fill" fill-rule="evenodd"
                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.146-3.146a.5.5 0 0 0-.708-.708L8 7.293 4.854 4.146a.5.5 0 1 0-.708.708L7.293 8l-3.147 3.146a.5.5 0 0 0 .708.708L8 8.707l3.146 3.147a.5.5 0 0 0 .708-.708L8.707 8l3.147-3.146z" />
            </svg>
            @csrf
            <h2 class="login__heading">Tutor Login</h2>
            <div class="p-relative">
                <input type="email" class="form-control login-form-input login-form-input-normal @if($errors->any()) invalid @endif" placeholder="Email" value="{{ old('email') }}" name="email"
                    required>
                <svg class="input-icon">
                    <use xlink:href="{{asset('assets/sprite.svg#icon-mail')}}"></use>
                </svg>
                @if($errors->any())
                <span class="fs-1-4 ws-no-wrap p-absolute top-100 right-0 fc-red">
                    {{ $errors->first() }}
                </span>
                @endif
            </div>

            <div class="p-relative">
                <input type="password" class="form-control login-form-input login-form-input-normal @error('password') invalid @enderror @if(session('passwordError')) invalid @endif" name="password"
                    placeholder="Password" required>
                <svg class="input-icon">
                    <use xlink:href="{{asset('assets/sprite.svg#icon-lock')}}"></use>
                </svg>
                @error('password')
                <span class="fs-1-4 ws-no-wrap p-absolute top-100 right-0 fc-red">
                    {{ $message }}
                </span>
                @enderror
                @if(session('passwordError'))
                <span class="fs-1-4 ws-no-wrap p-absolute top-100 right-0 fc-red">
                    {{ session('passwordError') }}
                </span>
                @endif
            </div>

            <div class="text-center">
                <button class="btn btn-tutor btn-login btn-animation-y">Login</button>
            </div>

            <div class="text-center">
                <a href="{{ route('password.request', ['is_tutor' => true]) }}" class="btn-link-tutor">Forgot your password?</a>
            </div>

            <p class="text-center fs-2">
                <span class="fc-grey">Don't have an account? </span><a href="{{ route('register.index.tutor.1') }}"
                    class="btn-link-tutor">Sign Up</a>
            </p>

        </form>
    </div>

    <div class="login--right login--right-tutor">
        <svg class="btn-close" width="1em" height="1em" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"
        data-back-href="{{ route('index') }}">
            {{-- for empty --}}
            <path class="btn-close-empty" fill-rule="evenodd"
                d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
            <path class="btn-close-empty" fill-rule="evenodd"
                d="M11.854 4.146a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708-.708l7-7a.5.5 0 0 1 .708 0z" />
            <path class="btn-close-empty" fill-rule="evenodd"
                d="M4.146 4.146a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7a.5.5 0 0 0-.708 0z" />

            {{-- for fill --}}
            <path class="btn-close-fill" fill-rule="evenodd"
                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.146-3.146a.5.5 0 0 0-.708-.708L8 7.293 4.854 4.146a.5.5 0 1 0-.708.708L7.293 8l-3.147 3.146a.5.5 0 0 0 .708.708L8 8.707l3.146 3.147a.5.5 0 0 0 .708-.708L8.707 8l3.147-3.146z" />
        </svg>
        <svg class="login--right__logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 245.56 56.53"><defs><style>.cls-1,.cls-3{fill:#fff;}.cls-2{fill:none;stroke:#fff;stroke-miterlimit:10;stroke-width:5px;}.cls-3{font-size:31.77px;font-family:BalooBhai-Regular, Baloo Bhai;}.cls-4{letter-spacing:-0.02em;}.cls-5{letter-spacing:-0.01em;}.cls-6{letter-spacing:0em;}.cls-7{letter-spacing:0em;}.cls-8{letter-spacing:-0.01em;}</style></defs><g id="图层_2" data-name="图层 2"><g id="图层_1-2" data-name="图层 1"><circle class="cls-1" cx="4.49" cy="28.1" r="4.49"/><path class="cls-2" d="M58.18,10.37l-19.34,16a4.06,4.06,0,0,1-4,.69L11.3,18.53a1.07,1.07,0,0,1-.25-1.88L29.52,3.91a8,8,0,0,1,6.56-1.14L57.77,8.52A1.06,1.06,0,0,1,58.18,10.37Z"/><path class="cls-2" d="M19.66,22.13a20.41,20.41,0,0,0,3.79,25.36.11.11,0,0,1,0,.13l-2.95,5.11a.11.11,0,0,0,.1.16H36.81c11.35,0,20.88-9.07,20.88-20.42a20.38,20.38,0,0,0-6.54-15"/><text class="cls-3" transform="translate(80.19 40.07)"><tspan class="cls-4">T</tspan><tspan x="16.87" y="0">u</tspan><tspan class="cls-5" x="35.36" y="0">t</tspan><tspan x="47.87" y="0">or</tspan><tspan class="cls-6" x="79.54" y="0">S</tspan><tspan class="cls-7" x="96.95" y="0">p</tspan><tspan x="115.6" y="0">a</tspan><tspan class="cls-8" x="132.88" y="0">c</tspan><tspan x="147.94" y="0">e</tspan></text></g></g>
        </svg>
        <div class="d-flex justify-content-center btn-google-container">
            {{-- google button --}}
            <div id="btn-google" class="btn-google btn-animation-y"></div>
            <span class="fs-1-4 p-absolute top-100 mt-2 fc-red">
                {{ session('googleLoginError') ?? session('googleLoginError') }}
            </span>
        </div>
    </div>
</div>

{{-- bg shapes for tutors --}}
@include('auth.partials.bg_shapes_tutor')

@endsection


@section('js')
<script>
    let isStudent = false;

    // ===================== Google Auth ==========================
    let googleBtnWidth = 240,
        googleBtnHeight = 50;
    adjustGoogleBtnSize();

    $(window).resize(function () {
        adjustGoogleBtnSize();
        renderButton();
    });

    $('#btn-google').click(function (e) {
        e.stopPropagation();
        window.location.href = '{{ route('login.google.tutor') }}';
    });

    function renderButton() {
        gapi.signin2.render('btn-google', {
            'scope': 'profile email',
            'width': googleBtnWidth,
            'height': googleBtnHeight,
            'longtitle': true,
            'theme': 'light'
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

</script>

<script src="{{ asset('js/login.js') }}"></script>

{{-- google services --}}
<script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
@endsection
