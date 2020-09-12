@extends('layouts.app')

@section('title', 'Chatting')

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

<div class="chatting container-fluid">
    <div class="row chatting-container">
        <div class="chatting__side-bar--left">
            @include('chatting.side-bar--left')
        </div>
        <div class="chatting__content">
            @include('chatting.content')
        </div>
    </div>
</div>

@endsection

@section('js')

<script src="{{ asset('js/chatting/index.js') }}"></script>

@endsection
