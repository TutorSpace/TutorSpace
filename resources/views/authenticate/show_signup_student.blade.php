@extends('layouts.index')
@section('title', 'signup page - student')

@section('content')


<div class="container signup-container ">
    <form action="/signup_student" method="POST" class="signup-container__form text-center">
        @csrf
        <div class="signup-container__form__header">
            <h1 class="heading-color">Sign up to be a Student</h1>
        </div>

        <div class="row row-cols-2">
            <div class="col">
                <div class="signup-container__form__group">
                    <input type="text" id="fullName" name="fullName" placeholder="Full Name *"
                        value="{{ old('fullName') }}" required>
                    <label for="fullName"><small>Full Name *</small></label>

                    @error('fullName')
                    <span class="error error-right">{{$message}}</span>
                    @enderror
                </div>

                <div class="signup-container__form__group">
                    <input type="password" id="password" name="password" placeholder="Password *" required>
                    <label for="password"><small>Password *</small></label>

                    @error('password')
                    <span class="error error-right">{{$message}}</span>
                    @enderror
                </div>

            </div>

            <div class="col">
                <div class="signup-container__form__group">
                    <input type="email" id="email" name="email" placeholder="USC Email *" value="{{ old('email') }}"
                        required>
                    <label for="email"><small>USC Email *</small></label>

                    @error('email')
                    <span class="error error-right">{{$message}}</span>
                    @enderror
                </div>

                <div class="signup-container__form__group">
                    <input type="password" id="password-confirm" name="password-confirm" placeholder="Confirm Password *"
                        required>
                    <label for="password-confirm"><small>Confirm Password *</small></label>

                    @error('password-confirm')
                    <span class="error error-right">Passwords do not match.</span>
                    @enderror
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-lg btn-bg-blue-light signup-container__form__btn btn-animated--up">
            <h5>Create Account</h5>
        </button>


    </form>
</div>


@endsection

@section('js')

<!-- for autocomplete -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="{{asset('js/signup.js')}}"></script>

@endsection
