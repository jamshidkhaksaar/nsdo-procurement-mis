<?php

namespace App\Traits;

use App\Models\User;
use App\Mail\ConfigChangeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

trait NotifiesUsers
{
    protected function notifyAllUsers($changeType, $itemName)
    {
        $allUserEmails = User::pluck('email')->toArray();
        $userName = Auth::user()->name;

        try {
            Mail::to($allUserEmails)->send(new ConfigChangeMail($userName, $changeType, $itemName));
        } catch (\Exception $e) {
            report($e);
        }
    }
}
