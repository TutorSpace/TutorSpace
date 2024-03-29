@extends('layouts.app')
@section('title', 'Login - Tutor')

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
                <input type="email" class="form-control login-form-input login-form-input-normal @error('loginError') invalid @enderror @error('email') invalid @enderror" placeholder="Email" value="{{ old('email') }}" name="email"
                    required>
                <svg class="input-icon">
                    <use xlink:href="{{asset('assets/sprite.svg#icon-mail')}}"></use>
                </svg>
                @error('loginError')
                <span class="fs-1-4 ws-no-wrap p-absolute top-100 right-0 fc-red">
                    {{ $message }}
                </span>
                @enderror

                @error('email')
                <span class="fs-1-4 ws-no-wrap p-absolute top-100 right-0 fc-red">
                    {{ $message }}
                </span>
                @enderror
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
                <span class="fs-1-4 ws-no-wrap p-absolute top-100 right-0 fc-red mt-2rem">
                    {{ session('passwordError') }}
                </span>
                @endif
            </div>

            <div class="text-right mt-1">
                <a href="{{ route('password.request', ['is_tutor' => true]) }}" class="btn-link-tutor fs-1-4">Forgot your password?</a>
            </div>

            <div class="text-center">
                <button class="btn btn-tutor btn-login btn-animation-y">Login</button>
            </div>

            <p class="text-center my-4 fs-1-4 fc-grey separator">or</p>

            <div class="d-flex justify-content-center btn-google-container mt-0 btn-google-container-sm">
                {{-- google button --}}
                <div id="btn-google-sm" class="btn-google btn-animation-y"></div>
                <span class="fs-1-4 p-absolute top-100 mt-2 fc-red">
                    {{ session('googleLoginError') }}
                </span>
            </div>

            <p class="text-center fs-1-8">
                <span class="fc-grey">Don't have an account? </span><a href="{{ route('register.index.tutor.1') }}"
                    class="btn-link-tutor fs-1-8">Sign Up</a>
            </p>
            <p class="text-center fs-1-8 mt-0">
                <span class="fc-grey">Switch to </span><a href="{{ route('login.index.student') }}"
                    class="btn-link-tutor fs-1-8">Student Login</a>
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
        <svg class="login--right__logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 244.61 55.39">
            <defs><style>.cls-1{fill:#fff;}.cls-2{fill:none;stroke:#fff;stroke-miterlimit:10;stroke-width:5px;}</style></defs><g id="图层_2" data-name="图层 2"><g id="图层_1-2" data-name="图层 1"><circle class="cls-1" cx="4.49" cy="28.1" r="4.49"/><path class="cls-2" d="M58.18,10.37l-19.34,16a4.06,4.06,0,0,1-4,.69L11.3,18.53a1.07,1.07,0,0,1-.25-1.88L29.52,3.91a8,8,0,0,1,6.56-1.14L57.77,8.52A1.06,1.06,0,0,1,58.18,10.37Z"/><path class="cls-2" d="M19.66,22.13a20.41,20.41,0,0,0,3.79,25.36.11.11,0,0,1,0,.13l-2.95,5.11a.11.11,0,0,0,.1.16H36.81c11.35,0,20.88-9.07,20.88-20.42a20.38,20.38,0,0,0-6.54-15"/><path class="cls-1" d="M81.36,25.27a4.49,4.49,0,0,1-.6-2.22,2.4,2.4,0,0,1,.55-1.78,2,2,0,0,1,1.45-.54H96.61a3.74,3.74,0,0,1,.41.95A4.11,4.11,0,0,1,97.21,23a2.4,2.4,0,0,1-.55,1.78,2,2,0,0,1-1.45.54H91.69V40c-.24.06-.6.12-1.1.19a12.37,12.37,0,0,1-1.48.09,6.1,6.1,0,0,1-1.28-.11,2.17,2.17,0,0,1-.94-.39,1.68,1.68,0,0,1-.57-.8,3.79,3.79,0,0,1-.19-1.33V25.27Z"/><path class="cls-1" d="M98.71,24.86a5.93,5.93,0,0,1,1-.19,9.18,9.18,0,0,1,1.41-.1,6.73,6.73,0,0,1,1.25.1,2.05,2.05,0,0,1,.94.38,1.8,1.8,0,0,1,.59.78,3.29,3.29,0,0,1,.21,1.28v6.83a2.37,2.37,0,0,0,.63,1.86,2.72,2.72,0,0,0,1.84.56,4.43,4.43,0,0,0,1.2-.13,4.32,4.32,0,0,0,.71-.25V24.86a5.93,5.93,0,0,1,1-.19,9.36,9.36,0,0,1,1.41-.1,6.85,6.85,0,0,1,1.26.1,2.15,2.15,0,0,1,.94.38,1.78,1.78,0,0,1,.58.78,3.29,3.29,0,0,1,.21,1.28v9.66a2.59,2.59,0,0,1-1.33,2.38,8.92,8.92,0,0,1-2.66,1.07,14.64,14.64,0,0,1-3.35.36,12.11,12.11,0,0,1-3.16-.38A7,7,0,0,1,100.9,39,5.29,5.29,0,0,1,99.28,37a7.33,7.33,0,0,1-.57-3Z"/><path class="cls-1" d="M122.59,34.77a1.33,1.33,0,0,0,.53,1.18,2.68,2.68,0,0,0,1.48.34,6.79,6.79,0,0,0,1.87-.28,3.82,3.82,0,0,1,.49.78,2.31,2.31,0,0,1,.21,1,2.45,2.45,0,0,1-.91,2,5,5,0,0,1-3.19.76,6.47,6.47,0,0,1-4.3-1.27,5.1,5.1,0,0,1-1.51-4.13V21.55c.23-.06.56-.13,1-.2a7.57,7.57,0,0,1,1.38-.11,4.07,4.07,0,0,1,2.18.49,2.32,2.32,0,0,1,.77,2.08v2h4.17a7.2,7.2,0,0,1,.36.88,3.53,3.53,0,0,1,.18,1.16,2.19,2.19,0,0,1-.5,1.6,1.77,1.77,0,0,1-1.32.49h-2.89Z"/><path class="cls-1" d="M145.69,32.36a9.43,9.43,0,0,1-.61,3.51,7,7,0,0,1-1.69,2.58A7.3,7.3,0,0,1,140.76,40a10.09,10.09,0,0,1-3.39.54A9.62,9.62,0,0,1,134,40a7.42,7.42,0,0,1-2.62-1.64,7.08,7.08,0,0,1-1.7-2.58,9.11,9.11,0,0,1-.61-3.43,9,9,0,0,1,.61-3.4,7.12,7.12,0,0,1,1.7-2.59A7.42,7.42,0,0,1,134,24.73a9.62,9.62,0,0,1,3.4-.57,9.38,9.38,0,0,1,3.39.59,7.73,7.73,0,0,1,2.63,1.65A7.23,7.23,0,0,1,145.08,29,8.91,8.91,0,0,1,145.69,32.36Zm-11.12,0a5,5,0,0,0,.75,3,2.43,2.43,0,0,0,2.08,1,2.33,2.33,0,0,0,2-1,5.25,5.25,0,0,0,.71-3,5,5,0,0,0-.73-2.94,2.57,2.57,0,0,0-4.13,0A5,5,0,0,0,134.57,32.36Z"/><path class="cls-1" d="M153.73,40a6.32,6.32,0,0,1-1,.19,9.18,9.18,0,0,1-1.41.1,6.73,6.73,0,0,1-1.25-.1,2.1,2.1,0,0,1-.94-.38,1.8,1.8,0,0,1-.59-.78,3.25,3.25,0,0,1-.21-1.28V28.26a2.73,2.73,0,0,1,.27-1.26,2.85,2.85,0,0,1,.78-.93,5.38,5.38,0,0,1,1.26-.75,13.64,13.64,0,0,1,1.6-.59,14.41,14.41,0,0,1,1.78-.4,12.77,12.77,0,0,1,1.84-.14,4.38,4.38,0,0,1,2.42.59,2.13,2.13,0,0,1,.89,1.92,3.16,3.16,0,0,1-.13.87,3.44,3.44,0,0,1-.32.78,12.65,12.65,0,0,0-1.36.07,12.21,12.21,0,0,0-1.37.19c-.44.08-.86.17-1.25.27a4.68,4.68,0,0,0-1,.33Z"/><path class="cls-1" d="M167.26,32.42c-.93-.32-1.78-.64-2.54-1a7.59,7.59,0,0,1-2-1.19,5,5,0,0,1-1.29-1.67,5.41,5.41,0,0,1-.46-2.37,5.19,5.19,0,0,1,2.08-4.32,9.29,9.29,0,0,1,5.83-1.62,16.72,16.72,0,0,1,2.54.19,7.92,7.92,0,0,1,2,.59,3.64,3.64,0,0,1,1.32,1,2.32,2.32,0,0,1,.47,1.44,2.51,2.51,0,0,1-.38,1.42,4,4,0,0,1-.92,1,7.06,7.06,0,0,0-1.87-.78,9.59,9.59,0,0,0-2.58-.33,4.27,4.27,0,0,0-2.09.39,1.16,1.16,0,0,0-.67,1,.93.93,0,0,0,.41.78,4.41,4.41,0,0,0,1.24.56l1.69.54a12,12,0,0,1,4.59,2.43,5.21,5.21,0,0,1,1.6,4,5.27,5.27,0,0,1-2.13,4.36c-1.42,1.12-3.5,1.67-6.26,1.67a14.38,14.38,0,0,1-2.71-.24,8.42,8.42,0,0,1-2.19-.69,4,4,0,0,1-1.47-1.15,2.49,2.49,0,0,1-.52-1.57,2.38,2.38,0,0,1,.54-1.57,3.91,3.91,0,0,1,1.18-1,8.41,8.41,0,0,0,2.17,1.2,7.59,7.59,0,0,0,2.81.51,3.82,3.82,0,0,0,2.19-.47,1.37,1.37,0,0,0,.64-1.12,1.1,1.1,0,0,0-.51-1,7,7,0,0,0-1.43-.65Z"/><path class="cls-1" d="M185.87,24.16a12.28,12.28,0,0,1,3.55.49,7.61,7.61,0,0,1,2.81,1.51,7.1,7.1,0,0,1,1.84,2.56,9.29,9.29,0,0,1,.67,3.67,10,10,0,0,1-.58,3.56,7,7,0,0,1-1.62,2.55A6.55,6.55,0,0,1,190,40a10,10,0,0,1-3.29.51,7.73,7.73,0,0,1-2.54-.41v5.27a8.2,8.2,0,0,1-1,.21,9.52,9.52,0,0,1-1.43.11,6.81,6.81,0,0,1-1.25-.1,2.15,2.15,0,0,1-.94-.38,1.77,1.77,0,0,1-.57-.78,3.49,3.49,0,0,1-.19-1.28V27.94a2.49,2.49,0,0,1,.36-1.4,3.79,3.79,0,0,1,1-1,8.07,8.07,0,0,1,2.44-1A13.17,13.17,0,0,1,185.87,24.16Zm.07,12.13q3.27,0,3.27-3.9a4.7,4.7,0,0,0-.81-3,2.85,2.85,0,0,0-2.34-1,3.61,3.61,0,0,0-1.08.15,3.89,3.89,0,0,0-.82.33v7a5,5,0,0,0,.82.32A3.71,3.71,0,0,0,185.94,36.29Z"/><path class="cls-1" d="M203.79,24.16a13.21,13.21,0,0,1,3.13.35,7,7,0,0,1,2.41,1.06,4.8,4.8,0,0,1,1.54,1.81,5.82,5.82,0,0,1,.54,2.59v7.12a2,2,0,0,1-.46,1.35,4.37,4.37,0,0,1-1.09.9A11.34,11.34,0,0,1,204,40.58a13.38,13.38,0,0,1-3-.31,7.3,7.3,0,0,1-2.32-1,4.28,4.28,0,0,1-1.49-1.62,4.77,4.77,0,0,1-.53-2.28A4.29,4.29,0,0,1,198,32a6.94,6.94,0,0,1,4-1.46l4.16-.45v-.22a1.37,1.37,0,0,0-.81-1.32,5.52,5.52,0,0,0-2.33-.4,10.71,10.71,0,0,0-2.35.26,13,13,0,0,0-2.07.63,2.24,2.24,0,0,1-.7-.87,2.76,2.76,0,0,1-.28-1.22,2.07,2.07,0,0,1,.39-1.32,3.1,3.1,0,0,1,1.23-.84,8.88,8.88,0,0,1,2.17-.51A18.26,18.26,0,0,1,203.79,24.16ZM204,36.64a6.68,6.68,0,0,0,1.2-.11,2.71,2.71,0,0,0,1-.3V33.69l-2.28.19a3.47,3.47,0,0,0-1.46.38,1,1,0,0,0-.58,1,1.28,1.28,0,0,0,.5,1A2.7,2.7,0,0,0,204,36.64Z"/><path class="cls-1" d="M223.42,28.42a4.47,4.47,0,0,0-1.51.25,3.48,3.48,0,0,0-2.08,2,4.33,4.33,0,0,0-.32,1.72,3.72,3.72,0,0,0,1.13,3,4,4,0,0,0,2.75,1,5.45,5.45,0,0,0,1.65-.22,10.14,10.14,0,0,0,1.24-.47,3.2,3.2,0,0,1,.95,1,2.41,2.41,0,0,1,.32,1.26,2.22,2.22,0,0,1-1.24,2,7,7,0,0,1-3.43.71,10.38,10.38,0,0,1-3.62-.59,8.11,8.11,0,0,1-2.78-1.65,7.26,7.26,0,0,1-1.79-2.56,8.2,8.2,0,0,1-.64-3.3,9.24,9.24,0,0,1,.68-3.67,7.21,7.21,0,0,1,1.86-2.59,7.81,7.81,0,0,1,2.72-1.52,10.24,10.24,0,0,1,3.25-.51,6.27,6.27,0,0,1,3.53.83,2.48,2.48,0,0,1,1.24,2.12,2.32,2.32,0,0,1-.29,1.13,3.9,3.9,0,0,1-.67.91,9,9,0,0,0-1.3-.49A5.48,5.48,0,0,0,223.42,28.42Z"/><path class="cls-1" d="M237.94,40.58a11.13,11.13,0,0,1-3.48-.52,7.93,7.93,0,0,1-2.8-1.57,7.27,7.27,0,0,1-1.87-2.64,9.29,9.29,0,0,1-.68-3.72,8.6,8.6,0,0,1,.68-3.6,7.07,7.07,0,0,1,1.79-2.48,7.21,7.21,0,0,1,2.55-1.43,9.33,9.33,0,0,1,2.92-.46,8.77,8.77,0,0,1,3.06.51,7.35,7.35,0,0,1,2.39,1.4,6.29,6.29,0,0,1,1.55,2.12,6.56,6.56,0,0,1,.56,2.7,2.21,2.21,0,0,1-.6,1.66,3.1,3.1,0,0,1-1.69.73l-7.84,1.17A2.61,2.61,0,0,0,235.9,36a5.62,5.62,0,0,0,2.48.53,8.55,8.55,0,0,0,2.46-.34,7.77,7.77,0,0,0,1.89-.77,2.62,2.62,0,0,1,.86.89,2.29,2.29,0,0,1,.35,1.2,2.25,2.25,0,0,1-1.33,2.13,6.92,6.92,0,0,1-2.29.73A15.73,15.73,0,0,1,237.94,40.58Zm-.89-12.48a3.14,3.14,0,0,0-1.32.25,2.83,2.83,0,0,0-.91.65,3,3,0,0,0-.52.89,3.57,3.57,0,0,0-.21,1l5.44-.89a2.5,2.5,0,0,0-.7-1.27A2.37,2.37,0,0,0,237.05,28.1Z"/></g></g>
        </svg>
        <div class="d-flex justify-content-center btn-google-container">
            {{-- google button --}}
            <div id="btn-google-lg" class="btn-google btn-animation-y"></div>
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
        googleBtnHeight = 50,
        longTitle = true;
    adjustGoogleBtnSize();

    $(window).resize(function () {
        adjustGoogleBtnSize();
        renderButton();
    });

    $('#btn-google-sm, #btn-google-lg').click(function (e) {
        e.stopPropagation();
        window.location.href = '{{ route('login.google.tutor') }}';
    });

    function renderButton() {

        gapi.signin2.render('btn-google-sm', {
            'scope': 'profile email',
            'width': googleBtnWidth,
            'height': googleBtnHeight,
            'longtitle': longTitle,
            'theme': 'light'
        });

        gapi.signin2.render('btn-google-lg', {
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

</script>

<script src="{{ asset('js/auth/login.js') }}"></script>

{{-- google services --}}
<script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
@endsection
