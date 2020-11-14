<li class="msg @if(isset($unRead) && $unRead) unread @endif">
    <div class="box">
        <div class="img-container">
            <img src="{{ Storage::url($user->profile_pic_url) }}" alt="user img">
        </div>
        <div class="content-container">
            <span class="content-1">
                <span class="content-1__content">
                    {{ $user->first_name }}
                    {{ $user->last_name }}
                </span>
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
