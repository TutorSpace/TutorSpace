<html>
  <head>
    <meta charset="utf-8" />
    <title>Refund Test</title>
    <meta name="description" content="Test page for Stripe Refund" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
  </head>
  <body>
    <!-- Display a payment form -->
    <form id="refund-form" method="POST" action="{!! URL::to('/payment/stripe/create_refund') !!}">
        {{ csrf_field() }}
        <p>Session ID:</p>
        <input type="text" name='session_id'/>
        <br/>
        <button id="submit">
            <span id="button-text">Create Refund</span>
        </button>
    </form>
  </body>
</html>
