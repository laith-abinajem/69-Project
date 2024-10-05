<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LightTint;
use App\Models\LightTintDetails;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;
class LightTintController extends Controller
{
    public function index(Request $request)
    {
        if(auth()->user()->type === "super_admin"){
            $query = LightTint::query();
            if ($request->has('user_id')) {
                $query->where('user_id', $request->user_id);
            }
            $data = $query->get();
        } else {
            $data = LightTint::where('user_id', auth()->user()->id)->get();
        }
        $users = User::get();
        return view('dashboard.pages.light.index',compact('data','users'));
    }

    public function filter(Request $request)
    {
        $users = User::get();
        return view('dashboard.pages.light.filter',compact('users'));
    }
    public function create(Request $request)
    {
        $users = User::get();
        return view('dashboard.pages.light.create',compact('users'));
    }
    public function store(Request $request)
    {
        try{
            $user_id = auth()->user()->id;
            if($request->user_id){
                $user = User::find($request->user_id);
                $user_id  = $request->user_id;
            }else{
                $user = User::find(auth()->user()->id);
            }
            if($user->lightTints->count() >= 5){
                Alert::toast('You cant add more than 5 ppf', 'error');
                return redirect()->route('dashboard.ppf.index' , ['user_id' => $user_id]);
            }
            $lightTint = LightTint::create([
                'light_brand' => $request->light_brand,
                'light_description' => $request->light_description,
                'hex' => $request->hex,
                'warranty' => $request->warranty,
                'user_id'=> $user->id
            ]);
            if ($request->hasFile('light_image')) {
                $lightTint->addMedia($request->file('light_image'))->toMediaCollection('light_image');
            }
        
            $prices = $request->price;
            $hideValues = $request->hide; 
            foreach ($prices as $classCar => $subClasses) {
                foreach ($subClasses as $subClassCar => $windows) {
                    foreach ($windows as $window => $price) {
                    $windowNumber = explode('_', $window)[0];
                    $details =   LightTintDetails::create([
                            'light_id' => $lightTint->id,
                            'class_car' => $classCar,
                            'sub_class_car' => $subClassCar,
                            'light_type' => $windowNumber,
                            'price' => $price,
                            'status' => $hideValues[$classCar] ?? 'false' 
                        ]);
                    }
                }
            }
           
            Alert::toast('Light tint created successfully', 'success');
            return redirect()->route('dashboard.light.index', ['user_id' => $user_id]);
        } catch (\Exception $e) {
            Alert::toast('An error occurred while updating the Light tint', 'error');
            return redirect()->back()->withInput();
        }
    }
    public function edit($id){
        $lightTint = LightTint::with('lightDetails')->find($id);
        $users = User::get();
        $photos = $lightTint->getFirstMediaUrl('light_image');
        return view('dashboard.pages.light.edit',compact('lightTint','users','photos'));
    }
    public function update(Request $request, $id){
        try{
            $user_id = auth()->user()->id;
            if($request->user_id){
                $user = User::find($request->user_id);
                $user_id  = $request->user_id;
            }
            $lightTint = LightTint::findOrFail($id);
            $lightTint->update([
                'light_brand' => $request->light_brand,
                'light_description' => $request->light_description,
                'hex' => $request->hex,
                'warranty' => $request->warranty,
                'user_id'=> $user_id
            ]);
    
            if ($request->hasFile('light_image')) {
                $lightTint->clearMediaCollection('light_image');
                $lightTint->addMedia($request->file('light_image'))->toMediaCollection('light_image');
            }
    
            $prices = $request->price;
            $hideValues = $request->hide; 
            LightTintDetails::where('light_id', $lightTint->id)->delete(); 
            foreach ($prices as $classCar => $subClasses) {
                foreach ($subClasses as $subClassCar => $windows) {
                    foreach ($windows as $window => $price) {
                        $windowNumber = explode('_', $window)[0];
                        LightTintDetails::create([
                            'light_id' => $lightTint->id,
                            'class_car' => $classCar,
                            'sub_class_car' => $subClassCar,
                            'light_type' => $windowNumber,
                            'price' => $price,
                            'status' => $hideValues[$classCar] ?? 'false' 
                        ]);
                    }
                }
            }
    
            Alert::toast('Light tint updated successfully', 'success');
            return redirect()->route('dashboard.light.index', ['user_id' => $user_id]);
        } catch (\Exception $e) {
            Alert::toast('An error occurred while updating the Light tint', 'error');
            return redirect()->back()->withInput();
        }
   
    }
    public function delete(Request $request,$id){
        $data = LightTint::find($id);
        $user_id = $data->user_id;
        $data->delete();
        toast('Success','success');
        return redirect()->route('dashboard.light.index', ['user_id' => $user_id]);
    }
    public function getLightById(Request $request, $id)
    {
        $data = LightTint::find($id);
        
        if ($data) {
            return response()->json([
                'success' => true,
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'light brand not found.'
            ], 404);
        }
    }
}
