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
                <span class="content-1__content">
                    {{ $notificationHeader }}
                </span>
                <p class="time mb-0">
                    {{ $time }}
                </p>
            </span>
            <span class="content-2">
                {{ $notificationContent }}
            </span>
        </div>
    </div>
</li>
