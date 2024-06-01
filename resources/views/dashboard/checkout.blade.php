<!-- resources/views/checkout.blade.php -->


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Checkout') }}</div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form id="payment-form" method="POST" action="{{ route('process-payment') }}">
                        @csrf
                        <div class="form-group">
                                <label for="amount">Amount:</label>
                                <input type="number" name="amount" id="amount" class="form-control" required>
                            </div>
                        <div class="form-group">
                            <label for="name">Cardholder's Name:</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="card-number">Card Number:</label>
                            <input type="text" name="sq-card-number" id="sq-card-number" class="form-control" value="1">

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="expiration">Expiration Date:</label>
                                    <input type="text" name="sq-expiration-number" id="sq-expiration-number" class="form-control" value="1">

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cvv">CVV:</label>
                                    <input type="text" name="sq-cvv" id="sq-cvv" class="form-control" value="1">

                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="postal-code">Postal Code:</label>
                            <input type="text" name="sq-postal-code" id="sq-postal-code" class="form-control" value="1">
                        </div>

                        <input type="hidden" id="card-nonce" name="nonce">

                        <button type="submit" class="btn btn-primary" id="checkout-button">Pay Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Include the Square payment form library -->
    <script src="https://js.squareupsandbox.com/v2/paymentform"></script>

    <script>
    const applicationId = 'sq0idp-W9lc4EFyc_29C48m16hIHA';
    const locationId = 'LNPE7YJ464MDQ';
    const paymentForm = new SqPaymentForm({
        applicationId: applicationId,
        locationId: locationId,
        inputClass: 'sq-input',
        autoBuild: false,
        cardNumber: {
            elementId: 'sq-card-number',
            placeholder: 'Card Number',
        },
        cvv: {
            elementId: 'sq-cvv',
            placeholder: 'CVV',
        },
        expirationDate: {
            elementId: 'sq-expiration-date',
            placeholder: 'MM/YY',
        },
        postalCode: {
            elementId: 'sq-postal-code',
            placeholder: 'Postal Code',
        },
        callbacks: {
            cardNonceResponseReceived: function(errors, nonce, cardData) {
                if (errors) {
                    console.error(errors);
                    return;
                }
                document.getElementById('card-nonce').value = nonce;
                document.getElementById('checkout-button').disabled = false;
            },
        },
    });

    function fillStaticData() {
        document.getElementById('sq-card-number').innerText = document.getElementById('static-card-number').value;
        document.getElementById('sq-expiration-date').innerText = document.getElementById('static-expiration').value;
        document.getElementById('sq-cvv').innerText = document.getElementById('static-cvv').value;
        document.getElementById('sq-postal-code').innerText = document.getElementById('static-postal-code').value;
    }

    function onGetCardNonce(event) {
        event.preventDefault();
        fillStaticData(); // Fill static data before submitting
        paymentForm.requestCardNonce();
        console.log(paymentForm.requestCardNonce());
    }

    document.getElementById('checkout-button').addEventListener('click', onGetCardNonce);

    paymentForm.build();
</script>
