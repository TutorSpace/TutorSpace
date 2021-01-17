<div class="container modal-add-payment-method">
    <!-- Display a payment form -->
    <form id="payment-form">
        <div class="sr-form-row">
            <label>
                Billing account details
            </label>
            <input type="text" id="email" placeholder="Email address" />
        </div>
        <div class="sr-form-row">
            <label>Payment details</label>
            <div id="card-element">
                <!--Stripe.js injects the Card Element-->
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
        {{-- TODO: nate add policy --}}
    </form>
</div>
