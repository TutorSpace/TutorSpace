@extends('layouts.app')

@section('title', 'Chatting')

@section('links-in-head')
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
@endsection

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
            {{-- @include('chatting.content', [
                'user' => App\User::find(Auth::user()->getChatrooms()[0]->user_id_1 == Auth::id() ? Auth::user()->getChatrooms()[0]->user_id_2 : Auth::user()->getChatrooms()[0]->user_id_1)
            ]) --}}
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    let currentUserId = "{{ Auth::id() }}";
</script>
<script src="{{ asset('js/chatting/index.js') }}"></script>

@endsection
