@extends('layouts.loggedin')
@section('title', 'home - tutor')
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
<div id="add-post-container">
    <h3>Write a Post</h3>
    <textarea name="post-content" id="post-content" placeholder="Begin typing post here."></textarea>
    <small class="subject-course">Subject / Course</small>
    <div class="add-post-bottom">
        <select class="custom-select custom-select-lg " name="add-post-course-subject" id="add-post-course-subject">
            <option selected="true" disabled="disabled">Select</option>
            <option value="ITP 104">ITP 104</option>
            <option value="Calculus">Calculus</option>
        </select>
        <button class="btn btn-lg btn-outline-primary btn-cancel">Cancel</button>
        <button class="btn btn-lg btn-primary btn-post">Post</button>
    </div>

</div>
@endsection

@section('content')
    <div class="container-fluid home__container ">
        <div class="row home__container__header">
            <div class="container home__container__header__content">
                <div class="home__container__header__content__text">
                    <div class="home__container__header__content__text__header">
                        <h2>Welcome Jeffrey!</h2>
                    </div>
                    <div class="home__container__header__content__text__descriptor">
                        <small>You have X unread message & Y Tutor Request(s)</small>
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
                <div class="col-12 col-sm-7 home__container__notifications__tutors">
                    <div class="home__container__notifications__title mb-0"><h5><span>Availability Calendar</span></h5></div>
                    {{-- <div class="home__container__notifications__text">
                        Click or drag on time slots you are free to tutor throughout the week. Update this calendar as
                        frequently as needed. Students will be requesting tutoring sessions with you based on your
                        availability that is noted here. You can also edit this calendar on your Profile page.
                    </div> --}}
                    <div class="home__container__notifications__calendar">
                        Calendar functionality is coming soon!
                    </div>
                </div>
                <div class="col-12 col-sm-5 home__container__notifications__sessions">
                    <div class="home__container__notifications__title pl-0 pr-0 mb-0">
                        <h5><span>Upcoming Sessions</span></h5>
                    </div>
                    <div class="session__container">
                        <span class="title">Student Name</span>
                        <span class="descriptor">Date</span>
                        <span class="descriptor">Subject / Course</span>
                        <span class="text">02/20/2020</span>
                        <span class="text">ITP 104</span>
                        <span class="descriptor">Time</span>
                        <span class="descriptor">Hourly Rate</span>
                        <span class="text">5 - 6pm</span>
                        <span class="text">$16 / hr</span>
                        <button class="btn btn-lg btn-outline-primary">Cancel Session</button>
                        <button class="btn btn-lg btn-primary">View Session</button>
                    </div>
                    <div class="session__container">
                        <span class="title">Student Name</span>
                        <span class="descriptor">Date</span>
                        <span class="descriptor">Subject / Course</span>
                        <span class="text">02/20/2020</span>
                        <span class="text">ITP 104</span>
                        <span class="descriptor">Time</span>
                        <span class="descriptor">Hourly Rate</span>
                        <span class="text">5 - 6pm</span>
                        <span class="text">$16 / hr</span>
                        <button class="btn btn-lg btn-outline-primary">Cancel Session</button>
                        <button class="btn btn-lg btn-primary">View Session</button>
                    </div>

                </div>
            </div>

            <div class="home__tutor-requests home__container__notifications__title">
                <div class="home__tutor-requests__header">
                    <h5>Tutor Requests <span class="home__tutor-requests__header--num">(2)</h5></span>
                </div>
                <div class="home__tutor-requests__content">
                    Click on the panel if you want to view the request in Messages.
                </div>

                <table class="table table-hover tutor-requests-table">
                    <tbody>
                        <tr>
                            <th scope="row"><img src="assets/mj.jpg" alt="tutor pic"><small class="bold">Student Name</small></th>

                            <td>
                                <div class="labels">Date</div>
                                <small class="bold">Wednesday, March 15, 2020</small>
                            </td>
                            <td>
                                <div class="labels">Subject / Course</div>
                                <small class="bold">ITP 104</small>
                            </td>
                            <td>
                                <div class="labels">Start Time</div>
                                <small class="bold">4:30pm</small>
                            </td>
                            <td>
                                <div class="labels">End Time</div>
                                <small class="bold">6:00pm</small>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-lg btn-outline-primary"><small>Decline</small></button>
                                <button class="btn btn-lg btn-primary"><small>Accept</small></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-hover tutor-requests-table">
                    <tbody>
                        <tr>
                            <th scope="row"><img src="assets/mj.jpg" alt="tutor pic"><small class="bold">Student Name</small></th>
                            <td>
                                <div class="labels">Date</div>
                                <small class="bold">Wednesday, March 15, 2020</small>
                            </td>
                            <td>
                                <div class="labels">Subject / Course</div>
                                <small class="bold">ITP 104</small>
                            </td>
                            <td>
                                <div class="labels">Start Time</div>
                                <small class="bold">4:30pm</small>
                            </td>
                            <td>
                                <div class="labels">End Time</div>
                                <small class="bold">6:00pm</small>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-lg btn-outline-primary"><small>Decline</small></button>
                                <button class="btn btn-lg btn-primary"><small>Accept</small></button>
                            </td>
                        </tr>
                    </tbody>
                </table>


            </div>

            <div class="row home__container__help-center">
                <div class="col">
                    <div class="home__container__help-center__header">
                        <div>
                            <h5 class="home__container__help-center__header__text">Dashboard</h5>
                            <form class="home__container__help-center__filter-container" id="filter-form" method="GET"
                                action="/home_filter">
                                <div class="select-container">
                                    <select class="custom-select custom-select-lg filter-post" name="filter-post"
                                        id="search-courses-subjects">
                                        <option value="all-courses-subjects" selected>All Courses / Subjects</option>
                                        <option value="my-courses-subjects">My Courses / Subjects</option>
                                    </select>
                                    <select class="custom-select custom-select-lg filter-post" name="filter-post"
                                        id="search-posts">
                                        <option selected>All Posts</option>
                                        <option value="tutor-posts">Tutor Posts</option>
                                        <option value="student-posts">Student Posts</option>
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
                            <tr>
                                <th scope="row"><img src="assets/mj.jpg" alt="tutor pic"> Jeffrey Miller </th>
                                <td>
                                    <p>00/00/00</p><span>ITP 104</span>
                                </td>
                                <td>I have an upcoming midterm for ITP 104 next Tuesday. Would anyone be available to help
                                    me this weekend?</td>
                                <td><button class="btn btn-lg btn-primary button--small">Send Message</button></td>
                            </tr>
                            <tr>
                                <th scope="row"><img src="assets/mj.jpg" alt="tutor pic"> Jeffrey Miller </th>
                                <td>
                                    <p>00/00/00</p><span>ITP 104</span>
                                </td>
                                <td>I have an upcoming midterm for ITP 104 next Tuesday. Would anyone be available to help
                                    me this weekend?</td>
                                <td><button class="btn btn-lg btn-primary button--small">Send Message</button></td>
                            </tr>
                            <tr>
                                <th scope="row"><img src="assets/mj.jpg" alt="tutor pic"> Jeffrey Miller </th>
                                <td>
                                    <p>00/00/00</p><span>ITP 104</span>
                                </td>
                                <td>I have an upcoming midterm for ITP 104 next Tuesday. Would anyone be available to help
                                    me this weekend?</td>
                                <td><button class="btn btn-lg btn-primary button--small">Send Message</button></td>
                            </tr>
                            <tr>
                                <th scope="row"><img src="assets/mj.jpg" alt="tutor pic"> Jeffrey Miller </th>
                                <td>
                                    <p>00/00/00</p><span>ITP 104</span>
                                </td>
                                <td>I have an upcoming midterm for ITP 104 next Tuesday. Would anyone be available to help
                                    me this weekend?</td>
                                <td><button class="btn btn-lg btn-primary button--small">Send Message</button></td>
                            </tr>
                            <tr>
                                <th scope="row"><img src="assets/mj.jpg" alt="tutor pic"> Jeffrey Miller </th>
                                <td>
                                    <p>00/00/00</p><span>ITP 104</span>
                                </td>
                                <td>I have an upcoming midterm for ITP 104 next Tuesday. Would anyone be available to help
                                    me this weekend?</td>
                                <td><button class="btn btn-lg btn-primary button--small">Send Message</button></td>
                            </tr>
                            <tr>
                                <th scope="row"><img src="assets/mj.jpg" alt="tutor pic"> Jeffrey Miller </th>
                                <td>
                                    <p>00/00/00</p><span>ITP 104</span>
                                </td>
                                <td>I have an upcoming midterm for ITP 104 next Tuesday. Would anyone be available to help
                                    me this weekend?</td>
                                <td><button class="btn btn-lg btn-primary button--small">Send Message</button></td>
                            </tr>
                            <tr>
                                <th scope="row"><img src="assets/mj.jpg" alt="tutor pic"> Jeffrey Miller </th>
                                <td>
                                    <p>00/00/00</p><span>ITP 104</span>
                                </td>
                                <td>I have an upcoming midterm for ITP 104 next Tuesday. Would anyone be available to help
                                    me this weekend?</td>
                                <td><button class="btn btn-lg btn-primary button--small">Send Message</button></td>
                            </tr>
                        </tbody>
                    </table>
    
                </div>
            </div>

        </div>



    </div>




    @endsection

    @section('js')
    
    <!-- defined javascript -->
    <script src="js/home_tutor.js"></script>
    <script src="js/home_common.js"></script>
    
    @endsection
    