<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\TintBrand;
use App\Models\TintDetails;
use RealRashid\SweetAlert\Facades\Alert;

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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'class_car' => 'required',
            'sub_class_car' => 'required',
            'window' => 'required',
            'price' => 'required',
        ]);
        try {
            $tintBrand = TintBrand::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
            ]);

            if ($request->hasFile('photo')) {
                $tintBrand->addMedia($request->file('photo'))->toMediaCollection('photos');
            }
            Alert::toast('TintBrand created successfully', 'success');
            return redirect()->route('tintbrands.index');
        } catch (\Exception $e) {
            Alert::toast('An error occurred while creating the TintBrand', 'error');
            return redirect()->back()->withInput();
        }
    }
    public function edit($id){
        $data = TintBrand::find($id);
        return view('dashboard.pages.tint.edit',compact('data'));
    }
    public function update(Request $request, $id){
    
        toast('Success', 'success');
        return redirect()->route('dashboard.tint.index');
    }
    public function delete(Request $request,$id){
        $data = TintBrand::find($id);
        $data->delete();
        toast('Success','success');
        return redirect()->route('dashboard.tint.index');
    }
}
