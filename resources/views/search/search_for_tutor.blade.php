@extends('layouts.loggedin')
@section('title', 'search for tutor')

@section('links-in-head')

<link href='{{asset('packages/core/main.css')}}' rel='stylesheet' />
<link href='{{asset('packages/daygrid/main.css')}}' rel='stylesheet' />
<link href='{{asset('packages/timegrid/main.css')}}' rel='stylesheet' />
<link href='{{asset('packages/bootstrap/main.css')}}' rel='stylesheet' />


<script src='{{asset('packages/core/main.js')}}'></script>
<script src='{{asset('packages/daygrid/main.js')}}'></script>
<script src='{{asset('packages/timegrid/main.js')}}'></script>
<script src='{{asset('packages/interaction/main.js')}}'></script>
<script src='{{asset('packages/bootstrap/main.js')}}'></script>

@endsection

@section('confirm-time-container')
<div id="confirm-time-container" class="calendar-container">
    <div id='calendar'></div>
</div>
@endsection

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
                    <input class="form-check-input" type="checkbox" value="freshman" id="freshman" name="year[]" checked>
                    <label class="form-check-label" for="freshman">
                        Freshman
                    </label>
                </div>
                <div class="form-check filter-year">
                    <input class="form-check-input" type="checkbox" value="sophomore" id="sophomore" name="year[]" checked>
                    <label class="form-check-label" for="sophomore">
                        Sophomore
                    </label>
                </div>
                <div class="form-check filter-year">
                    <input class="form-check-input" type="checkbox" value="junior" id="junior" name="year[]" checked>
                    <label class="form-check-label" for="junior">
                        Junior
                    </label>
                </div>
                <div class="form-check filter-year">
                    <input class="form-check-input" type="checkbox" value="senior" id="senior" name="year[]" checked>
                    <label class="form-check-label" for="senior">
                        Senior
                    </label>
                </div>
                <div class="form-check filter-year">
                    <input class="form-check-input" type="checkbox" value="graduate" id="graduate" name="year[]" checked>
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
            <button class="btn btn-lg btn-outline-primary" type="button">Price</button>
            <div class="filter">
                <label for="price-range-low">Low: <span id="price-range-low-value">10</span></label>
                <input type="range" class="custom-range price-range" min="0" max="20" id="price-range-low" name="price-range-low">

                <label for="price-range-high">High: <span id="price-range-high-value">25</span></label>
                <input type="range" class="custom-range price-range" min="10" max="40" id="price-range-high" name="price-range-high">
                <div class="button-container">
                    <button class="btn btn-outline-primary" id="clear-price" type="button">Clear</button>
                    <button class="btn btn-primary" id="save-price" type="button">Save</button>
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

        <div class="filter-box">
            <button class="btn btn-lg btn-outline-primary" type="button" id="btn-show-calendar">Availability</button>
            <input type="text" id="startTime" name="startTime" class="hidden">
            <input type="text" id="endTime" name="endTime" class="hidden">
        </div>
    </div>



    <div class="search-card-container row mb-5">
        @if(count($results) === 0)
            <h5 class="black">
                There are no matching search results.
            </h5>
        @else
            @foreach ($results as $result)
                @php
                    $resultUser = App\User::find($result->id);
                @endphp
                <div class="search-card-flex-container col-lg-3 col-md-4 col-sm-4 col-6" data-user-id="{{$result->id}}">
                    <div class="search-card">
                        @if($user->bookmarked($result->id))
                            <svg class="bookmark bookmark-marked" data-user-id="{{$result->id}}">
                                <use xlink:href="assets/sprite.svg#icon-bookmark"></use>
                            </svg>
                        @else
                            <svg class="bookmark" data-user-id="{{$result->id}}">
                                <use xlink:href="assets/sprite.svg#icon-bookmark"></use>
                            </svg>
                        @endif
                        <img src="{{asset("user_photos/{$result->profile_pic_url}")}}" alt="user photo" data-user-id="{{$result->id}}">
                        <p class="name">{{$result->full_name}}</p>
                        <p class="major">{{$result->major['major']}}</p>

                        <p class="star-container">${{$result->hourly_rate}} / hr |
                            @if($resultUser->getRating())
                                {{$resultUser->getRating()}}
                                <svg class="star">
                                    <use xlink:href="{{asset('assets/sprite.svg#icon-star')}}"></use>
                                </svg>
                            @else
                            No Rating
                            @endif
                        </p>
                        <p class="courses">Courses:
                            @foreach ($resultUser->courses as $course)
                                {{$course->course}}
                            @endforeach
                        </p>
                        <p class="subjects">Subjects:
                            @foreach ($resultUser->subjects as $subject)
                                {{$subject->subject}}
                            @endforeach
                        </p>
                    </div>
                </div>
            @endforeach
        @endif


    </div>

</form>



@endsection


@section('js')

<script src="{{asset('js/search.js')}}"></script>
<script src="{{asset('js/bookmark.js')}}"></script>
@endsection
