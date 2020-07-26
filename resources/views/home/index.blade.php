@extends('layouts.app')

@section('title', 'Home')

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

<div class="container-fluid home">
    @include('home.partials.header')

    <main class="container home__content">
        @if (Auth::user()->is_tutor)
        <div class="row">
            <h5 class="mb-2 w-100">You Have 2 New Tutor Requests!</h5>
            <div class="info-boxes">
                @include('home.partials.tutor_request', ['isNotification' => true])
            </div>
        </div>

        <div class="row">
            <h5 class="mb-2 w-100">Calendar</h5>

        </div>




        @else

        @endif
    </main>

</div>



@include('partials.footer')

@endsection

@section('js')

@include('partials.nav-auth-js')
<script src="{{ asset('js/home/index.js') }}"></script>
@endsection
