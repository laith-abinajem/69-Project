<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function getUser(Request $request)
    {
        if (!$user = $request->user()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        return response()->json(['user' => $user], 200);
    }

}
