<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Detailing;
use App\Models\User;

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
        $exterior_count=0;
        $interior_count=0;
        $inout_count=0;
        return view('dashboard.pages.detailing.create',compact('users','exterior_count','interior_count','inout_count',));
    }
    public function store(Request $request)
    {
       
    }
    public function edit($id){
        $tintBrand = Detailing::find($id);
        $users = User::get();
        $photos = $tintBrand->getFirstMediaUrl('photos');
        $exterior_count=0;
        $interior_count=0;
        $inout_count=0;
        return view('dashboard.pages.detailing.edit',compact('inout_count','interior_count','exterior_count','tintBrand','users','photos'));
    }
    public function update(Request $request, $id){
        try {
        
        } catch (\Exception $e) {
            Alert::toast('An error occurred while updating the TintBrand', 'error');
            return redirect()->back()->withInput();
        }
    }
    public function delete(Request $request,$id){
    
        return redirect()->route('dashboard.detailing.index');
    }
}
