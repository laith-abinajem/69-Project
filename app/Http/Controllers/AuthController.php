<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;
use App\Models\Subscription;
use Carbon\Carbon;
use Mail;
use Illuminate\Support\Str;
use App\Mail\AppMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Square\SquareClient;

class AuthController extends Controller
{
    public function index()
    {
        return view('dashboard.pages.auth.login');
    }

    public function login(Request $request)
    {
         // Validate input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            Alert::toast('Invalid input!', 'error');
            return back();
        }

        // Normalize email to lowercase
        $email = Str::lower($request->input('email'));
        $password = $request->input('password');
        $client = new SquareClient([
            'accessToken' => 'EAAAl8Ag58FVcJ5Suwt4U3OUtp_yfLM7CL-Qt8G5Ng-0PcJ8ds7oLbYtYbzzciMz',
            'environment' => 'production', 
        ]);
        // Fetch user by email case-insensitively
        $user = User::whereRaw('lower(email) = ?', [$email])->first();
        if ($user) {
            if($user->type !== 'super_admin'){
                $today = Carbon::now()->toDateString();
                $sub = Subscription::where('user_id', $user->id)->where('end_date', '>', $today)->first();
                if($sub && $sub->end_date !== null && $sub->subscription_id){
                    $api_response = $client->getSubscriptionsApi()->retrieveSubscription($sub->subscription_id);
                    $subscription = $api_response->getResult()->getSubscription();
                    $chargedThroughDate = $subscription->getChargedThroughDate();
                    $sub->update([
                        'end_date'=>$chargedThroughDate
                    ]);
                }
            }
          
            if ($user->status === 'approved') {
                if (Hash::check($password, $user->password)) {
                    if ($user->session_id && $user->session_id !== session()->getId()) {
                        return back();
                    }
                    Auth::login($user);
                    $user->session_id = session()->getId();
                    $user->save();
                    Alert::toast('Welcome back', 'info');
                    return redirect()->route('dashboard.home.index');
                } else {
                    Alert::toast('Wrong credentials!', 'error');
                    return back();
                }
            } else {
                Alert::toast('Your account is not approved!', 'error');
                return back();
            }
        } else {
            Alert::toast('Wrong credentials!', 'error');
            return back();
        }
        
    }

    public function forgetPassword(){
        return view('dashboard.pages.auth.forget');
    }
    public function SendCode(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);
        $code = Str::random(6);
        $user = User::where('email',$request->email)->first();
        if( $user ){
            $user->update([
                'code' => $code
            ]); 
            Mail::to($user->email)->send(new AppMail([
                 'title' => 'Thanks for using 69simulator',
                'body' => 'Your reset password code is: ' . $code . '. Please do not share it.'
            ]));
            Session::put('email', $request->email);
            return redirect()->route('check');
        }else{
            Alert::toast('Wrong credentials!','error');
            return back()->withErrors(['email' => 'The provided email does not match our records.']);
        }
    }
    public function check(){
        return view('dashboard.pages.auth.check-code');
    }
    public function checkCode(Request $request){
        $request->validate([
            'code' => 'required|string|min:6|max:6',
        ]);

        $email = Session::get('email');
        $user = User::where('email', $email)->where('code', $request->code)->first();

        if ($user) {
            return redirect()->route('resetPassword')->with('email', $email);
        } else {
            return back()->withErrors(['code' => 'The provided code is incorrect.']);
        }
    }

    public function resetPassword(){
        return view('dashboard.pages.auth.reset-password');
    }
    public function checkPassword(Request $request){
        $request->validate([
            'password' => 'required|string',
        ]);
        $email = Session::get('email');
        $user = User::where('email', $email)->first();

        if ($user) {
            $user->update([
                'password' => Hash::make($request->password)
            ]); 
            Session::forget('email');
            return redirect()->route('login');
        } else {
            return back()->withErrors(['code' => 'The provided code is incorrect.']);
        }
    }
    public function logout(Request $request)
    {
        $user = Auth::user();
        $user->session_id = null;
        $user->save();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}

