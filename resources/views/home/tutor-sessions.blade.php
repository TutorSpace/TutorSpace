@extends('layouts.app')

@section('title', 'Dashboard - Tutor Sessions')

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

@if(Auth::user()->is_tutor)
    @include('home.partials.availableTimeConfirmationModal')
    @include('home.partials.availableTimeDeleteConfirmationModal')
@endif

<div class="container-fluid home p-relative">
    @include('home.partials.menu_bar')
    <main class="home__content tutor-sessions">
        <div class="container col-layout-2 home__header-container">
            <div class="heading-container mb-5">
                <p class="heading">Tutor Sessions</p>
                <span>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed enim blanditiis ipsam nesciunt quia culpa eaque eligendi
                </span>
            </div>
            @include('home.partials.header')
        </div>

        @if (Auth::user()->is_tutor)
        <div class="container col-layout-2">
            <div class="row home__row-columns-2">
                <div class="col-lg-8" id="calendar-container">
                    <h5 class="w-100 calendar-heading">Calendar</h5>
                    <div id="calendar" class="w-100"></div>
                    <div class="calendar-note">
                        <span class="available-time">Available Time</span>
                        <span class="online">Online</span>
                        <span class="in-person">In Person</span>
                        <span class="note">Note: All time in the calender are based on PST.</span>
                    </div>
                </div>
                <div class="col-lg-4 info-cards">
                    <div class="d-flex align-items-center justify-content-between mb-1 flex-100">
                        <h5 class="mb-0 ws-no-wrap">Upcoming Sessions</h5>
                        <button class="btn btn-link fs-1-2 fc-grey btn-view-all-info-cards ws-no-wrap">View All</button>
                    </div>
                    @if (Auth::user()->is_tutor)
                        @php
                            $upcomingSessions = Auth::user()->upcomingSessions()->with(['student', 'course'])->get();
                        @endphp
                        @if ($upcomingSessions->count() > 0)
                            @for ($i = 0; $i < $upcomingSessions->count(); $i++)
                                @include('home.partials.upcoming_session_card', [
                                    'session' => $upcomingSessions->get($i),
                                    'user' => $upcomingSessions->get($i)->student,
                                    'hidden' => $i > 1
                                ])
                            @endfor
                        @else
                            <p class="fs-1-6 mt-2">No Upcoming Sessions Yet...</p>
                        @endif
                    @else
                        @php
                            $upcomingSessions = Auth::user()->upcomingSessions()->with(['tutor', 'course'])->get();
                        @endphp
                        @if ($upcomingSessions->count() > 0)
                            @for ($i = 0; $i < $upcomingSessions->count(); $i++)
                                @include('home.partials.upcoming_session_card', [
                                    'session' => $upcomingSessions->get($i),
                                    'user' => $upcomingSessions->get($i)->tutor,
                                    'hidden' => $i > 1
                                ])
                            @endfor
                        @else
                            <p class="fs-1-6 mt-2">No Upcoming Sessions Yet...</p>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        @else
        <div class="container col-layout-2">
            <div class="row mt-5">
                <div class="d-flex justify-content-between align-items-center w-100 mb-2 mt-5">
                    <h5>Upcoming Sessions</h5>
                    {{-- <button class="btn btn-link fs-1-4 fc-grey btn-view-all-info-boxes">View All</button> --}}
                </div>
                <div class="info-boxes info-boxes--sm-card">
                    @foreach (
                    Auth::user()
                        ->upcomingSessions()
                        ->with([
                            Auth::user()->is_tutor ? 'student' : 'tutor',
                            'course'
                        ])
                        ->get()
                            as
                        $session
                    )
                    @include('home.partials.upcoming_session_box', [
                        'session' => $session
                    ])
                    @endforeach
                </div>
            </div>
        </div>
        @endif


        <div class="container col-layout-2">
            <div class="row mt-5">
                <div class="d-flex justify-content-between align-items-center w-100 mb-2 mt-5">
                    <h5>Past Sessions</h5>
                    {{-- <button class="btn btn-link fs-1-4 fc-grey btn-view-all-info-boxes">View All</button> --}}
                </div>
                <div class="info-boxes info-boxes">
                    <div class="info-box info-box--explanation ">
                        <div class="user-info">
                            TUTORED WITH
                        </div>
                        <div class="date">
                            DATE
                        </div>
                        <div class="course">
                            COURSE
                        </div>
                        <div class="session-type">
                            TYPE
                        </div>
                        <div class="status">
                            STATUS
                        </div>
                        <div class="price">
                            TOTAL
                        </div>
                        <div class="action--toggle">
                            ACTION
                        </div>
                    </div>
                </div>
                <div class="info-boxes info-boxes--sm-card past-sessions">
                    @if(Auth::user()->is_tutor)
                        @foreach (
                            Auth::user()
                                ->pastSessions()
                                ->with([
                                    'student',
                                    'course'
                                ])
                                ->get()
                                as
                            $session
                            )
                            @include('home.partials.past_session', [
                                'user' => $session->student,
                                'status' => 'pending', // todo: status can be either 'pending' or 'completed'
                                'currUser' => Auth::user(),
                                'course' => $session->course
                            ])
                        @endforeach
                    @else
                        @foreach (
                            Auth::user()
                                ->pastSessions()
                                ->with([
                                    'tutor',
                                    'course'
                                ])
                                ->get()
                                as
                            $session
                            )
                            @include('home.partials.past_session', [
                                'user' => $session->tutor,
                                'status' => 'paid', // todo: status can be 'paid', 'unpaid', or 'completed'
                                'currUser' => Auth::user(),
                                'course' => $session->course
                            ])
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        @if (Auth::user()->is_tutor)
        <div class="container col-layout-2">
            <div class="row">
                <div class="d-flex justify-content-between align-items-center w-100 mb-2">
                    @php
                    $reviewCount = Auth::user()->aboutReviews()->count();
                    @endphp
                    <h5>Reviews ({{ $reviewCount }})</h5>
                    <button class="btn btn-link fs-1-4 fc-grey btn-view-all-info-boxes">View All</button>
                </div>
                <div class="info-boxes">
                    @php
                    $reviews = Auth::user()->aboutReviews;
                    $today = \Carbon\Carbon::today();
                    @endphp
                    @for ($i = 0; $i < $reviewCount; $i++)
                        @include('home.partials.review', [
                            'review' => $reviews->get($i),
                            'dateCreated' => $reviews->get($i)->created_at ?? $today,
                            'hidden' => $i >= 2
                        ])
                    @endfor
                </div>
            </div>
        </div>
        @endif

    </main>

</div>


@endsection

@section('js')


@if(Auth::user()->is_tutor)
    @include('home.partials.calendar-tutor')
@endif

<script>
let storageUrl = "{{ Storage::url('') }}";
</script>


<script src="{{ asset('js/home/index.js') }}"></script>
<script src="{{ asset('js/home/tutor-sessions.js') }}"></script>

@include('session.session-js')

@endsection
