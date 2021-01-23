<div class="modal fade" id="availableTimeConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route("availableTime.store") }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5>
                        Confirm Your Availability
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body fc-black-post">
                        <input type="hidden" value="" name="start-time">
                        <input type="hidden" value="" name="end-time">
                        Are you sure you are available from <br/>
                        <span class="fc-theme-color start-time">time</span><br/>
                        <span class="">to</span><br/>
                        <span class="fc-theme-color end-time">time</span>?

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-lg btn-secondary mr-2" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-lg btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
