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

        @if (Auth::user()->pendingTutorRequests()->count() > 0)
        <div class="container col-layout-3">
            <div class="row">
                <h5 class="mb-2 w-100">You Have {{ Auth::user()->pendingTutorRequests()->count() }} New Tutor Request(s)!</h5>

                <div class="info-boxes info-boxes--sm-card">
                    @foreach (Auth::user()->pendingTutorRequests()->orderBy('session_time_start', 'asc')->orderBy('session_time_start', 'asc')->get() as $tutorRequest)
                        @include('home.partials.tutor_request', [
                            'isNotification' => true,
                            'isFirstOne' => $loop->first,
                            'tutorRequest' => $tutorRequest
                        ])
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- not needed to account for small screen for now --}}
        {{-- <div class="container col-layout-3 col-layout-3--hidden">
            <div class="row">
                <h5 class="mb-2 w-100">Forum Notifications</h5>
                <div class="info-boxes">
                    @foreach (Auth::user()->notifications()
                        ->where('type', 'App\Notifications\Forum\NewFollowupAddedNotification')
                        ->orWhere('type', 'App\Notifications\Forum\NewReplyAddedNotification')
                        ->orWhere('type', 'App\Notifications\Forum\MarkedAsBestReplyNotification')
                        ->orderBy('created_at', 'desc')
                        ->get() as $notif)
                        @include('home.partials.notification', [
                            'notif' => $notif
                        ])
                    @endforeach
                </div>
            </div>
        </div> --}}

        <div class="container col-layout-3">
            <div class="row home__row-columns-2">
                <div class="" id="calendar-container">
                    <h5 class="w-100 calendar-heading">Calendar</h5>
                    <div id="calendar" class="w-100"></div>
                    <div class="calendar-note">
                        <span class="available-time">Available Time</span>
                        <span class="online">Online</span>
                        <span class="in-person">In Person</span>
                        <span class="note">Note: All time shown are based on {{ App\CustomClass\TimeFormatter::getTZShortHand(App\CustomClass\TimeFormatter::getTZ()) }} Time Zone.</span>
                    </div>
                </div>
                <div class="info-cards col-layout-3--hidden" id="upcoming-sessions-container">
                    @php
                        $upcomingSessions = Auth::user()->upcomingSessions()->with(['student', 'course'])->get();
                    @endphp
                    @if ($upcomingSessions->count() > 0)
                        <div class="d-flex align-items-center justify-content-between mb-1 flex-100">
                            <h5 class="mb-0 ws-no-wrap">Upcoming Sessions</h5>

                            @if ($upcomingSessions->count() > 2 + 1)
                            <button class="btn btn-link fs-1-2 fc-grey btn-view-all-info-cards ws-no-wrap">View All</button>
                            @endif
                        </div>
                        @for ($i = 0; $i < $upcomingSessions->count(); $i++)
                            @include('home.partials.upcoming_session_card', [
                                'session' => $upcomingSessions->get($i),
                                'user' => $upcomingSessions->get($i)->student,
                                'hidden' => $i > 2
                            ])
                        @endfor
                    @endif
                </div>
            </div>
        </div>

        @else

        @if (App\Transaction::unpaidPayments()->exists())
        <div class="container col-layout-3">
            <div class="row">
                <h5 class="mb-2 w-100">You Have {{ App\Transaction::unpaidPayments()->count() }} Unpaid Payment(s).</h5>
                <div class="info-boxes info-boxes--sm-card">
                    @foreach (App\Transaction::unpaidPayments()->get() as $transaction)
                        @include('home.partials.unpaid_payment', [
                            'transaction' => $transaction
                        ])
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        @if (Auth::user()->unratedSessions()->count() > 0)
        <div class="container col-layout-3">
            <div class="row">
                <h5 class="mb-2 w-100">You Have {{ Auth::user()->unratedSessions()->count() }} Unrated Tutoring Session(s).</h5>
                <div class="info-boxes info-boxes--sm-card">
                    @foreach (Auth::user()->unratedSessions() as $session)
                        @include('home.partials.unrated-session', [
                            'session' => $session
                        ])
                    @endforeach
                </div>
            </div>
        </div>
        @endif


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
                    <div class="graph-1 graph-1{{Auth::user()->is_tutor == 1 ? "--tutor":""}}">
                        <div id="scatter-chart"></div>
                    </div>
                    @if(Auth::user()->is_tutor)
                    <div class="graph-2">
                        <canvas id="rating-chart" class="rating-chart"></canvas>
                    </div>
                    @endif
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
                        {{-- PARTICIPATED POSTS 是我follow的post, 我自己的post，加上我directly reply过的post，注意不能重复count！) --}}
                        <span class="title">Participated</span>
                        <a class="number" href="{{ route('posts.my-participated') }}">{{ Auth::user()->participatedPosts()->get()->count() }}</a>
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
            @if (Auth::user()->is_tutor)
            <h4>Want to earn bonus more quickly?</h4>
            <a class="btn" href="{{ route('home.profile') }}">Become a Verified Tutor</a>
            @else
            <h4>Want to become a tutor?</h4>
            <button class="btn" id="btn-register-to-be-tutor">Register to be a Tutor</button>
            @endif
        </div>

        <div class="home__side-bar__upcoming-sessions">
            <div class="info-cards">
                @if (Auth::user()->is_tutor)
                    @php
                        $upcomingSessions = Auth::user()->upcomingSessions()->with(['student', 'course'])->orderBy('session_time_start', 'asc')->orderBy('session_time_end', 'asc')->get();
                    @endphp
                    @if ($upcomingSessions->count() > 0)
                        <div class="d-flex align-items-center justify-content-between mb-1 flex-100">
                            <h5 class="mb-0 ws-no-wrap">Upcoming Sessions</h5>
                            @if ($upcomingSessions->count() > 2)
                            <button class="btn btn-link fs-1-2 fc-grey btn-view-all-info-cards ws-no-wrap">View All</button>
                            @endif
                        </div>
                        @for ($i = 0; $i < $upcomingSessions->count(); $i++)
                            @include('home.partials.upcoming_session_card', [
                                'session' => $upcomingSessions->get($i),
                                'user' => $upcomingSessions->get($i)->student,
                                'hidden' => $i > 1
                            ])
                        @endfor
                    @endif
                @else
                    @php
                        $upcomingSessions = Auth::user()->upcomingSessions()->with(['tutor', 'course'])->get();
                    @endphp
                    @if ($upcomingSessions->count() > 0)
                        <div class="d-flex align-items-center justify-content-between mb-1 flex-100">
                            <h5 class="mb-0 ws-no-wrap">Upcoming Sessions</h5>
                            @if ($upcomingSessions->count() > 2 + 1)
                            <button class="btn btn-link fs-1-2 fc-grey btn-view-all-info-cards ws-no-wrap">View All</button>
                            @endif
                        </div>
                        @for ($i = 0; $i < $upcomingSessions->count(); $i++)
                            @include('home.partials.upcoming_session_card', [
                                'session' => $upcomingSessions->get($i),
                                'user' => $upcomingSessions->get($i)->tutor,
                                'hidden' => $i > 2
                            ])
                        @endfor
                    @endif
                @endif

            </div>
        </div>
        <div class="home__side-bar__notifications">
            @if ($forumNotifs->count() == 0)
            <div class="d-flex align-items-center justify-content-between mb-1 flex-100 no-data p-relative">
                <span class="mb-0 ws-no-wrap">Forum Notifications</span>
                <span class="no-data__content">No Recent Forum Notifications</span>
            </div>
            @else
            <div class="d-flex align-items-center justify-content-between mb-1 flex-100">
                <span class="mb-0 ws-no-wrap">Forum Notifications</span>
                @if ($forumNotifs->count() > 2 + 1)
                <button class="btn btn-link fs-1-2 fc-grey ws-no-wrap btn-view-all-notifications">View All</button>
                @endif

            </div>
            <div class="notifications--sidebar">
                @foreach ($forumNotifs as $key => $notif)
                    @include('home.partials.notification--sidebar', [
                        'notif' => $notif,
                        'hidden' => $key > 2
                    ])
                @endforeach
            </div>
            @endif
        </div>

        @if (!Auth::user()->is_tutor)
            <div class="home__side-bar__bookmarked-users">
                @include('home.partials.bookmarked-tutors--sidebar')
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
const redirectMissingPaymentUrl = '{{route("home.profile")}}'+ "?payment-section-redirect=true";
let storageUrl = "{{ Storage::url('') }}";
@if(!Auth::user()->is_tutor)
    function getRecommendedTutors() {
        JsLoadingOverlay.show(jsLoadingOverlayOptions);
        $.ajax({
            type:'GET',
            url: '{{ route('recommended-tutors') }}?refresh=true',
            success: (data) => {
                $('.recommended-tutors').html(data);
                console.log(data);
            },
            error: function(error) {
                console.log(error);
            },
            complete: () => {
                JsLoadingOverlay.hide();
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
