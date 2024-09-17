<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subscription;
use App\Models\Invoice;
use Carbon\Carbon;
use App\Models\Package;
use App\Models\LoginHistory;
class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Home Page (Admin Access)
        // Show number of users
        $subscriber_pending = User::where('type','subscriber')->where('status','pending')->count();
        $subscriber_approve = User::where('type','subscriber')->where('status','approved')->count();
        $subscriber_rejected = User::where('type','subscriber')->where('status','rejected')->count();

        // Display pending user approvals
        $pending_users = User::where('status','pending')->get();
      

        // Show number of active subscriptions
        $today = Carbon::now()->toDateString(); // Get today's date

        $subscriber_active = Subscription::where('end_date', '>', $today)->count();
        // Display a table of subscriptions expiring within the week
        // Calculate the start and end dates of the current week
        $now = Carbon::now();
        $endOfWeek = $now->copy()->endOfWeek();
        
        // Query to count subscriptions expiring within the current week
        $subscriber_expiry_week = Subscription::whereBetween('end_date', [$now, $endOfWeek])->get();
        
        // user With InWeek
        $user_withIn_day = User::whereBetween('created_at', [Carbon::now()->subDay(), Carbon::now()])
        ->get();

        $user_withIn_week = User::whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()])
        ->get();

        $user_withIn_month = User::whereBetween('created_at', [Carbon::now()->subMonth(), Carbon::now()])
        ->get();

        $packages = Package::get();
        // revenu 
        $total = Subscription::sum('price');
        $history = LoginHistory::where('created_at', '>=', Carbon::now()->subDays(3))
                       ->orderBy('created_at', 'desc')
                       ->get();

        $total_revenu = Invoice::where("user_id",auth()->user()->id)->sum('total');
        $total_cars = Invoice::where("user_id",auth()->user()->id)->count();

        return view('dashboard.pages.dashboard',compact('total_cars','total_revenu','packages','history','total','subscriber_expiry_week','subscriber_active','pending_users','subscriber_pending','user_withIn_week','user_withIn_month','user_withIn_day','subscriber_approve','subscriber_rejected'));
    }
}
