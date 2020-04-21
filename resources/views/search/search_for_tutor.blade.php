@extends('layouts.loggedin')
@section('title', 'search for tutor')

@section('content')


<div class="container search-container">
    <h2 class="search__header">Search Results</h2>
    <div class="search__box">
        <svg>
            <use xlink:href="assets/sprite.svg#icon-magnifying-glass"></use>
        </svg>
        <input type="text" placeholder="Search Names, Courses, Subjects" class="">
    </div>
    <div class="labels filters-label">Filters</div>

    <div class="filter-container">
        <div class="filter-box">
            <button class="btn btn-lg btn-outline-primary">Year</button>
            <div class="filter">
                <div class="form-check filter-year">
                    <input class="form-check-input" type="checkbox" value="" id="freshman">
                    <label class="form-check-label" for="freshman">
                        Freshman
                    </label>
                </div>
                <div class="form-check filter-year">
                    <input class="form-check-input" type="checkbox" value="" id="sophomore">
                    <label class="form-check-label" for="sophomore">
                        Sophomore
                    </label>
                </div>
                <div class="form-check filter-year">
                    <input class="form-check-input" type="checkbox" value="" id="junior">
                    <label class="form-check-label" for="junior">
                        Junior
                    </label>
                </div>
                <div class="form-check filter-year">
                    <input class="form-check-input" type="checkbox" value="" id="senior">
                    <label class="form-check-label" for="senior">
                        Senior
                    </label>
                </div>
                <div class="form-check filter-year">
                    <input class="form-check-input" type="checkbox" value="" id="graduate">
                    <label class="form-check-label" for="graduate">
                        Graduate
                    </label>
                </div>
                <div class="button-container">
                    <button class="btn btn-outline-primary" id="clear-year">Clear</button>
                    <button class="btn btn-primary" id="save-year">Save</button>
                </div>

            </div>
        </div>

        <div class="filter-box">
            <button class="btn btn-lg btn-outline-primary">Price</button>
            <div class="filter">
                <label for="price-range-low">Low: <span id="price-range-low-value">10</span></label>
                <input type="range" class="custom-range price-range" min="0" max="20" id="price-range-low">

                <label for="price-range-high">High: <span id="price-range-high-value">25</span></label>
                <input type="range" class="custom-range price-range" min="10" max="40" id="price-range-high">
                <div class="button-container">
                    <button class="btn btn-outline-primary" id="clear-price">Clear</button>
                    <button class="btn btn-primary" id="save-price">Save</button>
                </div>
            </div>


        </div>

        <div class="filter-box">
            <button class="btn btn-lg btn-outline-primary">Rating</button>
            <div class="filter">
                <label for="rating-range-low">Low: <span id="rating-range-low-value">2</span></label>
                <input type="range" class="custom-range rating-range" min="0" max="3" id="rating-range-low">

                <label for="rating-range-high">High: <span id="rating-range-high-value">4</span></label>
                <input type="range" class="custom-range rating-range" min="3" max="5" id="rating-range-high">
                <div class="button-container">
                    <button class="btn btn-outline-primary" id="clear-rating">Clear</button>
                    <button class="btn btn-primary" id="save-rating">Save</button>
                </div>
            </div>
        </div>

        <div class="filter-box">
            <button class="btn btn-lg btn-outline-primary">Availability</button>
            <div class="filter">
                <span class="text-danger" style="font-size: 2rem;">The Availability Functionality is coming soon!</span>
            </div>
        </div>
    </div>



    <div class="search-card-container row">
        <div class="search-card-flex-container col-lg-3 col-md-4 col-sm-4 col-6">
            <div class="search-card">
                <svg class="bookmark bookmark-marked">
                    <use xlink:href="assets/sprite.svg#icon-bookmark"></use>
                </svg>
                <img src="{{asset('assets/mj.jpg')}}" alt="user photo">
                <p class="name">Jeffrey Miller</p>
                <p class="major">Chemical Engineering</p>
                <p class="star-container">$16/hr | 4.5
                    <svg class="star">
                        <use xlink:href="{{asset('assets/sprite.svg#icon-star')}}"></use>
                    </svg>
                </p>
                <p class="courses">Courses: ITP 104, CRIT 350, DES 302,  ITP 104, CRIT 350, DES 302</p>
                <p class="subjects">Subjects: Art History, HTML/CSS, HTML/CSS. HTML/CSS. HTML/CSS,HTML/CSS</p>
            </div>
        </div>
        <div class="search-card-flex-container col-lg-3 col-md-4 col-sm-4 col-6">
            <div class="search-card">
                <svg class="bookmark bookmark-marked">
                    <use xlink:href="assets/sprite.svg#icon-bookmark"></use>
                </svg>
                <img src="{{asset('assets/mj.jpg')}}" alt="user photo">
                <p class="name">Jeffrey Miller</p>
                <p class="major">Chemical Engineering</p>
                <p class="star-container">$16/hr | 4.5
                    <svg class="star">
                        <use xlink:href="{{asset('assets/sprite.svg#icon-star')}}"></use>
                    </svg>
                </p>
                <p class="courses">Courses: ITP 104, CRIT 350, DES 302,  ITP 104, CRIT 350, DES 302</p>
                <p class="subjects">Subjects: Art History, HTML/CSS, HTML/CSS. HTML/CSS. HTML/CSS,HTML/CSS</p>
            </div>
        </div>


    </div>
</div>



@endsection


@section('js')

<script src="{{asset('js/search.js')}}"></script>

@endsection
