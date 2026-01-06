<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Traits\NotifiesUsers;

class ProvinceController extends Controller
{
    use NotifiesUsers;

    public function index()
    {
        $provinces = Province::orderBy('name')->get();
        return view('manager.provinces.index', compact('provinces'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:provinces',
        ]);

        $province = Province::create($validated);
        $this->notifyAllUsers('New Province/Location', $province->name);

        return redirect()->route('manager.provinces.index')->with('success', 'Province added successfully.');
    }

    public function destroy(Province $province)
    {
        $province->delete();
        return redirect()->route('manager.provinces.index')->with('success', 'Province deleted successfully.');
    }
}