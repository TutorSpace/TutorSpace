<div class="notification__content__header font-weight-bold">
    Session Confirmation (08/02/2020 Thursday)
</div>
<div class="notification__content__info">

    <div class="notification__content__info__wrapper">
        <div class="notification__content__info__header bg-primary">
            <img src="{{ Storage::url(Auth::user()->profile_pic_url) }}" alt="user photo" class="user-image">
        </div>

        <div class="container content">
            <p class="pt-3 fs-2-4 text-center fw-500">Neno Enim</p>

            <h6 class="mt-3 color-primary">Session Details</h6>

            <div class="d-flex justify-content-between mt-2">
                <div class="d-flex flex-column">
                    <div class="fc-grey fs-1-4">Date:</div>
                    <div class="fc-black-2 fs-1-6" id="session-date">
                        08/02/2020 Thursday
                    </div>
                </div>
                <div class="d-flex flex-column">
                    <div class="fc-grey fs-1-4">Time:</div>
                    <div class="fc-black-2 fs-1-6" id="session-time">
                        3:30pm - 5:00pm
                    </div>
                </div>
                <div class="d-flex flex-column">
                    <div class="fc-grey fs-1-4">Course:</div>
                    <div class="fc-black-2 fs-1-6">
                        Computer Science
                    </div>
                </div>

                <div class="d-flex flex-column">
                    <div class="fc-grey fs-1-4">Type:</div>
                    <div class="fc-black-2 fs-1-6">
                        In Person
                    </div>
                </div>

                <div class="d-flex flex-column">
                    <div class="fc-grey fs-1-4">Price:</div>
                    <div class="fs-1-6 color-primary">
                        $ 25
                    </div>
                </div>
            </div>

            <h6 class="color-primary">Price Summary</h6>
            <p class="fc-black-2 d-flex flex-row justify-content-between fs-1-6 mt-3">Session Income
                <span class="color-primary">$ 26</span>
            </p>
            <p class="fc-black-2 d-flex flex-row justify-content-between fs-1-6 mt-3">Service Fee (10%)
                <span class="color-primary">($ 2)</span>
            </p>
            <hr class="bc-primary mt-3"/>
            <p class="font-weight-bold fc-black-2 d-flex flex-row justify-content-between fs-1-6 mt-3">Total
                <span class="color-primary">$ 24</span>
            </p>

            <p class="fc-black-2 fs-1-6"><span class="font-weight-bold">Cancelation Policy: </span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>

            <p class="fc-black-2 fs-1-6 mt-2"><span class="font-weight-bold">Refund Policy: </span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>

            <div class="button-container">
                <a class="btn btn-primary" href="mailto:tutorspaceusc@gmail.com">Contact TutorSpace</a>
            </div>
        </div>
    </div>
</div>
