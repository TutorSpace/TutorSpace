<li class="msg @if(isset($unRead) && $unRead) unread @endif">
    <div class="box">
        <div class="img-container">
            @if ($notificationType == 'sessions')
            <div class="bg-color-notification--sessions"></div>
            @elseif($notificationType == 'forum')
            <div class="bg-color-notification--forum"></div>
            @elseif($notificationType == 'tutorspace')
            <div class="bg-color-notification--tutorspace"></div>
            @endif
        </div>
        <div class="content-container">
            <span class="content-1">
                <span class="user-name">Shuaiqing Luodgsdhgdlshglsdgdslkghshglhsdgldshgls</span>
                <p class="time mb-0">
                    {{ $time }}
                </p>
            </span>
            <span class="content-2">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima beatae veritatis aperiam laudantium. Voluptatibus doloremque ad ipsa, asperiores necessitatibus totam quaerat quia aliquam, adipisci, mollitia cum nemo enim? Accusamus, aut?
            </span>
        </div>
    </div>
</li>
