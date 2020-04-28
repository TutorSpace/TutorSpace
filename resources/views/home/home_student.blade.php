@extends('layouts.loggedin')
@section('title', 'home - student')
@section('st0-white', 'st0-white')
@section('nav-container-white', 'nav-container-white')

@section('nav-white')
<div class="nav-white">
</div>
@endsection

@section('body-class')
min-width-450
@endsection


@section('add-post-container')
<form id="add-post-container">
    <h3>Write a Post</h3>
    <textarea name="post-content" id="post-content" placeholder="Begin typing post here."></textarea>
    <small class="subject-course">Subject / Course</small>
    <div class="add-post-bottom">
        <select class="custom-select custom-select-lg " name="add-post-course-subject" id="add-post-course-subject">
            <option selected="true" disabled="disabled">Select</option>
            @if(count($interestedCourses) === 0 && count($interestedSubjects) === 0)
                <option disabled="disabled">Please first add interested courses/subjects in profile page.</option>
            @else
                @foreach ($interestedCourses as $interestedCourse)
                    <option value="course-{{$interestedCourse->id}}">{{$interestedCourse->course}}</option>
                @endforeach
                @foreach ($interestedSubjects as $interestedSubject)
                    <option value="subject-{{$interestedSubject->id}}">{{$interestedSubject->subject}}</option>
                @endforeach
            @endif
        </select>
        <button class="btn btn-lg btn-outline-primary btn-cancel">Cancel</button>
        <button class="btn btn-lg btn-primary btn-post" type="submit">Post</button>
    </div>
</form>
@endsection


@section('signup-wizard-container')
<div class="signup-wizard-container">
    <div class="top-container">
        <span>Skip</span>
    </div>
    <div class="middle-container">
        <div class="svg-container">
            <svg width="128" height="118" viewBox="0 0 128 118" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M105.58 47.3447H21.8324C21.6263 45.654 21.5201 43.9324 21.5201 42.186C21.5201 18.8873 40.4075 0 63.7062 0C87.0048 0 105.892 18.8873 105.892 42.186C105.892 43.9324 105.786 45.654 105.58 47.3447Z" fill="#FFF06A"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M-1.66793e-05 46.9792L127.17 46.9792C123.888 86.8724 96.6724 118 63.5848 118C30.4972 118 3.2817 86.8724 -1.66793e-05 46.9792Z" fill="url(#paint0_radial)"/>
                <defs>
                <radialGradient id="paint0_radial" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(63.706 50.3616) rotate(90) scale(51.4052 73.9907)">
                <stop stop-color="#FFF06A"/>
                <stop offset="1" stop-color="#FFF06A" stop-opacity="0"/>
                </radialGradient>
                </defs>
            </svg>
        </div>
        <div class="title-container">
            <h4>Welcome to Tütor!</h4>
        </div>
        <div class="subtitle-container">
            Flip through the next few cards to see how Tütor can help you get started!
        </div>
        <div class="progress-bar-container">
            <svg width="65" height="5" viewBox="0 0 65 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                <svg width="45" height="5" viewBox="0 0 45 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <svg width="45" height="5" viewBox="0 0 45 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="2.5" cy="2.5" r="2.5" fill="black"/>
                        <circle cx="12.5" cy="2.5" r="2.5" fill="#C4C4C4"/>
                        <circle cx="22.5" cy="2.5" r="2.5" fill="#C4C4C4"/>
                        <circle cx="32.5" cy="2.5" r="2.5" fill="#C4C4C4"/>
                        <circle cx="42.5" cy="2.5" r="2.5" fill="#C4C4C4"/>
                    </svg>
                </svg>

            </svg>
        </div>
    </div>
    <div class="bottom-container">
        <button class="btn btn-lg btn-primary btn-continue">
            Continue
        </button>
    </div>
</div>



<div class="signup-wizard-container">
    <div class="top-container">
        <span>Skip</span>
    </div>
    <div class="middle-container">
        <div class="svg-container">
            <svg width="112" height="67" viewBox="0 0 112 67" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="5" cy="5" r="5" fill="#2C86C4"/>
                <rect x="23.1583" y="1" width="78" height="7" rx="3.5" fill="#2C86C4"/>
                <circle cx="15" cy="24" r="5" fill="#FFC077"/>
                <rect x="33.1583" y="20" width="78" height="7" rx="3.5" fill="#FFC077"/>
                <circle cx="5" cy="43" r="5" fill="#2C86C4"/>
                <rect x="23.1583" y="39" width="78" height="7" rx="3.5" fill="#2C86C4"/>
                <circle cx="5" cy="62" r="5" fill="#2C86C4"/>
                <rect x="23.1583" y="58" width="78" height="7" rx="3.5" fill="#2C86C4"/>
            </svg>
        </div>
        <div class="title-container">
            <h4>List Your Courses</h4>
        </div>
        <div class="subtitle-container">
            Add the courses and subjects you can tutor on your profile so students can easily find you.
        </div>
        <div class="progress-bar-container">
            <svg width="65" height="5" viewBox="0 0 65 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                <svg width="65" height="5" viewBox="0 0 65 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <svg width="45" height="5" viewBox="0 0 45 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="2.5" cy="2.5" r="2.5" fill="#C4C4C4"/>
                        <circle cx="12.5" cy="2.5" r="2.5" fill="black"/>
                        <circle cx="22.5" cy="2.5" r="2.5" fill="#C4C4C4"/>
                        <circle cx="32.5" cy="2.5" r="2.5" fill="#C4C4C4"/>
                        <circle cx="42.5" cy="2.5" r="2.5" fill="#C4C4C4"/>
                    </svg>
                </svg>
            </svg>
        </div>
    </div>
    <div class="bottom-container">
        <button class="btn btn-lg btn-primary btn-continue">
            Continue
        </button>
    </div>
</div>

<div class="signup-wizard-container">
    <div class="top-container">
        <span>Skip</span>
    </div>
    <div class="middle-container">
        <div class="svg-container">
            <svg width="134" height="107" viewBox="0 0 134 107" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="17.881" cy="86.3347" r="7.33467" fill="#FFB2B2"/>
                <circle cx="53.9314" cy="53.9315" r="47.0282" fill="#FFCACA"/>
                <circle cx="13.8064" cy="64.7176" r="13.8064" fill="#FFB3B3"/>
                <circle cx="47.4597" cy="47.4596" r="5.17742" fill="#424242"/>
                <circle cx="14.6693" cy="31.9274" r="5.17742" fill="#424242"/>
                <path d="M96.6451 58.6859C100.528 68.6036 115.629 56.9475 109.589 53.5004C104.547 50.6233 102.685 64.7251 110.883 66.0195C119.081 67.3138 127.666 55.0586 122.101 54.3631C115.198 53.5004 120.721 66.875 125.121 66.875C129.435 66.875 131.305 62.4194 131.593 61.2689" stroke="#FFA5A5" stroke-width="3" stroke-linecap="round"/>
                <circle cx="34.9476" cy="99.6647" r="7.33467" fill="#FFB2B2"/>
                <circle cx="84.9959" cy="92.7614" r="7.33467" fill="#FFB2B2"/>
                <circle cx="17.2581" cy="67.3059" r="1.72581" fill="#EF8181"/>
                <circle cx="6.90322" cy="62.9914" r="1.72581" fill="#EF8181"/>
                <path d="M80.7766 31.178C79.3465 28.1267 61.1413 27.8128 59.5201 32.2941C58.973 34.3807 66.9415 45.837 69.6124 46.5374C72.9512 47.4129 82.2067 34.2292 80.7766 31.178Z" fill="#FFB2B2"/>
                <path d="M28.2942 0.831036C24.9435 1.18928 18.7169 18.2995 22.4258 21.2919C24.2203 22.4888 37.6474 18.6865 39.1795 16.3893C41.0948 13.5178 31.6448 0.472788 28.2942 0.831036Z" fill="#FFB2B2"/>
            </svg>
        </div>
        <div class="title-container">
            <h4>Add Your Bank Account</h4>
        </div>
        <div class="subtitle-container">
            Set up your bank account under “Edit Profile” for direct deposit payments.
        </div>
        <div class="progress-bar-container">
            <svg width="65" height="5" viewBox="0 0 65 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                <svg width="45" height="5" viewBox="0 0 45 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="2.5" cy="2.5" r="2.5" fill="#C4C4C4"/>
                    <circle cx="12.5" cy="2.5" r="2.5" fill="#C4C4C4"/>
                    <circle cx="22.5" cy="2.5" r="2.5" fill="black"/>
                    <circle cx="32.5" cy="2.5" r="2.5" fill="#C4C4C4"/>
                    <circle cx="42.5" cy="2.5" r="2.5" fill="#C4C4C4"/>
                </svg>
            </svg>
        </div>
    </div>
    <div class="bottom-container">
        <button class="btn btn-lg btn-primary btn-continue">
            Continue
        </button>
    </div>
</div>

<div class="signup-wizard-container">
    <div class="top-container">
        <span>Skip</span>
    </div>
    <div class="middle-container">
        <div class="svg-container">
            <svg width="56" height="74" viewBox="0 0 56 74" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M55.75 1C55.75 0.447715 55.3023 0 54.75 0H1.25C0.697715 0 0.25 0.447715 0.25 0.999999V73C0.25 73.5523 0.697715 74 1.25 74H4.00009C4.26531 74 4.51966 73.8946 4.7072 73.7071L27.2929 51.1214C27.6834 50.7309 28.3166 50.7309 28.7071 51.1214L51.2928 73.7071C51.4803 73.8946 51.7347 74 51.9999 74H54.75C55.3023 74 55.75 73.5523 55.75 73V1Z" fill="#FFDC60"/>
            </svg>
        </div>
        <div class="title-container">
            <h4>Save tutors you like</h4>
        </div>
        <div class="subtitle-container">
            Enjoyed a tutoring session? Save them to make it easier to find for next time.
        </div>
        <div class="progress-bar-container">
            <svg width="45" height="5" viewBox="0 0 45 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="2.5" cy="2.5" r="2.5" fill="#C4C4C4"/>
                <circle cx="12.5" cy="2.5" r="2.5" fill="#C4C4C4"/>
                <circle cx="22.5" cy="2.5" r="2.5" fill="#C4C4C4"/>
                <circle cx="32.5" cy="2.5" r="2.5" fill="black"/>
                <circle cx="42.5" cy="2.5" r="2.5" fill="#C4C4C4"/>
            </svg>
        </div>
    </div>
    <div class="bottom-container">
        <button class="btn btn-lg btn-primary btn-continue">
            Continue
        </button>
    </div>
</div>

<div class="signup-wizard-container">
    <div class="top-container">
        <span>Skip</span>
    </div>
    <div class="middle-container">
        <div class="svg-container">
            <svg width="163" height="151" viewBox="0 0 163 151" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M136.656 26.372C105.01 14.4065 79.857 9.30952 45.4764 8.82792C31.9897 8.639 20.5007 18.5117 20.1629 31.9955C19.1513 72.376 30.8825 129.699 67.5383 136.878C103.247 143.872 134.767 97.1915 151.401 60.4966C157.522 46.9947 150.522 31.6149 136.656 26.372Z" fill="#BCBCBC" fill-opacity="0.44"/>
                <path d="M63.0001 33C63.0001 29.6863 65.6864 27 69.0001 27H89.0001C92.3138 27 95.0001 29.6863 95.0001 33V58H63.0001V33Z" stroke="white" stroke-width="8"/>
                <rect x="52.0001" y="58" width="56" height="56" rx="8" fill="#FFC077" stroke="white" stroke-width="8"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M82.5 87.9799C84.7074 87.0155 86.25 84.8129 86.25 82.25C86.25 78.7982 83.4518 76 80 76C76.5482 76 73.75 78.7982 73.75 82.25C73.75 84.8129 75.2926 87.0155 77.5 87.9799V96H82.5V87.9799Z" fill="black"/>
            </svg>
        </div>
        <div class="title-container">
            <h4>Safe & Secure</h4>
        </div>
        <div class="subtitle-container">
            All communication is done through the Tütor website to maintain privacy & monitor language.
        </div>
        <div class="progress-bar-container">
            <svg width="45" height="5" viewBox="0 0 45 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="2.5" cy="2.5" r="2.5" fill="#C4C4C4"/>
                <circle cx="12.5" cy="2.5" r="2.5" fill="#C4C4C4"/>
                <circle cx="22.5" cy="2.5" r="2.5" fill="#C4C4C4"/>
                <circle cx="32.5" cy="2.5" r="2.5" fill="#C4C4C4"/>
                <circle cx="42.5" cy="2.5" r="2.5" fill="black"/>
            </svg>
        </div>
    </div>
    <div class="bottom-container">
        <button class="btn btn-lg btn-primary btn-continue">
            Let's start!
        </button>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid home__container">
    <div class="row home__container__header">
        <div class="container home__container__header__content">
            <div class="home__container__header__content__text">
                <div class="home__container__header__content__text__header">
                    <h2>Welcome {{Auth::user()->full_name}}!</h2>
                </div>
                <div class="home__container__header__content__text__descriptor">
                    <small>You have X unread message(s)</small>
                </div>
            </div>
            <div class="home__container__header__content__img">
                <svg width="274" height="167" viewBox="0 0 274 167" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M220.935 167H48.0039C44.5644 157.359 42.6914 146.975 42.6914 136.153C42.6914 85.4655 83.7819 44.375 134.47 44.375C185.157 44.375 226.248 85.4655 226.248 136.153C226.248 146.975 224.375 157.359 220.935 167Z"
                        fill="#FFC077" />
                    <path
                        d="M2 157L8.19327 152.628C9.57618 151.652 11.4238 151.652 12.8067 152.628L16.6933 155.372C18.0762 156.348 19.9238 156.348 21.3067 155.372L25.1933 152.628C26.5762 151.652 28.4238 151.652 29.8067 152.628L36 157"
                        stroke="#FFC077" stroke-width="4" stroke-linecap="round" />
                    <path
                        d="M272 157L265.512 152.551C264.149 151.616 262.351 151.616 260.988 152.551L256.762 155.449C255.399 156.384 253.601 156.384 252.238 155.449L248.012 152.551C246.649 151.616 244.851 151.616 243.488 152.551L237 157"
                        stroke="#FFC077" stroke-width="4" stroke-linecap="round" />
                    <path
                        d="M4.13126 101.052L11.0696 98.6493C12.8147 98.045 14.7466 98.714 15.7444 100.268L18.0107 103.798C19.0084 105.352 20.9404 106.021 22.6855 105.417L26.6495 104.044C28.3946 103.44 30.3265 104.109 31.3243 105.663L35.2911 111.842"
                        stroke="#FFC077" stroke-width="4" stroke-linecap="round" />
                    <path
                        d="M269.843 101.224L262.74 98.8003C261 98.2068 259.086 98.86 258.092 100.386L255.722 104.024C254.727 105.55 252.813 106.203 251.073 105.61L246.928 104.195C245.188 103.602 243.274 104.255 242.28 105.781L238.219 112.014"
                        stroke="#FFC077" stroke-width="4" stroke-linecap="round" />
                    <path
                        d="M33.6582 46.7492L40.9824 47.2676C42.8245 47.3979 44.338 48.7725 44.6445 50.5937L45.3408 54.7304C45.6473 56.5515 47.1608 57.9261 49.0029 58.0565L53.1874 58.3526C55.0296 58.483 56.543 59.8575 56.8495 61.6787L58.0683 68.9193"
                        stroke="#FFC077" stroke-width="4" stroke-linecap="round" />
                    <path
                        d="M239.876 46.9231L232.415 47.4434C230.561 47.5726 229.04 48.9343 228.731 50.7396L228.015 54.9321C227.707 56.7374 226.185 58.0991 224.332 58.2283L220.028 58.5284C218.174 58.6577 216.653 60.0193 216.344 61.8246L215.103 69.0931"
                        stroke="#FFC077" stroke-width="4" stroke-linecap="round" />
                    <path
                        d="M75.4088 15.8103L82.3721 18.1392C84.1235 18.725 85.2463 20.4336 85.0888 22.2737L84.7313 26.4533C84.5738 28.2934 85.6966 30.002 87.448 30.5878L91.4263 31.9183C93.1777 32.5041 94.3004 34.2127 94.143 36.0527L93.5171 43.3685"
                        stroke="#FFC077" stroke-width="4" stroke-linecap="round" />
                    <path
                        d="M197.503 15.9842L190.433 18.314C188.66 18.8985 187.519 20.6086 187.679 22.4447L188.042 26.6299C188.201 28.466 187.061 30.1762 185.287 30.7607L181.244 32.093C179.471 32.6775 178.33 34.3877 178.489 36.2238L179.125 43.5423"
                        stroke="#FFC077" stroke-width="4" stroke-linecap="round" />
                    <path
                        d="M131 2L135.289 7.89732C136.309 9.29992 136.309 11.2001 135.289 12.6027L132.711 16.1473C131.691 17.5499 131.691 19.4501 132.711 20.8527L135.289 24.3973C136.309 25.7999 136.309 27.7001 135.289 29.1027L131 35"
                        stroke="#FFC077" stroke-width="4" stroke-linecap="round" />
                </svg>

            </div>
        </div>
    </div>

    <div class="container">
        <div class="row home__container__notifications">
            <div class="col-12 col-sm-7 home__container__notifications__students">
                @if(count($recommendedCourses) === 0 && count($recommendedSubjects) === 0)
                    <!-- the commented div is to display when there is no recommended tutors -->
                    <div class="home__container__notifications__title mb-2">
                        <h5><span>Recommended Tutors</span></h5>
                    </div>
                    <div class="home__container__notifications__text">
                        Add subjects or courses you want help in on Your Profile to receive tutor recommendations.
                    </div>
                @endif
                @if(count($recommendedCourses) !== 0)
                    @foreach($recommendedCourses as $recommendedCourse)
                    <div class="home__container__notifications__title">
                        <h5>
                            <span>Recommended Tutors</span> for {{$recommendedCourse->course}}
                        </h5>
                    </div>
                    <table class="table table-hover recommended__tutors"
                    data-user-id="{{$recommendedCourse->id}}">
                        <tbody>
                            <tr data-user-id="{{$recommendedCourse->id}}">
                                <th scope="row">
                                    <img src="{{asset("user_photos/{$recommendedCourse->profile_pic_url}")}}" alt="tutor pic">
                                    {{$recommendedCourse->full_name}}
                                </th>
                                <td>
                                    <div>{{App\User::find($recommendedCourse->id)->school_year->first()->school_year}}</div>
                                    <div>{{App\User::find($recommendedCourse->id)->major->first()->major}}</div>
                                </td>
                                <td>
                                    @if(Auth::user()->bookmarked($recommendedCourse->id))
                                    <svg class="bookmark bookmark-marked" data-user-id="{{$recommendedCourse->id}}">
                                    @else
                                    <svg class="bookmark" data-user-id="{{$recommendedCourse->id}}">
                                    @endif
                                        <use xlink:href="assets/sprite.svg#icon-bookmark"></use>
                                    </svg>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @endforeach
                @endif
                @if(count($recommendedSubjects) !== 0)
                    @foreach($recommendedSubjects as $recommendedSubject)
                    <div class="home__container__notifications__title">
                        <h5>
                            <span>Recommended Tutors</span> for {{$recommendedSubject->subject}}
                        </h5>
                    </div>
                    <table class="table table-hover recommended__tutors"
                    data-user-id="{{$recommendedSubject->id}}">
                        <tbody>
                            <tr data-user-id="{{$recommendedSubject->id}}">
                                <th scope="row">
                                    <img src="{{asset("user_photos/{$recommendedSubject->profile_pic_url}")}}" alt="tutor pic">
                                    {{$recommendedSubject->full_name}}
                                </th>
                                <td>
                                    <div>{{App\User::find($recommendedSubject->id)->school_year->first()->school_year}}</div>
                                    <div>{{App\User::find($recommendedSubject->id)->major->first()->major}}</div>
                                </td>
                                <td>
                                    @if(Auth::user()->bookmarked($recommendedSubject->id))
                                    <svg class="bookmark bookmark-marked" data-user-id="{{$recommendedSubject->id}}">
                                    @else
                                    <svg class="bookmark" data-user-id="{{$recommendedSubject->id}}">
                                    @endif
                                        <use xlink:href="assets/sprite.svg#icon-bookmark"></use>
                                    </svg>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @endforeach
                @endif

            </div>
            <div class="col-12 col-sm-5 home__container__notifications__sessions change-student">
                <div class="col-sm-12 col-6 _col-extra-small-12">
                    @if(count($upcomingSessions) == 0)
                        <div class="home__container__notifications__title mb-2">
                            <h5><span>Upcoming Sessions</span></h5>
                        </div>
                        <div class="home__container__notifications__text">
                            Scheduled sessions between you and a tutor will appear below.
                        </div>
                    @else
                        <div class="home__container__notifications__title">
                            <h5><span>Upcoming Sessions</span></h5>
                        </div>
                        @foreach ($upcomingSessions as $upcomingSession)
                            <div class="session__container" data-session-id="{{$upcomingSession->session_id}}">
                                <span class="title">{{$upcomingSession->full_name}}</span>
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
                                <span class="descriptor">Hourly Rate</span>
                                <span class="text">
                                    {{$upcomingSession->start_time}} - {{$upcomingSession->end_time}}
                                </span>
                                <span class="text">${{$upcomingSession->hourly_rate}} / hr</span>
                                <button class="btn btn-lg btn-outline-primary" data-session-id="{{$upcomingSession->session_id}}">Cancel Session</button>
                                <button class="btn btn-lg btn-primary" data-session-id="{{$upcomingSession->session_id}}">View Session</button>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="col-sm-12 col-6 _col-extra-small-12 mt-4">
                    @if(count($pastTutors) == 0)
                    <div class="home__container__notifications__title mb-2">
                        <h5><span>No Past Tutors</span></h5>
                    </div>
                    <div class="home__container__notifications__text">
                        The last two tutors will appear below.
                    </div>
                    @else
                    <div class="home__container__notifications__title">
                        <h5><span>Past Tutors</span></h5>
                    </div>
                    @foreach($pastTutors as $pastTutor)
                    <div class="tutor-container" data-user-id="{{$pastTutor->tutor_id}}">
                        <div class="img-container">
                            <img src="{{asset("user_photos/{$pastTutor->profile_pic_url}")}}" alt="tutor pic">
                        </div>
                        <div class="tutor__info">
                            <div>{{$pastTutor->full_name}}</div>
                            <div>Last Session:
                                {{date('m/d/Y', strtotime($pastTutor->date))}}
                            </div>
                            <div>Total Sessions:
                                <span>{{$pastTutor->count}}</span>
                            </div>
                        </div>
                        <div class="bookmark-container">
                            @if(Auth::user()->bookmarked($pastTutor->tutor_id))
                            <svg class="bookmark bookmark-marked" data-user-id="{{$pastTutor->tutor_id}}">
                            @else
                            <svg class="bookmark" data-user-id="{{$pastTutor->tutor_id}}">
                            @endif
                                <use xlink:href="assets/sprite.svg#icon-bookmark"></use>
                            </svg>
                        </div>
                        <div class="btn-container">
                            <button class="btn btn-lg btn-outline-primary btn-view-past-session">Past Session</button>
                            <button class="btn btn-lg btn-primary btn-view-profile" data-user-id="{{$pastTutor->tutor_id}}">View Profile</button>
                        </div>

                    </div>
                    @endforeach


                    @endif
                </div>
            </div>
        </div>

        <div class="row home__container__help-center">
            <div class="col">
                <div class="home__container__help-center__header">
                    <div>
                        <h5 class="home__container__help-center__header__text">Dashboard</h5>
                        <form class="home__container__help-center__filter-container" id="filter-form" method="GET"
                            action="#">
                            <div class="select-container">
                                <select class="custom-select custom-select-lg filter-post" name="filter-post-course-subject"
                                    id="search-courses-subjects">
                                    <option value="all-courses-subjects" selected>All Courses / Subjects</option>
                                    <option value="my-courses-subjects">My Courses / Subjects</option>
                                </select>
                                <select class="custom-select custom-select-lg filter-post" name="filter-post-tutor-student"
                                    id="search-posts">
                                    <option value="tutor-student-posts" selected>Tutor & Student Posts</option>
                                    <option value="tutor-posts">Tutor Posts</option>
                                    <option value="student-posts">Student Posts</option>
                                    <option value="my-posts">My Posts</option>
                                </select>
                            </div>

                            <button class="btn btn-primary btn-search" id="btn-search" type="submit">Search</button>
                        </form>
                    </div>

                    <div>
                        <button class="btn btn-lg btn-outline-primary" id="add-post">Add Post +</button>

                    </div>

                </div>
                <table class="table table-hover home__container__help-center__table">
                    <tbody>
                        @foreach ($posts as $post)
                        <tr data-post-id="{{$post->post_id}}">
                            <th scope="row" onclick="viewProfile({{$post->user_id}})">
                                <img src="{{asset("user_photos/{$post->profile_pic_url}")}}" alt="tutor pic">
                                {{$post->full_name}}
                            </th>
                            <td>
                                <p>
                                    {{date('m/d/Y', strtotime($post->post_created_time))}}
                                </p>
                                <span>
                                    @if($post->is_course_post)
                                    {{$post->course}}
                                    @else
                                    {{$post->subject}}
                                    @endif
                                </span>
                            </td>
                            <td class="post-message">
                                {{$post->post_message}}
                            </td>
                            <td>
                                <button class="btn btn-lg btn-primary button--small" data-post-id="{{$post->post_id}}">
                                    Send Message
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>

    </div>



</div>


@endsection

@section('js')

{{-- jqueryUI --}}
<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
  crossorigin="anonymous"></script>


<script>
    let assetsURL = "{{asset("user_photos/")}}";
</script>

<!-- defined javascript -->
<script src="js/home_student.js"></script>
<script src="js/home_common.js"></script>

{{-- my js for bookmark --}}
<script src="{{asset('js/bookmark.js')}}"></script>

@if(session('signupSuccess'))
<script>
    // happen only if the user first signs up
    showSignupWizard();

    $('.signup-wizard-container').each(function() {
        $(this).find('.btn-continue').click(() => {
            $(this).hide();
            if(!$(this).is(':last-child')) {
                $(this).next().show();
            }
            else {
                $('#background-cover-2').hide();
            }
        });

        $(this).find('.top-container span').click(() => {
            $('#background-cover-2').hide();
        });
    })
</script>
@endif

@if(session('reportSuccess'))
<script>
    toastr.success('{{session('reportSuccess')}}');

</script>
@endif

@endsection
