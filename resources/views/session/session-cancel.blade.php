<div class="container modal-session-cancel">
    <h6 class="w-100 text-center my-5">Are you sure you want to cancel the session with Nemo Enim?</h6>

    <p class="fc-grey text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>

    <p class="font-weight-bold fc-black-2 mt-5">Why do you want to cancel the session?</p>
    <div class="mb-3">
        <select name="cancel-reason" class="form-control form-control-lg" id="cancel-reason">
            @foreach (App\SessionCancelReason::all() as $sessionCancelReason)
            <option value="{{ $sessionCancelReason->id }}">{{ $sessionCancelReason->reason }}</option>
            @endforeach
        </select>
    </div>

    <p class="fc-black-2 mt-5 fs-1-4"><span class="font-weight-bold">Cancellation Policy: </span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod </p>
    <p class="fc-black-2 mt-3 fs-1-4"><span class="font-weight-bold">Refund Policy: </span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt. </p>

</div>
