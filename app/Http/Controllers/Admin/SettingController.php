<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'company_name' => 'nullable|string|max:255',
            'company_logo' => 'nullable|image|max:2048',
            'site_favicon' => 'nullable|image|max:1024',
            'announcement_title' => 'nullable|string|max:255',
            'announcement_body' => 'nullable|string',
            'announcement_version' => 'nullable|string|max:10',
        ]);

        if ($request->has('company_name')) {
            Setting::set('company_name', $request->company_name);
        }
        
        // Handle Announcement Settings
        Setting::set('show_announcement', $request->has('show_announcement'));
        
        if ($request->has('announcement_title')) {
            Setting::set('announcement_title', $request->announcement_title);
        }
        if ($request->has('announcement_body')) {
            Setting::set('announcement_body', $request->announcement_body);
        }
        if ($request->has('announcement_version')) {
            Setting::set('announcement_version', $request->announcement_version);
        }

        if ($request->hasFile('company_logo')) {
            // Delete old logo
            $oldLogo = Setting::get('company_logo');
            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }

            $path = $request->file('company_logo')->store('settings', 'public');
            Setting::set('company_logo', $path);
        }

        if ($request->hasFile('site_favicon')) {
            // Delete old favicon
            $oldFavicon = Setting::get('site_favicon');
            if ($oldFavicon) {
                Storage::disk('public')->delete($oldFavicon);
            }

            $path = $request->file('site_favicon')->store('settings', 'public');
            Setting::set('site_favicon', $path);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }
}