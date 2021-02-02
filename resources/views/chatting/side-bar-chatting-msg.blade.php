<li class="msg @if(isset($unRead) && $unRead) unread @endif" data-user-id="{{ $user->id }}">
    <div class="box">
        <div class="img-container">
            @if (Illuminate\Support\Str::of($user->profile_pic_url)->contains('placeholder'))
            <div class="placeholder-img">
                <span>{{ strtoupper($user->first_name[0]) . ' ' . strtoupper($user->last_name[0]) }}</span>
            </div>
            @else
            <img src="{{ Storage::url($user->profile_pic_url) }}" alt="user img">
            @endif
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
                {{ $message }}
            </span>
        </div>
    </div>
</li>
