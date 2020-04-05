@extends('layouts.index')
@section('title', 'signup page - tutor')

@section('content')
    

<div class="container signup-container" id="signup_tutor_container">
    <form action="/signup_tutor" method="POST" class="signup-container__form text-center">
        @csrf
        <div class="signup-container__form__header">
            <h1 class="heading-color">Sign up to be a Tutor</h1>
        </div>

        <div class="row row-cols-2">
            <div class="col">
                <div class="signup-container__form__group">
                    <input type="text" id="fullName" name="fullName" placeholder="Full Name *" required>
                    <label for="fullName"><small>Full Name *</small></label>
                </div>


                
                <div class="signup-container__form__group">
                    <input type="password" id="password-1" name="password" placeholder="Password *" required>
                    <label for="password"><small>Password *</small></label>
                </div>

                {{-- <div class="signup-container__form__group">
                    <input type="text" id="major" name="major" placeholder="Major *" required>
                    <label for="major"><small>Major *</small></label>
                </div> --}}

                {{-- <div class="signup-container__form__group">
                    <input type="text" id="gpa" name="gpa" placeholder="GPA *" required>
                    <label for="gpa"><small>GPA *</small></label>
                </div> --}}


            </div>

            <div class="col">
                <div class="signup-container__form__group">
                    <input type="email" id="email" name="email" placeholder="USC Email *" required>
                    <label for="email"><small>USC Email *</small></label>
                </div>
                

                {{-- <div class="signup-container__form__group">
                    <input type="text" id="schoolYear" name="schoolYear" placeholder="School Year *" required>
                    <label for="schoolYear"><small>School Year *</small></label>
                </div> --}}

                <div class="signup-container__form__group">
                    <input type="password" id="password-confirm" name="password-confirm" placeholder="Confirm Password *" required>
                    <label for="password-confirm"><small>Confirm Password *</small></label>
                    
                </div>


                {{-- <div class="signup-container__form__group">
                    <input type="text" id="minor" name="minor" placeholder="Minor *" required>
                    <label for="mino"><small>Minor *</small></label>
                </div> --}}


                {{-- <div class="signup-container__form__group">
                    <input type="text" id="hourlyRate" name="hourlyRate" placeholder="Hourly Rate *" required>
                    <label for="hourlyRate"><small>Hourly Rate *</small></label>
                    <span class="error error-right" >Please check your inputs</span>
                </div> --}}


            </div>
        </div>

        <button type="submit" class="btn btn-lg btn-primary signup-container__form__btn btn-animated--up">Create Account</a>

    </form>

</div>

@endsection

@section('js')
<script src="{{asset('js/signup.js')}}"></script>

@endsection