<html>
<head>
    <meta charset="UTF-8">
    <title>Stripe demo</title>
    <meta name="description" content="A demo of a card reuse on Stripe" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
</head>
<script src="https://js.stripe.com/v3/"></script>
<style>
    .hidden {
        display: none;
    }
</style>
<body>
    @if (count($cards) > 0)
        <form id="payment-form">
            {!! csrf_field() !!}
            <input type="text" id='amount' name='amount'/><br/>
            @for ($i = 0; $i < count($cards); $i++)
                <input type="radio" id="{{$i}}" name="radio_option" value="{{$i}}"/>
                <div>
                    @php
                        $card = $cards[$i];
                    @endphp
                    <p>{{var_dump($card)}}</p>
                    {{-- <p>{{$card->last4}}</p>
                    <p>{{$card->exp_month}}</p>
                    <p>{{$card->exp_year}}</p> --}}
                </div>
            @endfor
            <p id="card-error" role="alert"></p>
            <button id="submit">Pay</button>
            <p class="result-message hidden">
                Payment succeeded, see the result in your
                <a href="" target="_blank">Stripe dashboard.</a> Refresh the page to pay again.
              </p>
        </form>
    @else
        <p>No cards</p>
    @endif
</body>
<script defer>
    var stripe = Stripe("pk_test_51H6RWlBtUwiw0w2oW1kGPF0AwsekfcKD0mz7Aj5M66bVelryG3uZdcE3lutEIb9ddWDlfpTGm3PjpZk5BjphHvU100pM9tg0rJ");
    var form = document.getElementById("payment-form");
    form.addEventListener("submit", function(event) {
        event.preventDefault();
        var purchase = {
            'amount': document.getElementById("amount").value,
            'card_num': document.querySelector('input[name="radio_option"]:checked').value
        };
        fetch("create_payment_intent_with_card", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                "X-CSRF-Token": '{{csrf_token()}}'
            },
            body: JSON.stringify(purchase)
        })
        .then(function(result) {
            return result.json();
        })
        .then(function(data) {
            console.log(data);
            completePayment(stripe, data);
        });
    });
    var completePayment = function(stripe, data) {
        loading(true);
        stripe
            .confirmCardPayment(data.clientSecret, {
                payment_method: data.paymentMethodId
            })
            .then(function(result) {
                if (result.error) {
                    // Show error to your customer
                    showError(result.error.message);
                } else {
                    // The payment succeeded!
                    orderComplete(result.paymentIntent.id);
                }
            });
    };
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
    var loading = function(isLoading) {
        if (isLoading) {
            // Disable the button and show a spinner
            document.querySelector("button").disabled = true;
        } else {
            document.querySelector("button").disabled = false;
        }
    };
</script>
</html>
