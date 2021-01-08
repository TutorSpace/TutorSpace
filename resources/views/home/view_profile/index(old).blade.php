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
    <div class="row view-profile__header-container">
        @include('home.view_profile.partials.header', [
            'user' => $user
        ])
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
                    @php
                    $reviewCount = $user->aboutReviews->count();
                    @endphp
                    <h5>Reviews ({{ $reviewCount }})</h5>
                    <button class="btn btn-link fs-1-4 fc-grey btn-view-all-info-boxes">View All</button>
                </div>
                <div class="info-boxes">
                    @php
                    $reviews = $user->aboutReviews;
                    $today = \Carbon\Carbon::today();
                    @endphp
                    @foreach($reviews as $review)
                        @include('home.partials.review', [
                        'content' => $review->review,
                        'dateCreated' => $review->created_at ?? $today
                    ])
                    @endforeach
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
            @php
                $courses = $user->courses;
            @endphp
            @foreach ($courses as $course)
            <p class="view-profile__course">
                {{ $course->course }}
            </p>
            @endforeach
        </div>
    </div>


    @else
    <h1>View Student Page is still under development.</h1>

    @endif
</main>


@endsection

@section('js')
<script>
    let otherUserId = "{{ $user->id }}";
    let otherUserHourlyRate = "{{ $user->hourly_rate }}";
    let courses = [
        @foreach($courses as $course)
        {
            id: "{{ $course->id }}",
            course: "{{ $course->course }}"
        },
        @endforeach
    ]
</script>

@if ($user->is_tutor)
    @include('home.view_profile.partials.calendar-view-profile')
@endif


@include('session.session-js')

<script src="{{ asset('js/view_profile/index.js') }}"></script>

@endsection