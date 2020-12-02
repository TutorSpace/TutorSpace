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
        <img src="{{ Storage::url($user->profile_pic_url) }}" alt="user img">
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
