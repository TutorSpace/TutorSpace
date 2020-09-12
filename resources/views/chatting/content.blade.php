<div class="chatting__content__header">
    <a class="user-name" href="#">
        Shuaiqing Luo
    </a>
    <span class="other-info">
        @if (true)
        @include('partials.svg-tutor-verified')
        @endif
        Beginner Tutor
    </span>
</div>
<div class="chatting__content__messages">
    @include('chatting.chat-message', [
        'myMessage' => false
    ])
    @include('chatting.chat-message', [
        'myMessage' => true
    ])
    @include('chatting.chat-message', [
        'myMessage' => false
    ])
    @include('chatting.chat-message', [
        'myMessage' => true
    ])
    @include('chatting.chat-message', [
        'myMessage' => false
    ])
    @include('chatting.chat-message', [
        'myMessage' => false
    ])
    @include('chatting.chat-message', [
        'myMessage' => true
    ])
</div>
<div class="send-msg-container">
    <h1>here</h1>
</div>
