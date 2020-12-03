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
        'myMessage' => false,
        'content' => "Lorem  ullam vel fugiat odit aliquid asperiores cum?",
        'time' => '5:38pm'
    ])
    @include('chatting.chat-message', [
        'myMessage' => true,
        'content' => "Lolor sit amet consectetur adipisicing elit. Quis unde tenetur tempore expedita corrupti eos esse in nobis susc sint voluptatem quas.",
        'time' => '9/2/20'
    ])
    @include('chatting.chat-message', [
        'myMessage' => false,
        'content' => "Ut aliqua officia do reprehenderit cillum adipisicing esse in excepteur anim nisi exercitation aute.",
        'time' => '9/3/20'
    ])
    @include('chatting.chat-message', [
        'myMessage' => true,
        'content' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis unde tenetur minus sint voluptatem quas.",
        'time' => '9/2/20'
    ])
    @include('chatting.chat-message', [
        'myMessage' => false,
        'content' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis unde tenetur tempore expedita corrupti eos esse in nobis suscipit repudiandae ad minima magni doloribus sit, beatae minus sint voluptatem quas.",
        'time' => '9/2/20'
    ])
    @include('chatting.chat-message', [
        'myMessage' => false,
        'content' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis unde tenetur tempore expedita corrupti eos esse in nobis suscipit repudiandae ad minima magni doloribus sit, beatae minus sint voluptatem quas.",
        'time' => '8/2/20'
    ])
    @include('chatting.chat-message', [
        'myMessage' => true,
        'content' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis unde tenerepudiandae ad minima magni doloribus sit, beatae minus sint voluptatem quas.",
        'time' => '8/1/20'
    ]),
    @include('chatting.chat-message', [
        'myMessage' => true,
        'content' => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis fugiat laborum vero mollitia praesentium ut aliquam vel quam quos omnis neque voluptate illum magni, dolorem cum. Aut quis vero consequuntur?",
        'time' => '9/2/20'
    ])
</div>
<div class="chatting__send-msg-container">
    <form class="search-bar-container" method="GET" action="#">
        <input type="text" class="search-bar form-control form-control-lg" placeholder="Type here...">
        <button class="btn btn-lg btn-primary btn-send" type="button">Send</button>
    </form>
</div>
