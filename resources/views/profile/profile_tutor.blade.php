@extends('layouts.loggedin')
@section('title', 'profile - tutor')

@section('content')

    <div class="container" id="profile-container" data-is-tutor="{{$user->is_tutor}}">
        <nav class="nav profile-nav">
            <a class="nav-link active" href="#" id="nav-about">About You</a>
            <a class="nav-link" href="#" id="nav-sessions">Sessions</a>
            <a class="nav-link" href="#" id="nav-reviews">Reviews</a>
        </nav>

        <div class="about__container">
            <div class="about__information">
                <div class="about__information__img">
                    <div class="img-container">
                        <img src="{{$userPhotoUrl}}" alt="profile_img">
                    </div>
                </div>

                <div class="about__information__content">
                    <div class="name"><h4 id="currentUserName">{{$user->full_name}}</h4></div>
                    <div class="major-minor-container">
                        <span class="descriptor">Major</span>
                        <span class="descriptor">Minor</span>
                        <span class="text">{{$user->major['major']}}</span>
                        <span class="text">{{$user->minor ?? 'None'}}</span>
                    </div>
                    <div class="year-container">
                        <span class="descriptor">Year</span>
                        <span class="text">{{$user->school_year['school_year']}}</span>
                    </div>
                    <div class="btn-container">
                        <a class="btn btn-lg btn-primary" href="/edit_profile">Edit Profile</a>
                        <a class="btn btn-lg btn-outline-primary" href="/edit_availability">Edit Availability</a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-5 col-12">
                    <form class="about__subjects" method="POST" action="/add_fav_subject">
                        @csrf
                        <div class="about__subjects__header">Subjects</div>
                        <div class="about__content">
                            <svg>
                                <use xlink:href="{{asset('assets/sprite.svg#icon-magnifying-glass')}}"></use>
                            </svg>
                            <input type="text" placeholder="Add Subjects" class="about__input" name="subject" id="subject" value="{{old('subject')}}" required>
                            <button class="btn btn-primary btn-lg add-btn" type="submit">Add +</button>
                        </div>
                    </form>

                    <div class="about__buttons__container" id="about__buttons__container--subjects">

                        @foreach ($subjects as $subject)
                        <button class="btn btn-lg" data-subject-id="{{$subject->id}}">
                            <svg>
                                <use xlink:href="{{asset('assets/sprite.svg#icon-cross')}}"></use>
                            </svg>
                            <span class="name">{{$subject->subject}}</span>
                        </button>
                        @endforeach

                    </div>

                    <form class="about__courses" method="POST" action="/add_fav_course">
                        @csrf
                        <div class="about__courses__header">
                            Courses
                        </div>
                        <div class="about__content">
                            <svg>
                                <use xlink:href="assets/sprite.svg#icon-magnifying-glass"></use>
                            </svg>
                            <input type="text" placeholder="Add Courses" class="about__input" name="course" id="course">
                            <button class="btn btn-primary btn-lg add-btn" type="submit">Add +</button>
                        </div>
                    </form>

                    <div class="about__buttons__container" id="about__buttons__container--courses">

                        @foreach ($courses as $course)
                        <button class="btn btn-lg" data-course-id="{{$course->id}}">
                            <svg>
                                <use xlink:href="{{asset('assets/sprite.svg#icon-cross')}}"></use>
                            </svg>
                            <span class="name">{{$course->course}}</span>
                        </button>
                        @endforeach

                    </div>

                    <form class="about__characteristics" method="POST" action="/add_characteristic">
                        @csrf
                        <div class="about__characteristics__header">
                            Characteristics
                        </div>
                        <div class="about__content">
                            <svg>
                                <use xlink:href="{{asset('assets/sprite.svg#icon-magnifying-glass')}}"></use>
                            </svg>
                            <input type="text" placeholder="Add Characteristics" class="about__input" name="characteristic" id="characteristic">
                            <button class="btn btn-primary btn-lg add-btn" type="submit">Add +</button>
                        </div>
                    </form>

                    <div class="about__buttons__container" id="about__buttons__container--characteristics">

                        @foreach ($characteristics as $characteristic)
                        <button class="btn btn-lg" data-characteristic-id="{{$characteristic->id}}">
                            <svg>
                                <use xlink:href="{{asset('assets/sprite.svg#icon-cross')}}"></use>
                            </svg>
                            <span class="name">{{$characteristic->characteristic}}</span>
                        </button>
                        @endforeach
                    </div>

                </div>
                <div class="col-sm-7 col-12 reviews">

                </div>

            </div>
        </div>

        <div class="sessions__container">
            <div class="sessions__container-1">
                <div class="sessions__header">
                    <h4>Upcoming Tutoring Sessions</h4>
                </div>
                {{-- <div class="sessions__header--sub">
                    Some description here
                </div> --}}
                <div class="sessions__info p-relative">

                    <div class="sessions__info upcoming-sessions-container">
                        <div class="shadow-container">

                        </div>
                        @if(count($upcomingSessions) === 0)
                        <h5>There are no upcoming sessions yet</h5>
                        @else
                            @foreach ($upcomingSessions as $upcomingSession)
                                <div class="session__container" data-session-id="{{$upcomingSession->session_id}}">
                                    <span class="title name">{{$upcomingSession->full_name}}</span>
                                    <span class="descriptor">Date</span>
                                    <span class="descriptor">Subject / Course</span>
                                    <span class="text">
                                        {{date('m/d/Y', strtotime($upcomingSession->date))}}
                                    </span>
                                    @if($upcomingSession->is_course)
                                        <span class="text">{{App\Course::find($upcomingSession->course_id)->course}}</span>
                                    @else
                                        <span class="text">{{App\Subject::find($upcomingSession->subject_id)->subject}}</span>
                                    @endif
                                    <span class="descriptor">Time</span>
                                    <span class="descriptor">Location</span>
                                    <span class="text">
                                        {{$upcomingSession->start_time}} - {{$upcomingSession->end_time}}
                                    </span>
                                    <span class="text">
                                        {{$upcomingSession->location ?? 'On Campus'}}
                                    </span>
                                    <button class="btn btn-lg btn-outline-primary" data-session-id="{{$upcomingSession->session_id}}">Cancel Session</button>
                                    <button class="btn btn-lg btn-primary" data-session-id="{{$upcomingSession->session_id}}">View Session</button>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <div class="sessions__container-2">
                <div class="sessions__header">
                    <h4>Past Tutoring Sessions</h4>
                </div>
                {{-- <div class="sessions__header--sub">
                    Some description here
                </div> --}}
                <div class="sessions__info">
                    @if(count($pastSessions) === 0)
                        <h5>There are no past sessions yet</h5>
                    @else
                        @foreach ($pastSessions as $pastSession)
                            <div class="session__container" data-session-id="{{$pastSession->session_id}}">
                                <span class="title">{{$pastSession->full_name}}</span>
                                <span class="descriptor">Date</span>
                                <span class="descriptor">Subject / Course</span>
                                <span class="text date">{{date('m/d/Y', strtotime($pastSession->date))}}</span>
                                @if($pastSession->is_course)
                                <span class="text subject-course">{{App\Course::find($pastSession->course_id)->course}}</span>
                                @else
                                <span class="text subject-course">{{App\Subject::find($pastSession->subject_id)->subject}}</span>
                                @endif
                                <span class="descriptor">Time</span>
                                <span class="descriptor">Hourly Rate</span>
                                <span class="text">{{$pastSession->start_time}} - {{$pastSession->end_time}}</span>
                                <span class="text">
                                    ${{$pastSession->hourly_rate}} / hr
                                </span>
                                <button class="btn btn-lg btn-outline-primary btn-write-review" data-session-id="{{$pastSession->session_id}}">Write a review +</button>
                                <button class="btn btn-lg btn-primary" data-session-id="{{$pastSession->session_id}}">View Session</button>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

        </div>



        <div class="reviews__container">
            <div class="reviews__container__sub">
                <div class="reviews__header">
                    <h4>Reviews About You</h4>
                </div>
                <div class="review-star__container__header">
                    <div>
                        @if(count($reviews) === 0)
                            <p class="mr-0">No Reviews About You yet</p>
                        @else
                            <p>{{$reviewTotalRating}}</p>
                            @for ($i = 0; $i < floor($reviewTotalRating); $i++)
                                <svg>
                                    <use xlink:href="{{asset('assets/sprite.svg#icon-star')}}"></use>
                                </svg>
                            @endfor
                            @for ($i = floor($reviewTotalRating); $i < 5; $i++)
                            <svg>
                                <use xlink:href="{{asset('assets/sprite.svg#icon-star-outlined')}}"></use>
                            </svg>
                            @endfor
                        @endif
                    </div>
                </div>
            </div>

            <p class="text-right grey-text">{{count($reviews)}} Review(s)</p>

            <div class="reviews">
                @foreach ($reviews as $review)
                @php
                    $reviewer = App\User::find($review->reviewer_id);
                    $session = App\Session::find($review->session_id);

                    // did not use created at, because the review might be updated. By defulat, it should equal to created time when created initially
                    $earlier = new DateTime($review->updated_at);
                    $later =  new DateTime(date('m/d/Y', time()));

                    $diff = $later->diff($earlier)->format("%a");

                @endphp
                <table class="table table-hover reviews-table">
                    <tbody>
                        <tr>
                            <th scope="row">
                                <img src="{{asset("user_photos/{$reviewer->profile_pic_url}")}}" alt="reviewee photo">
                            </th>
                            <td class="name">{{$reviewer->full_name}}</td>
                            <td class="subject-container">
                                <div class="grey-text">Subject / Course</div>
                                <div>{{$session->courseSubject()}}</div>
                            </td>
                            <td class="review-content__container">
                                <p class="review-content">
                                    {{$review->review}}

                                    {{-- $diff is string, dont use === here --}}
                                    @if($diff == 0)
                                    <span class="grey-text time-sent">
                                        Today
                                    </span>
                                    @else
                                    <span class="grey-text time-sent">
                                        {{$diff}} days ago
                                     </span>
                                    @endif
                                </p>
                            </td>
                            <td>
                                <div class="review-star__container">
                                    @for ($i = 0; $i < floor($review->star_rating); $i++)
                                        <svg>
                                            <use xlink:href="{{asset('assets/sprite.svg#icon-star')}}"></use>
                                        </svg>
                                    @endfor
                                    @for ($i = floor($review->star_rating); $i < 5; $i++)
                                    <svg>
                                        <use xlink:href="{{asset('assets/sprite.svg#icon-star-outlined')}}"></use>
                                    </svg>
                                    @endfor
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                @endforeach

            </div>

        </div>
    </div>



@endsection

@section('js')
<!-- for autocomplete -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="{{asset('js/profile.js')}}"></script>


@if(session('errors'))
<script>
    toastr.error("{{session('errors')->first()}}");
</script>
@elseif(session('success'))
<script>
    toastr.success("{{session('success')}}");
</script>
@elseif(session('error'))
<script>
    toastr.error("{{session('error')}}");
</script>
@endif


@endsection
