@extends('layouts.loggedin')
@section('title', 'view tutor profile')


@section('content')
    <div class="container" id="profile-container">
        <div>
            @if($from == 'search')
                <a class="btn btn-lg back-button" id="back-button" href="/search?navInput=">
                    Back to Search
                </a>
            @else
                <a class="btn btn-lg back-button" id="back-button" href="/{{$from}}">
                    Back to {{ucwords($from)}}
                </a>
            @endif
        </div>
        <div class="about__container">
            <div class="about__information">
                <div class="about__information__img">
                    <div class="img-container">
                        <img src="{{asset("user_photos/{$viewUser->profile_pic_url}")}}" alt="profile_img">
                    </div>
                </div>

                <div class="about__information__content">
                    <div class="name"><h4 id="currentUserName">{{$viewUser->full_name}}</h4></div>
                    <div class="major-minor-container">
                        <span class="descriptor">Major</span>
                        <span class="descriptor">Minor</span>
                        <span class="text">{{$viewUser->major['major']}}</span>
                        <span class="text">{{$viewUser->minor ?? 'None'}}</span>
                    </div>
                    <div class="year-container">
                        <span class="descriptor">Year</span>
                        <span class="text">{{$viewUser->school_year['school_year']}}</span>
                    </div>
                    <div class="btn-container">
                        <a class="btn btn-lg btn-primary" href="/message">Message</a>
                        <button class="btn btn-lg btn-outline-primary btn-request-tutor-session">Request Tutoring Session</button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 col-12">
                    <div class="about__subjects">
                        <div class="about__subjects__header">Subjects</div>
                    </div>

                    @if(count($subjects) === 0)
                        <div>
                            <span class="f-16">This user has not added any interested subjects yet.</span>
                        </div>
                    @else
                        <div class="about__buttons__container" id="about__buttons__container--subjects">
                            @foreach ($subjects as $subject)
                                <button class="btn btn-lg" data-subject-id="{{$subject->id}}">
                                    <span class="name">{{$subject->subject}}</span>
                                </button>
                            @endforeach
                        </div>
                    @endif

                    <div class="about__courses">
                        <div class="about__courses__header">
                            Courses
                        </div>
                    </div>

                    @if(count($courses) === 0)
                        <div>
                            <span class="f-16">This user has not added any interested courses yet.</span>
                        </div>
                    @else
                        <div class="about__buttons__container" id="about__buttons__container--courses">
                            @foreach ($courses as $course)
                            <button class="btn btn-lg" data-course-id="{{$course->id}}">
                                <span class="name">{{$course->course}}</span>
                            </button>
                            @endforeach
                        </div>
                    @endif


                    <div class="about__characteristics">
                        <div class="about__characteristics__header">
                            Characteristics
                        </div>
                    </div>

                    @if(count($characteristics) === 0)
                        <div>
                            <span class="f-16">This user has not added any characteristics yet.</span>
                        </div>
                    @else
                        <div class="about__buttons__container" id="about__buttons__container--characteristics">
                            @foreach ($characteristics as $characteristic)
                            <button class="btn btn-lg" data-characteristic-id="{{$characteristic->id}}">
                                <span class="name">{{$characteristic->characteristic}}</span>
                            </button>
                            @endforeach
                        </div>
                    @endif

                </div>
                <div class="col-sm-6 col-12 about__reviews">
                    <div class="top-container">
                        <div class="header">Reviews</div>
                        <div class="review-rating">
                            @if(count($reviews) === 0)
                                <p class="mr-0">No reviews of the user yet</p>
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

                    <div class="reviews-container">
                        @for ($i = 0; $i < min(count($reviews), 3); $i++)
                            @php
                                $review = $reviews[$i];
                                $fullName = App\User::find($review->id)->full_name;
                                $session = App\Session::find($review->session_id);
                                $courseSubject;
                                if($session->is_course) {
                                    $courseSubject = App\Course::find($session->course_id)->course;
                                }
                                else {
                                    $courseSubject = App\Subject::find($session->subject_id)->subject;
                                }
                            @endphp
                            <div class="review-container">
                                <div class="review-container--left">
                                    @for ($j = 0; $j < floor($reviews[$i]->star_rating); $j++)
                                        <svg>
                                            <use xlink:href="{{asset('assets/sprite.svg#icon-star')}}"></use>
                                        </svg>
                                    @endfor
                                    @for ($j = floor($reviews[$i]->star_rating); $j < 5; $j++)
                                    <svg>
                                        <use xlink:href="{{asset('assets/sprite.svg#icon-star-outlined')}}"></use>
                                    </svg>
                                    @endfor
                                </div>
                                <div class="review-container--right">
                                    <div class="header">
                                        {{$fullName}} &middot; {{$courseSubject}}
                                    </div>
                                    <div class="review-content">
                                        {{$reviews[$i]->review}}
                                    </div>
                                </div>
                            </div>
                        @endfor


                    </div>

                    <div class="bottom-container">
                        <a class="btn btn-lg btn-outline-primary btn-read-more" href="/reviews">
                            Read More
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection

@section('js')



<script src="{{asset('js/view_profile.js')}}"></script>

@endsection



