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

    <a class="btn btn-back" href="{{ App\CustomClass\URLManager::getBackURL(route('search.index')) }}">
        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
        </svg>
        <span>Back</span>
    </a>

    <div class="view-profile--left col-3">
        @include('home.view_profile.partials.user-info', [
            'user' => $user
        ])
    </div>
    {{-- <div class="row">
        <h5 class="w-100 mb-3 calendar-heading">Calendar</h5>
        <div id="calendar" class="w-100"></div>
        <div class="calendar-note">
            <span class="available-time">Available Time</span>
            <span class="online">Online</span>
            <span class="in-person">In Person</span>
            <span class="note">Note: All time in the calender are based on PST.</span>
        </div>
    </div> --}}

</main>


@endsection

@section('js')
<script>
    let otherUserId = "{{ $user->id }}";
    let otherUserHourlyRate = "{{ $user->hourly_rate }}";
</script>

@if ($user->is_tutor)
    @include('home.view_profile.partials.calendar-view-profile')
@endif


@include('session.session-js')

<script src="{{ asset('js/view_profile/index.js') }}"></script>

@endsection
