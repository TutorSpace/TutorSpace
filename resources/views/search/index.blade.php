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
    <div class="row">

    </div>
</div>

@include('partials.footer')

@endsection

@section('js')
@include('partials.nav-auth-js')
<script src="{{ asset('js/search/index.js') }}"></script>
@endsection
