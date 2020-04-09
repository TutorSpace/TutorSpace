@extends('layouts.loggedin')
@section('title', 'profile - tutor')

@section('content')

    <div class="container">
        <nav class="nav profile-nav">
            <a class="nav-link active" href="#" id="nav-about">About You</a>
            <a class="nav-link" href="#" id="nav-sessions">Sessions</a>
            <a class="nav-link" href="#" id="nav-reviews">Reviews</a>
        </nav>

        <div class="about__container">
            <div class="about__information">
                <div class="about__information__img">
                    <img src="assets/mj.jpg" alt="profile_img">
                </div>

                <div class="about__information__content">
                    <div class="name">Jamie Chang</div>
                    <div class="major-minor-container">
                        <span class="descriptor">Major</span>
                        <span class="descriptor">Minor</span>
                        <span class="text">B.S. Astronautical Engineering</span>
                        <span class="text">Web Development and Applications</span>
                    </div>
                    <div class="year-container">
                        <span class="descriptor">Year</span>
                        <span class="text">Senior</span>
                    </div>

                    <a class="btn btn-lg btn-primary" href="/edit_profile_tutor.html">Edit Profile</a>
                    <a class="btn btn-lg btn-outline-primary" href="/edit_availability.html">Edit Availability</a>
                </div>
            </div>

            <div class="row">
                <div class="col-5">
                    <div class="about__subjects">
                        <div class="about__subjects__header">Subjects</div>
                        <div class="about__content">
                            <svg>
                                <use xlink:href="assets/sprite.svg#icon-magnifying-glass"></use>
                            </svg>
                            <input type="text" placeholder="Add Subjects" class="about__input">
                        </div>
                    </div>

                    <div class="about__buttons__container">
                        <button class="btn btn-lg">
                            <svg>
                                <use xlink:href="assets/sprite.svg#icon-cross"></use>
                            </svg>
                            <span class="name">Calculus</span>
                        </button>
                        <button class="btn btn-lg">
                            <svg>
                                <use xlink:href="assets/sprite.svg#icon-cross"></use>
                            </svg>
                            <span class="name">Math</span>
                        </button>
                        <button class="btn btn-lg">
                            <svg>
                                <use xlink:href="assets/sprite.svg#icon-cross"></use>
                            </svg>
                            <span class="name">Ling</span>
                        </button>
                    </div>

                    <div class="about__courses">
                        <div class="about__courses__header">
                            Courses
                        </div>
                        <div class="about__content">
                            <svg>
                                <use xlink:href="assets/sprite.svg#icon-magnifying-glass"></use>
                            </svg>
                            <input type="text" placeholder="Add Courses" class="about__input">
                        </div>
                    </div>

                    <div class="about__buttons__container">
                        <button class="btn btn-lg">
                            <svg>
                                <use xlink:href="assets/sprite.svg#icon-cross"></use>
                            </svg>
                            <span class="name">EALC</span>
                        </button>
                        <button class="btn btn-lg">
                            <svg>
                                <use xlink:href="assets/sprite.svg#icon-cross"></use>
                            </svg>
                            <span class="name">CSCI</span>
                        </button>
                        <button class="btn btn-lg">
                            <svg>
                                <use xlink:href="assets/sprite.svg#icon-cross"></use>
                            </svg>
                            <span class="name">COMM</span>
                        </button>
                    </div>

                    <div class="about__characteristics">
                        <div class="about__characteristics__header">
                            Characteristics
                        </div>
                        <div class="about__content">
                            <svg>
                                <use xlink:href="assets/sprite.svg#icon-magnifying-glass"></use>
                            </svg>
                            <input type="text" placeholder="Add Characteristics" class="about__input">
                        </div>
                    </div>

                    <div class="about__buttons__container">
                        <button class="btn btn-lg">
                            <svg>
                                <use xlink:href="assets/sprite.svg#icon-cross"></use>
                            </svg>
                            <span class="name">Friendly</span>
                        </button>
                        <button class="btn btn-lg">
                            <svg>
                                <use xlink:href="assets/sprite.svg#icon-cross"></use>
                            </svg>
                            <span class="name">Patient</span>
                        </button>
                        <button class="btn btn-lg">
                            <svg>
                                <use xlink:href="assets/sprite.svg#icon-cross"></use>
                            </svg>
                            <span class="name">Hospital</span>
                        </button>
                    </div>

                </div>
                <div class="col-7 reviews">

                </div>

            </div>
        </div>

        <div class="sessions__container">
            <div class="sessions__container-1">
                <div class="sessions__header">
                    Upcoming Tutoring Sessions
                </div>
                <div class="sessions__header--sub">
                    Remember to start the session timer to confirm that both tutor and student are present. A $5 holding
                    fee will be charged to the student when the timer is started.
                </div>
                <div class="sessions__info">
                    <div class="sessions__info">
                        <div class="session__container">
                            <span class="title">Jamie Chang</span>
                            <span class="descriptor">Date</span>
                            <span class="descriptor">Course</span>
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
                            <span class="title">Jamie Chang</span>
                            <span class="descriptor">Date</span>
                            <span class="descriptor">Course</span>
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
                            <span class="title">Jamie Chang</span>
                            <span class="descriptor">Date</span>
                            <span class="descriptor">Course</span>
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
            </div>

            <div class="sessions__container-2">
                <div class="sessions__header">
                    Past Tutoring Sessions
                </div>
                <div class="sessions__header--sub">
                    Remember to start the session timer to confirm that both tutor and student are present. A $5 holding
                    fee will be charged to the student when the timer is started.
                </div>
                <div class="sessions__info">
                    <div class="session__container">
                        <span class="title">Jamie Chang</span>
                        <span class="descriptor">Date</span>
                        <span class="descriptor">Course</span>
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
                        <span class="title">Jamie Chang</span>
                        <span class="descriptor">Date</span>
                        <span class="descriptor">Course</span>
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
                        <span class="title">Jamie Chang</span>
                        <span class="descriptor">Date</span>
                        <span class="descriptor">Course</span>
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

        </div>


        <div class="saved__container">
            <div class="search-card-container row">
                <div class="search-card-flex-container col-3">
                    <div class="search-card">
                        <svg class="bookmark bookmark-marked">
                            <use xlink:href="assets/sprite.svg#icon-bookmark"></use>
                        </svg>
                        <img src="assets/mj.jpg" alt="user photo">
                        <p>Jeffrey M.</p>
                        <p>B.S. Chemical Engineering</p>
                        <p class="star-container">$16/hr | 4.5
                            <svg class="star">
                                <use xlink:href="assets/sprite.svg#icon-star"></use>
                            </svg>
                        </p>
                        <p>Courses: ITP 104, CRIT 350, DES 302...</p>
                        <p>Subjects: Art History, HTML/CSS...</p>
                    </div>
                </div>
                <div class="search-card-flex-container col-3">
                    <div class="search-card">
                        <svg class="bookmark ">
                            <use xlink:href="assets/sprite.svg#icon-bookmark"></use>
                        </svg>
                        <img src="assets/mj.jpg" alt="user photo">
                        <p>Jeffrey M.</p>
                        <p>B.S. Chemical Engineering</p>
                        <p class="star-container">$16/hr | 4.5
                            <svg class="star">
                                <use xlink:href="assets/sprite.svg#icon-star"></use>
                            </svg>
                        </p>
                        <p>Courses: ITP 104, CRIT 350, DES 302...</p>
                        <p>Subjects: Art History, HTML/CSS...</p>
                    </div>
                </div>
                <div class="search-card-flex-container col-3">
                    <div class="search-card">
                        <svg class="bookmark bookmark-marked">
                            <use xlink:href="assets/sprite.svg#icon-bookmark"></use>
                        </svg>
                        <img src="assets/mj.jpg" alt="user photo">
                        <p>Jeffrey M.</p>
                        <p>B.S. Chemical Engineering</p>
                        <p class="star-container">$16/hr | 4.5
                            <svg class="star">
                                <use xlink:href="assets/sprite.svg#icon-star"></use>
                            </svg>
                        </p>
                        <p>Courses: ITP 104, CRIT 350, DES 302...</p>
                        <p>Subjects: Art History, HTML/CSS...</p>
                    </div>
                </div>
                <div class="search-card-flex-container col-3">
                    <div class="search-card">
                        <svg class="bookmark ">
                            <use xlink:href="assets/sprite.svg#icon-bookmark"></use>
                        </svg>
                        <img src="assets/mj.jpg" alt="user photo">
                        <p>Jeffrey M.</p>
                        <p>B.S. Chemical Engineering</p>
                        <p class="star-container">$16/hr | 4.5
                            <svg class="star">
                                <use xlink:href="assets/sprite.svg#icon-star"></use>
                            </svg>
                        </p>
                        <p>Courses: ITP 104, CRIT 350, DES 302...</p>
                        <p>Subjects: Art History, HTML/CSS...</p>
                    </div>
                </div>
                <div class="search-card-flex-container col-3">
                    <div class="search-card">
                        <svg class="bookmark bookmark-marked">
                            <use xlink:href="assets/sprite.svg#icon-bookmark"></use>
                        </svg>
                        <img src="assets/mj.jpg" alt="user photo">
                        <p>Jeffrey M.</p>
                        <p>B.S. Chemical Engineering</p>
                        <p class="star-container">$16/hr | 4.5
                            <svg class="star">
                                <use xlink:href="assets/sprite.svg#icon-star"></use>
                            </svg>
                        </p>
                        <p>Courses: ITP 104, CRIT 350, DES 302...</p>
                        <p>Subjects: Art History, HTML/CSS...</p>
                    </div>
                </div>

            </div>


        </div>


        <div class="reviews__container">
            <div class="reviews__container__sub">
                <div class="reviews__header">
                    Reviews You Wrote
                </div>

                <div class="review-star__container__header">
                    <div>
                        <p>12</p>
                        <svg>
                            <use xlink:href="assets/sprite.svg#icon-star"></use>
                        </svg>
                        <svg>
                            <use xlink:href="assets/sprite.svg#icon-star"></use>
                        </svg>
                        <svg>
                            <use xlink:href="assets/sprite.svg#icon-star"></use>
                        </svg>
                        <svg>
                            <use xlink:href="assets/sprite.svg#icon-star"></use>
                        </svg>
                        <svg>
                            <use xlink:href="assets/sprite.svg#icon-star-outlined"></use>
                        </svg>
                    </div>
                </div>
            </div>

            <p class="text-right grey-text">102 Reviews</p>

            <div class="reviews">
                <table class="table table-hover reviews-table">
                    <tbody>
                        <tr>
                            <th scope="row">Sophia Park </th>
                            <td>
                                <div class="grey-text">Session Subject(s)</div>
                                <div>ITP 104</div>
                            </td>
                            <td class="review-content__container">
                                <p class="review-content">The consultant was incredibly helpful and I left feeling very optimistic about my paper. When I was stuck at a couple transitions she was able to suggest a tweak in order to fit what I was feeling but not able to say. Really just great<span class="grey-text time-sent">14
                                        days ago</span></p>

                            </td>
                            <td>
                                <div class="review-star__container">
                                    <svg>
                                        <use xlink:href="assets/sprite.svg#icon-star"></use>
                                    </svg>
                                    <svg>
                                        <use xlink:href="assets/sprite.svg#icon-star"></use>
                                    </svg>
                                    <svg>
                                        <use xlink:href="assets/sprite.svg#icon-star"></use>
                                    </svg>
                                    <svg>
                                        <use xlink:href="assets/sprite.svg#icon-star"></use>
                                    </svg>
                                    <svg>
                                        <use xlink:href="assets/sprite.svg#icon-star-outlined"></use>
                                    </svg>
                                </div>

                            </td>

                        </tr>
                    </tbody>
                </table>
                <table class="table table-hover reviews-table">
                    <tbody>
                        <tr>
                            <th scope="row">Sophia Park </th>
                            <td>
                                <div class="grey-text">Session Subject(s)</div>
                                <div>ITP 104</div>
                            </td>
                            <td class="review-content__container">
                                <p class="review-content">I didn't know what to expect going in, but it turned out to be very effective and informative. Speaking to someone who has so much writing expertise is an amazing experience. Very helpful. The environment is very homey and welcoming. The open windows and friendliness of the staff allow good ideas to come to mind. I really appreciate everything. Thank you! Thank you! Thank you!  Thank you! Thank you! Thank you!  Thank you! Thank you! Thank you!  Thank you! Thank you! Thank you!  Thank you! Thank you! Thank you! <span class="grey-text time-sent">14
                                        days ago</span></p>

                            </td>
                            <td>
                                <div class="review-star__container">
                                    <svg>
                                        <use xlink:href="assets/sprite.svg#icon-star"></use>
                                    </svg>
                                    <svg>
                                        <use xlink:href="assets/sprite.svg#icon-star"></use>
                                    </svg>
                                    <svg>
                                        <use xlink:href="assets/sprite.svg#icon-star"></use>
                                    </svg>
                                    <svg>
                                        <use xlink:href="assets/sprite.svg#icon-star"></use>
                                    </svg>
                                    <svg>
                                        <use xlink:href="assets/sprite.svg#icon-star-outlined"></use>
                                    </svg>
                                </div>

                            </td>

                        </tr>
                    </tbody>
                </table>
                <table class="table table-hover reviews-table">
                    <tbody>
                        <tr>
                            <th scope="row">Sophia Park </th>
                            <td>
                                <div class="grey-text">Session Subject(s)</div>
                                <div>ITP 104</div>
                            </td>
                            <td class="review-content__container">
                                <p class="review-content">I didn't know what to expect going in, but it turned out to be very effective and informative. Speaking to someone who has so much writing expertise is an amazing experience. Very helpful. The environment is very homey and welcoming. The open windows and friendliness of the staff allow good ideas to come to mind. I really appreciate everything. Thank you! Thank you! Thank you!  Thank you! Thank you! Thank you!  Thank you! Thank you! Thank you!  Thank you! Thank you! Thank you!  Thank you! Thank you! Thank you!Thank you! Thank you! Thank you!  Thank you! Thank you! Thank you!  Thank you! Thank you! Thank you!  Thank you! Thank you! Thank you!  Thank you! Thank you! Thank you! <span class="grey-text time-sent">14 days ago</span></p>

                            </td>
                            <td>
                                <div class="review-star__container">
                                    <svg>
                                        <use xlink:href="assets/sprite.svg#icon-star"></use>
                                    </svg>
                                    <svg>
                                        <use xlink:href="assets/sprite.svg#icon-star"></use>
                                    </svg>
                                    <svg>
                                        <use xlink:href="assets/sprite.svg#icon-star"></use>
                                    </svg>
                                    <svg>
                                        <use xlink:href="assets/sprite.svg#icon-star-outlined"></use>
                                    </svg>
                                    <svg>
                                        <use xlink:href="assets/sprite.svg#icon-star-outlined"></use>
                                    </svg>
                                </div>

                            </td>

                        </tr>
                    </tbody>
                </table>
            </div>


            <!-- <nav aria-label="..." class="_pagination">
                <ul class="pagination pagination-lg">
                    <li class="page-item disabled">
                        <span class="page-link">Previous</span>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item active">
                        <span class="page-link">
                            2
                            <span class="sr-only">(current)</span>
                        </span>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav> -->
        </div>


    </div>


@endsection

@section('js')

<script src="{{asset('js/profile.js')}}"></script>

@endsection