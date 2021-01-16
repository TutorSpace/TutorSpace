@extends('layouts.app')

@section('title', 'Notifications')

@section('links-in-head')
{{-- fullcalendar --}}
<link href='https://use.fontawesome.com/releases/v5.0.6/css/all.css' rel='stylesheet'>
<script src='{{asset('fullcalendar/main.min.js')}}'></script>
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

<div class="notification container-fluid">
    <div class="row notification-container">
        <div class="notification__side-bar--left">
            @include('notification.side-bar--left')
        </div>
        <div class="notification__content" id="notification__content">
            {{-- <div> --}}
                @include('notification.content.sessions.session-complete-tutor')
            {{-- </div> --}}

{{--
            <div>
                @include('notification.content.sessions.session-complete-student')
            </div>
            <div>
                @include('notification.content.sessions.session-cancel')
            </div>
            <div>
                @include('notification.content.sessions.session-decline')
            </div>
            <div>
                @include('notification.content.sessions.session-confirmation-student')
            </div>
            <div>
                @include('notification.content.sessions.session-confirmation-tutor')
            </div>
            <div>
                @include('notification.content.sessions.tutor-request')
            </div>
            <div>
                @include('notification.content.tutorspace.refund-request-initiated')
            </div>
            <div>
                @include('notification.content.tutorspace.refund-request-success')
            </div>
            <div>
                @include('notification.content.tutorspace.refund-request-fail')
            </div>
            <div>
                @include('notification.content.tutorspace.invite-to-be-tutor')
            </div>
            <div>
                @include('notification.content.tutorspace.welcome-msg-student')
            </div>
            <div>
                @include('notification.content.tutorspace.welcome-msg-tutor')
            </div>
            <div>
                @include('notification.content.tutorspace.tutor-verification-initiated')
            </div>
            <div>
                @include('notification.content.tutorspace.tutor-verification-processed')
            </div>
            <div>
                @include('notification.content.tutorspace.payment-fail')
            </div>
            <div>
                @include('notification.content.tutorspace.payment-fail-again')
            </div>
            <div>
                @include('notification.content.tutorspace.session-fee-received')
            </div>
            <div>
                @include('notification.content.tutorspace.tutor-level-up')
            </div>
            <div>
                @include('notification.content.forum.post-reported')
            </div>
            <div>
                @include('notification.content.forum.be-marked-as-best-reply')
            </div> --}}




        </div>
    </div>
</div>

@endsection

@section('js-2')
<script>
    // $('#notification__content > *').addClass('hidden');
    // $(document).on("click",".msgs .msg", function () {
    //     $('#notification__content > *').addClass('hidden');
    //     var children = $('.msgs')[0].children;
    //     for (var i = 0; i < children.length; i++) {
    //         var tableChild = children[i];
    //         if(tableChild == $(this)[0]) {
    //             $(`#notification__content > :nth-child(${i+1})`).removeClass('hidden');
    //         }
    //     }
    // });
</script>
@endsection
