<div class="chatting__content__header">
    <a class="user-name" href="#">
        {{ $user->first_name }} {{ $user->last_name }}
    </a>
    <span class="other-info">
        @if ($user->is_tutor_verified)
        @include('partials.svg-tutor-verified')
        @endif

        @if ($user->is_tutor)
        {{ $user->tutorLevel->tutor_level }} Tutor
        @endif
    </span>
</div>
<div class="chatting__content__messages">
    @foreach (Auth::user()->getMessages($user) as $message)
        @include('chatting.chat-message', [
            'myMessage' => $message->from == Auth::user()->id,
            'content' => $message->message,
            'time' => $message->created_at,
            'user' => $user
        ])
    @endforeach
</div>
<div class="chatting__send-msg-container">
    <form class="search-bar-container" id="msg-form" method="POST">
        <input type="text" class="search-bar form-control form-control-lg" placeholder="Type here..." id="msg-to-send" name="msg-to-send">
        <input type="hidden" value="{{ $user->id }}" name="other-user-id">
        <button class="btn btn-lg btn-primary btn-send" type="submit">Send</button>
    </form>
</div>
