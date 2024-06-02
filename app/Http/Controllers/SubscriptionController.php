<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
class SubscriptionController extends Controller
{
    public function index(){
        $data = Subscription::get();
        return view('dashboard.pages.subscription.index',compact('data'));
    }
    public function create(){
        return view('dashboard.pages.subscription.create');
    }
    public function store(Request $request){

    }
    public function edit($id,Request $request){

    }
    public function update($id,Request $request){
        
    }
}
