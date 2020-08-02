<div class="modal fade" id="availableTimeDeleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route("availableTime.delete") }}" method="POST">
                @method('DELETE')
                @csrf
                <div class="modal-header">
                    <h5>
                        Delete Availability
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body fc-black-post">
                        <input type="hidden" value="" name="available-time-id">
                        Are you sure you want to delete your availability time slot from <br/>
                        <span class="fc-theme-color start-time">time</span><br/>
                        <span class="">to</span><br/>
                        <span class="fc-theme-color end-time">time</span>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-lg btn-secondary mr-2" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-lg btn-delete">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
