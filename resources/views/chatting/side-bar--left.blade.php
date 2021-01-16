<div class="heading-container">
    <h4 class="heading">Messages</h4>
</div>
{{-- <form class="search-bar-container" method="GET" action="#">
    <input type="text" class="search-bar form-control form-control-lg" placeholder="Search...">
    <svg>
        <use xlink:href="{{asset('assets/sprite.svg#icon-magnifying-glass')}}"></use>
    </svg>
</form> --}}
<ul class="msgs">
    @foreach (Auth::user()->getChatrooms() as $chatroom)
        @php
            $otherUserId = Auth::id() == $chatroom->user_id_1 ? $chatroom->user_id_2 : $chatroom->user_id_1;
        @endphp
        @if ($chatroom->hasMessages())
            @include('chatting.side-bar-chatting-msg', [
                'unRead' => App\Chatroom::haveUnreadMessagesWith($otherUserId),
                'time' => $chatroom->getLatestMessageTime(),
                'user' => App\User::find($otherUserId),
                'message' => $chatroom->getLatestMessage()
            ])
        @elseif($chatroom->creator_user_id == Auth::id())
            @include('chatting.side-bar-chatting-msg', [
                'unRead' => false,
                'time' => '',
                'user' => App\User::find($otherUserId),
                'message' => ''
            ])
        @endif
    @endforeach
</ul>
