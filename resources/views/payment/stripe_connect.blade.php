<html>
<head>
    <meta charset="UTF-8">
    <title>Stripe demo</title>
    <meta name="description" content="A demo of a card payment on Stripe" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script   src="https://code.jquery.com/jquery-3.5.1.min.js"   integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="   crossorigin="anonymous"></script>

</head>
<style>
    .hidden {
        display: none;
    }
</style>
<body>
    <p class="result-message1 hidden">
        Login to
        <a href="" target="_blank">Stripe dashboard.</a>
        
    </p>
    <button id="setup-stripe-btn">Setup payouts on Stripe</button>
    <script defer>
        
        $("#setup-stripe-btn").click(function(){
            postToConnectAccount().then((response)=>{
                // redirect to create stripe account
                if (response.stripe_url){
                    window.location = response.stripe_url;
                // TODO: error
                }else{

                }
            
            })
        });

        function postToConnectAccount(){
            return $.ajax({
            url:"{{ route('stripe_onboarding') }}",
            method:'POST',
            headers: {
                'Content-Type': 'application/json',
                "X-CSRF-Token": '{{csrf_token()}}'
            }
            })
        }

        var urls = {
            'refresh_url': "{!! URL::to('/payment/stripe_index') !!}",
            'return_url': "{!! URL::to('/payment/stripe_index') !!}",
        };
        fetch("stripe_onboarding", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                "X-CSRF-Token": '{{csrf_token()}}'
            },
            body: JSON.stringify(urls)
        })
        .then(function(result) {
            return result.json();
        })
        .then(function(data) {
            document
                .querySelector(".result-message1 a")
                .setAttribute(
                "href",
                data.stripe_url
            );
            document.querySelector(".result-message1").classList.remove("hidden");
        });
    </script>
    <form id="charge-form" method="POST" action="{!! URL::to('/payment/stripe_charge') !!}">
        {{ csrf_field() }}
        <input type="text" name='amount'/>
        <button id="submit">
            <span id="button-text">Charge customer</span>
        </button>
    </form>
    <form id="refund-form" method="POST" action="{!! URL::to('/payment/stripe_refund') !!}">
        {{ csrf_field() }}
        <input type='text' name="charge_id">
        <button id="submit2">
            <span id="button-text">Refund</span>
        </button>
        <p class="result-message2 hidden" id='refund_result'>
        </p>
    </form>
    <form id="payout-form" method="POST" action="{!! URL::to('/payment/stripe_payout') !!}">
        {{ csrf_field() }}
        <input type="text" name='amount'/>
        <button id="submit">
            <span id="button-text">Pay to customer</span>
        </button>
    </form>
    @if ($status = Session::get("status"))
        <p>Status: {!! $status !!}</p>
        @php
            Session::forget('status');
        @endphp
    @endif
    @if ($failure_reason = Session::get("failure_reason"))
        <p>Failure reason: {!! $failure_reason !!}</p>
        @php
            Session::forget('failure_reason');
        @endphp
    @endif
</body>
</html>
