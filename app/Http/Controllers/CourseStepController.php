<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseStep;

class CourseStepController extends Controller
{
    public function index(Course $course)
    {
        $steps = $course->steps()->get();

        $user = auth()->user();

        if ($user) {
            // Get the IDs of steps completed by this user
            $completedStepIds = $user->completedSteps()->pluck('course_step_id')->toArray();

            // Mark each step as completed or not
            $steps->each(function ($step) use ($completedStepIds) {
                $step->completed = in_array($step->id, $completedStepIds);
            });
        } else {
            // If no user logged in, all steps are incomplete
            $steps->each(fn($step) => $step->completed = false);
        }

        return view('courses.course-steps.index', compact('course', 'steps'));
    }

    public function show(Course $course, CourseStep $step)
    {
        return view('courses.course-steps.show', compact('course', 'step'));
    }

    public function complete(Request $request, CourseStep $step)
    {
        $user = $request->user();

        $user->completedSteps()->syncWithoutDetaching($step->id);

        return redirect()
            ->route('courses.course-steps.show', [$step->course_id, $step->id])
            ->with('success', 'Step marked as complete!');
    }
}
