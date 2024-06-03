<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\TintBrand;
use App\Models\TintDetails;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;
class TintBrandController extends Controller
{
    public function index(Request $request)
    {
        $data = TintBrand::get();
        return view('dashboard.pages.tint.index',compact('data'));
    }
    public function create(Request $request)
    {
        return view('dashboard.pages.tint.create');
    }
    public function store(Request $request)
    {
        try {
            $tintBrand = TintBrand::create([
                'tint_brand' => $request->tint_brand,
                'tint_description' => $request->tint_description,
                'user_id'=> Auth::user()->id
            ]);
            if ($request->hasFile('tint_image')) {
                $tintBrand->addMedia($request->file('tint_image'))->toMediaCollection('photos');
            }
        
            // Prepare data for the tint_details table
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
         catch (\Exception $e) {
            Alert::toast('An error occurred while creating the TintBrand', 'error');
            return redirect()->back()->withInput();
        }
    }
    public function edit($id){
        $tintBrand = TintBrand::with('tintDetails')->find($id);
        return view('dashboard.pages.tint.edit',compact('tintBrand'));
    }
    public function update(Request $request, $id){
        try {
            $tintBrand = TintBrand::findOrFail($id);
            $tintBrand->update([
                'tint_brand' => $request->tint_brand,
                'tint_description' => $request->tint_description,
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
