<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Mail;
use Illuminate\Support\Facades\Hash;

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
        ]);
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'type' => $request->type,
                'status' => $request->status,
                'password' => Hash::make($request->password),
            ]);
            if ($request->hasFile('company_logo')) {
                $user->addMedia($request->file('company_logo'))->toMediaCollection('company_logo');
            }
            if ($request->hasFile('decal_logo')) {
                $user->addMedia($request->file('decal_logo'))->toMediaCollection('decal_logo');
            }
            // $title = 'welcomes';
            // $this->sendEmailCreateUser($request->email ,$request->password , $title ,$request->name ,'');
            Alert::toast('User created successfully', 'success');
            return redirect()->route('dashboard.user.index');
        } catch (\Exception $e) {
            Alert::toast('An error occurred while creating the User', 'error');
            return redirect()->back()->withInput();
        }
       
    }
    public function edit($id){
        $data = User::find($id);
        return view('dashboard.pages.user.edit',compact('data'));
    }
    public function update(Request $request, $id){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);
        try {
            $user = User::find($id);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'type' => $request->type,
                'status' => $request->status,
                'password' => Hash::make($request->password),
            ]);
            Alert::toast('User created successfully', 'success');
            return redirect()->route('dashboard.user.index');
        } catch (\Exception $e) {
            Alert::toast('An error occurred while creating the User', 'error');
            return redirect()->back()->withInput();
        }
        return redirect()->route('dashboard.user.index');
    }
    public function updateStatus(Request $request)
    {
        $user = User::find($request->user_id);
        if ($user) {
            $user->update([
                'status' => $request->status,
            ]);
            return response()->json(['message' => 'Status updated successfully'], 200);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }
    public function delete(Request $request,$id){
        $data = User::find($id);
        $data->delete();
        toast('Success','success');
        return redirect()->route('dashboard.user.index');
    }
    public function sendEmailCreateUser($email , $password , $title , $name, $message){
            
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $data = [
                    'subject' =>  $title,
                    'email'   =>  $email,
                    'content' => $message,
                    'name' => $name,
                    'message' => $message,
                    'password' => $password
                ];
                Mail::send('views.email', $data, function($message) use ($data) {
                    $message->to($data['email'])
                    ->subject($data['subject']);
                });
            }
    
             return true;
    }
}
