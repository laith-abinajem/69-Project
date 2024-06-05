<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $tokenResult = $user->createToken('LaravelAuthApp');
        $accessToken = $tokenResult->plainTextToken; 
    
        return response()->json(['token' => $accessToken], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $user = User::find(auth()->user()->id);
            $today = Carbon::now()->toDateString();
            $sub = Subscription::where('user_id',$user->id)->where('end_date', '>', $today)->count();
            if($user->status === 'approved' && $sub > 0 ){
                $tokenResult = auth()->user()->createToken('LaravelAuthApp');
                $accessToken = $tokenResult->plainTextToken; 
                return response()->json(['token' => $accessToken], 200);
            }else {
                return response()->json(['error' => 'Your account/subscription is not active '], 401);
            }
        } else {
            return response()->json(['error' => 'Wrong email or password'], 401);
        }
    }

}
