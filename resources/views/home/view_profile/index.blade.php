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

<div class="container-fluid view p-relative">
    <main class="view__content">
        <div class="container home__header-container">
            @include('home.partials.header')
        </div>

        @if (Auth::user()->is_tutor)
        <div class="container">
            <div class="row">
                <h5 class="mb-2 w-100">You Have 3 New Tutor Requests!</h5>
                <div class="info-boxes info-boxes--sm-card">
                    @include('home.partials.tutor_request', [
                        'isNotification' => true,
                        'forTutor' => true,
                        'user' => App\User::find(1)
                    ])
                    @include('home.partials.tutor_request', [
                        'isNotification' => true,
                        'forTutor' => true,
                        'user' => App\User::find(1)
                    ])
                    @include('home.partials.tutor_request', [
                        'isNotification' => true,
                        'forTutor' => true,
                        'user' => App\User::find(1)
                    ])
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <h5 class="mb-2 w-100">New Notifications</h5>
                <div class="info-boxes">
                    @include('home.partials.notification', [
                        'isCancellationNotification' => true,
                        'notificationContent' => 'Nemo Enim'
                    ])
                    @include('home.partials.notification', [
                        'isBestReplyNotification' => true,
                        'notificationContent' => 'Testing Post 1'
                    ])
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row home__row-columns-2">
                <div class="pr-0" id="calendar-container">
                    <h5 class="w-100 calendar-heading">Calendar</h5>
                    <div id="calendar" class="w-100"></div>
                    <div class="calendar-note">
                        <span class="available-time">Available Time</span>
                        <span class="online">Online</span>
                        <span class="in-person">In Person</span>
                        <span class="note">Note: All time in the calender are based on PST.</span>
                    </div>
                </div>
                <div class="info-cards" id="upcoming-sessions-container">
                    <div class="d-flex align-items-center justify-content-between mb-1 flex-100">
                        <h5 class="mb-0 ws-no-wrap">Upcoming Sessions</h5>
                        <button class="btn btn-link fs-1-2 fc-grey btn-view-all-info-cards ws-no-wrap">View All</button>
                    </div>
                    @include('home.partials.upcoming_session_card')
                    @include('home.partials.upcoming_session_card')
                    @include('home.partials.upcoming_session_card')
                    @include('home.partials.upcoming_session_card', [
                        'hidden' => true
                    ])
                    @include('home.partials.upcoming_session_card', [
                        'hidden' => true
                    ])
                </div>
            </div>
        </div>

        {{-- <div class="container">
            <div class="row">
                <div class="d-flex justify-content-between align-items-center w-100 mb-2">
                    <h5>Upcoming Sessions</h5>
                    <button class="btn btn-link fs-1-4 fc-grey btn-view-all-upcoming-sessions">View All Upcoming Sessions</button>
                </div>
                <div class="info-boxes">
                    @include('home.partials.upcoming_session_box')
                    @include('home.partials.upcoming_session_box')
                    @include('home.partials.upcoming_session_box')
                    @include('home.partials.upcoming_session_box', [
                        'hidden' => true
                    ])
                    @include('home.partials.upcoming_session_box', [
                        'hidden' => true
                    ])
                </div>
            </div>
        </div> --}}

        <div class="container">
            <div class="row">
                <h5 class="mb-2 w-100">Data Visualization</h5>
                <div class="home__data-visualizations">
                    <div class="graph-1">
                        <div id="scatter-chart"></div>
                    </div>
                    <div class="graph-2">
                        <div id="gauge-chart"></div>
                    </div>
                </div>
            </div>
        </div>

        @else
        <div class="container">
            <div class="row">
                <h5 class="mb-2 w-100">Congrats! Your Tutor Request has been approved!</h5>
                <div class="info-boxes">
                    @include('home.partials.tutor_request', [
                        'user' => App\User::find(1),
                        'isNotification' => true,
                        'forTutor' => false,
                        'approved' => true
                    ])

                    @include('home.partials.tutor_request', [
                        'user' => App\User::find(1),
                        'isNotification' => true,
                        'forTutor' => false,
                        'approved' => true
                    ])
                    @include('home.partials.tutor_request', [
                        'user' => App\User::find(1),
                        'isNotification' => true,
                        'forTutor' => false,
                        'approved' => true
                    ])
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="d-flex justify-content-between align-items-center w-100 mb-2">
                    <h5>Upcoming Sessions</h5>
                    <button class="btn btn-link fs-1-4 fc-grey btn-view-all-upcoming-sessions">View All Upcoming Sessions</button>
                </div>
                <div class="info-boxes">
                    @include('home.partials.upcoming_session_box')
                    @include('home.partials.upcoming_session_box')
                    @include('home.partials.upcoming_session_box')
                    @include('home.partials.upcoming_session_box', [
                        'hidden' => true
                    ])
                    @include('home.partials.upcoming_session_box', [
                        'hidden' => true
                    ])
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <h5 class="mb-2 w-100">Bookmarked Tutors</h5>

                <div class="user-cards bookmarked-tutors">
                    @forelse (Auth::user()->bookmarkedUsers as $user)
                        @include('partials.user_card', [
                            'user' => $user
                        ])
                    @empty
                    <h6 class="no-results">No bookmarked tutors yet</h6>
                    @endforelse
                </div>
                <div class="scroll-faded"></div>
            </div>
        </div>

        <div class="container-fluid recommended-tutors-bg-container">
            <div class="container">
                <div class="row">
                    <div class="mb-2 w-100 d-flex justify-content-between align-center">
                        <h5>Tutors You May Want to Know</h5>
                        <button class="btn btn-link text-white fs-1-4" id="btn-refresh">Refresh</button>
                    </div>
                    <div class="user-cards recommended-tutors">
                        @include('partials.recommended_tutors')
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <h5 class="mb-2 w-100">Tutor Requests</h5>
                <div class="info-boxes tutor-requests">
                    @include('home.partials.tutor_request', [
                        'user' => App\User::find(1),
                        'forTutor' => false,
                        'approved' => false
                    ])

                    @include('home.partials.tutor_request', [
                        'user' => App\User::find(1),
                        'forTutor' => false,
                        'approved' => true
                    ])

                    @include('home.partials.tutor_request', [
                        'user' => App\User::find(1),
                        'forTutor' => false,
                        'pending' => true
                    ])

                    @include('home.partials.tutor_request', [
                        'user' => App\User::find(1),
                        'forTutor' => false,
                        'pending' => true
                    ])

                    @include('home.partials.tutor_request', [
                        'user' => App\User::find(1),
                        'forTutor' => false,
                        'approved' => false
                    ])

                    @include('home.partials.tutor_request', [
                        'user' => App\User::find(1),
                        'forTutor' => false,
                        'approved' => true
                    ])

                    @include('home.partials.tutor_request', [
                        'user' => App\User::find(1),
                        'forTutor' => false,
                        'pending' => true
                    ])

                    @include('home.partials.tutor_request', [
                        'user' => App\User::find(1),
                        'forTutor' => false,
                        'pending' => true
                    ])
                </div>
                <div class="scroll-faded">
                </div>
            </div>

        </div>


        @endif

    </main>
</div>


@endsection

@section('js')




{{-- for data visualization --}}
@include('home.partials.data-visualization')

<script src="{{ asset('js/home/index.js') }}"></script>
@endsection
