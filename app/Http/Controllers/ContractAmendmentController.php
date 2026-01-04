<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\ContractAmendment;
use Illuminate\Http\Request;

class ContractAmendmentController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Contract $contract)
    {
        return view('contracts.amendments.create', compact('contract'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Contract $contract)
    {
        $validated = $request->validate([
            'amendment_number' => 'required|string|max:50',
            'new_expiry_date' => 'required|date|after:today',
            'document' => 'nullable|file|max:10240', // 10MB Max
            'notes' => 'nullable|string',
        ]);

        $path = null;
        if ($request->hasFile('document')) {
            $path = $request->file('document')->store('contracts/amendments', 'public');
        }

        $contract->amendments()->create([
            'amendment_number' => $validated['amendment_number'],
            'new_expiry_date' => $validated['new_expiry_date'],
            'document_path' => $path,
            'notes' => $validated['notes'],
        ]);

        return redirect()->route('contracts.show', $contract)
            ->with('success', 'Contract Amendment added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContractAmendment $amendment)
    {
        // $amendment is already resolved via implicit binding (shallow routing)
        // But we might need the parent contract for context in the view
        $contract = $amendment->contract;
        return view('contracts.amendments.edit', compact('amendment', 'contract'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContractAmendment $amendment)
    {
        $validated = $request->validate([
            'amendment_number' => 'required|string|max:50',
            'new_expiry_date' => 'required|date',
            'document' => 'nullable|file|max:10240',
            'notes' => 'nullable|string',
        ]);

        if ($request->hasFile('document')) {
            // Optionally delete old file
            // Storage::disk('public')->delete($amendment->document_path);
            $path = $request->file('document')->store('contracts/amendments', 'public');
            $amendment->document_path = $path;
        }

        $amendment->amendment_number = $validated['amendment_number'];
        $amendment->new_expiry_date = $validated['new_expiry_date'];
        $amendment->notes = $validated['notes'];
        $amendment->save();

        return redirect()->route('contracts.show', $amendment->contract_id)
            ->with('success', 'Amendment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContractAmendment $amendment)
    {
        $contractId = $amendment->contract_id;
        $amendment->delete();

        return redirect()->route('contracts.show', $contractId)
            ->with('success', 'Amendment deleted successfully.');
    }
}