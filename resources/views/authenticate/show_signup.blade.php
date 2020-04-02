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
                <div class="text-center"><a class="btn btn-lg btn-primary btn-animated--up" href="/signup_tutor">Get
                        Started!</a></div>
            </div>
        </div>
        <div class="col">
            <div class="signup-container__box--student">
                <h3>Student</h3>
                <h5>- Get help from USC students who have already taken the courses you’re in </h5>
                <h5>- Browse through profiles to find a tutor that best fits your learning style, budget, and
                    schedule </h5>
                <div class="text-center"><a class="btn btn-lg btn-bg-blue-light btn-animated--up"
                        href="/signup_student">Get Started!</a></div>
            </div>
        </div>
    </div>

    <div class="signup-container__flag">
        <svg width="215" height="534" viewBox="0 0 215 534" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M115.671 0H98.6709V534H115.671V0Z" fill="#FFC077" />
            <path d="M184.693 36.1723H80.8326V7.04688H184.693L214.771 21.6096L184.693 36.1723Z" fill="#FFC077" />
            <path opacity="0.1"
                d="M184.693 33.8238H80.8326V36.1727H184.693L214.771 21.61L212.345 20.4355L184.693 33.8238Z"
                fill="black" />
            <path d="M30.0773 74.6918H133.938V45.5664H30.0773L0 60.1291L30.0773 74.6918Z" fill="#FFC077" />
            <path opacity="0.1" d="M2.42546 58.9551L0 60.1295L30.0773 74.6922H133.938V72.3434H30.0773L2.42546 58.9551Z"
                fill="black" />
            <path d="M156.966 12.6836H139.107V30.5346H156.966V12.6836Z" fill="#97D2FB" />
            <path
                d="M67.204 69.0561C72.1354 69.0561 76.1332 65.06 76.1332 60.1306C76.1332 55.2012 72.1354 51.2051 67.204 51.2051C62.2725 51.2051 58.2748 55.2012 58.2748 60.1306C58.2748 65.06 62.2725 69.0561 67.204 69.0561Z"
                fill="#2C86C4" />
            <path
                d="M107.15 25.8368C110.005 25.8368 112.32 23.5232 112.32 20.6694C112.32 17.8155 110.005 15.502 107.15 15.502C104.295 15.502 101.981 17.8155 101.981 20.6694C101.981 23.5232 104.295 25.8368 107.15 25.8368Z"
                fill="#CCCCCC" />
            <path
                d="M107.15 64.3583C110.005 64.3583 112.32 62.0447 112.32 59.1908C112.32 56.337 110.005 54.0234 107.15 54.0234C104.295 54.0234 101.981 56.337 101.981 59.1908C101.981 62.0447 104.295 64.3583 107.15 64.3583Z"
                fill="#CCCCCC" />
        </svg>

    </div>

</div>


@endsection

@section('js')
<script src="{{asset('js/signup.js')}}"></script>

@endsection
