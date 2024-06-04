<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\Package;
use RealRashid\SweetAlert\Facades\Alert;

class PackageController extends Controller
{
    public function index(){
        $data = Package::get();
        return view('dashboard.pages.package.index',compact('data'));
    }
    public function create(){
        return view('dashboard.pages.package.create');
    }
    public function store(Request $request)
    {
        try {
            $package = Package::create([
                'name' => $request->name,
                'price' => $request->price,
                'days'=> $request->days
            ]);
            
            Alert::toast('Package created successfully', 'success');
            return redirect()->route('dashboard.package.index');
        }
         catch (\Exception $e) {
            Alert::toast('An error occurred while creating the Package', 'error');
            return redirect()->back()->withInput();
        }
    }
    public function edit($id,Request $request){

    }
    public function update($id,Request $request){
        
    }
    public function delete(Request $request,$id){
        $data = Package::find($id);
        $data->delete();
        toast('Success','success');
        return redirect()->route('dashboard.package.index');
    }
}
