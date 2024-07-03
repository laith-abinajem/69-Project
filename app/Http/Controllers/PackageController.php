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
        $old_package = Package::find($request->id);
        $package = Package::create([
            'name' => $old_package->name,
            'price' => $request->price,
            'days'=> $old_package->days,
            'interval'=> $old_package->interval
        ]);
        $old_package->delete();
      
     
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
                }
            }
        } catch (ApiException $e) {
        }
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
