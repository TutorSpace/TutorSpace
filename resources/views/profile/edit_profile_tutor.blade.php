@extends('layouts.loggedin')
@section('title', 'edit profile - tutor')

@section('content')


<div class="container edit-profile__container">
    <div>
        <a class="btn btn-lg back-button" id="back-button" href="/profile">
            Back to Profile
        </a>
    </div>

    <form action="edit_profile" class="edit-profile__form" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="edit-profile__form__header">
            <h4>Edit Profile</h4>
            <div class="buttons">
                <a class="btn btn-lg btn-outline-primary" id="cancel-edit-profile" href="/edit_profile">Cancel</a>
                <button class="btn btn-lg btn-primary" type="submit">Save Changes</button>
            </div>
        </div>
        <div class="w-75 edit-profile__form__content">
            <span class="labels">Full Name *</span>
            <span class="labels disabled">Email *</span>
            <input type="text" value="{{$fullName}}" name="fullName" required>
            <input type="email" value="{{$email}}" disabled>
            <span class="labels">Major *</span>
            <span class="labels">Minor</span>
            <input type="text" value="{{$major}}" name="major" id="major" required>
            <input type="text" value="{{$minor}}" name="minor">

            <span class="labels">GPA *</span>
            <span class="labels">Hourly Rate</span>
            <input type="text" value="{{$gpa}}" name="gpa" id="gpa" required>
            <input type="text" value="{{$hourlyRate}}" name="hourlyRate">

            <span class="labels">Year *</span>
            <span class="labels">Upload Profile Picture</span>
            <input type="text" value="{{$year}}" name="schoolYear" id="schoolYear" required>
            <div class="input-group">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="input-photo" name="profile-pic">
                  <label class="custom-file-label" for="input-photo" id="file-input-text">
                        Choose file
                    </label>
                </div>
            </div>
            @if(session('errors'))
                <div class="error error-right">{{$errors->first()}}</div>
            @endif
            @if(session('success'))
                <div class="success text-success ">{{session('success')}}</div>
            @endif

        </div>


    </form>

    {{-- <form action="" class="edit-profile__form">
        <div class="edit-profile__form__header">
            <h2>Edit Bank Information</h2>
            <div class="buttons">
                <button class="btn btn-lg btn-outline-primary">Cancel</button>
                <button class="btn btn-lg btn-primary">Save Changes</button>
            </div>
        </div>

        <h5>Account 1</h5>
        <div class="edit-profile__form__bank">
            <div class="edit-profile__form__content">
                <span class="labels">Name on Account *</span>
                <span class="labels">Account Type *</span>
                <input type="text" value="Jamie Chang">
                <!-- <input type="text" placeholder="Savings"> -->
                <select>
                    <option value="">Choose an option</option>
                    <option value="checkings">Checkings</option>
                    <option value="savings">Savings</option>
                </select>
                <span class="labels">Bank Transit Number *</span>
                <span class="labels">Bank Account Number *</span>
                <input type="text" value="110000498">
                <input type="text" value="********1683">
            </div>
        </div>

    </form> --}}


</div>



@endsection

@section('js')
<!-- for autocomplete -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{asset('js/edit_profile.js')}}"></script>

@endsection
