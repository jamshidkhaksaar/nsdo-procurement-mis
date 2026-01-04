<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Project;
use App\Models\AssetDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Asset::with('project');

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('asset_tag', 'like', "%{$search}%");
            });
        }

        $assets = $query->latest()->get();
        return view('assets.index', compact('assets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::all();
        return view('assets.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'asset_tag' => 'required|string|unique:assets',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'condition' => 'required|in:New,Good,Fair,Poor,Broken',
            'location_province' => 'nullable|string',
            'location_department' => 'nullable|string',
            'handed_over_to' => 'nullable|string',
            'handed_over_by' => 'nullable|string',
            'photo' => 'nullable|image|max:2048', // 2MB Max
            'documents.*' => 'nullable|file|max:10240', // 10MB Max per file
        ]);

        // Handle Photo Upload
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('assets/photos', 'public');
            $validated['photo_path'] = $path;
        }

        $asset = Asset::create($validated);

        // Handle Documents Upload (Handover/Takeover forms)
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('assets/documents', 'public');
                AssetDocument::create([
                    'asset_id' => $asset->id,
                    'type' => 'generic', // Can be refined in UI to distinguish types
                    'file_path' => $path,
                    'uploaded_at' => now(),
                ]);
            }
        }

        return redirect()->route('assets.index')
            ->with('success', 'Asset created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Asset $asset)
    {
        $asset->load(['project', 'documents', 'audits.user']);
        return view('assets.show', compact('asset'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asset $asset)
    {
        $projects = Project::all();
        return view('assets.edit', compact('asset', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'asset_tag' => 'required|string|unique:assets,asset_tag,' . $asset->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'condition' => 'required|in:New,Good,Fair,Poor,Broken',
            'location_province' => 'nullable|string',
            'location_department' => 'nullable|string',
            'handed_over_to' => 'nullable|string',
            'handed_over_by' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($asset->photo_path) {
                Storage::disk('public')->delete($asset->photo_path);
            }
            $path = $request->file('photo')->store('assets/photos', 'public');
            $validated['photo_path'] = $path;
        }

        $asset->update($validated);

        // Upload new documents if any
         if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('assets/documents', 'public');
                AssetDocument::create([
                    'asset_id' => $asset->id,
                    'type' => 'generic',
                    'file_path' => $path,
                    'uploaded_at' => now(),
                ]);
            }
        }

        return redirect()->route('assets.index')
            ->with('success', 'Asset updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asset $asset)
    {
        // Delete associated files
        if ($asset->photo_path) {
            Storage::disk('public')->delete($asset->photo_path);
        }
        
        foreach($asset->documents as $doc) {
            Storage::disk('public')->delete($doc->file_path);
        }

        $asset->delete();

        return redirect()->route('assets.index')
            ->with('success', 'Asset deleted successfully.');
    }
}