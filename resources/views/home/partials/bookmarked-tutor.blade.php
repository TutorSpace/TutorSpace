<div class="bookmarked-user @if(isset($hidden) && $hidden) hidden @endif" @if(isset($hidden) && $hidden) data-to-hide="true" @endif" data-user-id="{{ $user->id }}">
    @if (Illuminate\Support\Str::of($user->profile_pic_url)->contains('placeholder'))
    <div class="user-img placeholder-img">
        <span>{{ strtoupper($user->first_name[0]) . ' ' . strtoupper($user->last_name[0]) }}</span>
    </div>
    @else
    <img src="{{ Storage::url($user->profile_pic_url) }}" alt="bookmarked user" class="user-img">
    @endif

    <div class="bookmarked-user__content">
        <a class="user-name fc-black-2" href="{{ route('view.profile', $user) }}">{{ $user->first_name }} {{ $user->last_name }}</a>
        <div class="buttons">
            <a class="btn btn-outline-primary" href="{{ $user->getChattingRoute() }}">Message</a>
            <a class="btn btn-primary" href="{{ route('view.profile', $user->id) . '?request=true' }}">Request</a>
        </div>
    </div>
</div>
