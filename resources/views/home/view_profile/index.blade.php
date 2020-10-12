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
    @if ($user->is_tutor)
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

            <div class="forum row mx-0">
                <h5 class="w-100">Top Rated Posts</h5>
                <div class="col-12 col-md-9 post-previews px-0">
                    @include('forum.partials.post-preview-general')
                </div>
                <div class="col-12 col-md-3 forum-data-container">
                    <div class="forum-data">
                        {{-- <svg class="notification-indicator" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="7.5" cy="7.5" r="7.5" fill="#FFBC00"/>
                        </svg> --}}
                        <span class="title">My Posts</span>
                        <a class="number" href="{{ route('posts.my-posts') }}">{{ Auth::user()->posts()->count() }}</a>
                    </div>
                    <div class="forum-data">
                        <span class="title">Participated</span>
                        <a class="number" href="{{ route('posts.my-participated') }}">{{ Auth::user()->postsReplied()->count() }}</a>
                    </div>
                    <div class="forum-data">
                        <span class="title">Followed</span>
                        <a class="number" href="{{ route('posts.my-follows') }}">{{ Auth::user()->followedPosts()->count() }}</a>
                    </div>
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
    <h1>View Student Page is still under development.</h1>

    @endif
</main>


@endsection

@section('js')

@include('home.partials.calendar-view-tutor')

<script src="{{ asset('js/view_profile/index.js') }}"></script>

<script>

    $('#tutor-profile-request-session').on('click',function() {
        if($('.modal-verify-tutor')[0]) return;


        @php
            $callbackFuncName_details = "session_details";
            $callbackFuncName_confirm = "session_confirm";
        @endphp
        


        bootbox.dialog({
            message: `@include('book-session.book-session')`,
            size: 'medium',
            onEscape: true,
            backdrop: true,
            centerVertical: true,
            buttons: {
                Next: {
                    label: 'Next',
                    className: 'btn btn-primary p-3 px-5',
                    callback: {{ $callbackFuncName_details }}
                },
            }
        });

        function session_details() {
            bootbox.dialog({
                message: `@include('book-session.session-details')`,
                size: 'medium',
                onEscape: true,
                backdrop: true,
                centerVertical: true,
                buttons: {
                    Next: {
                    label: 'Next',
                    className: 'btn btn-primary p-3 px-5',
                    callback: {{ $callbackFuncName_confirm }}
                },
                }
            });
        }

        function session_confirm() {
            bootbox.dialog({
                message: `@include('book-session.session-confirm')`,
                size: 'medium',
                onEscape: true,
                backdrop: true,
                centerVertical: true,
                buttons: {
                    Submit: {
                    label: 'Submit',
                    className: 'btn btn-primary p-3 px-5',
                    callback: function(){},
                },
                }
            });
        }
    });

</script>

@endsection
