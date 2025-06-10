<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\HandlesValidationRequests;
use App\Models\Course;
Use App\Models\Learnpath;
use Illuminate\Http\Request;

class LearnpathController extends Controller
{
    use HandlesValidationRequests;
    public function index()
    {
        $learnpaths = Learnpath::all();
        return view('learnpath.index', compact ('learnpaths'));
    }

    public function create()
    {
        $courses = Course::all();
        return view('learnpath.create', compact('courses'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'header' => 'required|max:255',
            'courses' => 'required|array',
            'courses.*' => 'exists:courses,id',
            'description' => 'required|string',
        ]);

        $learnpath = Learnpath::create([
            'title' => $validated['title'],
            'header' => $validated['header'],
            'description' => $validated['description'],
        ]);

        $learnpath->courses()->sync($validated['courses']);

        return redirect()->route('learnpath.index')->with('success', 'Learning path created successfully');
    }

    public function show(Learnpath $learnpath)
    {
        return view('learnpath.show', compact('learnpath'));
    }

    public function edit(Learnpath $learnpath)
    {
        $courses = Course::all();
        return view('learnpath.edit', compact('learnpath', 'courses'));
    }

    public function update(Request $request, Learnpath $learnpath)
    {
        $validated = $request->validate(array_merge([
            'title' => 'required|string|max:255',
            'header' => 'required|max:255',
            'courses' => 'required|array',
            'courses.*' => 'exists:courses,id',
            'description' => 'required|string',
        ], $this->validationRequestRules()));

        $this->deleteValidationRequests($request, $learnpath);

        $learnpath->update($validated);

        $learnpath->courses()->sync($validated['courses']);

        return redirect()->route('learnpath.index')->with('success', 'Learning path updated successfully');
    }

    public function destroy(Learnpath $learnpath)
    {
        $learnpath->delete();

        return redirect()->route('learnpath.index')->with('success', 'Learning path deleted successfully');
    }
}
