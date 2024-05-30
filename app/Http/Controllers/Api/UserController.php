<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function getUser(Request $request)
    { 
        $user = User::with('tintBrands.tintDetails')->find($request->user()->id);

        if (!$user) {
            return response()->json([
                'data' => null,
                'code' => 404,
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'data' => $user,
            'code' => 200,
            'message' => 'Data returned successfully'
        ], 200);
    }

}
