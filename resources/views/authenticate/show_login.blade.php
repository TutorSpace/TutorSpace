@extends('layouts.index')
@section('title', 'login page')

@section('content')

<div class="container-fluid login-container">
    <div class="row login-container__img">
        <svg width="215" height="199" viewBox="0 0 215 199" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M178.214 79.8426H36.9788C36.6313 76.9918 36.4524 74.0889 36.4524 71.1442C36.4524 31.8523 68.3048 0 107.597 0C146.888 0 178.741 31.8523 178.741 71.1442C178.741 74.0889 178.562 76.9918 178.214 79.8426Z"
                fill="#FFF06A" />
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M0.160533 79.2308L214.624 79.2308C209.088 146.507 163.192 199 107.392 199C51.5928 199 5.69614 146.507 0.160533 79.2308Z"
                fill="url(#paint0_radial)" />
            <defs>
                <radialGradient id="paint0_radial" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse"
                    gradientTransform="translate(107.597 84.9349) rotate(90) scale(86.6895 124.781)">
                    <stop stop-color="#FFF06A" />
                    <stop offset="1" stop-color="#FFF06A" stop-opacity="0" />
                </radialGradient>
            </defs>
        </svg>

    </div>

    <div class="row login-container__content">
        <form action="/login" class="login-container__content__form" method="post">
            @csrf
            <div class="login-container__content__form__header text-center">
                <h1 class="heading-color">Log in</h1>
            </div>
            
            <input type="email" name="email" placeholder="USC Email" class="">
            <input type="password" name="password" placeholder="Password" class="password">
            <div class="forget-password">
                <a href="/forget_password">Forgot Password</a>
            </div>
            <button class="btn btn-lg btn-primary login-btn btn-animated--up" type="submit">Log in</button>
            <button class="btn btn-lg btn-outline-primary btn-animated--up">Sign up</button>
        </form>

    </div>



</div>

@endsection

@section('js')
<script src="{{asset('js/login.js')}}"></script>

@endsection
