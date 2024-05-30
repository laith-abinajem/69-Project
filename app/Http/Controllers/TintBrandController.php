<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\TintBrand;
use App\Models\TintDetails;

class TintBrandController extends Controller
{
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
}
