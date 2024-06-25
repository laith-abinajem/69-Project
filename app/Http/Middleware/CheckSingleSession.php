<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckSingleSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            // Check if the current session ID matches the one stored in the database
            if ($user->session_id !== session()->getId()) {
                // Log out the user
                Auth::logout();
                session()->invalidate();
                session()->regenerateToken();

                return redirect()->route('login')->withErrors('Your account is logged in from another device.');
            }
        }

        return $next($request);
    }
}
