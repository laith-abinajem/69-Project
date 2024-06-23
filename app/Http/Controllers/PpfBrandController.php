<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PpfBrand;
use App\Models\TintDetails;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;
class PpfBrandController extends Controller
{
    public function index(Request $request)
    {
        if(auth()->user()->type === "super_admin"){
            $query = PpfBrand::query();
            if ($request->has('user_id')) {
                $query->where('user_id', $request->user_id);
            }
            $data = $query->get();
        } else {
            $data = PpfBrand::where('user_id', auth()->user()->id)->get();
        }
        $users = User::get();
        return view('dashboard.pages.ppf.index',compact('data','users'));
    }

    public function filter(Request $request)
    {
        $users = User::get();
        return view('dashboard.pages.ppf.filter',compact('users'));
    }
    public function create(Request $request)
    {
        $users = User::get();
        return view('dashboard.pages.ppf.create',compact('users'));
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
                Alert::toast('You cant add more than 5 ppf', 'error');
                return redirect()->route('dashboard.ppf.index');
            }
            $ppfBrand = PpfBrand::create([
                'tint_brand' => $request->tint_brand,
                'tint_description' => $request->tint_description,
                'hex' => $request->hex,
                'guage_level' => $request->guage_level,
                'user_id'=> $user->id
            ]);
            if ($request->hasFile('tint_image')) {
                $ppfBrand->addMedia($request->file('tint_image'))->toMediaCollection('photos');
            }
        
            $prices = $request->price;
            foreach ($prices as $classCar => $subClasses) {
                foreach ($subClasses as $subClassCar => $windows) {
                    foreach ($windows as $window => $price) {
                    $windowNumber = explode('_', $window)[0];
                    $details =   TintDetails::create([
                            'tint_id' => $ppfBrand->id,
                            'class_car' => $classCar,
                            'sub_class_car' => $subClassCar,
                            'window' => $windowNumber,
                            'price' => $price
                        ]);
                    }
                }
            }
           
            Alert::toast('Ppf Brand created successfully', 'success');
            return redirect()->route('dashboard.ppf.index');
       
    }
    public function edit($id){
        $ppfBrand = PpfBrand::with('ppfDetails')->find($id);
        $users = User::get();
        $photos = $ppfBrand->getFirstMediaUrl('photos');
        return view('dashboard.pages.ppf.edit',compact('ppfBrand','users','photos'));
    }
    public function update(Request $request, $id){
        try {
            $user_id = auth()->user()->id;
            if($request->user_id){
                $user = User::find($request->user_id);
                $user_id  = $request->user_id;
            }
            $ppfBrand = PpfBrand::findOrFail($id);
            $ppfBrand->update([
                'tint_brand' => $request->tint_brand,
                'tint_description' => $request->tint_description,
                'hex' => $request->hex,
                'guage_level' => $request->guage_level,
                'user_id'=> $user_id
            ]);
    
            if ($request->hasFile('tint_image')) {
                $ppfBrand->clearMediaCollection('photos');
                $ppfBrand->addMedia($request->file('tint_image'))->toMediaCollection('photos');
            }
    
            $prices = $request->price;
            TintDetails::where('tint_id', $ppfBrand->id)->delete(); 
            foreach ($prices as $classCar => $subClasses) {
                foreach ($subClasses as $subClassCar => $windows) {
                    foreach ($windows as $window => $price) {
                        $windowNumber = explode('_', $window)[0];
                        TintDetails::create([
                            'tint_id' => $ppfBrand->id,
                            'class_car' => $classCar,
                            'sub_class_car' => $subClassCar,
                            'window' => $windowNumber,
                            'price' => $price
                        ]);
                    }
                }
            }
    
            Alert::toast('Ppf Brand updated successfully', 'success');
            return redirect()->route('dashboard.ppf.index');
        } catch (\Exception $e) {
            Alert::toast('An error occurred while updating the Ppf Brand', 'error');
            return redirect()->back()->withInput();
        }
    }
    public function delete(Request $request,$id){
        $data = PpfBrand::find($id);
        $data->delete();
        toast('Success','success');
        return redirect()->route('dashboard.ppf.index');
    }
}
