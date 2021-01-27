<div class="notification__content__header font-weight-bold">
    Referral Bonus Claimed
</div>
<div class="notification__content__info">

    <div class="notification__content__info__wrapper">
        <div class="notification__content__info__header bg-primary"></div>

        <div class="container content">
            @if ($forNewUser)
            <h6 class="color-primary">
                You have successfully claimed a referral bonus of ${{ $bonus }}. One of our staff member will shortly send you an email to ask for your Venmo account, and your bonus will be sent to you via Venmo within 3 days.
            </h6>
            @else
            <h6 class="color-primary">
                Your referral code is successfully activated by a student you invited. You will receive a referral bonus of ${{ $bonus }}. One of our staff member will shortly send you an email to ask for your Venmo account, and your bonus will be sent to you via Venmo within 3 days.
            </h6>
            @endif

            <div class="button-container">
                <a class="btn btn-primary" href="mailto:tutorspacehelp@gmail.com" target="_blank">Contact TutorSpace</a>
            </div>
        </div>
    </div>
</div>
