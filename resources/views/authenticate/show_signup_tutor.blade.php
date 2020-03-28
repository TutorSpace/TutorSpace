@extends('layouts.index')
@section('title', 'signup page - tutor')

@section('content')
    <div class="container signup-container" id="signup_tutor_container">
        <form action="#" class="signup-container__form text-center">
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
                        <input type="text" id="major" name="major" placeholder="Major *" required>
                        <label for="major"><small>Major *</small></label>
                    </div>

                    <div class="signup-container__form__group">
                        <input type="text" id="gpa" name="gpa" placeholder="GPA *" required>
                        <label for="gpa"><small>GPA *</small></label>
                    </div>
                </div>

                <div class="col">
                    <div class="signup-container__form__group">
                        <input type="text" id="graduatingYear" name="graduatingYear" placeholder="Graduting Year *"
                            required>
                        <label for="graduatingYear"><small>Graduting Year *</small></label>
                    </div>


                    <div class="signup-container__form__group">
                        <input type="text" id="minor" name="minor" placeholder="Minor *" required>
                        <label for="mino"><small>Minor *</small></label>
                    </div>


                    <div class="signup-container__form__group">
                        <input type="text" id="experience" name="experience" placeholder="Experience *" required>
                        <label for="experience"><small>Experience *</small></label>
                    </div>

                </div>
            </div>

            <a type="submit" class="btn btn-lg btn-primary signup-container__form__btn btn-animated--up" href="/profile_tutor.html">Create Account</a>
        </form>

    </div>


@endsection

@section('js')
<script src="{{asset('js/signup.js')}}"></script>

@endsection