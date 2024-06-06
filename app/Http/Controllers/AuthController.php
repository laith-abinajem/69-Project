<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;
use App\Models\Subscription;
use Carbon\Carbon;
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
    public function check(){
        return view('dashboard.pages.auth.check-code');

    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
