<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AddsOn;
use App\Models\Car;

class UserController extends Controller
{
    public function getUser(Request $request)
    { 
        $currencySymbols = [
            'USD' => '$',
            'EUR' => '€',
            'JPY' => '¥',
            'GBP' => '£',
            'AUD' => 'A$',
            'CAD' => 'C$',
            'CHF' => 'CHF',
            'CNY' => '¥',
            'SEK' => 'kr',
            'NZD' => 'NZ$',
            'MXN' => '$',
            'SGD' => 'S$',
            'HKD' => 'HK$',
            'NOK' => 'kr',
            'KRW' => '₩',
            'TRY' => '₺',
            'INR' => '₹',
            'RUB' => '₽',
            'BRL' => 'R$',
            'ZAR' => 'R'
        ];
    
        $user = User::with(['tintBrands.tintDetails', 'tintBrands.media'])->find($request->user()->id);

        if (!$user) {
            return response()->json([
                'data' => null,
                'code' => 404,
                'message' => 'User not found'
            ], 404);
        }
        $currencyCode = $user->currency; // assuming 'currency' is the field name in your users table
        $currencySymbol = isset($currencySymbols[$currencyCode]) ? $currencySymbols[$currencyCode] : $currencyCode;
        $user->company_logo = $user->getFirstMediaUrl('company_logo');
        $user->decal_logo = $user->getFirstMediaUrl('decal_logo');
        $user->detailing_decal = $user->getFirstMediaUrl('detailing_decal');
        $user->video = $user->getFirstMediaUrl('videos');
        unset($user->media);
        unset($user->sub_id);
        unset($user->email_verified_at);
        unset($user->code);
        unset($user->card_id);
        unset($user->square_customer_id);
        unset($user->session_id);
        unset($user->parent_id);
        $user->currency = $currencySymbol; 
        // Fetch add-ons related to 'tint' service for the user
        $addons_tint = AddsOn::where('user_id', $user->id)
        ->where('service', 'tint')
        ->get()
        ->map(function ($addon) {
            return [
                'id' => $addon->id,
                'service' => $addon->service,
                'name' => $addon->name,
                'description' => $addon->description,
                'price' => $addon->price,
                'hex' => $addon->hex,
                'media_url' => $addon->getMediaUrlAttribute(),
                'created_at' => $addon->created_at,
                'updated_at' => $addon->updated_at,
            ];
        });

        // $user->addons = $addons;

        $user->tintBrands->each(function ($tintBrand) use ($addons_tint) {
            $tintBrand->tint_logo = $tintBrand->getFirstMediaUrl('photos');
            unset($tintBrand->media);
            // Attach add-ons to the tint brand
            $tintBrand->addons = $addons_tint;
            $groupedTintDetails = $tintBrand->tintDetails->groupBy(function ($detail) {
                // Clean class_car value by removing spaces and parentheses
                $classCar = str_replace([' ', '(', ')'], '', $detail->class_car);
                return $classCar . '-' . $detail->sub_class_car;
            })->map(function ($group) {
                // Clean the class_car value for the output
                $classCar = str_replace([' ', '(', ')'], '', $group->first()->class_car);
                $subClassCar = str_replace([' ', '(', ')'], '', $group->first()->sub_class_car);
                return [
                    'id' => $group->first()->id,
                    'tint_id' => $group->first()->tint_id,
                    'class_car' => $classCar,
                    'sub_class_car' => $subClassCar,
                    'hide' => $group->first()->status,
                    'window' => $group->pluck('window')->toArray(),
                    'price' => $group->pluck('price')->toArray(),
                    'created_at' => $group->first()->created_at,
                    'updated_at' => $group->first()->updated_at,
                ];
            })->values()->toArray();
        
            $tintBrand->tint_details = $groupedTintDetails;
            unset($tintBrand->tintDetails);
            // Collect class_car values where hide is false
            $tintBrand->exclude_class = collect($groupedTintDetails)
            ->filter(function ($detail) {
                return $detail['hide'] === 'true';
            })
            ->pluck('class_car')
            ->unique()
            ->values()
            ->toArray();
        });
        $addons_ppf = AddsOn::where('user_id', $user->id)
        ->where('service', 'ppf')
        ->get()
        ->map(function ($addon) {
            return [
                'id' => $addon->id,
                'service' => $addon->service,
                'name' => $addon->name,
                'description' => $addon->description,
                'price' => $addon->price,
                'hex' => $addon->hex,
                'media_url' => $addon->getMediaUrlAttribute(),
                'created_at' => $addon->created_at,
                'updated_at' => $addon->updated_at,
            ];
        });
        $user->ppfBrands->each(function ($ppfBrand)  use ($addons_ppf){
            $ppfBrand->ppf_image = $ppfBrand->getFirstMediaUrl('ppf_image');
            unset($ppfBrand->media);
            $ppfBrand->addons = $addons_ppf;
    
            $groupedPpfDetails = $ppfBrand->ppfDetails->groupBy(function ($detail) {
                $classCar = str_replace([' ', '(', ')'], '', $detail->class_car);
                return $classCar . '-' . $detail->sub_class_car;
            })->map(function ($group) {
                // Clean the class_car value for the output
                $classCar = str_replace([' ', '(', ')'], '', $group->first()->class_car);
                $subClassCar = str_replace([' ', '(', ')'], '', $group->first()->sub_class_car);

                return [
                    'id' => $group->first()->id,
                    'ppf_id' => $group->first()->ppf_id,
                    'class_car' => $classCar,
                    'sub_class_car' => $subClassCar,
                    'hide' => $group->first()->status,
                    'ppf_type' => $group->pluck('ppf_type')->toArray(),
                    'price' => $group->pluck('price')->toArray(),
                    'created_at' => $group->first()->created_at,
                    'updated_at' => $group->first()->updated_at,
                ];
            })->values()->toArray();
    
            $ppfBrand->ppf_details = $groupedPpfDetails;
            unset($ppfBrand->ppfDetails);
            $ppfBrand->exclude_class = collect($groupedPpfDetails)
            ->filter(function ($detail) {
                return $detail['hide'] === 'true';
            })
            ->pluck('class_car')
            ->unique()
            ->values()
            ->toArray();
        });
        $addons_light = AddsOn::where('user_id', $user->id)
        ->where('service', 'light-tint')
        ->get()
        ->map(function ($addon) {
            return [
                'id' => $addon->id,
                'service' => $addon->service,
                'name' => $addon->name,
                'description' => $addon->description,
                'price' => $addon->price,
                'hex' => $addon->hex,
                'media_url' => $addon->getMediaUrlAttribute(),
                'created_at' => $addon->created_at,
                'updated_at' => $addon->updated_at,
            ];
        });
        $user->lightTints->each(function ($lightTint) use ($addons_light) {
            $lightTint->light_image = $lightTint->getFirstMediaUrl('light_image');
            unset($lightTint->media);
            $lightTint->addons = $addons_light;
        
            // Sanitize class_car before grouping
            $groupedLightsDetails = $lightTint->lightDetails->map(function ($detail) {
                $detail->class_car = str_replace([' ', '(', ')'], '', $detail->class_car);
                $detail->sub_class_car = str_replace([' ', '(', ')'], '', $detail->sub_class_car);
                return $detail;
            })->groupBy(function ($detail) {
                return $detail->class_car . '-' . $detail->sub_class_car;
            })->map(function ($group) {
                $classCar = str_replace([' ', '(', ')'], '', $group->first()->class_car);
                $subClassCar = str_replace([' ', '(', ')'], '', $group->first()->sub_class_car);
                return [
                    'id' => $group->first()->id,
                    'light_id' => $group->first()->light_id,
                    'class_car' => $classCar,
                    'sub_class_car' =>  $subClassCar,
                    'hide' => $group->first()->status,
                    'light_type' => $group->pluck('light_type')->toArray(),
                    'price' => $group->pluck('price')->toArray(),
                    'created_at' => $group->first()->created_at,
                    'updated_at' => $group->first()->updated_at,
                ];
            })->values()->toArray();
        
            $lightTint->light_details = $groupedLightsDetails;
            unset($ppfBrand->lightDetails);
            $lightTint->exclude_class = collect($groupedLightsDetails)
            ->filter(function ($detail) {
                return $detail['hide'] === 'true';
            })
            ->pluck('class_car')
            ->unique()
            ->values()
            ->toArray();
        });
        $addons_detailing = AddsOn::where('user_id', $user->id)
        ->where('service', 'detailing')
        ->get()
        ->map(function ($addon) {
            return [
                'id' => $addon->id,
                'service' => $addon->service,
                'name' => $addon->name,
                'description' => $addon->description,
                'price' => $addon->price,
                'hex' => $addon->hex,
                'media_url' => $addon->getMediaUrlAttribute(),
                'created_at' => $addon->created_at,
                'updated_at' => $addon->updated_at,
            ];
        });
        $user->detailingBrands->each(function ($detailingBrand) use ($addons_detailing)  {
            $detailingBrand->detailing_image = $detailingBrand->getFirstMediaUrl('detailing_image');
            unset($detailingBrand->media);
            // Attach add-ons to the tint brand
            $detailingBrand->addons = $addons_detailing;
            $groupedDetailingDetails = $detailingBrand->detailingDetails->map(function ($detail) {
                // Clean both class_car and sub_class_car values
                $detail->class_car = str_replace([' ', '(', ')'], '', $detail->class_car);
                $detail->sub_class_car = str_replace([' ', '(', ')'], '', $detail->sub_class_car);
                return $detail;
            })->groupBy(function ($detail) {
                return $detail->class_car . '-' . $detail->sub_class_car;
            })->map(function ($group) {
                // Clean the class_car and sub_class_car values for the output
                $classCar = str_replace([' ', '(', ')'], '', $group->first()->class_car);
                $subClassCar = str_replace([' ', '(', ')'], '', $group->first()->sub_class_car);
                return [
                    'id' => $group->first()->id,
                    'detailing_id' => $group->first()->detailing_id,
                    'class_car' => $classCar,
                    'sub_class_car' => $subClassCar,
                    'hide' => $group->first()->status,
                    'price' => $group->first()->price,  // Use the price of the first item in the group
                    'created_at' => $group->first()->created_at,
                    'updated_at' => $group->first()->updated_at,
                ];
            })->values()->toArray();
    
            $detailingBrand->detailing_details = $groupedDetailingDetails;
            unset($detailingBrand->detailingDetails);
            $detailingBrand->exclude_class = collect($groupedDetailingDetails)
            ->filter(function ($detail) {
                return $detail['hide'] === 'true';
            })
            ->pluck('class_car')
            ->unique()
            ->values()
            ->toArray();
        });
        return response()->json([
            'data' => $user,
            'code' => 200,
            'message' => 'Data returned successfully'
        ], 200);
    }
    public function getCars(Request $request)
    {    
        $cars = Car::select('Year', 'Make', 'Model')->get();
        return response()->json([
            'data' => $cars,
            'code' => 200,
            'message' => 'Data returned successfully'
        ], 200);
    }
}
