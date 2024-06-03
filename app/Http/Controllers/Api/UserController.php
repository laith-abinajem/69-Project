<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function getUser(Request $request)
    { 
        $user = User::with(['tintBrands.tintDetails', 'tintBrands.media'])->find($request->user()->id);

        if (!$user) {
            return response()->json([
                'data' => null,
                'code' => 404,
                'message' => 'User not found'
            ], 404);
        }
        $user->company_logo = $user->getFirstMediaUrl('company_logo');
        $user->decal_logo = $user->getFirstMediaUrl('decal_logo');
        unset($user->media);
        $user->tintBrands->each(function ($tintBrand) {
            $tintBrand->tint_logo = $tintBrand->getFirstMediaUrl('photos');
            unset($tintBrand->media); 
        });
        return response()->json([
            'data' => $user,
            'code' => 200,
            'message' => 'Data returned successfully'
        ], 200);
    }

}
