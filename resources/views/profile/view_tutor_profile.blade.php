@extends('layouts.loggedin')
@section('title', 'view tutor profile')


@section('content')
    <div class="container" id="profile-container">
        <div>
            <a class="btn btn-lg back-button" id="back-button" href="/profile">
                Back to Profile
            </a>
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

                    <div class="about__buttons__container" id="about__buttons__container--subjects">
                        @foreach ($subjects as $subject)
                            <button class="btn btn-lg" data-subject-id="{{$subject->id}}">
                                <span class="name">{{$subject->subject}}</span>
                            </button>
                        @endforeach
                    </div>

                    <div class="about__courses">
                        <div class="about__courses__header">
                            Courses
                        </div>
                    </div>

                    <div class="about__buttons__container" id="about__buttons__container--courses">
                        @foreach ($courses as $course)
                        <button class="btn btn-lg" data-course-id="{{$course->id}}">
                            <span class="name">{{$course->course}}</span>
                        </button>
                        @endforeach

                    </div>


                    <div class="about__characteristics">
                        <div class="about__characteristics__header">
                            Characteristics
                        </div>
                    </div>

                    <div class="about__buttons__container" id="about__buttons__container--characteristics">
                        @foreach ($characteristics as $characteristic)
                        <button class="btn btn-lg" data-characteristic-id="{{$characteristic->id}}">
                            <span class="name">{{$characteristic->characteristic}}</span>
                        </button>
                        @endforeach
                    </div>

                </div>
                <div class="col-sm-6 col-12 about__reviews">
                    <div class="header">Reviews</div>
                    
                </div>

            </div>
        </div>
    </div>

@endsection

@section('js')



<script src="{{asset('js/view_profile.js')}}"></script>

@endsection



