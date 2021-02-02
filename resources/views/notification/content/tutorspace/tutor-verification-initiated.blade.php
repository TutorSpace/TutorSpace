<div class="notification__content__header font-weight-bold">
    We Have Received Your Request to Be a Verified Tutor.
</div>
<div class="notification__content__info">

    <div class="notification__content__info__wrapper">
        <div class="notification__content__info__header bg-primary"></div>

        <div class="container content">
            <h6 class="color-primary">
                Your request to be a verified tutor has been received.
            </h6>
            <p class="fs-1-6 mt-2">
                Hi {{ Auth::user()->first_name }}, thank you for your interest in being a verified tutor. We want to let you know that your uploaded materials are currently under screening by our staff. Your privacy is always our top priority, and TutorSpace guarantees that we will never share your personal information to any outside party. You will get a response from TutorSpace about the result within three days, and thanks for your patience.
            </p>

            <div class="button-container">
                <a class="btn btn-primary" href="mailto:tutorspacehelp@gmail.com" target="_blank">Contact TutorSpace</a>
            </div>
        </div>
    </div>
</div>
