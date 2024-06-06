<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;
use Mail;
use App\Mail\AppMail;
use Illuminate\Support\Facades\Hash;
use App\Models\Subscription;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data = User::get();
        $today_date = Carbon::today();

        return view('dashboard.pages.user.index',compact('data','today_date'));
    }
    public function create(Request $request)
    {
        return view('dashboard.pages.user.create');
    }
    public function store(Request $request)
    {   
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required',
        ]);
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'type' => $request->type,
                'status' => $request->status,
                'password' => Hash::make($request->password),
            ]);

            
            if($request->type === "super_admin"){
                $superAdminRole = Role::where('name','Super Admin')->first();
                $user->assignRole($superAdminRole);
            }else{
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
            if ($request->hasFile('video')) {
                $user->addMedia($request->file('video'))->toMediaCollection('videos');
            }
            if($request->status === 'approved'){
                $startDate = Carbon::now();
                $endDate = (clone $startDate)->addWeeks(1);
                $sub = Subscription::create([
                    "price"=>0,
                    "package_type"=> 'trial',
                    "payment_status"=>'success',
                    "start_date"=>$startDate,
                    "end_date"=>$endDate,
                    "user_id"=>$user->id,
    
                ]);
            }
            // $title = 'welcomes';
            // $this->sendEmailCreateUser($request->email ,$request->password , $title ,$request->name ,'');
            Alert::toast('User created successfully', 'success');
            return redirect()->route('dashboard.user.index');
        } catch (\Exception $e) {
            Alert::toast('An error occurred while creating the User', 'error');
            return redirect()->back()->withInput();
        }
       
    }
    public function edit($id){
        $data = User::find($id);
        return view('dashboard.pages.user.edit',compact('data'));
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
                'status' => $request->status,
                'password' => Hash::make($request->password),
            ]);
            if ($request->hasFile('company_logo')) {
                $user->clearMediaCollection('company_logo');
                $user->addMedia($request->file('company_logo'))->toMediaCollection('company_logo');
            }
            if ($request->hasFile('decal_logo')) {
                $user->clearMediaCollection('decal_logo');
                $user->addMedia($request->file('decal_logo'))->toMediaCollection('decal_logo');
            }
            if ($request->hasFile('video')) {
                $user->clearMediaCollection('video');
                $user->addMedia($request->file('video'))->toMediaCollection('videos');
            }
            if($request->status === 'approved' &&  !$user->subscription ){
                $startDate = Carbon::now();
                $endDate = (clone $startDate)->addWeeks(1);
                $sub = Subscription::create([
                    "price"=>0,
                    "package_type"=> 'trial',
                    "payment_status"=>'success',
                    "start_date"=>$startDate,
                    "end_date"=>$endDate,
                    "user_id"=>$user->id,
    
                ]);
            }
            Alert::toast('User created successfully', 'success');
            return redirect()->route('dashboard.user.index');
        } catch (\Exception $e) {
            Alert::toast('An error occurred while creating the User', 'error');
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
            $sub = Subscription::create([
                "price"=>0,
                "package_type"=> 'trial',
                "payment_status"=>'success',
                "start_date"=>$startDate,
                "end_date"=>$endDate,
                "user_id"=>$user->id,

            ]);
            Mail::to($user->email)->send(new AppMail([
                'title' => 'Welcome To 69simulator',
                'body' => 'Your account has been approved, and we have given you a 7-day trial subscription. Enjoy using 69simulator!',
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
  
}
