@extends('layouts.app')

@section('title', 'Dashboard - Profile Settings')

@section('body-class')
bg-white-dark-4

@if(Auth::check() && Auth::user()->is_tutor)
bg-tutor
@else
bg-student
@endif

@endsection

@section('links-in-head')
{{-- fullcalendar --}}
<link href='https://use.fontawesome.com/releases/v5.0.6/css/all.css' rel='stylesheet'>
<link href='{{asset('fullcalendar/main.min.css')}}' rel='stylesheet' />
<script src='{{asset('fullcalendar/main.min.js')}}'></script>
@endsection

@section('content')

@include('partials.nav')

<div class="container-fluid home p-relative">
    @include('home.partials.menu_bar')
    <main class="home__content">
        <div class="container home__header-container">
            <div class="heading-container">
                <p class="heading">Profile Settings</p>
                <span>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed enim blanditiis ipsam nesciunt quia culpa eaque eligendi
                </span>
            </div>
        </div>

        <form class="container profile">
            <div class="row">
                <h5 class="w-100 profile__heading">Personal Information</h5>
                <div class="profile__form-row">
                    <div>
                        <label for="" class="profile__label">First Name</label>
                        <input type="text" class="profile__input form-control form-control-lg" placeholder="Shuaiqing" readonly>
                    </div>
                    <div>
                        <label for="" class="profile__label">Last Name</label>
                        <input type="text" class="profile__input form-control form-control-lg" placeholder="Luo" disabled readonly>
                    </div>
                </div>

                <div class="profile__form-row mt-3">
                    <div>
                        <label for="" class="profile__label">First Major</label>
                        <input type="text" class="profile__input form-control form-control-lg" value="Computer Science">
                    </div>
                    <div>
                        <label for="" class="profile__label">Second Major (optional)</label>
                        <input type="text" class="profile__input form-control form-control-lg" value="">
                    </div>
                    <div>
                        <label for="" class="profile__label">Minor (optional)</label>
                        <input type="text" class="profile__input form-control form-control-lg" value="">
                    </div>
                </div>

                <div class="profile__form-row mt-3">
                    <div>
                        <label for="" class="profile__label">Class Standing</label>
                        <input type="text" class="profile__input form-control form-control-lg" value="Junior">
                    </div>
                    <div class="gpa">
                        <label for="" class="profile__label">GPA</label>
                        <input type="text" class="profile__input form-control form-control-lg" value="4.0">
                    </div>
                </div>

                <h5 class="w-100 profile__heading">Tutor Information</h5>
                <div class="profile__form-row">
                    <div>
                        <label for="" class="profile__label">Courses you would like to tutor</label>
                        <input type="text" class="profile__input form-control form-control-lg" value="">
                    </div>
                    <div class="hourly-rate">
                        <label for="" class="profile__label">Hourly Rate</label>
                        <input type="text" class="profile__input form-control form-control-lg" value="18">
                    </div>
                </div>
            </div>
        </form>


    </main>

</div>


@endsection

@section('js')

<script src="{{ asset('js/home/index.js') }}"></script>
@endsection
