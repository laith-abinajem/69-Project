<div id="form-container">
    <div id="card-container"></div>
    <button id="card-button">Save Card</button>
</div>

<script src="https://sandbox.web.squarecdn.com/v1/square.js"></script>
<script>
    async function initializeSquarePayments() {
        const payments = Square.payments('sandbox-sq0idb-YUWObSyjVpaI6A4yV6iX9A', 'sandbox'); // or 'production'
        const card = await payments.card();
        await card.attach('#card-container');

        document.getElementById('card-button').addEventListener('click', async () => {
            const { token, error } = await card.tokenize();
            if (error) {
                console.error(error);
                return;
            }
            console.log(token)
            const response = await fetch('/add-card', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    nonce: token,
                    customer_id: '5H6FNDRBN0DTQ40CKPAAPTGM1G'
                })
            });

            if (response.ok) {
                const cardData = await response.json();
                console.log('Card added:', cardData);
            } else {
                const errorData = await response.json();
                console.error('Error adding card:', errorData);
            }
        });
    }

    initializeSquarePayments();
</script>