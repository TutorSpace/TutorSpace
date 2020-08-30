@extends('layouts.app')

@section('title', "$user->first_name's Profile")

@section('body-class')
bg-white-dark-4

@if(Auth::check() && Auth::user()->is_tutor)
bg-tutor
@else
bg-student
@endif

@endsection

@section('links-in-head')
{{-- fullcalendar --}}
<link href='https://use.fontawesome.com/releases/v5.0.6/css/all.css' rel='stylesheet'>
<script src='{{asset('fullcalendar/main.min.js')}}'></script>
@endsection

@section('content')

@include('partials.nav')

<main class="container view-profile p-relative">
    @if (Auth::user()->is_tutor)
    <div class="row back-container">
        <a class="btn btn-lg btn-back" href="{{ App\CustomClass\URLManager::getBackURL(route('posts.index')) }}">
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
            </svg>
            Back
        </a>
    </div>
    <div class="row view-profile__header-container">
        @include('home.view_profile.partials.header')
    </div>

    <div class="row">
        <div class="col-9 pl-0">
            <h5 class="w-100 mb-3 calendar-heading">Calendar</h5>
            <div id="calendar" class="w-100"></div>
            <div class="calendar-note">
                <span class="available-time">Available Time</span>
                <span class="online">Online</span>
                <span class="in-person">In Person</span>
                <span class="note">Note: All time in the calender are based on PST.</span>
            </div>

            <div class="reviews">
                <div class="d-flex justify-content-between align-items-center w-100 mb-2">
                    <h5>Reviews (5)</h5>
                    <button class="btn btn-link fs-1-4 fc-grey btn-view-all-info-boxes">View All</button>
                </div>
                <div class="info-boxes">
                    @include('home.partials.review', [
                        'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium molestiae, ullam hic modi sequi amet, id non voluptatum, repudiandae dicta perspiciatis nihil ab labore cupiditate odio nisi iure minima praesentium?'
                    ])
                    @include('home.partials.review', [
                        'content' => 'He is very nice!'
                    ])
                    @include('home.partials.review', [
                        'content' => 'I love his CSCI 201 course! Best private tutor ever!'
                    ])
                    @include('home.partials.review', [
                        'hidden' => true,
                        'content' => 'No, he is not good'
                    ])
                    @include('home.partials.review', [
                        'hidden' => true,
                        'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium molestiae, ullam hic modi sequi amet, id non voluptatum, repudiandae dicta'
                    ])
                </div>
            </div>
        </div>

        <div class="col-3 pl-5 pr-0">
            <h5 class="mb-3">Courses He Teaches</h5>
            <p class="view-profile__course">
                MATH 115
            </p>
            <p class="view-profile__course">
                MATH 226
            </p>
            <p class="view-profile__course">
                CSCI 104
            </p>
            <p class="view-profile__course">
                BUAD 304
            </p>
        </div>
    </div>


    @else


    @endif
</main>


@endsection

@section('js')

@include('home.partials.calendar-view-tutor')

<script src="{{ asset('js/view_profile/index.js') }}"></script>
@endsection
