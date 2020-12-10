<html>
  <head>
    <meta charset="utf-8" />
    <title>Invoice Test</title>
    <meta name="description" content="Test page for Stripe Invoice" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
  </head>
  <body>
    <!-- Display a payment form -->
    <form id="invoice-form" method="POST" action="{!! URL::to('/payment/create_invoice') !!}">
        {{ csrf_field() }}
        <p>Amount:</p>
        <input type="text" name='amount'/>
        <p>Target Connect Account:</p>
        <input type="text" name='destination_account_id'/>
        <br/>
        <button id="submit">
            <span id="button-text">Create Invoice</span>
        </button>
        <?php echo $invoice_id ?? ''; ?>
    </form>
  </body>
</html>
