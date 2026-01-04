<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contracts = Contract::with('amendments')->latest()->get();
        return view('contracts.index', compact('contracts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contracts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vendor_name' => 'required|string|max:255',
            'contract_reference' => 'required|string|unique:contracts',
            'signed_date' => 'required|date',
            'expiry_date' => 'required|date|after_or_equal:signed_date',
        ]);

        Contract::create($validated);

        return redirect()->route('contracts.index')
            ->with('success', 'Contract created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contract $contract)
    {
        $contract->load('amendments');
        return view('contracts.show', compact('contract'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contract $contract)
    {
        return view('contracts.edit', compact('contract'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contract $contract)
    {
        $validated = $request->validate([
            'vendor_name' => 'required|string|max:255',
            'contract_reference' => 'required|string|unique:contracts,contract_reference,' . $contract->id,
            'signed_date' => 'required|date',
            'expiry_date' => 'required|date|after_or_equal:signed_date',
        ]);

        $contract->update($validated);

        return redirect()->route('contracts.index')
            ->with('success', 'Contract updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract)
    {
        $contract->delete();

        return redirect()->route('contracts.index')
            ->with('success', 'Contract deleted successfully.');
    }
}