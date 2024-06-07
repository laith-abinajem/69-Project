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
        $user->video = $user->getFirstMediaUrl('videos');
        unset($user->media);
        unset($user->sub_id);
        unset($user->email_verified_at);
        unset($user->code);
        $user->tintBrands->each(function ($tintBrand) {
            $tintBrand->tint_logo = $tintBrand->getFirstMediaUrl('photos');
            unset($tintBrand->media);
    
            $groupedTintDetails = $tintBrand->tintDetails->groupBy(function ($detail) {
                return $detail->class_car . '-' . $detail->sub_class_car;
            })->map(function ($group) {
                return [
                    'id' => $group->first()->id,
                    'tint_id' => $group->first()->tint_id,
                    'class_car' => $group->first()->class_car,
                    'sub_class_car' => $group->first()->sub_class_car,
                    'window' => $group->pluck('window')->toArray(),
                    'price' => $group->pluck('price')->toArray(),
                    'created_at' => $group->first()->created_at,
                    'updated_at' => $group->first()->updated_at,
                ];
            })->values()->toArray();
    
            $tintBrand->tint_details = $groupedTintDetails;
            unset($tintBrand->tintDetails);
        });
        return response()->json([
            'data' => $user,
            'code' => 200,
            'message' => 'Data returned successfully'
        ], 200);
    }

}
