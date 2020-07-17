@extends('layouts.app')

@section('title', 'Search Results')


@section('body-class')
bg-white-dark-4

@if(Auth::check() && Auth::user()->is_tutor)
bg-tutor
@else
bg-student
@endif

@endsection

@section('content')

@include('partials.nav')



<div class="container search">
    <h4 class="ml-2">
        Search Results ({{ session()->has('users') ? session()->get('users')->count() : 0 }})
    </h4>
    <div class="row mt-5">
        <div class="col-lg-4">
            {{-- filter --}}
            <form class="filter p-relative fc-black bg-white-dark-5" method="POST" action="{{ route('search.search') }}">
                @csrf
                @if ($errors->filter->any())
                    <p class="fs-1-4 fc-red text-right">
                        {{ $errors->filter->first() }}
                    </p>
                @endif
                <span class="filter-heading">
                    <svg class="mr-2" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <rect width="15" height="15" fill="url(#pattern15)" fill-opacity="0.6"/>
                        <defs>
                        <pattern id="pattern15" patternContentUnits="objectBoundingBox" width="1" height="1">
                        <use xlink:href="#image15" transform="scale(0.00195312)"/>
                        </pattern>
                        <image id="image15" width="512" height="512" xlink:href="data:image/png;base64,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"/>
                        </defs>
                    </svg>
                    <span class="mr-auto">Filter</span>
                    <button class="btn btn-link btn-hide" type="button">show</button>
                </span>

                <div class="flex__content">
                    <hr>
                    <div class="filter__available-time">
                        <span class="filter-heading--2">
                            Available Time
                        </span>

                        <div class="filter__inputs mt-3">
                            <div class="filter__input-container">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-calendar" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1zm1-3a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2z"/>
                                    <path fill-rule="evenodd" d="M3.5 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5zm9 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5z"/>
                                </svg>
                                <input type="text" id="start-date" class="filter__input" placeholder="Start Date" name="available-start-date" value="{{ old('available-start-date') }}">
                            </div>

                            <span class="separator">to</span>

                            <div class="filter__input-container">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-calendar" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1zm1-3a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2z"/>
                                    <path fill-rule="evenodd" d="M3.5 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5zm9 0a.5.5 0 0 1 .5.5V1a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 .5-.5z"/>
                                </svg>
                                <input type="text" id="end-date" class="filter__input" placeholder="End Date" name="available-end-date" value="{{ old('available-end-date') }}">
                            </div>
                        </div>

                        <div class="filter__checkboxes filter__checkboxes--available-time @if(!old('available-start-date') && !old('available-end-date') && !old('available-time-range') && !old('available-start-time') && !old('available-end-time')) hidden-2 @endif">
                            <div class="top-3">
                                <div class="filter__checkbox mt-3">
                                    <input type="checkbox" id="checkbox-morning" class="checkbox-range" name="available-time-range" value="morning"
                                    @if (old('available-time-range') == 'morning')
                                        checked
                                    @endif
                                    >
                                    <label for="checkbox-morning">
                                        Morning
                                    </label>
                                </div>

                                <div class="filter__checkbox mt-3">
                                    <input type="checkbox" id="checkbox-afternoon" class="checkbox-range"
                                    name="available-time-range" value="afternoon"
                                    @if (old('available-time-range') == 'afternoon')
                                        checked
                                    @endif
                                    >
                                    <label for="checkbox-afternoon">
                                        Afternoon
                                    </label>
                                </div>

                                <div class="filter__checkbox mt-3">
                                    <input type="checkbox" id="checkbox-night" class="checkbox-range" name="available-time-range" value="night"
                                    @if (old('available-time-range') == 'night')
                                        checked
                                    @endif
                                    >
                                    <label for="checkbox-night">
                                        Night
                                    </label>
                                </div>
                            </div>

                            <div>
                                <div class="filter__checkbox mt-3">
                                    <input type="checkbox" id="checkbox-any-time"
                                    name="available-time-range" value="anytime"
                                    @if (old('available-time-range') == 'anytime')
                                        checked
                                    @endif
                                    >
                                    <label for="checkbox-any-time">
                                        Any time is fine for me.
                                    </label>
                                </div>

                                <div class="filter__checkbox mt-3">
                                    <input type="checkbox" id="checkbox-specify-detail-time"
                                    name="available-time-range" value="specify-time"
                                    @if (old('available-time-range') == 'specify-time')
                                        checked
                                    @endif
                                    >
                                    <label for="checkbox-specify-detail-time">
                                        I want to specify a time.
                                    </label>
                                </div>
                            </div>

                        </div>

                        <div class="filter__inputs mt-3
                        @if (old('available-time-range') != 'specify-time')
                            hidden
                        @endif
                        " id="select-detail-time">
                            <div class="filter__input-container">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-clock" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm8-7A8 8 0 1 1 0 8a8 8 0 0 1 16 0z"/>
                                    <path fill-rule="evenodd" d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z"/>
                                </svg>
                                <input type="text" id="start-time" class="filter__input ui-timepicker-input" placeholder="Start Time"
                                name="available-start-time"
                                value="{{ old('available-start-time') }}"
                                >
                            </div>

                            <span class="separator">to</span>

                            <div class="filter__input-container">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-clock" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm8-7A8 8 0 1 1 0 8a8 8 0 0 1 16 0z"/>
                                    <path fill-rule="evenodd" d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z"/>
                                </svg>
                                <input type="text" id="end-time" class="filter__input ui-timepicker-input" placeholder="End Time"
                                name="available-end-time"
                                value="{{ old('available-end-time') }}"
                                >
                            </div>
                        </div>
                    </div>


                    <div class="filter__price">
                        <span class="filter-heading--2">
                            Price
                        </span>

                        <input id="price-range-input" type="text"/>

                        <div class="filter__inputs mt-3">
                            <div class="filter__input-container">
                                <svg>
                                    <use xlink:href="{{asset('assets/sprite.svg#icon-dollar')}}"></use>
                                </svg>
                                <input type="number" class="filter__input" placeholder="Minimum" id="price-low"
                                min="10" max="50"
                                name="price-low"
                                value="{{ old('price-low') }}">
                            </div>

                            <span class="separator">to</span>

                            <div class="filter__input-container">
                                <svg>
                                    <use xlink:href="{{asset('assets/sprite.svg#icon-dollar')}}"></use>
                                </svg>
                                <input type="number" class="filter__input" placeholder="Maximum" id="price-high" min="10" max="50"
                                name="price-high"
                                value="{{ old('price-high') }}"
                                >
                            </div>
                        </div>
                    </div>

                    <div class="filter__tutor-level">
                        <span class="filter-heading--2">
                            Tutor Level
                        </span>

                        <div class="filter__checkboxes">
                            @foreach (App\TutorLevel::all() as $tutorLevel)
                            <div class="filter__checkbox mt-2">
                                <input type="checkbox" name="tutor-level[]" value="{{ $tutorLevel->id }}" id="checkbox-{{ $tutorLevel->tutor_level }}"
                                @if (old('tutor-level') && in_array($tutorLevel->id, old('tutor-level')))
                                    checked
                                @endif
                                >
                                <label for="checkbox-{{ $tutorLevel->tutor_level }}">
                                    {{ $tutorLevel->tutor_level }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="text-right mt-3">
                        <button class="btn btn-lg btn-submit" type="submit">
                            Apply
                        </button>
                    </div>
                </div>

                <input type="hidden" name="nav-search-content" id="search-content">
            </form>

        </div>

        {{-- search results --}}
        <div class="col">
            <div class="search-results">
                @include('search.search-result')
            </div>
        </div>
    </div>
</div>

@include('partials.footer')

@endsection

@section('js')
@include('partials.nav-auth-js')
<script src="{{ asset('js/search/index.js') }}"></script>

<script>
    $("#price-range-input").slider('setValue', [
        parseInt({{ old('price-low') }}),
        parseInt({{ old('price-high') }})
    ]);
</script>
@endsection
