<h4 class="heading">Message</h4>
<form class="search-bar-container" method="GET" action="#">
    <input type="text" class="search-bar form-control form-control-lg" placeholder="Search...">
    <svg>
        <use xlink:href="{{asset('assets/sprite.svg#icon-magnifying-glass')}}"></use>
    </svg>
</form>
<ul class="msgs">
    @foreach (Auth::user()->getChatrooms() as $chatroom)
        @include('chatting.side-bar-chatting-msg', [
            'unRead' => true,
            'time' => "5:38pm",
            'user' => App\User::find(Auth::id() == $chatroom->user_id_1 ? $chatroom->user_id_2 : $chatroom->user_id_1)
        ])
    @endforeach
</ul>
