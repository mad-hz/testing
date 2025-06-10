<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\HandlesValidationRequests;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseResource;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    use HandlesValidationRequests;
    // Dashboard / Index showing all courses with related info
    public function __invoke()
    {
        $user = Auth::user();

        // Eager load prerequisites, steps, creator, and resources
        $courses = Course::with(['prerequisites', 'steps', 'creator', 'resources'])->get();

        $enrolledCourseIds = $user ? $user->courses()->pluck('courses.id')->toArray() : [];

        $missingPrerequisitesMap = [];

        if ($user) {
            foreach ($courses as $course) {
                $missing = $course->prerequisites
                    ->filter(fn($prereq) => !in_array($prereq->id, $enrolledCourseIds))
                    ->pluck('title')
                    ->toArray();

                $missingPrerequisitesMap[$course->id] = $missing;
            }
        }

        foreach ($courses as $course) {
            $course->canEnroll = $user ? $course->checkPrerequisitesForUser($user) : false;
        }

        return view('courses.dashboard', [
            'courses' => $courses,
            'enrolledCourseIds' => $enrolledCourseIds,
            'missingPrerequisites' => $missingPrerequisitesMap,
        ]);
    }

    // Show the create form
    public function create()
    {
        return view('courses.create');
    }

    // Store a new course
    public function store(Request $request)
    {
        // Validate inputs (can extend to validate resources uploads here too)
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'credits' => 'required|integer',
        ]);

        // optionally validate files for resources here if uploading in this form

        $course = new Course($validated);

        // Link the creator correctly (assuming your Course model has user_id as FK)
        $course->user_id = Auth::id();

        $course->save();

        // TODO: Handle resource uploads here if implemented in this request

        return redirect()->route('courses.dashboard')->with('success', 'Course created successfully!');
    }

    // Show a single course details
    public function show(Course $course)
    {
        // Eager load all needed relations: prerequisites, creator, resources
        $course->load('prerequisites', 'creator', 'resources');

        $user = Auth::user();
        $enrolledCourseIds = $user ? $user->courses()->pluck('courses.id')->toArray() : [];

        $missingPrerequisites = [];
        if ($user) {
            $missingPrerequisites = $course->prerequisites
                ->filter(fn($prereq) => !in_array($prereq->id, $enrolledCourseIds))
                ->pluck('title')
                ->toArray();
        }

        return view('courses.show', [
            'course' => $course,
            'enrolledCourseIds' => $enrolledCourseIds,
            'missingPrerequisites' => $missingPrerequisites,
        ]);
    }

    // Show the edit form
    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    // Update a course
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate(array_merge([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'credits' => 'required|integer',
        ], $this->validationRequestRules()));

        $this->deleteValidationRequests($request, $course);

        $course->update($validated);


        // TODO: Handle resource updates if needed

        return redirect()->route('courses.dashboard')->with('success', 'Course updated successfully!');
    }

    // Delete a course
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('courses.dashboard')->with('success', 'Course deleted successfully!');
    }

    // Enroll or unenroll a user to/from a course
    public function enroll(Course $course)
    {
        $user = Auth::user();

        if ($user->courses()->where('course_id', $course->id)->exists()) {
            $user->courses()->detach($course->id);
            return back()->with('success', 'You have unenrolled from the course.');
        }

        $user->courses()->attach($course->id);

        return back()->with('success', 'You have successfully enrolled in the course!');
    }

    // Show progress for a course for the current user
    public function progress(Course $course)
    {
        $user = auth()->user();

        if (!$user->courses->contains($course)) {
            abort(403, 'You are not enrolled in this course.');
        }

        $missing = $course->prerequisites->filter(fn($prereq) => !$user->courses->contains($prereq));

        if ($missing->isNotEmpty()) {
            return redirect()->route('courses.show', $course)
                ->with('error', 'You must enroll in the prerequisite course(s) first: ' . $missing->pluck('title')->join(', '));
        }

        $steps = $course->steps()->with('completedByUsers')->get();
        $completedSteps = $user->completedSteps->where('course_id', $course->id);

        $progress = $steps->count() > 0
            ? round(($completedSteps->count() / $steps->count()) * 100, 2)
            : 0;

        return view('courses.progress', compact('course', 'steps', 'completedSteps', 'progress'));
    }

    public function storeResource(Request $request, Course $course)
    {
        $validated = $request->validate([
            'type' => 'required|in:video,link,document',
            'url' => 'nullable|url',
            'document' => 'nullable|file|mimes:pdf,doc,docx',
        ]);

        if ($validated['type'] === 'document' && $request->hasFile('document')) {
            $file = $request->file('document');
            $path = $file->store('course_resources');

            $resource = new CourseResource();
            $resource->course_id = $course->id;
            $resource->type = 'document';
            $resource->file_path = $path;
            $resource->filename = $file->getClientOriginalName();
            $resource->save();
        } elseif (in_array($validated['type'], ['video', 'link']) && !empty($validated['url'])) {
            $resource = new CourseResource();
            $resource->course_id = $course->id;
            $resource->type = $validated['type'];
            $resource->url = $validated['url'];
            $resource->save();
        } else {
            return back()->withErrors('Invalid resource data.');
        }

        return back()->with('success', 'Resource added successfully!');
    }
}
