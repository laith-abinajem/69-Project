<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Square\SquareClient;
use Square\Environment;
use Square\Exceptions\ApiException;
use Square\Models\CreatePaymentRequest;
use App\Models\Subscription;

class PaymentController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new SquareClient([
            'accessToken' => env('SQUARE_ACCESS_TOKEN'),
            'environment' => Environment::SANDBOX, // Default to sandbox
        ]);
    }

    public function createPayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
        ]);

        $amount = $request->input('amount');

        $money = new \Square\Models\Money();
        $money->setAmount(1 * 100); // Amount in cents
        $money->setCurrency('USD'); // Adjust based on your currency

        $createPaymentRequest = new CreatePaymentRequest('CBASELLWAfAzJ0oCKMYU53ENIYE', uniqid(), $money);


        try {
            $response = $this->client->getPaymentsApi()->createPayment($createPaymentRequest);

            if ($response->isSuccess()) {
                $payment = $response->getResult()->getPayment();
                Subscription::create([
                    'payment_status' => $payment->getStatus(),
                    'amount' => $amount,
                ]);
                return response()->json(['success' => true, 'message' => 'Payment successful!']);
            } else {
                return response()->json(['success' => false, 'message' => $response->getErrors()]);
            }
        } catch (ApiException $e) {
            dd(1);
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
