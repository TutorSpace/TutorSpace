<div class="container modal-add-payment-method">
    <!-- Display a payment form -->
    <form id="payment-form">
        <div class="sr-form-row mb-3">
            <label>
                Billing account details
            </label>
            <input class="billing-account-inputs" type="text" id="card-holder" placeholder="Card holder" />
            <input class="billing-account-inputs" type="text" id="email" placeholder="Email address" />
        </div>
        <div class="sr-form-row">
            <label>Payment details</label>
            <div id="card-element">
                <!--Stripe.js injects the Card Element-->
            </div>
            <div class="add-card-agreement">
                <input type="checkbox" id="add-card-agreement" class="add-card-agreement-input" name="agreement">
                {{-- todo: add link here --}}
                <label for="add-card-agreement" class="my-3 fs-1-4 font-italic fw-500">
                    By checking this box, I agree to <a href="{{route("service-agreement.show")}}" class="color-primary" target="_blank">TutorSpace Services Agreement</a> and <a href="https://stripe.com/legal" class="color-primary" target="_blank">Stripe Services Agreement</a>.
                </label>
            </div>
            <button id="btn-add-payment-submit">
                <div class="spinner hidden" id="spinner"></div>
                <span id="button-text">Confirm</span>
            </button>
            <p id="card-error" role="alert"></p>
            <div class="sr-result hidden">
                <p>Card setup completed<br /></p>
                <pre>
                    <code></code>
                </pre>
            </div>
        </div>
    </form>
</div>
