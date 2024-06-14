<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Square Payment Form</title>
  <script type="text/javascript" src="https://js.squareup.com/v2/paymentform"></script>
  <script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function () {
      const paymentForm = new SqPaymentForm({
        applicationId: "{{ env('sq0idp-W9lc4EFyc_29C48m16hIHA') }}",
        inputClass: "sq-input",
        autoBuild: false,
        inputStyles: [{ fontSize: "16px" }],
        cardNumber: { elementId: "sq-card-number" },
        cvv: { elementId: "sq-cvv" },
        expirationDate: { elementId: "sq-expiration-date" },
        postalCode: { elementId: "sq-postal-code" },
        callbacks: {
          cardNonceResponseReceived: function (errors, nonce, cardData) {
            if (errors) {
              console.error("Encountered errors:");
              errors.forEach(function (error) {
                console.error(error.message);
              });
              return;
            }
            alert("Nonce received: " + nonce);
            document.getElementById('card-nonce').value = nonce;
            document.getElementById('payment-form').submit();
          }
        }
      });
      paymentForm.build();
      document.getElementById("pay-button").addEventListener("click", function (event) {
        event.preventDefault();
        paymentForm.requestCardNonce();
      });
    });
  </script>
</head>
<body>
  <form id="payment-form" action="{{ route('processPayment') }}" method="post">
    @csrf
    <div id="sq-card-number"></div>
    <div id="sq-cvv"></div>
    <div id="sq-expiration-date"></div>
    <div id="sq-postal-code"></div>
    <input type="hidden" id="card-nonce" name="nonce">
    <button id="pay-button">Pay</button>
  </form>
</body>
</html>
