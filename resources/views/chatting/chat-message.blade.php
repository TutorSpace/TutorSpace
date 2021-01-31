@if ($myMessage)
<div class="message message--self">
    <div class="time-container">
        {{ $time }}
    </div>
    <div class="message-content-container">
        {{ $content }}
    </div>
</div>
@else
<div class="message message--other">
    <div class="img-container">
        @if (Illuminate\Support\Str::of($user->profile_pic_url)->contains('placeholder'))
        <div class="user-img placeholder-img">
            <span>{{ strtoupper($user->first_name[0]) . ' ' . strtoupper($user->last_name[0]) }}</span>
        </div>
        @else
        <img src="{{ Storage::url($user->profile_pic_url) }}" alt="user img" class="user-img">
        @endif
    </div>
    <div class="message-content-container">
        <span class="content">
            {{ $content }}
        </span>
    </div>
    <div class="time-container">
        {{ $time }}
    </div>
</div>
@endif
