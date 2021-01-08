<div class="container modal-session" id="modal-book-session">

    <h5 class="w-100 text-center mb-3">Book your Tutor Session</h5>
    {{-- <div class="mb-3">
        <img src="" alt="profile-img" id="user-img">
        <span class="font-weight-bold ml-2 fc-black-2" id="user-name">
        </span>
    </div> --}}
    <span class="fc-grey fs-1-4 mt-5 mb-2">Drag on the calender to choose the time for your session.</span>
    <div class="row mb-5">
        <div class="col-12 pl-0 fs-1-4">
            <div class="w-100 calendar" id="calendar-request-session"></div>
            <div class="calendar-note">
                <span class="available-time">Available Time</span>
                <span class="note">Note: All time in the calender are based on PST.</span>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between calendar-details">
        <div class="d-flex flex-column mt-3">
            <div class="fc-grey fs-1-4">Date:</div>
            <div class="fc-black-2 fs-1-6" id="session-date">
                {{-- 08/02/2020 Thursday --}}
            </div>
        </div>
        <div class="d-flex flex-column mt-3">
            <div class="fc-grey fs-1-4">Time:</div>
            <div class="fc-black-2 fs-1-6" id="session-time">
                {{-- 3:30pm - 5:00pm --}}
            </div>
        </div>
        <div class="d-flex flex-column mt-3">
            <div class="fc-grey fs-1-4">Tutor Hourly Rate:</div>
            <div class="fc-black-2 fs-1-6" id="hourly-rate">
                {{-- $ 16 per hour --}}
            </div>
        </div>
    </div>

</div>
