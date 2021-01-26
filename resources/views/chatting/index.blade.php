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

<div class="chatting container-lg">
    <div class="row chatting-container">
        <div class="chatting__side-bar--left">
            @include('chatting.side-bar--left')
        </div>
        <div class="chatting__content">
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
    var pusher = new Pusher('d8a4fc3115898457a40f', {
        cluster: 'us3',
        authEndpoint: '/broadcasting/auth',
        encrypted: true,
        auth: {
            headers: {
                'X-CSRF-Token': $("meta[name=csrf-token]").attr('content')
            }
        }
    });

    // subscribe to listen to new chatrooms
    (function subscribeChatroom() {
        var channel = pusher.subscribe("private-" + "{{ App\Chatroom::getChannelName() }}");
        channel.bind('NewChatroom', function(data) {
            subscribeNewMessageChannel(data.otherUserId);
        });
    })();

    // todo: debug this when there
    // subscribe to listen to new messages for existing chatrooms
    @foreach (Auth::user()->getChatrooms() as $chatroom)
        @php
            $otherUserId = Auth::id() == $chatroom->user_id_1 ? $chatroom->user_id_2 : $chatroom->user_id_1;
        @endphp
        subscribeNewMessageChannel("{{ $otherUserId }}");
    @endforeach

    function subscribeNewMessageChannel(otherUserId) {
        // subscribe to the channel
        let channelName = currentUserId < otherUserId ? `private-message.${currentUserId}.${otherUserId}` : `private-message.${otherUserId}.${currentUserId}`;

        var channel = pusher.subscribe(channelName);
        channel.bind('NewMessage', function(data) {
            let {from, to, message, created_at, chatroomView, imgUrl} = data;
            let currentlyViewingId = $('.msg .box.bg-grey-light').closest('.msg').attr('data-user-id');

            let currentViewing = currentlyViewingId == from || currentlyViewingId == to;

            if(currentViewing) {
                if(from == currentlyViewingId && to == currentUserId) {
                    appendOtherMessage(message, created_at, imgUrl);
                    scrollToBottom();
                } else if(from == currentUserId && to == currentlyViewingId) {
                    // appendMyMessage(message, created_at);
                    // scrollToBottom();
                }
            } else {
                if(!$(`.msg[data-user-id=${otherUserId}]`)[0]) {
                    $('.msgs').append(chatroomView);
                }
                $(`.msg[data-user-id=${otherUserId}]`).addClass('unread');
            }

            $(`.msg[data-user-id=${otherUserId}] .content-2`).html(message);
            $(`.msg[data-user-id=${otherUserId}] .time`).html(created_at);
        });
    }

    $('.msgs').on('click', '.msg', function () {
        $('.msg .box').removeClass('bg-grey-light');
        $('.msg').removeClass('bg-grey-light');
        $(this).find('.box').addClass('bg-grey-light');
        $(this).addClass('bg-grey-light');
        let otherUserId = $(this).attr('data-user-id');
        JsLoadingOverlay.show(jsLoadingOverlayOptions);
        $.ajax({
            type:'GET',
            url: '/chatting/get-messages',
            data: {
                'userId': otherUserId
            },
            success: (data) => {
                $(this).removeClass('unread');
                $('.chatting__content').html(data);
                scrollToBottom();
                appendSendMsgFunc();
            },
            complete: () => {
                JsLoadingOverlay.hide();
            }
        });
    });

    @if(isset($toViewOtherUserId))
    $(".msg[data-user-id={{ $toViewOtherUserId }}]").click();
    @endif

    function scrollToBottom() {
        $('.chatting__content__messages').scrollTop($('.chatting__content__messages')[0].scrollHeight);
    }

    function appendSendMsgFunc() {
        // sending messages
        $('#msg-form').submit(function() {
            if($('#msg-to-send').val()) {
                $.ajax({
                    type:'POST',
                    url: '/chatting/send-msg',
                    data: $('#msg-form').serialize(),
                    success: (data) => {

                    },
                    error: (err) => {
                        toastr.error('Something went wrong when sending message. Please contact tutorspacehelp@gmail.com for more details.')
                        console.log(err);
                    }
                });
                appendMyMessage($('#msg-to-send').val(), moment().format('YYYY-MM-DD H:mm:ss'));
                scrollToBottom();
                $('#msg-to-send').val('');
            }
            return false;
        });
    }

    function appendMyMessage(message, time) {
        // append my own message
        let el =
        `<div class="message message--self">
            <div class="time-container">
                ${time}
            </div>
            <div class="message-content-container">
                ${message}
            </div>
        </div>`;

        $('.chatting__content__messages').append(el);
    }

    function appendOtherMessage(message, time, imgUrl) {
        // append other's message
        let el =
        `<div class="message message--other">
            <div class="img-container">
                <img src="${imgUrl}" alt="user img">
            </div>
            <div class="message-content-container">
                <span class="content">
                    ${message}
                </span>
            </div>
            <div class="time-container">
                ${time}
            </div>
        </div>`;

        $('.chatting__content__messages').append(el);
    }
</script>
<script src="{{ asset('js/chatting/index.js') }}"></script>

@endsection
