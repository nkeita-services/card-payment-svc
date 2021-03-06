<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Stripe Card Elements sample</title>
    <meta name="description" content="A demo of Stripe Payment Intents" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="icon" href="/img/stripe/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="/css/stripe/normalize.css" />
    <link rel="stylesheet" href="/css/stripe/global.css" />
    <script src="https://js.stripe.com/v3/"></script>
    <script src="/js/stripe/script.js" defer></script>
  </head>

  <body>
    <div class="sr-root">
      <div class="sr-main">
        <form id="payment-form" class="sr-payment-form">
          <div class="sr-combo-inputs-row">
            <div class="sr-input sr-card-element" id="card-element"></div>
          </div>
          <div class="sr-field-error" id="card-errors" role="alert"></div>
          <button id="submit">
            <div class="spinner hidden" id="spinner"></div>
            <span id="button-text">Pay</span><span id="order-amount"></span>
          </button>
        </form>
        <div class="sr-result hidden">
          <p>Payment completed<br /></p>
          <pre>
            <code></code>
          </pre>
        </div>
      </div>
    </div>
  </body>

  <script>
      var originator= {
          originatorType: "User",
          originatorId: "<?php echo $userId ?>"
      };
      var orderData = {
        currency: "<?php echo $currency ?>",
        amount: <?php echo $amount ?>,
        accountId: "<?php echo $accountId ?>",
        description: "<?php echo $description ?>",
          regions: ["5e99a07063389569485205f3"],
        originator: originator

      };
      var accessToken = "<?php echo $accessToken ?>"
  </script>
</html>
