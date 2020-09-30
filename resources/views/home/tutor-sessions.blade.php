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
    <main class="home__content">
        <div class="container col-layout-2 home__header-container">
            <div class="heading-container mb-5">
                <p class="heading">Tutor Sessions</p>
                <span>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed enim blanditiis ipsam nesciunt quia culpa eaque eligendi
                </span>
            </div>
            @include('home.partials.header')
        </div>

        <div class="container col-layout-2">
            <div class="row home__row-columns-2">
                <div class="col-lg-8">
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

        <div class="container col-layout-2">
            <div class="row mt-5">
                <h5 class="mb-2 w-100 mt-5">Past Sessions</h5>
                <div class="info-boxes info-boxes info-boxes--sm-card">
                    <div>
                        <div class="info-box info-box--explanation tutor-request">
                            <div class="user-info">
                                TUTORED WITH
                            </div>
                            <div class="date">
                                DATE
                            </div>
                            <div class="course">
                                COURSE
                            </div>
                            <div class="type">
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
                    @include('home.partials.past_session', [
                        'user' => App\User::find(1)
                    ])

                    @include('home.partials.past_session', [
                        'user' => App\User::find(2)
                    ])

                    {{-- @include('home.partials.past_session', [
                        'user' => App\User::find(3)
                    ])

                    @include('home.partials.past_session', [
                        'user' => App\User::find(4)
                    ])

                    @include('home.partials.past_session', [
                        'user' => App\User::find(3)
                    ])

                    @include('home.partials.past_session', [
                        'user' => App\User::find(4)
                    ]) --}}

                </div>
                <div class="scroll-faded">
                </div>
            </div>
        </div>

        <div class="container col-layout-2">
            <div class="row">
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
@endsection
