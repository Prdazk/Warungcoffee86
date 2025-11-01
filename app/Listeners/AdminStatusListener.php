<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Models\AdminData;

class AdminStatusListener
{
    /**
     * Handle the login event.
     */
    public function handleLogin(Login $event)
    {
        $user = $event->user;
        if ($user instanceof AdminData) {
            // Set admin login = aktif
            $user->update(['status' => 1]);
            // Set admin lain = nonaktif
            AdminData::where('id', '!=', $user->id)->update(['status' => 0]);
        }
    }

    /**
     * Handle the logout event.
     */
    public function handleLogout(Logout $event)
    {
        $user = $event->user;
        if ($user instanceof AdminData) {
            // Set admin logout = nonaktif
            $user->update(['status' => 0]);
        }
    }
}
