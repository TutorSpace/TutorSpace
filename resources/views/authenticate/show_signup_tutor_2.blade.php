@extends('layouts.index')
@section('title', 'signup page - tutor')

@section('content')


<div class="container signup-container" id="signup_tutor_container">
    <form action="/signup_tutor_2" method="POST" class="signup-container__form text-center">
        @csrf
        <div class="signup-container__form__header">
            <h1 class="heading-color">Sign up to be a Tutor</h1>
        </div>

        <div class="row row-cols-2">
            <div class="col">

                <input type="text" id="major" name="major" placeholder="Major *" value="{{ old('major') }}" required>
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

            <div class="signup-container__form__group">
                <input type="text" id="hourlyRate" name="hourlyRate" placeholder="Hourly Rate"
                    value="{{ old('hourlyRate') }}" required>
                <label for="hourlyRate"><small>Hourly Rate *</small></label>
                @error('hourlyRate')
                <span class="error error-right">{{$message}}</span>
                @enderror
            </div>


        </div>

        <div class="col">
            <div class="signup-container__form__group">
                <input type="text" id="minor" name="minor" placeholder="Minor" value="{{ old('minor') }}">
                <label for="minor"><small>Minor</small></label>
                @error('minor')
                <span class="error error-right">{{{$message}}}</span>
                @enderror
            </div>

            <div class="signup-container__form__group">
                <input type="text" id="gpa" name="gpa" placeholder="gpa" value="{{ old('gpa') }}">
                <label for="gpa"><small>GPA</small></label>
                @error('gpa')
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
    </form>
</div>

<button type="submit" class="btn btn-lg btn-primary signup-container__form__btn btn-animated--up">
    <h5>Create Account</h5>
</button>





@endsection

@section('js')
<script src="{{asset('js/signup.js')}}"></script>

@endsection
