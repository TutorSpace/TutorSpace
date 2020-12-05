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
            <div class="chatting__content__header">
                <a class="user-name invisible" href="#">
                    placeholder
                </a>
                <span class="other-info">
                </span>
            </div>
            <div class="chatting__content__messages">

            </div>
            <div class="chatting__send-msg-container">
                <form class="search-bar-container" action="#" onsubmit="return false;">
                    <input type="text" class="search-bar form-control form-control-lg" placeholder="Type here..." id="msg-to-send" name="msg-to-send">
                    <input type="hidden" value="" name="other-user-id">
                    <button class="btn btn-lg btn-primary btn-send" type="submit">Send</button>
                </form>
            </div>
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
