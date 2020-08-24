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
<script src="{{ asset('js/plotly.js') }}"></script>
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
                <div class="col-lg-8  mt-5">
                    <h5 class="w-100 calendar-heading">Calendar</h5>
                    <div id="calendar" class="w-100"></div>
                    <div class="calendar-note">
                        <span>Available Time</span>
                    </div>
                </div>
                <div class="col-lg-4 info-cards  mt-5">
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

        <div class="container">
            <div class="row forum mt-0">
                <h5 class="w-100">Recommended Posts</h5>
                <div class="col-12 col-sm-8 post-previews px-0">
                    @include('forum.partials.post-preview-general')
                </div>
                <div class="col-12 col-sm-4 forum-data-container">
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

    </main>

</div>


@endsection

@section('js')

<script>
@if(Auth::user()->is_tutor)
    let calendar;
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            // timeZone: 'PST',
            themeSystem: 'bootstrap',
            initialView: 'timeGridDay',
            headerToolbar: {
                left: 'prev title next',
                center: '',
                right: 'today timeGridDay timeGridThreeDay'
            },
            eventColor: 'rgb(213, 208, 223)',
            height: 'auto',
            navLinks: true, // can click day/week names to navigate views
            selectable: true,
            selectMirror: true,
            nowIndicator: true,
            slotMinTime: "08:00:00",
            slotMaxTime: "24:00:00",
            allDaySlot: false,
            selectOverlap: false,
            validRange: function (nowDate) {
                return {
                    start: nowDate
                };
            },
            // editable: true,
            expandRows: true,
            views: {
                timeGridThreeDay: {
                    type: 'timeGrid',
                    duration: { days: 5 },
                    buttonText: '5 days'
                }
            },
            now: function () {
                return "{{ Carbon\Carbon::now()->toDateTimeString() }}";
            },
            selectAllow: function(selectionInfo) {
                let startTime = moment(selectionInfo.start);
                if(startTime.isBefore(moment()))
                    return false;
                return true;
            },
            select: function (selectionInfo) {
                let startTime = selectionInfo.start;
                let endTime = selectionInfo.end;
                showAvailableTimeForm(startTime, endTime);
            },
            eventClick: function (eventClickInfo) {
                eventClickInfo.jsEvent.preventDefault(); // don't let the browser navigate
                if (eventClickInfo.event.url) {
                    window.open(eventClickInfo.event.url);
                }
                console.log(eventClickInfo.event);
                if(eventClickInfo.event.extendedProps.type == 'available-time') {
                    showAvailableTimeDeleteForm(eventClickInfo.event.start, eventClickInfo.event.end, eventClickInfo.event.id);
                }

            },
            events: [
                @foreach(Auth::user()->availableTimes as $time)
                {
                    textColor: 'transparent',
                    start: '{{$time->available_time_start}}',
                    end: '{{$time->available_time_end}}',
                    description: "",
                    id: "{{ $time->id }}",
                    type: "available-time",
                    classNames: ['my-available-time', 'hover--pointer']
                },
                @endforeach

                @foreach(Auth::user()->upcomingSessions as $upcomingSession)
                {
                    @php
                        $startTime = date("H:i", strtotime($upcomingSession->session_time_start));
                        $endTime = date("H:i", strtotime($upcomingSession->session_time_end));
                    @endphp
                    @if($upcomingSession->is_in_person)
                    title: 'In Person',
                    extendedProps: {
                        "type": "upcoming-session--inperson"
                    },
                    classNames: ['inperson-session'],
                    @else
                    title: 'Online',
                    extendedProps: {
                        "type": "upcoming-session--online"
                    },
                    classNames: ['online-session'],
                    @endif
                    start: '{{date('Y-m-d', strtotime($upcomingSession->date))}}T{{$startTime}}',
                    end: '{{date('Y-m-d', strtotime($upcomingSession->date))}}T{{$endTime}}',
                    description: "",
                },
                @endforeach
            ],
        });
        calendar.render();
    });
    $('#availableTimeConfirmationModal form').submit(function(e) {
        e.preventDefault();
        let data = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: "{{ route('availableTime.store') }}",
            data: data,
            success: function success(data) {
                var successMsg = data.successMsg;
                toastr.success(successMsg);
                calendar.addEvent({
                    textColor: 'transparent',
                    start: data.available_time_start,
                    end: data.available_time_end,
                    description: "",
                    id: data.availableTimeId,
                    type: "available-time",
                    classNames: ['my-available-time', 'hover--pointer']
                });
                $('#availableTimeConfirmationModal').modal('hide');
            },
            error: function error(_error) {
                console.log(_error);
                toastr.error("There is an error when submitting your availability. Please try again.");
            }
        });
    });
    $('#availableTimeDeleteConfirmationModal form').submit(function(e) {
        e.preventDefault();
        let data = $(this).serialize();
        $.ajax({
            type: 'DELETE',
            url: "{{ route('availableTime.delete') }}",
            data: data,
            success: function success(data) {
                var successMsg = data.successMsg;
                toastr.success(successMsg);
                calendar.getEventById(data.availableTimeId).remove();
                $('#availableTimeDeleteConfirmationModal').modal('hide');
            },
            error: function error(_error) {
                console.log(_error);
                toastr.error("There is an error when canceling your availability. Please try again.");
            }
        });
    });
@endif


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
<script>

    var postViewCntData = {
        x: [
            @foreach(App\Post::getViewCntWeek(1) as $view)
            "{{ $view->viewed_at }}",
            @endforeach
        ],
        y: [
            @foreach(App\Post::getViewCntWeek(1) as $view)
            "{{ $view->view_count }}",
            @endforeach
        ],
        type: 'scatter',
        mode: 'lines+markers',
        name:'Post View Count',
        hovertemplate: '%{y}<extra></extra>',
    };

    var profileViewCntData = {
        x: [
            @foreach(App\User::getViewCntWeek(1) as $view)
            "{{ $view->viewed_at }}",
            @endforeach
        ],
        y: [
            @foreach(App\User::getViewCntWeek(1) as $view)
            "{{ $view->view_count }}",
            @endforeach
        ],
        type: 'scatter',
        mode: 'lines+markers',
        name:'Profile View Count',
        hovertemplate: '%{y}<extra></extra>',
    };

    var data = [postViewCntData, profileViewCntData];

    var layout = {
        showlegend: true,
        font: {size: 10},
        height: 350,
        legend: {
            xanchor: 'right',
        },
        margin: {
            l: 30,
            r: 25,
            b: 35,
            t: 50,
            pad: 0
        },
        yaxis: {fixedrange: true},
        xaxis : {fixedrange: true},
        plot_bgcolor: "#F9F9F9",
        paper_bgcolor:"#F9F9F9",
    };

    // create a deep copy of layout
    var scatterGraphLayout = Object.assign({}, layout);
    scatterGraphLayout.title = 'Post/Profile View Count Data';
    // scatterGraphLayout.yaxis = {title: 'View Count (times)'};

    var options = {
            scrollZoom: true,
            displaylogo: false,
            displayModeBar: false,
            responsive: true,
        };

    Plotly.newPlot(
        'scatter-chart',
        data,
        scatterGraphLayout,
        options
    );

    // for the gauge chart
    var data = [{
        domain: { row: 1, column: 1 },
        value: 85,
        // title: { text: "5-Star Rating" },
        type: "indicator",
        mode: "gauge+number+delta",
        number: {
            suffix: "%",
            font: {
                size: 50
            }
        },
        delta: {
            reference: 70,
            // font: {
            //     size: 15
            // },
            increasing: {
                // color: ""
            }
        },
        gauge: {
            axis: { range: [0, 100] },
            // bgcolor: "white",
            color: "red",
            bar: {
                color: "#FFBC00"
            }
        }
    }];

    var gaugeGraphLayout = Object.assign({}, layout);
    gaugeGraphLayout.title = '5-Star Rating';
    gaugeGraphLayout.margin = {
            l: 30,
            r: 30,
            b: 35,
            t: 50,
            pad: 0
    };


    Plotly.newPlot('gauge-chart', data, gaugeGraphLayout, options);
</script>
<script src="{{ asset('js/home/index.js') }}"></script>
@endsection
