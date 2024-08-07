<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Logout;
use App\Models\LoginHistory;
class LogSuccessfulLogout
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Logout $event)
    {
        $data = LoginHistory::where('user_id', $event->user->id)
            ->whereNull('logout_time')
            ->orderBy('login_time', 'desc')
            ->first();
            if($data){
                $data->update(['logout_time' => now()]);
            }
    }
}
