<div class="container modal-session-cancel">
    <h6 class="w-100 text-center my-5">Are you sure you want to cancel the session with <span class="name"></span>?</h6>

    <p class="font-weight-bold fc-black-2 mt-5">Why do you want to cancel the session?</p>
    <div class="mb-3">
        <select name="cancel-reason" class="form-control form-control-lg" id="cancel-reason">
            @foreach (App\SessionCancelReason::all() as $sessionCancelReason)
            <option value="{{ $sessionCancelReason->id }}">{{ $sessionCancelReason->reason }}</option>
            @endforeach
        </select>
    </div>

    {{-- todo: add link here --}}
    <p class="fc-black-2 mt-5 fs-1-4"><span class="font-weight-bold">Cancellation Policy: </span>Users can cancel a session at least 24 hours (for students) or 12 hours (for tutors) before the session starts without a penalty. To know more details, please check our
        <a href="{{route('cancellation-policy.show')}}" class="color-primary" target="_blank">Cancellation Policy</a>.
    </p>

    {{-- todo: add link here --}}
    <p class="fc-black-2 mt-3 fs-1-4"><span class="font-weight-bold">Refund Policy: </span>TutorSpace will provide a full refund if your tutor does not show up. To know more details, please check our
        <a href="{{route('refund-policy.show')}}" class="color-primary" target="_blank">Refund Policy</a>.
    </p>


</div>
