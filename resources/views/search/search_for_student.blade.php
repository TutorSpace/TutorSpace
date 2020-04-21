@extends('layouts.loggedin')
@section('title', 'search for student')

@section('content')


<form class="container search-container" method="GET" action="/search">
    <h2 class="search__header">Search Results</h2>
    <div class="search__box">
        <svg>
            <use xlink:href="assets/sprite.svg#icon-magnifying-glass"></use>
        </svg>
        <input type="text" placeholder="Search Names, Courses, Subjects" class="" name="searchInput">
    </div>
    <div class="labels filters-label">Filters</div>

    <div class="filter-container">
        <div class="filter-box">
            <button class="btn btn-lg btn-outline-primary" type="button">Year</button>
            <div class="filter">
                <div class="form-check filter-year">
                    <input class="form-check-input" type="checkbox" value="freshman" id="freshman" name="year">
                    <label class="form-check-label" for="freshman">
                        Freshman
                    </label>
                </div>
                <div class="form-check filter-year">
                    <input class="form-check-input" type="checkbox" value="sophomore" id="sophomore" name="year">
                    <label class="form-check-label" for="sophomore">
                        Sophomore
                    </label>
                </div>
                <div class="form-check filter-year">
                    <input class="form-check-input" type="checkbox" value="junior" id="junior" name="year">
                    <label class="form-check-label" for="junior">
                        Junior
                    </label>
                </div>
                <div class="form-check filter-year">
                    <input class="form-check-input" type="checkbox" value="senior" id="senior" name="year">
                    <label class="form-check-label" for="senior">
                        Senior
                    </label>
                </div>
                <div class="form-check filter-year">
                    <input class="form-check-input" type="checkbox" value="graduate" id="graduate" name="year">
                    <label class="form-check-label" for="graduate">
                        Graduate
                    </label>
                </div>
                <div class="button-container">
                    <button class="btn btn-outline-primary" id="clear-year" type="button">Clear</button>
                    <button class="btn btn-primary" id="save-year" type="button">Save</button>
                </div>
            </div>
        </div>


        <div class="filter-box">
            <button class="btn btn-lg btn-outline-primary" type="button">Rating</button>
            <div class="filter">
                <label for="rating-range-low">Low: <span id="rating-range-low-value">2</span></label>
                <input type="range" class="custom-range rating-range" min="0" max="3" id="rating-range-low" name="rating-range-low">

                <label for="rating-range-high">High: <span id="rating-range-high-value">4</span></label>
                <input type="range" class="custom-range rating-range" min="3" max="5" id="rating-range-high" name="rating-range-high">
                <div class="button-container">
                    <button class="btn btn-outline-primary" id="clear-rating" type="button">Clear</button>
                    <button class="btn btn-primary" id="save-rating" type="button">Save</button>
                </div>
            </div>
        </div>
    </div>


    <div class="search-card-container row mb-5">
        <div class="search-card-flex-container col-4 col-xl-3">
            <div class="search-card">
                <img src="assets/jamie.png" alt="user photo">
                <p class="bold">Jamie C.</p>
                <p>B.S. Astronautical Engineering</p>
                <p class="star-container year">Dec 2021 | 4.5
                    <svg class="star">
                        <use xlink:href="assets/sprite.svg#icon-star" ></use>
                    </svg>
                </p>
                <p class="labels">Courses</p>
                <p class="courses">ITP 104, MATH 210, ASTRO 340...</p>
                <p class="labels">Subjects</p>
                <p class="courses"> Calculus 2, HTML/CSS...</p>
            </div>
        </div>

        <div class="search-card-flex-container col-4 col-xl-3">
            <div class="search-card">
                <img src="assets/sophia.png" alt="user photo">
                <p class="bold">Sophia P.</p>
                <p>B.A. Design</p>
                <p class="star-container year">May 2020 | 4.8
                    <svg class="star">
                        <use xlink:href="assets/sprite.svg#icon-star" ></use>
                    </svg>
                </p>
                <p class="labels">Courses</p>
                <p class="courses">ITP 310, CRIT 350, ART 130...</p>
                <p class="labels">Subjects</p>
                <p class="courses">Art History, HTML/CSS...</p>
            </div>
        </div>

        <div class="search-card-flex-container col-4 col-xl-3">
            <div class="search-card">
                <img src="assets/mj.jpg" alt="user photo">
                <p class="bold">Jeffrey C.</p>
                <p>B.S. Electrical Engineering</p>
                <p class="star-container year">Dec 2021 | 4.5
                    <svg class="star">
                        <use xlink:href="assets/sprite.svg#icon-star" ></use>
                    </svg>
                </p>
                <p class="labels">Courses</p>
                <p class="courses">ITP 104, CRIT 350, DES 302...</p>
                <p class="labels">Subjects</p>
                <p class="courses">Art History, HTML/CSS...</p>
            </div>
        </div>

        <div class="search-card-flex-container col-4 col-xl-3">
            <div class="search-card">
                <img src="assets/mj.jpg" alt="user photo">
                <p class="bold">Jeffrey C.</p>
                <p>B.S. Business Administration</p>
                <p class="star-container year">Dec 2021 | 4.5
                    <svg class="star">
                        <use xlink:href="assets/sprite.svg#icon-star" ></use>
                    </svg>
                </p>
                <p class="labels">Courses</p>
                <p class="courses">ITP 104, CRIT 350, DES 302...</p>
                <p class="labels">Subjects</p>
                <p class="courses">Art History, HTML/CSS...</p>
            </div>
        </div>

        <div class="search-card-flex-container col-4 col-xl-3">
            <div class="search-card">
                <img src="assets/mj.jpg" alt="user photo">
                <p class="bold">Jeffrey C.</p>
                <p>M.S. Sculpture</p>
                <p class="star-container year">Dec 2021 | 4.5
                    <svg class="star">
                        <use xlink:href="assets/sprite.svg#icon-star" ></use>
                    </svg>
                </p>
                <p class="labels">Courses</p>
                <p class="courses">ITP 104, CRIT 350, DES 302...</p>
                <p class="labels">Subjects</p>
                <p class="courses">Art History, HTML/CSS...</p>
            </div>
        </div>

    </div>
</form>



@endsection


@section('js')

<script src="{{asset('js/search.js')}}"></script>

@endsection
