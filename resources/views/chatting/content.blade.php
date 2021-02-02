<div class="chatting__content__header">
    <a class="user-name" href="{{ route('view.profile', $user) }}">
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
    @if ((!Auth::check() || !Auth::user()->is_tutor) && $user->is_tutor)
    <a class="btn btn-request btn-primary" href="{{ route('view.profile', $user->id) . '?request=true' }}" target="_blank">
        Request a Session
    </a>
    @else
    <a class="btn btn-view btn-primary" href="{{ route('view.profile', $user->id) }}" target="_blank">
        View Profile
    </a>
    @endif
</div>
<div class="chatting__content__messages">
    @php
    $tz = App\CustomClass\TimeFormatter::getTZ();
    @endphp
    @foreach (Auth::user()->getMessages($user) as $message)
        @include('chatting.chat-message', [
            'myMessage' => $message->from == Auth::id(),
            'content' => $message->message,
            'time' => $message->created_at->setTimeZone($tz),
            'user' => $user
        ])
    @endforeach
</div>
<div class="chatting__send-msg-container">
    <form class="search-bar-container" id="msg-form" method="POST">
        <input type="text" class="search-bar form-control form-control-lg" placeholder="Type here..." id="msg-to-send" name="msg-to-send">
        <input type="hidden" value="{{ $user->id }}" name="other-user-id">
        <button class="btn btn-lg btn-primary btn-send" type="submit">Send</button>
        <input type="hidden" name="tz" value="" id="tz">
    </form>
</div>
