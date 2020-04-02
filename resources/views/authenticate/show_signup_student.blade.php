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
                    <input type="text" id="firstName" name="firstName" placeholder="First Name *" required>
                    <label for="firstName"><small>First Name *</small></label>
                </div>

                <div class="signup-container__form__group">
                    <input type="email" id="email" name="email" placeholder="USC Email *" required>
                    <label for="email"><small>USC Email *</small></label>
                </div>


                <div class="signup-container__form__group">
                    <input type="text" id="major" name="major" placeholder="Major *" required>
                    <label for="major"><small>Major *</small></label>
                </div>

                <div class="signup-container__form__group">
                    <input type="password" id="password-1" name="password" placeholder="Password *" required>
                    <label for="password"><small>Password *</small></label>
                </div>

            </div>

            <div class="col">

                <div class="signup-container__form__group">
                    <input type="text" id="lastName" name="lastName" placeholder="Last Name *" required>
                    <label for="lastName"><small>Last Name *</small></label>
                </div>


                <div class="signup-container__form__group">
                    <input type="text" id="schoolYear" name="schoolYear" placeholder="School Year *" required>
                    <label for="schoolYear"><small>School Year *</small></label>
                </div>


                <div class="signup-container__form__group">
                    <input type="text" id="minor" name="minor" placeholder="Minor">
                    <label for="minor"><small>Minor</small></label>

                </div>

                <div class="signup-container__form__group">
                    <input type="password" id="password-check" name="password-check" placeholder="Check Password *"
                        required>
                    <label for="password-check"><small>Check Password *</small></label>
                    <span class="error error-right">Please check your inputs</span>
                </div>

            </div>


        </div>

        <button type="submit" class="btn btn-lg btn-bg-blue-light signup-container__form__btn btn-animated--up">
            <h5>Create Account</h5>
        </a>


    </form>
</div>


@endsection

@section('js')
<script src="{{asset('js/signup.js')}}"></script>

@endsection