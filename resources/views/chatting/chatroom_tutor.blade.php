@extends('layouts.loggedin')
@section('title', 'chatting room')

@section('links-in-head')
<script src="https://js.pusher.com/6.0/pusher.min.js"></script>
@endsection

@section('content')
<div class="container">
    <div class="m-header-container">
        <h2>Messages
            {{-- for unread messages --}}
            {{-- <span>(10)</span> --}}
        </h2>
    </div>

    <div class="row">
        <div class="col-4 m-left-container">
            <form class="search-messages-container" method="GET" action="#" id="form-search-message">
                <svg>
                    <use xlink:href="assets/sprite.svg#icon-magnifying-glass"></use>
                </svg>
                <input type="text" class="search-messages" placeholder="Search Messages">
            </form>

            <table class="table table-hover messages-table-left">
                <tbody>

                    @foreach ($chatrooms as $chatroom)
                    @php
                        $otherUser = $chatroom->user_id_1 == Auth::id() ? App\User::find($chatroom->user_id_2) : App\User::find($chatroom->user_id_1);

                        // only for tutor
                        $tutorRequest = App\Tutor_request::where('tutor_id', '=', $user->id)
                                        ->where('student_id', '=', $otherUser->id)->first();

                        $unread = $chatroom->haveUnreadMessages($user->id, $otherUser->id);
                    @endphp
                        <tr data-user-id="{{$otherUser->id}}">
                            <td class="{{$unread ? 'unread' : ''}}">
                                <div class="messages-table-left-top">
                                    <span class="name">{{$otherUser->full_name}}</span>
                                    @if($tutorRequest)
                                        <span class="request-pending" data-request-id="{{$tutorRequest->id}}">Request Pending</span>
                                    @endif
                                </div>
                                {{-- for displaying time --}}
                                {{-- <span class="time">{{$chatroom->getLatestMessageTime() ?? 'No Messages'}}</span> --}}
                                <span class="time">{{$chatroom->getLatestMessageTime() ? date('Y-m-d h:i', strtotime($chatroom->getLatestMessageTime())) : 'No Messages'}}</span>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <div class="col-8 m-right-container">

            <div class="message-input-container">
                <input type="text" class="message-input" id="msg-to-send" placeholder="Type a message..." onkeydown="sendMessageEnter(event)">
                <button id="btn-send-msg" onclick="sendMessage()">Send</button>
            </div>
        </div>
    </div>

</div>

@endsection



@section('js')
<!-- defined javascript -->
<script src="{{asset("js/messages.js")}}"></script>
<script>

</script>
@endsection




