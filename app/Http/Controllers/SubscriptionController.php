<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use App\Models\Package;
class SubscriptionController extends Controller
{
    public function index(){
        $today = Carbon::now()->toDateString();
        if(auth()->user()->type === "super_admin"){
            $data = Subscription::get();
            $current_sub = Subscription::where('user_id', auth()->user()->id)
            ->where('end_date', '>', $today)
            ->latest()
            ->first();
            $packages = Package::get();

        }else{
            $current_sub = Subscription::where('user_id', auth()->user()->id)
            ->where('end_date', '>', $today)
            ->latest()
            ->first();
            $data = Subscription::where('user_id',auth()->user()->id)->get();
            $packages = Package::get();
            // $selected_package = Package::where('name',$current_sub->package_type)->first();

        }
        return view('dashboard.pages.subscription.index',compact('data','current_sub','packages'));
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
            $subscription = Subscription::create([
                "price"=>0,
                "package_type"=>$package->name,
                "user_id"=>$request->user_id,
                "start_date"=>$startDate,
                "end_date"=>$endDate,
            ]);
            Alert::toast('Subscription created successfully', 'success');
            return redirect()->route('dashboard.subscription.index');
       
    }
    public function edit($id,Request $request){

    }
    public function update($id,Request $request){
        
    }
    public function delete(Request $request,$id){
        $data = Subscription::find($id);
        $data->delete();
        toast('Success','success');
        return redirect()->route('dashboard.subscription.index');
    }
}
