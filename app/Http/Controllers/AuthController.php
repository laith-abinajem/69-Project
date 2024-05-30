<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use RealRashid\SweetAlert\Facades\Alert;
class AuthController extends Controller
{
    public function index()
    {
        return view('dashboard.login');
    }

    public function login(Request $request)
    {
        $cred = $request->only(['email','password']);
        if(Auth::attempt($cred))
        {
            Alert::toast('Welcome back','info');
            return redirect()->route('dashboard.home.index');
        }
        else
        {
            Alert::toast('Wrong credentials!','error');
            return back();
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
