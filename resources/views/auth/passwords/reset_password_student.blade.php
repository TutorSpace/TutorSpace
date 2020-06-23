@extends('layouts.app')
@section('title', 'Reset Password - Student')

@section('body-class')
bg-grey-light body-login
@endsection

@section('content')
<div class="container login">
    <div class="login--left login--left-student">
        <form action="{{ route('reset-password.index.student') }}" method="POST">
            @csrf
            <h2 class="login__heading">Reset Password</h2>
            <p class="login__notice">
                @csrf
                No worries! Enter your email and we'll send instructions to reset your password.
            </p>
            <div class="p-relative">
                <input type="email" class="form-control login-form-input login-form-input-normal" placeholder="Email" value="{{ old('email') }}" name="email"
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

            <div class="text-center">
                <button class="btn btn-student btn-send btn-animation-y">Send</button>
            </div>

            <p class="resend-email">
                Didn't get the code? <button class="btn btn-link btn-link-student" id="resend-code" type="button">Resend code</button>
                <span id="timeLabel"></span>
            </p>

            <p class="text-center fs-2">
                <span class="fc-grey">Back to </span><a href="{{ route('login.index.student') }}"
                    class="btn-link-student">Log in</a>
            </p>

        </form>
    </div>

    <div class="login--right login--right-student">
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
        <svg class="login--right__logo" width="330" height="91" viewBox="0 0 330 91" fill="none"
            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <rect width="330" height="91" fill="url(#pattern0)" />
            <defs>
                <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                    <use xlink:href="#image0" transform="translate(-0.000518888) scale(0.0037775 0.0136986)" />
                </pattern>
                <image id="image0" width="265" height="73"
                    xlink:href="data:image/png;base64,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" />
            </defs>
        </svg>
    </div>
</div>

{{-- bg shapes for students --}}
@include('auth.partials.bg_shapes_student')

@endsection


@section('js')

{{-- for resend veri code js --}}
<script src="{{ asset('js/register.js') }}"></script>

@endsection
