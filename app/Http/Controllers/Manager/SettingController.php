<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        // Fetch settings relevant to managers. For now, we can fetch all or specific ones.
        // Let's pretend they have a 'manager_notification_email' setting.
        $settings = Setting::all()->pluck('value', 'key');
        return view('manager.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // No settings to update currently.
        return redirect()->route('manager.settings.index')->with('success', 'Manager settings updated successfully.');
    }
}