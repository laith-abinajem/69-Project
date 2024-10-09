<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailingDetails;
use App\Models\Detailing;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;

class DetailingController extends Controller
{
    public function index(Request $request)
    {
        if(auth()->user()->type === "super_admin"){
            $query = Detailing::query();
            if ($request->has('user_id')) {
                $query->where('user_id', $request->user_id);
            }
            $data = $query->get();
        } else {
            $data = Detailing::where('user_id', auth()->user()->id)->get();
        }
        $users = User::get();

        return view('dashboard.pages.detailing.index',compact('data','users'));
    }

    public function filter(Request $request)
    {
        $users = User::get();
        return view('dashboard.pages.detailing.filter',compact('users'));
    }
    public function create(Request $request)
    {
        $users = User::get();
        $exterior_count= Detailing::where('user_id',auth()->user()->id)->where('detailing_type','exterior')->count();
        $interior_count= Detailing::where('user_id',auth()->user()->id)->where('detailing_type','exterior')->count();
        $inout_count= Detailing::where('user_id',auth()->user()->id)->where('detailing_type','exterior')->count();
        $all_detailings = Detailing::select('id','detailing_brand')->get();
        
        return view('dashboard.pages.detailing.create',compact('all_detailings','users','exterior_count','interior_count','inout_count',));
    }
    public function store(Request $request)
    {
        $user_id = auth()->user()->id;
        if($request->user_id){
            $user = User::find($request->user_id);
            $user_id  = $request->user_id;
        }else{
            $user = User::find(auth()->user()->id);
        }
        $exterior_count= Detailing::where('user_id',$user->id)->where('detailing_type','exterior')->count();
        $interior_count= Detailing::where('user_id',$user->id)->where('detailing_type','interior')->count();
        $inout_count= Detailing::where('user_id',$user->id)->where('detailing_type','inout')->count();

        if($exterior_count > 4){
            Alert::toast("You can't add more than 4 exterior", 'error');
            return redirect()->route('dashboard.detailing.index' , ['user_id' => $user_id]);
        }
        
        if($interior_count > 4){
            Alert::toast("You can't add more than 4 exterior", 'error');
            return redirect()->route('dashboard.detailing.index', ['user_id' => $user_id]);
        }
        
        if($inout_count > 4){
            Alert::toast("You can't add more than 4 exterior", 'error');
            return redirect()->route('dashboard.detailing.index', ['user_id' => $user_id]);
        }

        $detailingBrand = Detailing::create([
            'detailing_brand' => $request->detailing_brand,
            'detailing_description' => $request->detailing_description,
            'detailing_type' => $request->detailing_type,
            'hex' => $request->hex,
            'warranty' => $request->warranty,
            'detailing_brand_level' => $request->detailing_brand_level,
            'user_id'=> $user->id
        ]);
        if ($request->hasFile('detailing_image')) {
            $detailingBrand->addMedia($request->file('detailing_image'))->toMediaCollection('detailing_image');
        }
        // Check if a URL is provided (optional)
        if ($request->filled('image_url')) {
            $detailingBrand->addMediaFromUrl($request->input('image_url'))->toMediaCollection('detailing_image');
        }
        $prices = $request->price;
        $hideValues = $request->hide; 
        foreach ($prices as $classCar => $subClasses) {
            foreach ($subClasses as $subClassCar => $windows) {
                foreach ($windows as $window => $price) {
                $details =   DetailingDetails::create([
                        'detailing_id' => $detailingBrand->id,
                        'class_car' => $classCar,
                        'sub_class_car' => $subClassCar,
                        'price' => $price,
                        'status' => $hideValues[$classCar] ?? 'false' 
                    ]);
                }
            }
        }
    
        Alert::toast('detailing Brand created successfully', 'success');
        return redirect()->route('dashboard.detailing.index', ['user_id' => $user_id]);
    
    }
    public function edit($id){
        $detailingBrand = Detailing::with('detailingDetails')->find($id);
        $users = User::get();
        $photos = $detailingBrand->getFirstMediaUrl('detailing_image');
        $exterior_count= Detailing::where('user_id',auth()->user()->id)->where('detailing_type','exterior')->count();
        $interior_count= Detailing::where('user_id',auth()->user()->id)->where('detailing_type','exterior')->count();
        $inout_count= Detailing::where('user_id',auth()->user()->id)->where('detailing_type','exterior')->count();
        return view('dashboard.pages.detailing.edit',compact('inout_count','interior_count','exterior_count','detailingBrand','users','photos'));
    }
    public function update(Request $request, $id){
        try {
            $user_id = auth()->user()->id;
            if($request->user_id){
                $user = User::find($request->user_id);
                $user_id  = $request->user_id;
            }else{
                $user = User::find(auth()->user()->id);
            }
            $exterior_count= Detailing::where('user_id',$user->id)->where('detailing_type','exterior')->count();
            $interior_count= Detailing::where('user_id',$user->id)->where('detailing_type','interior')->count();
            $inout_count= Detailing::where('user_id',$user->id)->where('detailing_type','inout')->count();
    
            if($exterior_count > 4){
                Alert::toast("You can't add more than 4 exterior", 'error');
                return redirect()->route('dashboard.detailing.index', ['user_id' => $user_id]);
            }
            
            if($interior_count > 4){
                Alert::toast("You can't add more than 4 exterior", 'error');
                return redirect()->route('dashboard.detailing.index', ['user_id' => $user_id]);
            }
            
            if($inout_count > 4){
                Alert::toast("You can't add more than 4 exterior", 'error');
                return redirect()->route('dashboard.detailing.index', ['user_id' => $user_id]);
            }
    
            $detailingBrand = Detailing::findOrFail($id);
            $detailingBrand->update([
                'detailing_brand' => $request->detailing_brand,
                'detailing_description' => $request->detailing_description,
                'detailing_type' => $request->detailing_type,
                'hex' => $request->hex,
                'detailing_brand_level' => $request->detailing_brand_level,
                'user_id'=> $user->id,
                'warranty' => $request->warranty,
            ]);
            if ($request->hasFile('detailing_image')) {
                $detailingBrand->addMedia($request->file('detailing_image'))->toMediaCollection('detailing_image');
            }
        
            $prices = $request->price;
            $hideValues = $request->hide; 
            DetailingDetails::where('detailing_id', $detailingBrand->id)->delete(); 
            foreach ($prices as $classCar => $subClasses) {
                foreach ($subClasses as $subClassCar => $windows) {
                    foreach ($windows as $window => $price) {
                    $details =   DetailingDetails::create([
                            'detailing_id' => $detailingBrand->id,
                            'class_car' => $classCar,
                            'sub_class_car' => $subClassCar,
                            'price' => $price,
                            'status' => $hideValues[$classCar] ?? 'false' 
                        ]);
                    }
                }
            }
        
            Alert::toast('detailing Brand updated successfully', 'success');
            return redirect()->route('dashboard.detailing.index', ['user_id' => $user_id]);
        
            } catch (\Exception $e) {
                Alert::toast('An error occurred while updating the TintBrand', 'error');
                return redirect()->back()->withInput();
            }
    }
    public function delete(Request $request,$id){
        $detailingBrand = Detailing::find($id);
        $user_id = $detailingBrand->user_id;
        $detailingBrand->delete();
        return redirect()->route('dashboard.detailing.index', ['user_id' => $user_id]);
    }
    public function getDetailingById(Request $request)
    {
        $data = Detailing::find($request->id);
        $photo = '';

        $photo = $data->getFirstMediaUrl('detailing_image');
        if ($data) {
            return response()->json([
                'success' => true,
                'data' => [
                    'detailing_brand' => $data->detailing_brand,
                    'detailing_description' => $data->detailing_description,
                    'detailing_type' => $data->detailing_type,
                    'hex' => $data->hex,
                    'detailing_brand_level' => $data->detailing_brand_level,
                    'warranty' => $data->warranty,
                    'photo' => $photo, 
                ],
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Detailing brand not found.'
            ], 404);
        }
    }
}
