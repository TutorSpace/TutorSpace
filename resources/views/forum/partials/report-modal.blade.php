<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <form class="modal-dialog modal-dialog-centered" role="document" action="{{ route('forum.report.store') }}"
        method="POST">
        @csrf
        <input type="hidden" value="" id="report-for" name="report-for">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fc-black-post">Report</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @foreach (App\ReportReason::all() as $reportReason)
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="report-reason" id="report-reason-{{ $reportReason->id }}" value="{{ $reportReason->id }}"
                    @if ($loop->first)
                        checked
                    @endif>
                    <label class="form-check-label" for="report-reason-{{ $reportReason->id }}">
                        {{ $reportReason->reason }}
                    </label>
                </div>
                @endforeach
                <label for="report" class="fc-black-post">Description</label>
                <textarea id="report" name="report" rows="3" class="form-control fs-1-6" required></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-lg btn-secondary mr-2" data-dismiss="modal">Cancel</button>
                <button class="btn btn-lg btn-submit" type="submit">Submit</button>
            </div>
        </div>
    </form>
</div>
