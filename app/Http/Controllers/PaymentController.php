<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Square\Environment;
use Square\Exceptions\ApiException;
use Square\Models\CreatePaymentRequest;
use App\Models\Subscription;
use App\Models\Package;

use Square\SquareClient;
use Square\Models\CreateCheckoutRequest;
use Square\Models\CreateOrderRequest;
use Square\Models\Order;
use Square\Models\OrderLineItem;
use Square\Models\Money;

use Carbon\Carbon;
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

    // public function createPayment(Request $request)
    // {
    //     $request->validate([
    //         'amount' => 'required|numeric',
    //     ]);

    //     $amount = $request->input('amount');

    //     $money = new \Square\Models\Money();
    //     $money->setAmount(1 * 100); // Amount in cents
    //     $money->setCurrency('USD'); // Adjust based on your currency

    //     $createPaymentRequest = new CreatePaymentRequest('CBASELLWAfAzJ0oCKMYU53ENIYE', uniqid(), $money);


    //     try {
    //         $response = $this->client->getPaymentsApi()->createPayment($createPaymentRequest);

    //         if ($response->isSuccess()) {
    //             $payment = $response->getResult()->getPayment();
    //             Subscription::create([
    //                 'payment_status' => $payment->getStatus(),
    //                 'amount' => $amount,
    //             ]);
    //             return response()->json(['success' => true, 'message' => 'Payment successful!']);
    //         } else {
    //             return response()->json(['success' => false, 'message' => $response->getErrors()]);
    //         }
    //     } catch (ApiException $e) {
    //         dd(1);
    //         return response()->json(['success' => false, 'message' => $e->getMessage()]);
    //     }
    // }

    function createPayment(Request $request){
        $package = Package::find($request->package_id);
        //subscription ==> customer_id , order_id(null), transaction_id(null), payment_status(pending), package_type(1 month) , start_date (null),end_date(null)
        $user_id = auth()->user()->id;
        if($request->user_id){
            $user_id = $request->user_id;
        }
        $subscription = Subscription::create([
            "price"=>$package->price,
            "package_type"=>$package->name,
            "user_id"=> $user_id,
            "payment_status"=>'failed',
        ]);
        $client = new SquareClient([
            'accessToken' => 'EAAAl4ZyBLIRqCXuoUe-u77nYVLdmAyxjFzYHgQHyv9TuaY6dYEWzYsqiWJekQHe',
            'environment' => 'sandbox', 
        ]);
        
        $checkout_api = $client->getCheckoutApi();

        $idempotency_key = $this->generateIdempotencyKey();
        
        $order = new Order("LJ17XDN9GP4GY");
        
        $line_item = new OrderLineItem('1');
        $line_item->setName('Subscription');
        $base_price_money = new Money();
        $base_price_money->setAmount($subscription->price); 
        $base_price_money->setCurrency('USD');
        $line_item->setBasePriceMoney($base_price_money);
                
        $order->setLineItems([$line_item]);

        $create_order_request = new CreateOrderRequest();
        $create_order_request->setOrder($order);
        
        $checkout_request = new CreateCheckoutRequest($idempotency_key, $create_order_request);
        $checkout_request->setRedirectUrl(route('check-payment',['subscription_id' => $subscription->id , 'days' => $package->days]));
        
        $response = $checkout_api->createCheckout("LJ17XDN9GP4GY", $checkout_request);
        

        if ($response->isSuccess()) {
             //subscription ==> order_id(gen)
           
            $checkout_url = $response->getResult()->getCheckout()->getCheckoutPageUrl();
            return redirect($checkout_url);

        } else {
            dd($response);
            dd('error');
        }
    }

    function checkPayment(Request $request){
        $client = new SquareClient([
            'accessToken' => 'EAAAl4ZyBLIRqCXuoUe-u77nYVLdmAyxjFzYHgQHyv9TuaY6dYEWzYsqiWJekQHe',
            'environment' => 'sandbox', 
        ]);
        $subscription = Subscription::find($request->subscription_id);
       
        $api_response = $client->getTransactionsApi()->retrieveTransaction('LJ17XDN9GP4GY',$request->transactionId);
        if ($api_response->isSuccess()) {
            $result = $api_response->getResult();

            if($result->getTransaction() && $result->getTransaction()->getTenders() && $result->getTransaction()->getTenders()[0]->getCardDetails() ){
                if( $result->getTransaction()->getTenders()[0]->getCardDetails()->getStatus() === "CAPTURED"){
                    $startDate = Carbon::now();
                    $endDate = (clone $startDate)->addDays($request->days);
                    $subscription->update([
                        "payment_status"=>'success',
                        "transaction_id"=>$result->getTransaction()->getId(),
                        "order_id"=>$result->getTransaction()->getOrderId(),
                        "start_date"=>$startDate,
                        "end_date"=>$endDate,
                        
                    ]);
                    return redirect()->route('payment-success');
                }
                
            }
        } 

        $errors = $api_response->getErrors();

        $subscription->update([
            "payment_status"=>'failed',
            "start_date"=>'',
            "end_date"=>'',
        ]);
        return redirect()->route('payment-failed');
    }

    function generateIdempotencyKey() {
        return bin2hex(random_bytes(16));
    }
}
