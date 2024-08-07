<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\LoginHistory;

class CheckSingleSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
       {
           if (Auth::check()) {
               $user = Auth::user();

               if($user->type !== 'super_admin'){
                    $currentSessionId = session()->getId();

                    // Check if the session ID stored in the user's record is different
                    if ($user->session_id !== $currentSessionId) {
                        // Log out the user from other sessions
                        LoginHistory::where('user_id', $user->id)
                            ->whereNull('logout_time')
                            ->orderBy('login_time', 'desc')
                            ->first()
                            ->update(['logout_time' => now()]);
                        session()->getHandler()->destroy($user->session_id);
    
                        // Update the user's record with the current session ID
                        $user->session_id = $currentSessionId;
                        $user->save();
                    }
               }
              
           }

           return $next($request);
       }
}
