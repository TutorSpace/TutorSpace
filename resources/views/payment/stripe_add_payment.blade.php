<html>
  <head>
    <meta charset="utf-8" />
    <title>Add Payment Method</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <style>
        /* Variables */
        * {
        box-sizing: border-box;
        }
        body {
        font-family: -apple-system, BlinkMacSystemFont, sans-serif;
        font-size: 16px;
        -webkit-font-smoothing: antialiased;
        display: flex;
        justify-content: center;
        align-content: center;
        height: 100vh;
        width: 100vw;
        }
        form {
        width: 30vw;
        min-width: 500px;
        align-self: center;
        box-shadow: 0px 0px 0px 0.5px rgba(50, 50, 93, 0.1),
            0px 2px 5px 0px rgba(50, 50, 93, 0.1), 0px 1px 1.5px 0px rgba(0, 0, 0, 0.07);
        border-radius: 7px;
        padding: 40px;
        }

    </style>
    <script src="https://js.stripe.com/v3/"></script>

  </head>

  <body>
    <!-- Display a payment form -->
    <form id="payment-form">
      <div id="card-element"><!--Stripe.js injects the Card Element--></div>
      <button id="submit">
        <div class="spinner hidden" id="spinner"></div>
        <span id="button-text">Pay</span>
      </button>
      <p id="card-error" role="alert"></p>
      <p class="result-message hidden">
        Payment succeeded, see the result in your
        <a href="" target="_blank">Stripe dashboard.</a> Refresh the page to pay again.
      </p>
    </form>
  </body>

  <script defer>
    // A reference to Stripe.js initialized with your real test publishable API key.
    var stripe = Stripe("pk_test_51HvqSrGxwAT7uYY4xEdsjjJD8HcIC4en1jSFwH0Qrhe2TSSM1r1KqkbcweDkdsCwYkEpaPP63mmCgys4DGBfPz9200cmsSAtZn");
    // The items the customer wants to buy
    var purchase = {
        items: [{ id: "xl-tshirt" }],
        amount: 1234
    };
    // Disable the button until we have Stripe set up on the page
    document.querySelector("button").disabled = true;
    fetch("{{ route('payment.stripe.create_payment_intent') }}", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
            "X-CSRF-Token": '{{csrf_token()}}'
        },
        body: JSON.stringify(purchase)
    })
    .then(function(result) {
        return result.json();
    })
    .then(function(data) {
        var elements = stripe.elements();
        var style = {
        base: {
            color: "#32325d",
            fontFamily: 'Arial, sans-serif',
            fontSmoothing: "antialiased",
            fontSize: "16px",
            "::placeholder": {
            color: "#32325d"
            }
        },
        invalid: {
            fontFamily: 'Arial, sans-serif',
            color: "#fa755a",
            iconColor: "#fa755a"
        }
        };
        var card = elements.create("card", { style: style });
        // Stripe injects an iframe into the DOM
        card.mount("#card-element");
        card.on("change", function (event) {
            // Disable the Pay button if there are no card details in the Element
            document.querySelector("button").disabled = event.empty;
            document.querySelector("#card-error").textContent = event.error ? event.error.message : "";
        });
        var form = document.getElementById("payment-form");
        form.addEventListener("submit", function(event) {
            event.preventDefault();
            // Complete payment when the submit button is clicked
            payWithCard(stripe, card, data.clientSecret);
        });
    });
    // Calls stripe.confirmCardPayment
    // If the card requires authentication Stripe shows a pop-up modal to
    // prompt the user to enter authentication details without leaving your page.
    var payWithCard = function(stripe, card, clientSecret) {
        loading(true);
        stripe
            .confirmCardPayment(clientSecret, {
                payment_method: {
                    card: card
                },
                setup_future_usage: 'off_session'
            })
            .then(function(result) {
                if (result.paymentIntent.status === 'succeeded') {
                // The payment is complete!
                    orderComplete(result.paymentIntent.id);
                }else{
                    alert(result.paymentIntent.status)
                }

                if (result.error) {
                    // Show error to your customer
                    showError(result.error.message);
                } else {
                    // The payment succeeded!

                }
            });
    };
    /* ------- UI helpers ------- */
    // Shows a success message when the payment is complete
    var orderComplete = function(paymentIntentId) {
        loading(false);
        document
            .querySelector(".result-message a")
            .setAttribute(
            "href",
            "https://dashboard.stripe.com/test/payments/" + paymentIntentId
            );
        document.querySelector(".result-message").classList.remove("hidden");
        document.querySelector("button").disabled = true;
    };
    // Show the customer the error from Stripe if their card fails to charge
    var showError = function(errorMsgText) {
        loading(false);
        var errorMsg = document.querySelector("#card-error");
        errorMsg.textContent = errorMsgText;
        setTimeout(function() {
            errorMsg.textContent = "";
        }, 4000);
    };
    // Show a spinner on payment submission
    var loading = function(isLoading) {
        if (isLoading) {
            // Disable the button and show a spinner
            document.querySelector("button").disabled = true;
            document.querySelector("#spinner").classList.remove("hidden");
            document.querySelector("#button-text").classList.add("hidden");
        } else {
            document.querySelector("button").disabled = false;
            document.querySelector("#spinner").classList.add("hidden");
            document.querySelector("#button-text").classList.remove("hidden");
        }
    };
</script>
</html>
