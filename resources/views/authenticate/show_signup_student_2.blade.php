@extends('layouts.index')
@section('title', 'signup page - student')

@section('content')

<div class="container signup-container ">
    <form action="/signup_student_2" method="POST" class="signup-container__form text-center">
        @csrf

        <div class="signup-container__form__header">
            <h1 class="heading-color">Sign up to be a Student</h1>
        </div>

        <div class="row row-cols-2">
            <div class="col">

                <div class="signup-container__form__group">
                    <input type="text" id="major" name="major" placeholder="Major *" value="{{ old('major') }}"
                        required>
                    <label for="major"><small>Major *</small></label>
                    @error('major')
                    <span class="error error-right">{{$message}}</span>
                    @enderror
                </div>

                <div class="signup-container__form__group">
                    <input type="text" id="schoolYear" name="schoolYear" placeholder="School Year *"
                        value="{{ old('schoolYear') }}" required>
                    <label for="schoolYear"><small>School Year *</small></label>
                    @error('schoolYear')
                    <span class="error error-right">{{$message}}</span>
                    @enderror
                </div>

            </div>

            <div class="col p-relative">

                <div class="signup-container__form__group">
                    <input type="text" id="minor" name="minor" placeholder="Minor" value="{{ old('minor') }}">
                    <label for="minor"><small>Minor</small></label>
                    @error('minor')
                    <span class="error error-right">{{{$message}}}</span>
                    @enderror
                </div>

                <div class="file-input-group">
                    <label for="profile-pic" class="label-upload"><span>Upload Profile Image</span></label>

                    <input type="file" id="profile-pic" name="profile-pic" placeholder="Upload Profile Picture">


                </div>
                @error('profile-pic')
                <span class="error error-right error-input-file">{{$message}}</span>
                @enderror

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
