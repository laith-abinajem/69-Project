<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Card;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Mail;
use App\Mail\AppMail;
use App\Models\Package;
use Square\SquareClient;

class SubscriptionController extends Controller
{
    public function index(){
        $today = Carbon::now()->toDateString();
        $users = User::get();
        if(auth()->user()->type === "super_admin"){
            $data = Subscription::get();
            $current_sub = Subscription::where('user_id', auth()->user()->id)
            ->where('end_date', '>', $today)
            ->latest()
            ->first();
            $packages = Package::get();
            $price = Subscription::where('user_id',auth()->user()->id)->sum('price');
            $count = Subscription::where('user_id',auth()->user()->id)->count();
            $card = Card::where('customer_id',auth()->user()->square_customer_id)->first();
        }else{
            $current_sub = Subscription::where('user_id', auth()->user()->id)
            ->where('end_date', '>', $today)
            ->latest()
            ->first();
            $data = Subscription::whereHas('user',function($query){
                $query->where('id', auth()->user()->id)
                ->orWhere('parent_id', auth()->user()->id);
                
            })->get();
            $packages = Package::where('interval','!=','WEEKLY')->get();
            $price = Subscription::where('user_id',auth()->user()->id)->sum('price');
            $count = Subscription::where('user_id',auth()->user()->id)->count();
            $card = Card::where('customer_id',auth()->user()->square_customer_id)->first();
            // $selected_package = Package::where('name',$current_sub->package_type)->first();

        }
        return view('dashboard.pages.subscription.index',compact('users','count','price','data','current_sub','packages','card'));
    }
    public function create(){
        $packages = Package::get();
        $users = User::get();
        return view('dashboard.pages.subscription.create',compact('packages','users'));
    }
    public function store(Request $request){
        $package = Package::find($request->package_id);
        $startDate = Carbon::now();
        $endDate = (clone $startDate)->addDays($package->days);
        $user = User::find($request->user_id);
         $subscription = Subscription::where('user_id',$request->user_id)->where('end_date', '>', $startDate)->first();
        if(!$subscription){
            $subscription = Subscription::create([
                "price"=>$package->price,
                "package_type"=>$package->name,
                "user_id"=>$request->user_id,
                "start_date"=>$startDate,
                "end_date"=>$endDate,
            ]);

            $user = User::find($request->user_id);
            Mail::to($user->email)->send(new AppMail([
                'title' => 'Welcome To 69simulator',
                'body' => 'Your account has been approved, and we have given you a new subscription. Enjoy using 69simulator!',
            ]));
            Alert::toast('Subscription created successfully', 'success');
            return redirect()->route('dashboard.subscription.index');
        }else{
            Alert::toast('This user already have active subscription', 'error');
            return redirect()->route('dashboard.subscription.index');
            // $subscription = Subscription::where('user_id',$request->user_id)->where('end_date', '>', $startDate)->first();
            // if($subscription){
            //     if ($subscription->end_date > $startDate) {
            //         $daysToAdd = $startDate->diffInDays($subscription->end_date);
            //         $endDateUpdate = (clone $endDate)->addDays($daysToAdd);
            //     } else {
            //         $endDateUpdate = $endDate;
            //     }
            //     $subscription->update([
            //         "end_date"=>$endDateUpdate,
            //         "package_type"=>$package->name,
            //     ]);
            // }else{
            //     $subscription = Subscription::create([
            //         "price"=>$package->price,
            //         "package_type"=>$package->name,
            //         "user_id"=>$request->user_id,
            //         "start_date"=>$startDate,
            //         "end_date"=>$endDate,
            //     ]);
    
            //     $user = User::find($request->user_id);
            //     Mail::to($user->email)->send(new AppMail([
            //         'title' => 'Welcome To 69simulator',
            //         'body' => 'Your account has been approved, and we have given you a new subscription. Enjoy using 69simulator!',
            //     ]));
            // }
        }
        
       
    }
    public function edit($id,Request $request){

    }
    public function update(Request $request){
        $client = new SquareClient([
            'accessToken' => 'EAAAl4ZyBLIRqCXuoUe-u77nYVLdmAyxjFzYHgQHyv9TuaY6dYEWzYsqiWJekQHe',
            'environment' => 'sandbox',
        ]);
        $package = Package::find($request->package_id);
        $user = User::find(auth()->user()->id);
        if($request->user_id){
            $user = User::find($request->user_id);
        }
        $subscription = Subscription::find($request->subscription_id);
        $card = Card::where('customer_id',$user->square_customer_id)->first();
        if($subscription->subscription_id){
            if($card){
                $body = new \Square\Models\SwapPlanRequest($package->plan_id);
                $api_response = $client->getSubscriptionsApi()->swapPlan($subscription->subscription_id, $body);
                Alert::toast('Subscription updated successfully', 'success');
                return redirect()->route('dashboard.subscription.index');
            }else{
                Alert::toast('You should add card !', 'error');
                return redirect()->route('dashboard.subscription.index');
            }
           
        }else{
            if(auth()->user()->type === 'super_admin'){
                $startDate = Carbon::now();
                $endDate = (clone $startDate)->addDays($package->days);
                $subscription->update([
                    "price"=>$package->price,
                    "package_type"=>$package->name,
                    "user_id"=>$request->user_id,
                    "start_date"=>$startDate,
                    "end_date"=>$endDate,
                ]);
                Alert::toast('Subscription updated successfully', 'success');
                return redirect()->route('dashboard.subscription.index');
            }else{
                if(!$card){
                    Alert::toast('You should add card !', 'error');
                    return redirect()->route('dashboard.subscription.index');
                }else{
                    Alert::toast('This user already have active subscription', 'error');
                    return redirect()->route('dashboard.subscription.index');
                }
            }
        }
     
    }
    public function delete(Request $request,$id){
        $data = Subscription::find($id);
        $data->delete();
        toast('Success','success');
        return redirect()->route('dashboard.subscription.index');
    }
}
