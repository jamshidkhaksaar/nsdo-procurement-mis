<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\Department;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        $staffMembers = Staff::with('department')->orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        return view('manager.staff.index', compact('staffMembers', 'departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        Staff::create($validated);

        return redirect()->route('manager.staff.index')->with('success', 'Staff member added successfully.');
    }

    public function destroy(Staff $staff)
    {
        $staff->delete();
        return redirect()->route('manager.staff.index')->with('success', 'Staff member removed successfully.');
    }
}