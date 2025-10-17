<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\DepartmentPlant;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $departmentsQuery = Department::query();

        if ($search) {
            $departmentsQuery->where(function ($query) use ($search) {
                $query->where('department', 'like', '%' . $search . '%')
                      ->orWhere('abbrivation', 'like', '%' . $search . '%');
            });
        }

        $departments = $departmentsQuery->latest()->paginate(5)->withQueryString();

        return view('department.index', compact('departments'));
    }

    public function create()
    {
        return view('department.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'department' => 'required|string|max:255',
            'abbrivation' => 'required|string|max:255'
        ]);

        Department::create([
            'department' => $request->department,
            'abbrivation' => $request->abbrivation
        ]);

        return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }

    public function edit(Department $department)
    {
        return view('department.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'department' => 'required|string|max:255',
            'abbrivation' => 'required|string|max:255'
        ]);

        $department->update($request->all());

        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }

    public function getFilteredDepartment(Request $request)
    {
        $plant = $request->input('area');

        $department = DepartmentPlant::getFilteredPlant($plant);

        return response()->json($department);
    }
}
