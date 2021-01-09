@extends('layouts.app')

@section('title', 'Dashboard')

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

{{-- plotly --}}
<script src="{{ asset('vendor/plotly/plotly.js') }}"></script>
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
        <div class="container col-layout-3 home__header-container">
            @include('home.partials.header')
        </div>

        @if (Auth::user()->is_tutor)
        <div class="container col-layout-3">
            <div class="row">
                <h5 class="mb-2 w-100">You Have {{ Auth::user()->tutorRequests()->count() }} New Tutor Requests!</h5>

                <div class="info-boxes info-boxes--sm-card">
                    @foreach (Auth::user()->tutorRequests as $tutorRequest)
                        @include('home.partials.tutor_request', [
                            'isNotification' => true,
                            'isFirstOne' => $loop->first,
                            'tutorRequest' => $tutorRequest
                        ])
                    @endforeach
                </div>
            </div>
        </div>

        <div class="container col-layout-3 col-layout-3--hidden">
            <div class="row">
                <h5 class="mb-2 w-100">Forum Notifications</h5>
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

        <div class="container col-layout-3">
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
                <div class="info-cards col-layout-3--hidden" id="upcoming-sessions-container">
                    <div class="d-flex align-items-center justify-content-between mb-1 flex-100">
                        <h5 class="mb-0 ws-no-wrap">Upcoming Sessions</h5>
                        <button class="btn btn-link fs-1-2 fc-grey btn-view-all-info-cards ws-no-wrap">View All</button>
                    </div>

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
                </div>
            </div>
        </div>

        @else
        <div class="container col-layout-3">
            <div class="row">
                <h5 class="mb-2 w-100">You Have 2 Unpaid Payments.</h5>
                <div class="info-boxes info-boxes--sm-card">
                    @include('home.partials.unpaid_payment', [
                        'isNotification' => true,
                        'forTutor' => true,
                        'user' => App\User::find(1),
                        'isFirstOne' => true
                    ])
                    @include('home.partials.unpaid_payment', [
                        'isNotification' => true,
                        'forTutor' => true,
                        'user' => App\User::find(1)
                    ])
                    @include('home.partials.unpaid_payment', [
                        'isNotification' => true,
                        'forTutor' => true,
                        'user' => App\User::find(1)
                    ])

                </div>
            </div>
        </div>


        <div class="container col-layout-3">
            <div class="row">
                <div class="mb-2 w-100 d-flex justify-content-between align-center">
                    <h5>Tutors You May Want to Know</h5>
                    <button class="btn btn-link fs-1-4" id="btn-refresh">Refresh</button>
                </div>
                <div class="user-cards recommended-tutors">
                    @include('partials.recommended_tutors')
                </div>
            </div>
        </div>
        @endif


        <div class="container col-layout-3">
            <div class="row">
                <h5 class="mb-2 w-100">Data Visualization</h5>
                <div class="home__data-visualizations">
                    <div class="graph-1">
                        <div id="scatter-chart"></div>
                    </div>
                    <div class="graph-2">
                        <canvas id="rating-chart" class="rating-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="container col-layout-3">
            <div class="row forum mt-0">
                <h5 class="w-100">Recommended Posts</h5>
                <div class="col-12 col-md-9 post-previews px-0">
                    @include('forum.partials.post-preview-general')
                </div>
                <div class="col-12 col-md-3 forum-data-container">
                    <div class="forum-data">
                        <span class="title">My Posts</span>
                        <a class="number" href="{{ route('posts.my-posts') }}">{{ Auth::user()->posts()->count() }}</a>
                    </div>
                    <div class="forum-data">
                        {{-- TODO: NATE (PARTICIPATED POSTS ARE 我follow的post, 我自己的post，加上我directly reply过的post，注意不能重复count！) --}}
                        {{-- 做完以后别把我留下的todo comment删掉，我们之后要一起过一遍代码确保ok --}}
                        <span class="title">Participated</span>
                        <a class="number" href="{{ route('posts.my-participated') }}">{{ Auth::user()->getParticipatedPosts()->count() }}</a>
                    </div>
                    <div class="forum-data">
                        <span class="title">Followed</span>
                        <a class="number" href="{{ route('posts.my-follows') }}">{{ Auth::user()->followedPosts()->count() }}</a>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <section class="home__side-bar">
        <div class="home__board">
        </div>

        <div class="home__side-bar__upcoming-sessions">
            <div class="info-cards">
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
        <div class="home__side-bar__notifications">
            <div class="d-flex align-items-center justify-content-between mb-1 flex-100">
                <span class="mb-0 ws-no-wrap">Forum Notifications</span>
                <button class="btn btn-link fs-1-2 fc-grey ws-no-wrap btn-view-all-notifications">View All</button>
            </div>
            <div class="notifications--sidebar">
                @include('home.partials.notification--sidebar', [
                    'isCancellationNotification' => true,
                    'notificationContent' => 'Computer Science'
                ])
                @include('home.partials.notification--sidebar', [
                    'isBestReplyNotification' => true,
                    'notificationContent' => 'Testing Post 1'
                ])
                @include('home.partials.notification--sidebar', [
                    'isCancellationNotification' => true,
                    'notificationContent' => 'Computer Science'
                ])
                @include('home.partials.notification--sidebar', [
                    'isBestReplyNotification' => true,
                    'notificationContent' => 'Testing Post 1'
                ])
                @include('home.partials.notification--sidebar', [
                    'isCancellationNotification' => true,
                    'notificationContent' => 'Computer Science',
                    'hidden' => true
                ])
                @include('home.partials.notification--sidebar', [
                    'isBestReplyNotification' => true,
                    'notificationContent' => 'Testing Post 1',
                    'hidden' => true
                ])
            </div>
        </div>

        @if (!Auth::user()->is_tutor)
        <div class="home__side-bar__bookmarked-users">
            <div class="d-flex align-items-center justify-content-between mb-1 flex-100">
                <span class="mb-0 ws-no-wrap">Bookmarked Tutors</span>
                <button class="btn btn-link fs-1-2 fc-grey ws-no-wrap btn-view-all-bookmarked-users">View All</button>
            </div>

            <div class="bookmarked-users">
                @forelse (Auth::user()->bookmarkedUsers as $key => $user)
                    @include('home.partials.bookmarked-tutor', [
                        'user' => $user,
                        'hidden' => $key > 2
                    ])
                @empty
                <h6 class="no-results">No bookmarked tutors yet</h6>
                @endforelse
            </div>
        </div>
        @endif

    </section>
</div>


@endsection

@section('js')

@if(Auth::user()->is_tutor)
    @include('home.partials.calendar-tutor')
@endif

<script>
let storageUrl = "{{ Storage::url('') }}";
@if(!Auth::user()->is_tutor)
    function getRecommendedTutors() {
        $.ajax({
            type:'GET',
            url: '{{ route('recommended-tutors') }}?refresh=true',
            success: (data) => {
                $('.recommended-tutors').html(data);
                console.log(data);
            },
            error: function(error) {
                console.log(error);
            }
        });
    }
    // refresh recommended tutors
    $('#btn-refresh').click(function() {
        getRecommendedTutors();
    });
@endif
</script>

{{-- for data visualization --}}
@include('home.partials.data-visualization')

<script src="{{ asset('js/home/index.js') }}"></script>

@include('session.session-js')

@endsection
