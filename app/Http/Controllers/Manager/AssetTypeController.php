<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\AssetType;
use Illuminate\Http\Request;
use App\Traits\NotifiesUsers;

class AssetTypeController extends Controller
{
    use NotifiesUsers;

    public function index()
    {
        $assetTypes = AssetType::orderBy('name')->get();
        return view('manager.asset-types.index', compact('assetTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:asset_types',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $assetType = AssetType::create($validated);
        $this->notifyAllUsers('Asset Category', $assetType->name);

        return redirect()->route('manager.asset-types.index')->with('success', 'Asset type created successfully.');
    }

    public function update(Request $request, AssetType $assetType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:asset_types,name,' . $assetType->id,
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $assetType->update($validated);
        $this->notifyAllUsers('Asset Category Update', $assetType->name);

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