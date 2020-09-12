@if ($myMessage)
<div class="message message--self">
    <div class="img-container">
        <img src="{{ Storage::url(Auth::user()->profile_pic_url) }}" alt="user img">
    </div>
    <div class="message-content-container">
        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsum atque doloremque autem modi dolores nihil nisi eos dolore voluptatibus cum, in explicabo, cumque non sit earum ratione culpa praesentium ea!
    </div>
    <div class="time-container">
        5:38pm
    </div>
</div>
@else
<div class="message message-other">
    <div class="img-container">
        <img src="{{ Storage::url(Auth::user()->profile_pic_url) }}" alt="user img">
    </div>
    <div class="message-content-container">
        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsum atque doloremque autem modi dolores nihil nisi eos dolore voluptatibus cum, in explicabo, cumque non sit earum ratione culpa praesentium ea!
    </div>
    <div class="time-container">
        5:38pm
    </div>
</div>
@endif
