<div class="info-card @if(isset($hidden) && $hidden) hidden-2 @endif">
    <div class="d-flex justify-content-between align-items-center">
        <a class="user-name" href="#">
            Shuaiqing Luo
        </a>
        <div class="p-relative">
            <svg class="action-toggle" width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-three-dots" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
            </svg>
            <ul class="action-toggle__content">
                <li class="d-flex align-items-center justify-content-center">
                    <svg>
                        <use xlink:href="{{asset('assets/sprite.svg#icon-blocked')}}"></use>
                    </svg>
                    <button class="btn px-0 py-0 fs-1-6 btn-cancel-session" type="button">Cancel</button>
                </li>
            </ul>
        </div>
    </div>
    <div class="info-card__row">
        <div class="row-left">
            <small class="title">Date</small>
            <span class="content">08/02<span class="info-card__year">/20</span> Thur</span>
        </div>
        <div class="row-right">
            <small class="title">Course</small>
            <span class="content">Math 102A</span>
        </div>
    </div>
    <div class="info-card__row">
        <div class="row-left">
            <small class="title">Time</small>
            <span class="content">13:30 - 15:00</span>
        </div>
        <div class="row-right d-flex align-items-center">
            <button class="btn btn-primary btn-view btn-view-session">View</button>
        </div>
    </div>
</div>
