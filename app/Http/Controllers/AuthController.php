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
use Illuminate\Support\Facades\Session;
class AuthController extends Controller
{
    public function index()
    {
        return view('dashboard.pages.auth.login');
    }

    public function login(Request $request)
    {
        $cred = $request->only(['email','password']);
        $user = User::where('email', $request->email)->first();
        $today = Carbon::now()->toDateString();
        if($user->status === 'approved' ){
            if(Auth::attempt($cred))
            {
                Alert::toast('Welcome back','info');
                return redirect()->route('dashboard.home.index');
            } else
            {
                Alert::toast('Wrong credentials!','error');
                return back();
            }
        } else
        {
            Alert::toast('Wrong credentials!','error');
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
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}

