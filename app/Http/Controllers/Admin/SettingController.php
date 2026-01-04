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
            'company_logo' => 'nullable|image|max:2048', // 2MB Max
        ]);

        if ($request->has('company_name')) {
            Setting::set('company_name', $request->company_name);
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

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }
}