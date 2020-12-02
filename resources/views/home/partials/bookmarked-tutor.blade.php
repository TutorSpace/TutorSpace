<div class="bookmarked-user @if(isset($hidden) && $hidden) hidden @endif" @if(isset($hidden) && $hidden) data-to-hide="true" @endif" data-user-id="{{ $user->id }}">
    <img src="{{ Storage::url($user->profile_pic_url) }}" alt="bookmarked user">
    <div class="bookmarked-user__content">
        <span class="user-name">{{ $user->first_name }} {{ $user->last_name }}</span>
        <div class="buttons">
            <a class="btn btn-outline-primary" href="{{ route('chatting.index') }}">Message</a>
            <a class="btn btn-primary" href="{{ route('view.profile', $user->id) }}">Request</a>
        </div>
    </div>
</div>
