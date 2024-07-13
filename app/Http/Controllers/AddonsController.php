<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AddsOn;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;
class AddonsController extends Controller
{
    public function index(Request $request)
    {
        if(auth()->user()->type === "super_admin"){
            $query = AddsOn::query();
            if ($request->has('user_id')) {
                $query->where('user_id', $request->user_id);
            }
            $data = $query->get();
        } else {
            $data = AddsOn::where('user_id', auth()->user()->id)->get();
        }
        $users = User::get();
        return view('dashboard.pages.addons.index',compact('data','users'));
    }
    public function filter(Request $request)
    {
        $users = User::get();
        return view('dashboard.pages.addons.filter',compact('users'));
    }
    public function create(Request $request)
    {
        $users = User::get();
        return view('dashboard.pages.addons.create',compact('users'));
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
        $addson = AddsOn::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'hex' => $request->hex,
            'service' => $request->service,
            'user_id'=> $user->id
        ]);
        if ($request->hasFile('addon_image')) {
            $addson->addMedia($request->file('addon_image'))->toMediaCollection('addon_image');
        }
    
        Alert::toast('Service created successfully', 'success');
        return redirect()->route('dashboard.addons.index', ['user_id' => $user_id]);
       
    }
    public function edit($id){
        $data = AddsOn::find($id);
        $users = User::get();
        $photos = $data->getFirstMediaUrl('addon_image');
        return view('dashboard.pages.addons.edit',compact('data','users','photos'));
    }
    public function update(Request $request, $id){
        try {
            $user_id = auth()->user()->id;
            if($request->user_id){
                $user = User::find($request->user_id);
                $user_id  = $request->user_id;
            }
            $addson = AddsOn::findOrFail($id);
            $addson->update([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'hex' => $request->hex,
                'service' => $request->service,
                'user_id'=> $user->id
            ]);
    
            if ($request->hasFile('addon_image')) {
                $addson->clearMediaCollection('addon_image');
                $addson->addMedia($request->file('addon_image'))->toMediaCollection('addon_image');
            }
            Alert::toast('Service updated successfully', 'success');
            return redirect()->route('dashboard.addons.index' , ['user_id' => $user_id]);
        } catch (\Exception $e) {
            Alert::toast('An error occurred while updating the Service', 'error');
            return redirect()->back()->withInput();
        }
    }
    public function delete(Request $request,$id){
        $addson = AddsOn::find($id);
        $user_id = $addson->user_id;
        $addson->delete();
        toast('Success','success');
        return redirect()->route('dashboard.addons.index', ['user_id' => $user_id]);
    }
}
