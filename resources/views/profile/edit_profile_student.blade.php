@extends('layouts.loggedin')
@section('title', 'edit profile - student')

@section('content')


<div class="container edit-profile__container">
    <div>
        <a class="btn btn-lg back-button" id="back-button" href="/profile">
            Back to Profile
        </a>
    </div>

    <form action="edit_profile" class="edit-profile__form" method="POST">
        @csrf
        <div class="edit-profile__form__header">
            <h2>Edit Profile</h2>
            <div class="buttons">
                <button class="btn btn-lg btn-outline-primary">Cancel</button>
                <button class="btn btn-lg btn-primary">Save Changes</button>
            </div>
        </div>
        <div class="w-75 edit-profile__form__content">
            <span class="labels">Full Name *</span>
            <span class="labels">Email *</span>
            <input type="text" value="Jamie Chang">
            <input type="email" value="jamiec@usc.edu" class="disable">
            <span class="labels">Password *</span>
            <span class="labels">Year *</span>
            <input type="password" value="123">
            <input type="text" value="Freshman">
            <span class="labels">Major *</span>
            <span class="labels">Minor</span>
            <input type="text" value="B.S. Astronautical Engineering">
            <input type="text" value="Web Technologies and Application">
            <span class="labels">Upload Profile Picture *</span>
            <span class="labels invisible">hidden span</span>
            <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="input-photo-label">Upload</span>
                </div>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="input-photo" aria-describedby="input-photo-label">
                  <label class="custom-file-label" for="input-photo">Choose file</label>
                </div>
              </div>
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

<script src="{{asset('js/edit_profile.js')}}"></script>

@endsection