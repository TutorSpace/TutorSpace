@extends('layouts.index')
@section('title', 'signup page')

@section('content')

<div class="container-fluid signup-container">

    <div class="signup-container__header" id="header">
        <h1 class="heading-color">I want to be a...</h1>
    </div>

    <div class="row row-cols-2 signup-container__box">
        <div class="col">
            <div class="signup-container__box--tutor">
                <h3>Tutor</h3>
                <h5>- Help other USC students in courses you’ve already taken or subjects you’re comfortable in
                </h5>
                <h5>- Decide your own hourly pay </h5>
                <h5>- Set your own tutoring schedule </h5>
                <div class="text-center"><a class="btn btn-lg btn-primary btn-animated--up" href="/signup_tutor">Get Started!</a></div>
            </div>
        </div>
        <div class="col">
            <div class="signup-container__box--student">
                <h3>Student</h3>
                <h5>- Get help from USC students who have already taken the courses you’re in </h5>
                <h5>- Browse through profiles to find a tutor that best fits your learning style, budget, and
                    schedule </h5>
                <div class="text-center"><a class="btn btn-lg btn-bg-blue-light btn-animated--up" href="/signup_student">Get Started!</a></div>
            </div>
        </div>
    </div>

    <div class="signup-container__flag">
        <svg width="215" height="534" viewBox="0 0 215 534" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M115.671 0H98.6709V534H115.671V0Z" fill="#CCCCCC" />
            <path d="M184.693 36.172H80.8328V7.04663H184.693L214.771 21.6093L184.693 36.172Z" fill="#AFAFAF" />
            <path opacity="0.1"
                d="M184.693 33.8231H80.8328V36.1719H184.693L214.771 21.6092L212.345 20.4348L184.693 33.8231Z"
                fill="black" />
            <path d="M30.0773 74.6925H133.938V45.5671H30.0773L0 60.1298L30.0773 74.6925Z" fill="#AFAFAF" />
            <path opacity="0.1"
                d="M2.42546 58.9553L0 60.1297L30.0773 74.6924H133.938V72.3436H30.0773L2.42546 58.9553Z"
                fill="black" />
            <path d="M156.966 12.6833H139.107V30.5344H156.966V12.6833Z" fill="#37BDF6" />
            <path
                d="M67.2041 69.0552C72.1356 69.0552 76.1333 65.0591 76.1333 60.1296C76.1333 55.2002 72.1356 51.2041 67.2041 51.2041C62.2726 51.2041 58.2749 55.2002 58.2749 60.1296C58.2749 65.0591 62.2726 69.0552 67.2041 69.0552Z"
                fill="#0075E0" />
            <path
                d="M107.15 25.8368C110.005 25.8368 112.32 23.5232 112.32 20.6694C112.32 17.8155 110.005 15.502 107.15 15.502C104.295 15.502 101.981 17.8155 101.981 20.6694C101.981 23.5232 104.295 25.8368 107.15 25.8368Z"
                fill="#CCCCCC" />
            <path
                d="M107.15 64.3575C110.005 64.3575 112.32 62.044 112.32 59.1901C112.32 56.3362 110.005 54.0227 107.15 54.0227C104.295 54.0227 101.981 56.3362 101.981 59.1901C101.981 62.044 104.295 64.3575 107.15 64.3575Z"
                fill="#CCCCCC" />
        </svg>
    </div>

</div>


@endsection

@section('js')
<script src="{{asset('js/signup.js')}}"></script>

@endsection
