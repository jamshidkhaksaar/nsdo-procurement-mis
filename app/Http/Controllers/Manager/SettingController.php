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
        $request->validate([
            'manager_email' => 'nullable|email|max:255',
        ]);

        if ($request->has('manager_email')) {
            Setting::set('manager_email', $request->manager_email);
        }

        return redirect()->route('manager.settings.index')->with('success', 'Manager settings updated successfully.');
    }
}