<div class="notification__content__header font-weight-bold">
    Congrats! Your tutor verification request is successfully processed.
</div>
<div class="notification__content__info">

    <div class="notification__content__info__wrapper">
        <div class="notification__content__info__header bg-primary"></div>

        <div class="container content">
            <h6 class="color-primary">
                We have successfully processed your tutor verification request!
            </h6>
            {{-- todo: link to the policy here --}}
            <p class="fs-1-6 mt-2">
                Hi {{ Auth::user()->first_name }}, thank you for sending your materials and requesting for tutor verification. Based on your past academic records, we are glad to approve your request. You will see a special badge in your profile if you have listed at least one verified course as the courses you want to teach. For information regarding the benefits of becoming a verified tutor, please check TutorSpace’s both Tutor Growth Plan Policy and Tutor Verification Policy. If you have any further questions, please contact us immediately.
            </p>

            <div class="button-container">
                <a class="btn btn-primary" href="mailto:tutorspacehelp@gmail.com" target="_blank">Contact TutorSpace</a>
            </div>
        </div>
    </div>
</div>
