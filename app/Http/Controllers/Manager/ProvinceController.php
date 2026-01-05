<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
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

        Province::create($validated);

        return redirect()->route('manager.provinces.index')->with('success', 'Province added successfully.');
    }

    public function destroy(Province $province)
    {
        $province->delete();
        return redirect()->route('manager.provinces.index')->with('success', 'Province deleted successfully.');
    }
}