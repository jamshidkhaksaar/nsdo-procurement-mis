<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\AssetType;
use Illuminate\Http\Request;

class AssetTypeController extends Controller
{
    public function index()
    {
        $assetTypes = AssetType::orderBy('name')->get();
        return view('manager.asset-types.index', compact('assetTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:asset_types',
            'useful_life_years' => 'required|integer|min:1',
            'depreciation_method' => 'required|string',
            'description' => 'nullable|string',
        ]);

        AssetType::create($validated);

        return redirect()->route('manager.asset-types.index')->with('success', 'Asset type created successfully.');
    }

    public function update(Request $request, AssetType $assetType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:asset_types,name,' . $assetType->id,
            'useful_life_years' => 'required|integer|min:1',
            'depreciation_method' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $assetType->update($validated);

        return redirect()->route('manager.asset-types.index')->with('success', 'Asset type updated successfully.');
    }

    public function destroy(AssetType $assetType)
    {
        if ($assetType->assets()->count() > 0) {
            return back()->withErrors(['error' => 'Cannot delete asset type that has associated assets.']);
        }

        $assetType->delete();

        return redirect()->route('manager.asset-types.index')->with('success', 'Asset type deleted successfully.');
    }
}