@php
$tz = App\CustomClass\TimeFormatter::getTZ();
@endphp

<div class="{{ $hidden ? 'hidden-2' : '' }}">
    <div class="info-box" data-route-url="{{ route('payment.stripe.refund.user_request_refund', $session->id) }}">
        <div class="user-info">
            <img src="{{ Storage::url($user->profile_pic_url) }}" alt="profile-img">
            <a class="content" href="{{ route('view.profile', $user) }}">
                {{ $user->first_name }} {{ $user->last_name }}
            </a>
        </div>
        <div class="date">
            <span class="title show--sm">Date</span>
            <div>
                <span class="content">
                    {{ date("m/d", strtotime($session->session_time_start))->setTimezone(new DateTimeZone($tz)) }}<span class="info-box__year">{{ date("/y", strtotime($session->session_time_start)) }}</span>
                    {{ date("D", strtotime($session->session_time_start)) }}
                </span>
            </div>
            <span class="title mt-2 show--sm">Time</span>
            <span class="content">
                {{ date("H:i", strtotime($session->session_time_start)) }}
                -
                {{ date("H:i", strtotime($session->session_time_end)) }}
            </span>
        </div>
        <div class="course">
            <span class="title show--sm">Course</span>
            <span class="content">{{ $session->course->course }}</span>
        </div>
        <div class="session-type">
            <span class="title show--sm">Type</span>
            <div class="content">{{ $session->is_in_person ? 'In Person' : 'Online' }}</div>
        </div>
        @if (!$currUser->is_tutor)
        <div class="status">
            <span class="title show--sm">Status</span>
            {{-- @if ($status == 'pending')
            <div class="content pending hide--sm">
                Pending <br />
                Payment
            </div>
            <div class="content pending show--sm">
                Pending Payment
            </div> --}}
            @if($status == 'paid')
            <div class="content paid">Paid</div>
            @else
            <div class="content unpaid">Unpaid</div>
            @endif
        </div>
        @endif
        <div class="price">
            <span class="title show--sm">Price</span>
            <div class="content">${{ $session->calculateSessionFee() }}</div>
        </div>
        <div class="action--toggle p-relative">
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-three-dots hide--sm" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
            </svg>
            <div class="action--toggle--list p-absolute d-none flex-column">
                @if (!$currUser->is_tutor)
                @if($status != 'paid')
                <a class="d-flex flex-row" href="{{ route('payment.stripe.redirect-payment', $session) }}" target="_blank">
                    <svg width="2rem" height="2rem" viewBox="0 0 16 16" class="bi bi-credit-card" fill="#626262" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z"/>
                        <path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1z"/>
                    </svg>
                    <span class="action--toggle--list--title fc-black-2">Pay</span>
                </a>
                @endif
                @can('review-session', $session)
                <a class="d-flex flex-row action-review" data-route-url="{{ route('session.review', $session) }}">
                    <svg width="2rem" height="2rem" viewBox="0 0 16 16" class="bi bi-chat-square-dots" fill="#626262" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h2.5a2 2 0 0 1 1.6.8L8 14.333 9.9 11.8a2 2 0 0 1 1.6-.8H14a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                        <path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                    </svg>
                    <span class="action--toggle--list--title fc-black-2">Review</span>
                </a>
                @endcan
                @endif

                <a class="d-flex flex-row" @if ($currUser->is_tutor) href="{{ route('help-center.index') }}"@endif>
                    <svg width="2rem" height="2rem" viewBox="0 0 16 16" class="bi bi-info-square" fill="#626262" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z"/>
                        <circle cx="8" cy="4.5" r="1"/>
                    </svg>

                    @if ($currUser->is_tutor)
                    <span class="action--toggle--list--title fc-black-2">
                        Help
                    </span>
                    @else
                    <span class="action--toggle--list--title fc-black-2 action-refund">
                        Refund
                    </span>
                    @endif
                </a>
            </div>
        </div>
    </div>
</div>
