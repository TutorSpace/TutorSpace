<div class="container modal-switch-account">
    <p class="font-weight-bold text-center fs-2-2 mt-5">Are you sure you want to switch to your {{ $currUser->is_tutor ? "student" : "tutor" }} account?</p>
    <p class="fc-grey text-center fs-1-4">You can always switch back to your {{ $currUser->is_tutor ? "tutor" : "student" }} account later.</p>
</div>
