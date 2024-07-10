<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Square\Environment;
use Square\Exceptions\ApiException;
use Square\Models\CreatePaymentRequest;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Card;
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

use Square\Models\CatalogObject;
use Square\Models\CatalogItem;
use Square\Models\CatalogItemVariation;
use Square\Models\CatalogSubscriptionPlan;
use Square\Models\SubscriptionPhase;
use Square\Models\UpsertCatalogObjectRequest;


class PaymentController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new SquareClient([
            'accessToken' => 'EAAAl4ZyBLIRqCXuoUe-u77nYVLdmAyxjFzYHgQHyv9TuaY6dYEWzYsqiWJekQHe',
            'environment' => Environment::SANDBOX, // Default to sandbox
        ]);
        
    }

    function createPayment(Request $request){
        $client = new SquareClient([
            'accessToken' => 'EAAAl4ZyBLIRqCXuoUe-u77nYVLdmAyxjFzYHgQHyv9TuaY6dYEWzYsqiWJekQHe',
            'environment' => 'sandbox',
        ]);

        // Retrieve Catalog Objects

        // $api_response = $client->getCatalogApi()->listCatalog();

        // if ($api_response->isSuccess()) {
        //     $result = $api_response->getResult();
        //     dd($result);
        // } else {
        //     $errors = $api_response->getErrors();
        //     dd($errors);

        // }

        // Build a Simple Catalog
        // $price_money = new \Square\Models\Money();
        // $price_money->setAmount(300);
        // $price_money->setCurrency('USD');
        
        // $item_variation_data = new \Square\Models\CatalogItemVariation();
        // $item_variation_data->setItemId('#coffee');
        // $item_variation_data->setName('Small');
        // $item_variation_data->setPricingType('FIXED_PRICING');
        // $item_variation_data->setPriceMoney($price_money);
        
        // $catalog_object = new \Square\Models\CatalogObject('ITEM_VARIATION', '#small_coffee');
        // $catalog_object->setItemVariationData($item_variation_data);
        
        // $price_money1 = new \Square\Models\Money();
        // $price_money1->setAmount(350);
        // $price_money1->setCurrency('USD');
        
        // $item_variation_data1 = new \Square\Models\CatalogItemVariation();
        // $item_variation_data1->setItemId('#coffee');
        // $item_variation_data1->setName('Large');
        // $item_variation_data1->setPricingType('FIXED_PRICING');
        // $item_variation_data1->setPriceMoney($price_money1);
        
        // $catalog_object1 = new \Square\Models\CatalogObject('ITEM_VARIATION', '#large_coffee');
        // $catalog_object1->setItemVariationData($item_variation_data1);
        
        // $variations = [$catalog_object, $catalog_object1];
        // $item_data = new \Square\Models\CatalogItem();
        // $item_data->setName('Coffee');
        // $item_data->setDescription('Coffee Drink');
        // $item_data->setAbbreviation('Co');
        // $item_data->setVariations($variations);
        
        // $object = new \Square\Models\CatalogObject('ITEM', '#coffee');
        // $object->setItemData($item_data);
        
        // $body = new \Square\Models\UpsertCatalogObjectRequest('1111', $object);
        
        // $api_response = $client->getCatalogApi()->upsertCatalogObject($body);
        
        // if ($api_response->isSuccess()) {
        //     $result = $api_response->getResult();
        //     dd($result);
        // } else {
        //     $errors = $api_response->getErrors();
        //     dd($errors);
        // }


        // Upsert catalog object

        // price_money = new \Square\Models\Money();
        // $price_money->setAmount(300);
        // $price_money->setCurrency('USD');
        
        // $item_variation_data = new \Square\Models\CatalogItemVariation();
        // $item_variation_data->setItemId('#KEG35HS3KPABVURLLXK6NZJO');
        // $item_variation_data->setName('Small');
        // $item_variation_data->setPricingType('FIXED_PRICING');
        // $item_variation_data->setPriceMoney($price_money);
        // $item_variation_data->setAvailableForBooking(true);
        
        // $catalog_object = new \Square\Models\CatalogObject('FTSD2VICSMVQLJMR65Z2QQFT');
        // $catalog_object->setType('ITEM_VARIATION');
        // $catalog_object->setVersion(1718038838443);
        // $catalog_object->setItemVariationData($item_variation_data);
        
        // $variations = [$catalog_object];
        // $item_data = new \Square\Models\CatalogItem();
        // $item_data->setName('Coffee');
        // $item_data->setAbbreviation('Co');
        // $item_data->setAvailableOnline(true);
        // $item_data->setAvailableForPickup(true);
        // $item_data->setAvailableElectronically(true);
        // $item_data->setVariations($variations);
        // $item_data->setProductType('REGULAR');
        
        // $object = new \Square\Models\CatalogObject('#KEG35HS3KPABVURLLXK6NZJO');
        // $object->setType('ITEM');
        // $object->setItemData($item_data);
        
        // $body = new \Square\Models\UpsertCatalogObjectRequest('f8013347-8bc0-4fcd-b520-d754e4ca66bc', $object);
        
        // $api_response = $client->getCatalogApi()->upsertCatalogObject($body);
        
        // if ($api_response->isSuccess()) {
        //     $result = $api_response->getResult();
        // } else {
        //     $errors = $api_response->getErrors();
        // }



        // {
        //     "catalog_object": {
        //       "type": "ITEM",
        //       "id": "5UZLI32RRMWLQJOOVZCQA4IP",
        //       "updated_at": "2024-06-10T18:14:51.606Z",
        //       "created_at": "2024-06-10T18:14:51.606Z",
        //       "version": 1718043291606,
        //       "is_deleted": false,
        //       "present_at_all_locations": true,
        //       "item_data": {
        //         "name": "Coffee",
        //         "abbreviation": "Co",
        //         "is_taxable": true,
        //         "available_online": true,
        //         "available_for_pickup": true,
        //         "available_electronically": true,
        //         "variations": [
        //           {
        //             "type": "ITEM_VARIATION",
        //             "id": "FTSD2VICSMVQLJMR65Z2QQFT",
        //             "updated_at": "2024-06-10T18:14:51.606Z",
        //             "created_at": "2024-06-10T17:00:38.443Z",
        //             "version": 1718043291606,
        //             "is_deleted": false,
        //             "present_at_all_locations": true,
        //             "item_variation_data": {
        //               "item_id": "5UZLI32RRMWLQJOOVZCQA4IP",
        //               "name": "Small",
        //               "ordinal": 0,
        //               "pricing_type": "FIXED_PRICING",
        //               "price_money": {
        //                 "amount": 300,
        //                 "currency": "USD"
        //               },
        //               "available_for_booking": true,
        //               "sellable": true,
        //               "stockable": true
        //             }
        //           }
        //         ],
        //         "product_type": "REGULAR",
        //         "is_archived": false
        //       }
        //     },
        //     "id_mappings": [
        //       {
        //         "client_object_id": "#KEG35HS3KPABVURLLXK6NZJO",
        //         "object_id": "5UZLI32RRMWLQJOOVZCQA4IP"
        //       }
        //     ]
        //   }

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
            'accessToken' => 'EAAAl4ZyBLIRqCXuoUe-u77nYVLdmAyxjFzYHgQHyv9TuaY6dYEWzYsqiWJekQHe',
            'environment' => 'sandbox',
        ]);
        
        $checkout_api = $client->getCheckoutApi();

        $idempotency_key = $this->generateIdempotencyKey();
        
        $order = new Order("L09XH4WWXKBAN");
        
        $line_item = new OrderLineItem('1');
        $line_item->setName('Subscription refund');
        $base_price_money = new Money();
        $cent_price = 1 * 100;
        $base_price_money->setAmount($cent_price); 
        $base_price_money->setCurrency('USD');
        $line_item->setBasePriceMoney($base_price_money);
                
        $order->setLineItems([$line_item]);

        $create_order_request = new CreateOrderRequest();
        $create_order_request->setOrder($order);
        
        $checkout_request = new CreateCheckoutRequest($idempotency_key, $create_order_request);
        $checkout_request->setRedirectUrl(route('dashboard.check-payment',['subscription_id' => $subscription->id , 'days' => $package->days]));
        
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
            'accessToken' => 'EAAAl4ZyBLIRqCXuoUe-u77nYVLdmAyxjFzYHgQHyv9TuaY6dYEWzYsqiWJekQHe',
            'environment' => 'sandbox',
        ]);
        // $subscription = Subscription::find($request->subscription_id);
        
        $api_response = $client->getTransactionsApi()->retrieveTransaction('LJ17XDN9GP4GY',$request->transactionId);
        if ($api_response->isSuccess()) {

            // get list card + save it in table + then we can refund money
            $result = $api_response->getResult();
          
            if($result->getTransaction() && $result->getTransaction()->getTenders() && $result->getTransaction()->getTenders()[0]->getCardDetails() ){
                if( $result->getTransaction()->getTenders()[0]->getCardDetails()->getStatus() === "CAPTURED"){
                    // $user = User::find(auth()->user()->id);
                    // $api_response = $client->getCardsApi()->listCards('', $user->square_customer_id);
                    // dd($api_response);
                    // $card = Card::create([
                    //     "card_id" => $api_response->id,
                    //     "card_brand"=>$api_response->card_brand,
                    //     "card_type"=>$api_response->card_type,
                    //     "last_4"=>$api_response->last_4,
                    //     "cardholder_name"=>$api_response->cardholder_name,
                    //     "bin"=>$api_response->bin,
                    //     "customer_id"=>$api_response->customer_id,
                    // ]);


                    // $startDate = Carbon::now();
                    // $endDate = (clone $startDate)->addDays($request->days);
                    // if ($subscription->end_date > $startDate) {
                    //     $daysToAdd = $startDate->diffInDays($subscription->end_date);
                    //     $endDateUpdate = (clone $endDate)->addDays($daysToAdd);
                    // } else {
                    //     $endDateUpdate = $endDate;
                    // }
                    // $subscription->update([
                    //     "payment_status"=>'success',
                    //     "transaction_id"=>$result->getTransaction()->getId(),
                    //     "order_id"=>$result->getTransaction()->getOrderId(),
                    //     "start_date"=>$startDate,
                    //     "end_date"=>$endDateUpdate,
                        
                    // ]);
                    // $user = User::find($subscription->user_id);
                    // Mail::to($user->email)->send(new AppMail([
                    //     'title' => 'Thanks To Use 69simulator',
                    //     'body' => 'Your subscription has been successfully activated. We hope you enjoy using 69simulator!',
                    // ]));
                    return redirect()->route('dashboard.payment-success');
                }
                
            }
        } 

        $errors = $api_response->getErrors();

        // $subscription->update([
        //     "payment_status"=>'failed',
        // ]);
        // $user = User::find($subscription->user_id);
        // Mail::to($user->email)->send(new AppMail([
        //     'title' => 'Thanks To Use 69simulator',
        //     'body' => 'Your subscription has been rejected. Please check your card and try again',
        // ]));
        return redirect()->route('dashboard.payment-failed');
    }

    function processPayment(Request $request){
        $request->validate([
            'customer_id' => 'required|string',
            'nonce' => 'required|string', 
        ]);

        $customerId = $request->input('customer_id');
        $nonce = $request->input('nonce');
        $client = new SquareClient([
            'accessToken' => 'EAAAl4ZyBLIRqCXuoUe-u77nYVLdmAyxjFzYHgQHyv9TuaY6dYEWzYsqiWJekQHe',
            'environment' => 'sandbox',
        ]);
        try {
            $billing_address = new \Square\Models\Address();
            $body = new \Square\Models\CreateCustomerCardRequest($nonce);
            $body->setBillingAddress($billing_address);

            $card = $client->getCustomersApi()->createCustomerCard($customerId, $body);
            $user = User::find(auth()->user()->id);
            $api_response = $client->getCardsApi()->listCards('', $user->square_customer_id);
            if ($api_response->isSuccess() && !empty($api_response->getResult()->getCards())) {
                $cards = $api_response->getResult()->getCards();
                $cardData = $cards[0];
                $card = Card::create([
                    "card_id" => $cardData->getId(),
                    "card_brand" => $cardData->getCardBrand(),
                    "card_type" => $cardData->getCardType(), 
                    "last_4" => $cardData->getLast4(),
                    "cardholder_name" => $cardData->getCardholderName(),
                    "bin" => $cardData->getBin(),
                    "customer_id" => $user->square_customer_id,
                    "exp_month" => $cardData->getExpMonth(), // Add expiration month
                    "exp_year" => $cardData->getExpYear(), // Add expiration year
                ]);
            
            }
            return response()->json($card, 200);
            // return redirect()->route('dashboard.subscription.index');

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    function generateIdempotencyKey() {
        return bin2hex(random_bytes(16));
    }


    //Create plans 
    

    public function createSubscriptionPlans()
    {
        $client = new SquareClient([
            'accessToken' => 'EAAAl4ZyBLIRqCXuoUe-u77nYVLdmAyxjFzYHgQHyv9TuaY6dYEWzYsqiWJekQHe',
            'environment' => 'sandbox',
        ]);

        $catalogApi = $client->getCatalogApi();

        $plans = [
            [
                'id' => 1,
                'name' => 'Weekly Plan',
                'interval' => 'WEEKLY',
                'price' => 0, // Free plan
            ],
            [
                'id' => 5,
                'name' => 'Monthly Plan',
                'interval' => 'MONTHLY',
                'price' => 1000, // $10.00
            ],
            [
                'id' => 2,
                'name' => 'Quarterly Plan',
                'interval' => 'THREE_MONTHS',
                'price' => 2700, // $27.00
            ],
            [
                'id' => 3,
                'name' => 'Semi-Annual Plan',
                'interval' => 'SIX_MONTHS',
                'price' => 5000, // $50.00
            ],
            [
                'id' => 4,
                'name' => 'Annual Plan',
                'interval' => 'ANNUAL',
                'price' => 9000, // $90.00
            ],
        ];

        foreach ($plans as $plan) {
            $priceMoney = new Money();
            $priceMoney->setAmount($plan['price']); // Amount in cents
            $priceMoney->setCurrency('USD');

            $subscriptionPhase = new SubscriptionPhase($plan['interval']);
            $subscriptionPhase->setRecurringPriceMoney($priceMoney);

            $subscriptionPlanData = new CatalogSubscriptionPlan($plan['name'], [$subscriptionPhase]);

            $catalogObject = new CatalogObject('SUBSCRIPTION_PLAN', '#'.$plan['id']);
            $catalogObject->setSubscriptionPlanData($subscriptionPlanData);

            $upsertCatalogObjectRequest = new UpsertCatalogObjectRequest($this->generateIdempotencyKey(), $catalogObject);

            try {
                $result = $catalogApi->upsertCatalogObject($upsertCatalogObjectRequest);
            
                echo 'Successfully created subscription plan: ' . $plan['name'] . "\n";
            } catch (ApiException $e) {
                echo 'Error creating subscription plan: ' . $e->getMessage() . "\n";
            }
        }


    }

    public function createPayment2(Request $request)
    {
        $client = new SquareClient([
            'accessToken' => 'EAAAl4ZyBLIRqCXuoUe-u77nYVLdmAyxjFzYHgQHyv9TuaY6dYEWzYsqiWJekQHe',
            'environment' => 'sandbox',
        ]);
        $customersApi = $client->getCustomersApi();
        // get Subscriptions 
        $subscriptionsApi = $client->getSubscriptionsApi();
        $user = User::find(auth()->user()->id);
        $card = Card::where('customer_id',$user->square_customer_id)->first();
        $package = Package::find($request->package_id);
        // check card before go to payment 
        if($card){
            $customerId = $user->square_customer_id;
            // Retrieve the plan ID based on the package type
            $planId = $package->plan_id;
            // Create subscription
            $createSubscriptionRequest = new \Square\Models\CreateSubscriptionRequest('LJ17XDN9GP4GY', $planId,$customerId);
            $createSubscriptionRequest->setCardId($card->card_id);
            $subscriptionResponse = $subscriptionsApi->createSubscription($createSubscriptionRequest);
            // check if subscription success
            if ($subscriptionResponse->isSuccess()) {
                // Retrieve the subscription ID and redirect URL for payment
                $subscription = $subscriptionResponse->getResult()->getSubscription();
                $subscriptionId = $subscription->getId();
                $redirectUrl = $subscription->getCardId(); 
                $startDate = Carbon::now();
                $endDate = (clone $startDate)->addDays($package->days);
                $sub = Subscription::create([
                    "user_id"=> $user->id,
                    "order_id"=> 1,
                    "transaction_id"=> $subscriptionId ,
                    "subscription_id"=> $subscriptionId ,
                    "payment_status"=> 'success',
                    "price"=> $package->price,
                    "package_type"=> $package->name,
                    "end_date"=> $endDate,
                    "start_date"=> $startDate,
                ]);
                $user->update([
                    "sub_id"=> $sub->id
                ]);
                return redirect()->route('dashboard.payment-success');
            } else {
                // dd($subscriptionResponse->getErrors()[0]->getDetail());
                return redirect()->route('dashboard.payment-failed')->with('error', 'Failed to create subscription: ' . $subscriptionResponse->getErrors()[0]->getDetail());
            }
        }else{
            return redirect()->route('dashboard.subscription.index');
        }
    }
    public function deleteSubscribtion(Request $request,$id){
        $client = new SquareClient([
            'accessToken' => 'EAAAl4ZyBLIRqCXuoUe-u77nYVLdmAyxjFzYHgQHyv9TuaY6dYEWzYsqiWJekQHe',
            'environment' => 'sandbox',
        ]);
        $api_response = $client->getSubscriptionsApi()->cancelSubscription($id);

        $data = Subscription::where('subscription_id',$id)->first();
        $data->update([
            'end_date'=>null
        ]);
        toast('Success','success');
        return redirect()->route('dashboard.subscription.index');
    }
    
    public function listSubscriptionPlans()
    {
        $client = new SquareClient([
            'accessToken' => 'EAAAl4ZyBLIRqCXuoUe-u77nYVLdmAyxjFzYHgQHyv9TuaY6dYEWzYsqiWJekQHe',
            'environment' => 'sandbox',
        ]);

        $catalogApi = $client->getCatalogApi();

        try {
            $response = $catalogApi->listCatalog(null, 'SUBSCRIPTION_PLAN');
        
            $plans = $response->getResult()->getObjects();
            //dd($response->getResult());
            foreach ($plans as $plan) {
                $planData = $plan->getSubscriptionPlanData();
                // echo 'Plan Name: ' . $planData->getName() . "\n";
                echo 'Plan ID: ' . $plan->getId() . "<br>";
                // echo 'Cadence: ' . $planData->getPhases()[0]->getCadence() . "\n";
                // echo 'Price: ' . $planData->getPhases()[0]->getRecurringPriceMoney()->getAmount() / 100 . "\n";
                // echo "\n";
            }
        } catch (ApiException $e) {
            echo 'Error listing subscription plans: ' . $e->getMessage() . "\n";
        }
    }
}
