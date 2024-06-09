<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Square\Environment;
use Square\Exceptions\ApiException;
use Square\Models\CreatePaymentRequest;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Package;

use Square\SquareClient;
use Square\Models\CreateCheckoutRequest;
use Square\Models\CreateOrderRequest;
use Square\Models\Order;
use Square\Models\OrderLineItem;
use Square\Models\Money;
use Mail;
use App\Mail\AppMail;
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

    function createPayment(Request $request){
        $package = Package::find($request->package_id);
        $user_id = auth()->user()->id;
        if($request->user_id){
            $user_id = $request->user_id;
        }
        $today = Carbon::now()->toDateString();
        $subscription = Subscription::where('user_id',$user_id)->where('end_date', '>', $today)->first();
        if(!$subscription){
            $subscription = Subscription::create([
                "price"=>$package->price,
                "package_type"=>$package->name,
                "user_id"=> $user_id,
                "payment_status"=>'failed',
            ]);
        }
       
        $client = new SquareClient([
            'accessToken' => 'EAAAl8Ag58FVcJ5Suwt4U3OUtp_yfLM7CL-Qt8G5Ng-0PcJ8ds7oLbYtYbzzciMz',
            'environment' => 'production', 
        ]);
        
        $checkout_api = $client->getCheckoutApi();

        $idempotency_key = $this->generateIdempotencyKey();
        
        $order = new Order("L09XH4WWXKBAN");
        
        $line_item = new OrderLineItem('1');
        $line_item->setName('Subscription');
        $base_price_money = new Money();
        $cent_price = $package->price * 100;
        $base_price_money->setAmount($cent_price); 
        $base_price_money->setCurrency('USD');
        $line_item->setBasePriceMoney($base_price_money);
                
        $order->setLineItems([$line_item]);

        $create_order_request = new CreateOrderRequest();
        $create_order_request->setOrder($order);
        
        $checkout_request = new CreateCheckoutRequest($idempotency_key, $create_order_request);
        $checkout_request->setRedirectUrl(route('check-payment',['subscription_id' => $subscription->id , 'days' => $package->days]));
        
        $response = $checkout_api->createCheckout("L09XH4WWXKBAN", $checkout_request);
        

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
            'accessToken' => 'EAAAl8Ag58FVcJ5Suwt4U3OUtp_yfLM7CL-Qt8G5Ng-0PcJ8ds7oLbYtYbzzciMz',
            'environment' => 'production', 
        ]);
        $subscription = Subscription::find($request->subscription_id);
        
        $api_response = $client->getTransactionsApi()->retrieveTransaction('L09XH4WWXKBAN',$request->transactionId);
        if ($api_response->isSuccess()) {
            $result = $api_response->getResult();

            if($result->getTransaction() && $result->getTransaction()->getTenders() && $result->getTransaction()->getTenders()[0]->getCardDetails() ){
                if( $result->getTransaction()->getTenders()[0]->getCardDetails()->getStatus() === "CAPTURED"){
                    $startDate = Carbon::now();
                    $endDate = (clone $startDate)->addDays($request->days);
                    if ($subscription->end_date > $startDate) {
                        $daysToAdd = $startDate->diffInDays($subscription->end_date);
                        $endDateUpdate = (clone $endDate)->addDays($daysToAdd);
                    } else {
                        $endDateUpdate = $endDate;
                    }
                    $subscription->update([
                        "payment_status"=>'success',
                        "transaction_id"=>$result->getTransaction()->getId(),
                        "order_id"=>$result->getTransaction()->getOrderId(),
                        "start_date"=>$startDate,
                        "end_date"=>$endDateUpdate,
                        
                    ]);
                    $user = User::find($subscription->user_id);
                    Mail::to($user->email)->send(new AppMail([
                        'title' => 'Thanks To Use 69simulator',
                        'body' => 'Your subscription has been successfully activated. We hope you enjoy using 69simulator!',
                    ]));
                    return redirect()->route('dashboard.payment-success');
                }
                
            }
        } 

        $errors = $api_response->getErrors();

        $subscription->update([
            "payment_status"=>'failed',
        ]);
        $user = User::find($subscription->user_id);
        Mail::to($user->email)->send(new AppMail([
            'title' => 'Thanks To Use 69simulator',
            'body' => 'Your subscription has been rejected. Please check your card and try again',
        ]));
        return redirect()->route('dashboard.payment-failed');
    }

    function generateIdempotencyKey() {
        return bin2hex(random_bytes(16));
    }
}
