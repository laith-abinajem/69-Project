<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\LoginHistory;

class LogSessionExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $lastActivity = session()->get('last_activity');

            if ($lastActivity && (time() - $lastActivity > config('session.lifetime') * 60)) {
                LoginHistory::where('user_id', Auth::id())
                    ->whereNull('logout_time')
                    ->orderBy('login_time', 'desc')
                    ->first()
                    ->update(['logout_time' => now()]);

                Auth::logout();
                return redirect('/login')->with('message', 'Session expired. Please login again.');
            }

            session()->put('last_activity', time());
        }

        return $next($request);
    }
}
