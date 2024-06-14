<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;
use Mail;
use Square\SquareClient;
use App\Mail\AppMail;
use Illuminate\Support\Facades\Hash;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage; 
use App\Models\Package;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
class UserController extends Controller
{
    public function index(Request $request)
    {
        if(auth()->user()->type === "super_admin"){
            $data = User::get();
        } else {
            $data = User::where('id', auth()->user()->id)->get();
        }
        $packages = Package::get();
        $today_date = Carbon::today();
        return view('dashboard.pages.user.index',compact('data','today_date','packages'));
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
            'video_path' => 'sometimes|string',
            'video_filename' => 'sometimes|string',
        ]);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'type' => $request->type,
                'status' => $request->status,
                'password' => Hash::make($request->password),
            ]);

            
            if($request->type === "super_admin"){
                $superAdminRole = Role::where('name','Super Admin')->first();
                $user->assignRole($superAdminRole);
            }else{
                $subscriberRole = Role::where('name' ,'Subscriber')->first();
                if($subscriberRole){
                    $user->assignRole($subscriberRole);
                }
            }

            if ($request->hasFile('company_logo')) {
                $user->addMedia($request->file('company_logo'))->toMediaCollection('company_logo');
            }
            if ($request->hasFile('decal_logo')) {
                $user->addMedia($request->file('decal_logo'))->toMediaCollection('decal_logo');
            }
            if ($request->filled('video_path') && $request->filled('video_filename')) {
                $videoPath = $request->input('video_path');
                $videoFilename = $request->input('video_filename');
                $user->addMediaFromDisk($videoPath, 'videos')
                    ->usingFileName($videoFilename)
                    ->toMediaCollection('videos');
            }

            $createCustomerRequest = new \Square\Models\CreateCustomerRequest();
            $createCustomerRequest->setEmailAddress($user->email);
            $createCustomerRequest->setGivenName($user->name);
            $client = new SquareClient([
                'accessToken' => 'EAAAl4ZyBLIRqCXuoUe-u77nYVLdmAyxjFzYHgQHyv9TuaY6dYEWzYsqiWJekQHe',
                'environment' => 'sandbox', 
            ]);
            $customersApi = $client->getCustomersApi();
    
            $customerResponse = $customersApi->createCustomer($createCustomerRequest);
            $customerId = $customerResponse->getResult()->getCustomer()->getId();
            $user->update([
                'square_customer_id' => $customerId
            ]);

            // $title = 'welcomes';
            // $this->sendEmailCreateUser($request->email ,$request->password , $title ,$request->name ,'');
            Alert::toast('User created successfully', 'success');
            return redirect()->route('dashboard.user.index');
     
       
    }
    public function edit($id){
        $data = User::find($id);
        $companyLogo = $data->getFirstMediaUrl('company_logo');
        $decalLogo = $data->getFirstMediaUrl('decal_logo');
        $video = $data->getFirstMediaUrl('videos'); // Make sure to use 'videos' here
        return view('dashboard.pages.user.edit',compact('data','companyLogo','decalLogo','video'));
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
                'status' => $request->status,
            ]);
            if($request->password !== null){
                $user->update([
                    'password' => Hash::make($request->password),
                ]);
            }
            if ($request->hasFile('company_logo')) {
                $user->clearMediaCollection('company_logo');
                $user->addMedia($request->file('company_logo'))->toMediaCollection('company_logo');
            }
            if ($request->hasFile('decal_logo')) {
                $user->clearMediaCollection('decal_logo');
                $user->addMedia($request->file('decal_logo'))->toMediaCollection('decal_logo');
            }
            if ($request->filled('video_path') && $request->filled('video_filename')) {
                $user->clearMediaCollection('videos');
                $videoPath = $request->input('video_path');
                $videoFilename = $request->input('video_filename');
                $user->addMediaFromDisk($videoPath, 'videos')
                    ->usingFileName($videoFilename)
                    ->toMediaCollection('videos');
            }
            if($request->status === 'approved' &&  !$user->subscription ){
                $startDate = Carbon::now();
                $endDate = (clone $startDate)->addWeeks(1);
                $sub = Subscription::create([
                    "price"=>0,
                    "package_type"=> 'trial',
                    "payment_status"=>'success',
                    "start_date"=>$startDate,
                    "end_date"=>$endDate,
                    "user_id"=>$user->id,
    
                ]);
            }
            Alert::toast('User Updated successfully', 'success');
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
            $startDate = Carbon::now();
            $endDate = (clone $startDate)->addWeeks(1);
            // $sub = Subscription::create([
            //     "price"=>0,
            //     "package_type"=> 'trial',
            //     "payment_status"=>'success',
            //     "start_date"=>$startDate,
            //     "end_date"=>$endDate,
            //     "user_id"=>$user->id,

            // ]);
            // Mail::to($user->email)->send(new AppMail([
            //     'title' => 'Welcome To 69simulator',
            //     'body' => 'Your account has been approved, and we have given you a 7-day trial subscription. Enjoy using 69simulator!',
            // ]));
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
    public function uploadLargeFiles(Request $request) {
        $receiver = new \Pion\Laravel\ChunkUpload\Receiver\FileReceiver('file', $request, HandlerFactory::classFromRequest($request));
    
        if (!$receiver->isUploaded()) {
            // file not uploaded
        }
    
        $fileReceived = $receiver->receive(); // receive file
        if ($fileReceived->isFinished()) { // file uploading is complete / all chunks are uploaded
            $file = $fileReceived->getFile(); // get file
            $extension = $file->getClientOriginalExtension();
            $fileName = str_replace('.'.$extension, '', $file->getClientOriginalName()); //file name without extenstion
            $fileName .= '_' . md5(time()) . '.' . $extension; // a unique file name
            $disk = Storage::disk('videos');
            $path = $disk->putFileAs('videos', $file, $fileName);
            // delete chunked file
            unlink($file->getPathname());
            return [
                'path' => asset('storage/' . $path),
                'path_without_storage' =>  $path,
                'filename' => $fileName
            ];
        }
    
        // otherwise return percentage information
        $handler = $fileReceived->handler();
        return [
            'done' => $handler->getPercentageDone(),
            'status' => true
        ];
    }
}
