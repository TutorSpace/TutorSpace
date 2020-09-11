<h4 class="heading">Message</h4>
<div class="search-bar-container">
    <input type="text" class="search-bar form-control form-control-lg" placeholder="Search...">
    <svg>
        <use xlink:href="{{asset('assets/sprite.svg#icon-magnifying-glass')}}"></use>
    </svg>
</div>
<ul class="chatting-msgs">
    @include('chatting.side-bar-chatting-msg')
</ul>
