<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\TintBrand;
use App\Models\TintDetails;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;

class TintBrandController extends Controller
{
    public function index(Request $request)
    {
        if(auth()->user()->type === "super_admin"){
            $query = TintBrand::query();
            if ($request->has('user_id')) {
                $query->where('user_id', $request->user_id);
            }
            $data = $query->get();
        } else {
            $data = TintBrand::where('user_id', auth()->user()->id)->get();
        }
        $users = User::get();
        return view('dashboard.pages.tint.index',compact('data','users'));
    }

    public function filter(Request $request)
    {
        $users = User::get();
        return view('dashboard.pages.tint.filter',compact('users'));
    }
    public function create(Request $request)
    {
        $users = User::get();

        return view('dashboard.pages.tint.create',compact('users'));
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
            if($user->tintBrands->count() >= 5){
                Alert::toast('You cant add more than 5 tint', 'error');
                return redirect()->route('dashboard.tint.index');
            }
            $tintBrand = TintBrand::create([
                'tint_brand' => $request->tint_brand,
                'tint_description' => $request->tint_description,
                'tint_brand_level' => $request->tint_brand_level,
                'hex' => $request->hex,
                'guage_level' => $request->guage_level,
                'user_id'=> $user->id
            ]);
            if ($request->hasFile('tint_image')) {
                $tintBrand->addMedia($request->file('tint_image'))->toMediaCollection('photos');
            }
        
            $prices = $request->price;
            foreach ($prices as $classCar => $subClasses) {
                foreach ($subClasses as $subClassCar => $windows) {
                    foreach ($windows as $window => $price) {
                    $windowNumber = explode('_', $window)[0];
                    $details =   TintDetails::create([
                            'tint_id' => $tintBrand->id,
                            'class_car' => $classCar,
                            'sub_class_car' => $subClassCar,
                            'window' => $windowNumber,
                            'price' => $price
                        ]);
                    }
                }
            }
           
            Alert::toast('TintBrand created successfully', 'success');
            return redirect()->route('dashboard.tint.index');
       
    }
    public function edit($id){
        $tintBrand = TintBrand::with('tintDetails')->find($id);
        $users = User::get();
        $photos = $tintBrand->getFirstMediaUrl('photos');
        return view('dashboard.pages.tint.edit',compact('tintBrand','users','photos'));
    }
    public function update(Request $request, $id){
        try {
            $user_id = auth()->user()->id;
            if($request->user_id){
                $user = User::find($request->user_id);
                $user_id  = $request->user_id;
            }
            $tintBrand = TintBrand::findOrFail($id);
            $tintBrand->update([
                'tint_brand' => $request->tint_brand,
                'tint_description' => $request->tint_description,
                'tint_brand_level' => $request->tint_brand_level,
                'hex' => $request->hex,
                'guage_level' => $request->guage_level,
                'user_id'=> $user_id
            ]);
    
            if ($request->hasFile('tint_image')) {
                $tintBrand->clearMediaCollection('photos');
                $tintBrand->addMedia($request->file('tint_image'))->toMediaCollection('photos');
            }
    
            $prices = $request->price;
            TintDetails::where('tint_id', $tintBrand->id)->delete(); 
            foreach ($prices as $classCar => $subClasses) {
                foreach ($subClasses as $subClassCar => $windows) {
                    foreach ($windows as $window => $price) {
                        $windowNumber = explode('_', $window)[0];
                        TintDetails::create([
                            'tint_id' => $tintBrand->id,
                            'class_car' => $classCar,
                            'sub_class_car' => $subClassCar,
                            'window' => $windowNumber,
                            'price' => $price
                        ]);
                    }
                }
            }
    
            Alert::toast('TintBrand updated successfully', 'success');
            return redirect()->route('dashboard.tint.index');
        } catch (\Exception $e) {
            Alert::toast('An error occurred while updating the TintBrand', 'error');
            return redirect()->back()->withInput();
        }
    }
    public function delete(Request $request,$id){
        $data = TintBrand::find($id);
        $data->delete();
        toast('Success','success');
        return redirect()->route('dashboard.tint.index');
    }
}
