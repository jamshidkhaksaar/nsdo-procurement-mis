<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Supplier::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $suppliers = $query->latest()->paginate(20);

        return view('manager.suppliers.index', compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:suppliers',
        ]);

        Supplier::create($validated);

        return redirect()->route('manager.suppliers.index')
            ->with('success', 'Supplier created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:suppliers,name,' . $supplier->id,
        ]);

        $supplier->update($validated);

        return redirect()->route('manager.suppliers.index')
            ->with('success', 'Supplier updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        // Check if supplier is used in assets?
        // The FK is nullOnDelete, so it's safe to delete, assets will just lose the link.
        $supplier->delete();

        return redirect()->route('manager.suppliers.index')
            ->with('success', 'Supplier deleted successfully.');
    }
}
