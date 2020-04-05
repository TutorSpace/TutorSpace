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
        <form action="/login" method="POST" class="login-container__content__form">
            @csrf
            <div class="login-container__content__form__header text-center">
                <h1 class="heading-color">Log In</h1>
            </div>
            

            <div class="login-container__content__form__group">
            <input type="email" id="email" name="email" placeholder="Email" value="{{session('email')}}" required>
                <label for="email"><small>Email</small></label>
                @error('email')
                <span class="error">This email has not been signed up yet.</span>
                @enderror
            </div>

            <div class="login-container__content__form__group">
                <input type="password" id="password" name="password" placeholder="Password" required>
                <label for="password"><small>Password</small></label>
                @error('password')
                <span class="error">Please enter the correct password.</span>
                @enderror
                @if (session('loginError'))
                <span class="error">{{session('loginError')}}</span>
                @endif
                <a href="/forget_password" class="forget-password">Forgot Password</a>
            </div>

            
            <button class="btn btn-lg btn-primary login-btn btn-animated--up">Log In</button>
            <button class="btn btn-lg btn-outline-primary btn-animated--up">Sign Up</button>
        </form>

    </div>



</div>


@endsection

@section('js')
<script src="{{asset('js/login.js')}}"></script>

@endsection
