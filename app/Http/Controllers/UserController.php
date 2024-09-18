<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;
use Mail;
use Square\SquareClient;
use App\Mail\AppMail;
use Illuminate\Support\Facades\Hash;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage; 
use App\Models\Package;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
class UserController extends Controller
{
    public function index(Request $request)
    {
        if(auth()->user()->type === "super_admin"){
            $data = User::get();
        } else {
            $data = User::where('id', auth()->user()->id)
            ->orWhere('parent_id', auth()->user()->id)
            ->get();
        }
        $packages = Package::get();
        $today_date = Carbon::today();
        return view('dashboard.pages.user.index',compact('data','today_date','packages'));
    }
    public function create(Request $request)
    {
        return view('dashboard.pages.user.create');
    }
    public function store(Request $request)
    { 
        // try{
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required',
                'company_name' => 'required',
                'video_path' => 'sometimes|string',
                'video_filename' => 'sometimes|string',
            ]);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'type' => $request->type,
                'status' => $request->status,
                'password' => Hash::make($request->password),
                'company_name' => $request->company_name,
                'language' => $request->language,
                'currency' => $request->currency,
                'custom_text' => $request->custom_text,
                'hex' => $request->hex,
                'api_key' => $request->api_key,
                'business_id' => $request->business_id,
            ]);
    
            if($request->type === "super_admin"){
                $superAdminRole = Role::where('name','Super Admin')->first();
                $user->assignRole($superAdminRole);
            }elseif($request->type === "subscriber"){
                $subscriberRole = Role::where('name' ,'Subscriber')->first();
                if($subscriberRole){
                    $user->assignRole($subscriberRole);
                }
            }
    
            if ($request->hasFile('company_logo')) {
                $user->addMedia($request->file('company_logo'))->toMediaCollection('company_logo');
            }
            if ($request->hasFile('decal_logo')) {
                $user->addMedia($request->file('decal_logo'))->toMediaCollection('decal_logo');
            }
            if ($request->hasFile('detailing_decal')) {
                $user->addMedia($request->file('detailing_decal'))->toMediaCollection('detailing_decal');
            }
            if ($request->filled('video_path') && $request->filled('video_filename')) {
                $videoPath = $request->input('video_path');
                $videoFilename = $request->input('video_filename');
                $user->addMediaFromDisk($videoPath, 'videos')
                    ->usingFileName($videoFilename)
                    ->toMediaCollection('videos');
            }
    
            $createCustomerRequest = new \Square\Models\CreateCustomerRequest();
            $createCustomerRequest->setEmailAddress($user->email);
            $createCustomerRequest->setGivenName($user->name);
            $client = new SquareClient([
                'accessToken' => 'EAAAl4ZyBLIRqCXuoUe-u77nYVLdmAyxjFzYHgQHyv9TuaY6dYEWzYsqiWJekQHe',
                'environment' => 'sandbox', 
            ]);
            $customersApi = $client->getCustomersApi();
    
            $customerResponse = $customersApi->createCustomer($createCustomerRequest);
            $customerId = $customerResponse->getResult()->getCustomer()->getId();
            $user->update([
                'square_customer_id' => $customerId
            ]);
            Alert::toast('User created successfully', 'success');
            return redirect()->route('dashboard.user.index');
        // } catch (\Exception $e) {
        //     Alert::toast('An error occurred while creating the User', 'error');
        //     return redirect()->back()->withInput();
        // }
       
    }
    public function edit($id){
        $data = User::find($id);
        $companyLogo = $data->getFirstMediaUrl('company_logo');
        $decalLogo = $data->getFirstMediaUrl('decal_logo');
        $detailing_decal = $data->getFirstMediaUrl('detailing_decal');
        $video = $data->getFirstMediaUrl('videos'); 
        return view('dashboard.pages.user.edit',compact('data','companyLogo','decalLogo','video','detailing_decal'));
    }
    public function update(Request $request, $id){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);
        try {
            $user = User::find($id);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'company_name' => $request->company_name,
                'language' => $request->language,
                'currency' => $request->currency,
                'custom_text' => $request->custom_text,
                'type' => $request->type,
                'hex' => $request->hex,
                'api_key' => $request->api_key,
                'business_id' => $request->business_id,
            ]);
            if($request->password !== null){
                $user->update([
                    'password' => Hash::make($request->password),
                ]);
            }
            if($request->status !== null){
                $user->update([
                   'status' => $request->status,
                ]);
            }
            if ($request->hasFile('company_logo')) {
                $user->clearMediaCollection('company_logo');
                $user->addMedia($request->file('company_logo'))->toMediaCollection('company_logo');
            }
            if ($request->hasFile('decal_logo')) {
                $user->clearMediaCollection('decal_logo');
                $user->addMedia($request->file('decal_logo'))->toMediaCollection('decal_logo');
            }
            if ($request->hasFile('detailing_decal')) {
                $user->clearMediaCollection('detailing_decal');
                $user->addMedia($request->file('detailing_decal'))->toMediaCollection('detailing_decal');
            }
            if ($request->filled('video_path') && $request->filled('video_filename')) {
                $user->clearMediaCollection('videos');
                $videoPath = $request->input('video_path');
                $videoFilename = $request->input('video_filename');
                $user->addMediaFromDisk($videoPath, 'videos')
                    ->usingFileName($videoFilename)
                    ->toMediaCollection('videos');
            }
            Alert::toast('User Updated successfully', 'success');
            return redirect()->route('dashboard.user.index');
        } catch (\Exception $e) {
            Alert::toast('An error occurred while Updating the User', 'error');
            return redirect()->back()->withInput();
        }
        return redirect()->route('dashboard.user.index');
    }
    public function updateStatus(Request $request)
    {
        $user = User::find($request->user_id);
        if ($user) {
            $user->update([
                'status' => $request->status,
            ]);
            $startDate = Carbon::now();
            $endDate = (clone $startDate)->addWeeks(1);
            Mail::to($user->email)->send(new AppMail([
                'title' => 'Welcome To 69simulator',
                'body' => 'Your account has been approved , Enjoy using 69simulator!',
            ]));
            return response()->json(['message' => 'Status updated successfully'], 200);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }
    public function delete(Request $request,$id){
        $data = User::find($id);
        $data->delete();
        toast('Success','success');
        return redirect()->route('dashboard.user.index');
    }
    public function uploadLargeFiles(Request $request) {
        $receiver = new \Pion\Laravel\ChunkUpload\Receiver\FileReceiver('file', $request, HandlerFactory::classFromRequest($request));
    
        if (!$receiver->isUploaded()) {
            // file not uploaded
        }
    
        $fileReceived = $receiver->receive(); // receive file
        if ($fileReceived->isFinished()) { // file uploading is complete / all chunks are uploaded
            $file = $fileReceived->getFile(); // get file
            $extension = $file->getClientOriginalExtension();
            $fileName = str_replace('.'.$extension, '', $file->getClientOriginalName()); //file name without extenstion
            $fileName .= '_' . md5(time()) . '.' . $extension; // a unique file name
            $disk = Storage::disk('videos');
            $path = $disk->putFileAs('videos', $file, $fileName);
            // delete chunked file
            unlink($file->getPathname());
            return [
                'path' => asset('storage/' . $path),
                'path_without_storage' =>  $path,
                'filename' => $fileName
            ];
        }
    
        // otherwise return percentage information
        $handler = $fileReceived->handler();
        return [
            'done' => $handler->getPercentageDone(),
            'status' => true
        ];
    }

    public function createEmployee(Request $request)
    {
        return view('dashboard.pages.user.create_employee');
    }
    public function storeEmployee(Request $request)
    { 
        try{
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required',
            ]);
            $package = Package::where('name', 'like', '%' . "epmloyee" . '%')->first();

            if(!$package){
                Alert::toast('An error occurred while Updating the User', 'error');
                return redirect()->back()->withInput();
            }
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'type' => 'employee',
                'status' => 'approved',
                'password' => Hash::make($request->password),
                'card_id',auth()->user()->card_id,
                'parent_id',auth()->user()->id,
            ]);
            
            $superAdminRole = Role::where('name','Employee')->first();
            $user->assignRole($superAdminRole);
    
            $createCustomerRequest = new \Square\Models\CreateCustomerRequest();
            $createCustomerRequest->setEmailAddress($user->email);
            $createCustomerRequest->setGivenName($user->name);
            $client = new SquareClient([
                'accessToken' => 'EAAAl4ZyBLIRqCXuoUe-u77nYVLdmAyxjFzYHgQHyv9TuaY6dYEWzYsqiWJekQHe',
                'environment' => 'sandbox', 
            ]);
            $customersApi = $client->getCustomersApi();
    
            $customerResponse = $customersApi->createCustomer($createCustomerRequest);
            $customerId = $customerResponse->getResult()->getCustomer()->getId();
            $user->update([
                'square_customer_id' => $customerId
            ]);
            $subscriptionsApi = $client->getSubscriptionsApi();
            $card = Card::where('customer_id',$user->square_customer_id)->first();
            // check card before go to payment 
            if($card){
                $customerId = $user->square_customer_id;
                // Retrieve the plan ID based on the package type
                $planId = $package->plan_id;
                // Create subscription
                $createSubscriptionRequest = new \Square\Models\CreateSubscriptionRequest('L09XH4WWXKBAN', $planId,$customerId);
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
            }
            Alert::toast('User created successfully', 'success');
            return redirect()->route('dashboard.user.index');
        } catch (\Exception $e) {
            Alert::toast('An error occurred while creating the User', 'error');
            return redirect()->back()->withInput();
        }
       
    }
    public function deleteEmplyee(Request $request,$id){
        $client = new SquareClient([
            'accessToken' => 'EAAAl8Ag58FVcJ5Suwt4U3OUtp_yfLM7CL-Qt8G5Ng-0PcJ8ds7oLbYtYbzzciMz',
            'environment' => 'production', 
        ]);
        $user = User::find($id);
        $sub = Subscription::where('user_id',$id)->first();
        
        if($sub->subscription_id){
            $api_response = $client->getSubscriptionsApi()->cancelSubscription($sub->subscription_id);
            $sub->update([
                'end_date'=>null
            ]);
        }
        $user->delete();

        toast('Success','success');
        return redirect()->route('dashboard.user.index');
    }
}
