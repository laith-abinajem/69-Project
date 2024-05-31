<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data = User::get();
        return view('dashboard.pages.user.index',compact('data'));
    }
    public function create(Request $request)
    {
        return view('dashboard.pages.user.create');
    }
    public function store(Request $request)
    {   
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required',
            'price' => 'required',
        ]);
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'type' => $request->type,
                'status' => $request->status,
                'password' => Hash::make($request->password),
            ]);
           
            Alert::toast('TintBrand created successfully', 'success');
            return redirect()->route('tintbrands.index');
        } catch (\Exception $e) {
            Alert::toast('An error occurred while creating the TintBrand', 'error');
            return redirect()->back()->withInput();
        }
       
    }
    public function edit($id){
        $data = User::find($id);
        return view('dashboard.pages.user.edit',compact('data'));
    }
    public function update(Request $request, $id){
    
        toast('Success', 'success');
        return redirect()->route('dashboard.user.index');
    }
    public function delete(Request $request,$id){
        $data = User::find($id);
        $data->delete();
        toast('Success','success');
        return redirect()->route('dashboard.user.index');
    }
}
