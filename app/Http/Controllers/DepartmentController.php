<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\HandlesValidationRequests;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    use HandlesValidationRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::all();
        return view('departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('departments.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'banner'      => ['nullable', 'image', 'max:2048'],
            'users'       => ['required', 'array'],
            'users.*'     => ['exists:users,id'],
        ]);

        $imagePath = null;
        if ($request->hasFile('banner')) {
            $imagePath = $request->file('banner')->store('departments', 'public');
        }

        $department = Department::create([
            'name'        => $validated['name'],
            'description' => $validated['description'],
            'banner'      => $imagePath,
        ]);

        $department->users()->sync($validated['users']);

        return redirect('/departments')->with('success', 'Department created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        return view('departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        $users = User::all();
        return view('departments.edit', compact('department', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        $validated = $request->validate(array_merge([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'banner'      => ['nullable', 'image', 'max:2048'],
            'users'       => ['required', 'array'],
            'users.*'     => ['exists:users,id'],
        ], $this->validationRequestRules()));

        $this->deleteValidationRequests($request, $department);

        // Handle banner upload or keep old one
        if ($request->hasFile('banner')) {
            // Store new banner
            $bannerPath = $request->file('banner')->store('departments', 'public');

            // Optional: delete old banner file if exists
            if ($department->banner && \Storage::disk('public')->exists($department->banner)) {
                \Storage::disk('public')->delete($department->banner);
            }

            $validated['banner'] = $bannerPath;
        } else {
            // Keep old banner
            $validated['banner'] = $request->input('old_banner');
        }

        $department->update([
            'name'        => $validated['name'],
            'description' => $validated['description'],
            'banner'      => $validated['banner'],
        ]);

        $department->users()->sync($validated['users']);

        return redirect('/departments')->with('success', 'Department updated successfully.');
    }


    /**
     * Show the confirmation page before deletion.
     */
    public function delete(Department $department)
    {
        return view('departments.delete', compact('department'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }
}
