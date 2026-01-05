<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::orderBy('name')->get();
        return view('manager.departments.index', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments',
        ]);

        Department::create($validated);

        return redirect()->route('manager.departments.index')->with('success', 'Department added successfully.');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('manager.departments.index')->with('success', 'Department deleted successfully.');
    }
}