<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\Package;
use RealRashid\SweetAlert\Facades\Alert;
use Square\SquareClient;
use Square\Models\CatalogObject;
use Square\Models\CatalogItem;
use Square\Models\CatalogItemVariation;
use Square\Models\CatalogSubscriptionPlan;
use Square\Models\SubscriptionPhase;
use Square\Models\UpsertCatalogObjectRequest;
use Square\Models\Money;


class PackageController extends Controller
{
    public function index(){
        $data = Package::get();
        return view('dashboard.pages.package.index',compact('data'));
    }
    public function create(){
        return view('dashboard.pages.package.create');
    }
    public function store(Request $request)
    {
        try{

            $package = Package::create([
                'name' => $request->name,
                'price' => $request->price,
                'days'=> 0,
                'interval'=> $request->interval
            ]);
            if($request->interval === "WEEKLY"){
                $package->update([
                    'days'=>7
                ]);
            }elseif($request->interval === "MONTHLY"){
                $package->update([
                    'days'=>30
                ]);
            }elseif($request->interval === "NINETY_DAYS"){
                $package->update([
                    'days'=>90
                ]);
            }elseif($request->interval === "QUARTERLY"){
                $package->update([
                    'days'=>180
                ]);
            }elseif($request->interval === "ANNUAL"){
                $package->update([
                    'days'=>360
                ]);
            }
         
            $client = new SquareClient([
                'accessToken' => 'EAAAl8Ag58FVcJ5Suwt4U3OUtp_yfLM7CL-Qt8G5Ng-0PcJ8ds7oLbYtYbzzciMz',
                'environment' => 'production', 
            ]);
        
            $catalogApi = $client->getCatalogApi();
            
            $priceMoney = new Money();
            $priceMoney->setAmount($package->price * 100); 
            $priceMoney->setCurrency('USD');
    
            $subscriptionPhase = new SubscriptionPhase($package->interval);
            $subscriptionPhase->setRecurringPriceMoney($priceMoney);
    
            $subscriptionPlanData = new CatalogSubscriptionPlan($package->name, [$subscriptionPhase]);
    
            $catalogObject = new CatalogObject('SUBSCRIPTION_PLAN', '#'.$package->id);
            $catalogObject->setSubscriptionPlanData($subscriptionPlanData);
    
            $upsertCatalogObjectRequest = new UpsertCatalogObjectRequest($this->generateIdempotencyKey(), $catalogObject);
    
            try {
                $result = $catalogApi->upsertCatalogObject($upsertCatalogObjectRequest);
    
                // Check if the result is successful and contains the catalog object
                if ($result->isSuccess() && $result->getResult() && $result->getResult()->getCatalogObject()) {
                    $planId = $result->getResult()->getCatalogObject()->getId();
                    $package->update(["plan_id" => $planId]);
                } else {
                    // Log or handle errors
                    $errors = $result->getErrors();
                    foreach ($errors as $error) {
                        // Log errors
                        dd($error);
                    }
                }
            } catch (ApiException $e) {
            }
        
            Alert::toast('Package created successfully', 'success');
            return redirect()->route('dashboard.package.index');
        }
        catch (\Exception $e) {
           Alert::toast('An error occurred while creating the Package', 'error');
           return redirect()->back()->withInput();
       }
        
    }
    public function edit($id){
        $data = Package::find($id);

        return view('dashboard.pages.package.edit',compact('data'));
    }
    public function update($id,Request $request){
        $package = Package::find($request->id);
        $package->update([
            'price' => $request->price,
        ]);
        // if($request->interval === "WEEKLY"){
        //     $package->update([
        //         'days'=>7
        //     ]);
        // }elseif($request->interval === "MONTHLY"){
        //     $package->update([
        //         'days'=>30
        //     ]);
        // }elseif($request->interval === "THREE_MONTHS"){
        //     $package->update([
        //         'days'=>90
        //     ]);
        // }elseif($request->interval === "SIX_MONTHS"){
        //     $package->update([
        //         'days'=>180
        //     ]);
        // }elseif($request->interval === "ANNUAL"){
        //     $package->update([
        //         'days'=>360
        //     ]);
        // }
     
        // $client = new SquareClient([
        //     'accessToken' => 'EAAAl8Ag58FVcJ5Suwt4U3OUtp_yfLM7CL-Qt8G5Ng-0PcJ8ds7oLbYtYbzzciMz',
        //     'environment' => 'production', 
        // ]);
        
        // $catalogApi = $client->getCatalogApi();
        
        // // Replace with your package details
        // $packageId = '#'.$package->id;
        // $newPrice = $package->price * 100; // Price in cents
        
        // try {
        //     // Fetch the existing CatalogObject
        //     $catalogObjectResponse = $catalogApi->listCatalog($packageId, 'SUBSCRIPTION_PLAN');
        //     $existingCatalogObject = $catalogObjectResponse->getResult()->getObjects();
        
        //     if ($existingCatalogObject) {
        //         // Update the price in the existing CatalogObject
        //         $priceMoney = new Money();
        //         $priceMoney->setAmount($newPrice); 
        //         $priceMoney->setCurrency('USD');
        
        //         $subscriptionPhase = new SubscriptionPhase($package->interval);
        //         $subscriptionPhase->setRecurringPriceMoney($priceMoney);
        
        //         $subscriptionPlanData = $existingCatalogObject->getSubscriptionPlanData();
        //         $subscriptionPlanData->setPhases([$subscriptionPhase]);
        
        //         $existingCatalogObject->setSubscriptionPlanData($subscriptionPlanData);
        
        //         // Upsert the updated CatalogObject
        //         $upsertCatalogObjectRequest = new UpsertCatalogObjectRequest(
        //             uniqid(), // Use a unique idempotency key
        //             $existingCatalogObject
        //         );
        
        //         $result = $catalogApi->upsertCatalogObject($upsertCatalogObjectRequest);
        //     } else {
        //     }
        // } catch (ApiException $e) {
        //     echo "API Exception: " . $e->getMessage();
        // }
        Alert::toast('package Updated successfully', 'success');
        return redirect()->route('dashboard.package.index');
    }
    public function delete(Request $request,$id){
        $data = Package::find($id);
        $data->delete();
        toast('Success','success');
        return redirect()->route('dashboard.package.index');
    }
    function generateIdempotencyKey() {
        return bin2hex(random_bytes(16));
    }

}
