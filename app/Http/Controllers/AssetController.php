<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Project;
use App\Models\AssetDocument;
use App\Models\AssetType;
use App\Models\Province;
use App\Models\Department;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Asset::with(['project', 'creator', 'editor']);

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
        $assetTypes = AssetType::orderBy('name')->get();
        $provinces = Province::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        $staffMembers = Staff::orderBy('name')->get();
        
        return view('assets.create', compact('projects', 'assetTypes', 'provinces', 'departments', 'staffMembers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'asset_type_id' => 'nullable|exists:asset_types,id',
            'asset_tag' => 'required|string|unique:assets',
            'serial_number' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'useful_life_years' => 'nullable|numeric|min:0',
            'purchase_date' => 'nullable|date',
            'condition' => 'required|in:New,Good,Fair,Poor,Broken',
            'province_id' => 'nullable|exists:provinces,id',
            'department_id' => 'nullable|exists:departments,id',
            'staff_id' => 'nullable|exists:staff,id',
            'room_number' => 'nullable|string|max:255',
            'location_province' => 'nullable|string',
            'location_department' => 'nullable|string',
            'handed_over_to' => 'nullable|string',
            'handed_over_by' => 'nullable|string',
            'handover_date' => 'nullable|date',
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
    public function show(Request $request, Asset $asset)
    {
        $asset->load(['project', 'documents', 'audits.user', 'assetType', 'province', 'department', 'staff', 'creator', 'editor']);
        
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json($asset);
        }

        return view('assets.show', compact('asset'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asset $asset)
    {
        $projects = Project::all();
        $assetTypes = AssetType::orderBy('name')->get();
        $provinces = Province::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        $staffMembers = Staff::orderBy('name')->get();

        return view('assets.edit', compact('asset', 'projects', 'assetTypes', 'provinces', 'departments', 'staffMembers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'asset_type_id' => 'nullable|exists:asset_types,id',
            'asset_tag' => 'required|string|unique:assets,asset_tag,' . $asset->id,
            'serial_number' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'useful_life_years' => 'nullable|numeric|min:0',
            'purchase_date' => 'nullable|date',
            'condition' => 'required|in:New,Good,Fair,Poor,Broken',
            'province_id' => 'nullable|exists:provinces,id',
            'department_id' => 'nullable|exists:departments,id',
            'staff_id' => 'nullable|exists:staff,id',
            'room_number' => 'nullable|string|max:255',
            'location_province' => 'nullable|string',
            'location_department' => 'nullable|string',
            'handed_over_to' => 'nullable|string',
            'handed_over_by' => 'nullable|string',
            'handover_date' => 'nullable|date',
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

    public function roomList(Request $request)
    {
        $provinces = Province::all();
        $departments = Department::all();
        
        // Get unique room numbers for the filter dropdown
        $rooms = Asset::whereNotNull('room_number')->distinct()->pluck('room_number');

        $query = Asset::with(['project', 'assetType', 'staff']);

        if ($request->filled('province_id')) {
            $query->where('province_id', $request->province_id);
        }
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }
        if ($request->filled('room_number')) {
            $query->where('room_number', $request->room_number);
        }

        $assets = $query->get();

        return view('assets.room-list', compact('assets', 'provinces', 'departments', 'rooms'));
    }

    public function exportRoomList(Request $request)
    {
        $query = Asset::with(['project', 'assetType', 'staff', 'province', 'department']);

        if ($request->filled('province_id')) {
            $query->where('province_id', $request->province_id);
        }
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }
        if ($request->filled('room_number')) {
            $query->where('room_number', $request->room_number);
        }

        $assets = $query->get();
        
        $data = [
            'assets' => $assets,
            'prepared_by' => $request->prepared_by,
            'approved_by' => $request->approved_by,
            'date' => now()->format('Y-m-d'),
            'room' => $request->room_number ?? 'All Rooms',
            'province' => $request->filled('province_id') ? Province::find($request->province_id)->name : 'All',
            'department' => $request->filled('department_id') ? Department::find($request->department_id)->name : 'All',
        ];

        if ($request->format == 'pdf') {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.room-list-pdf', $data);
            return $pdf->download('Room_Asset_List_' . now()->format('Ymd') . '.pdf');
        }

        // Add Excel logic if needed, but the user emphasized PDF with signature
        return back()->with('error', 'Excel format for room list is coming soon. Please use PDF.');
    }

    public function exportShowPdf(Asset $asset)
    {
        $asset->load(['project', 'documents', 'assetType', 'province', 'department', 'staff', 'creator', 'editor']);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.asset-detail-pdf', compact('asset'));
        return $pdf->download('Asset_' . $asset->asset_tag . '.pdf');
    }

    public function markDamaged(Asset $asset)
    {
        $asset->update(['condition' => 'Broken']);
        return back()->with('success', 'Asset marked as Damaged (Broken).');
    }
}