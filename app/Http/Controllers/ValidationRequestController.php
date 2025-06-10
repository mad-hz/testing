<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Course;
use App\Models\Department;
use App\Models\Learnpath;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ValidationRequestController extends Controller
{
    /**
     * Store a new validation request.
     * @param Request $request web request.
     * @param string $type content type.
     * @param int $content_id id of the content.
     * @return RedirectResponse
     */
    public function store(Request $request, string $type, int $content_id): RedirectResponse
    {
        $request->validate([
            'description' => 'string|max:1000',
        ]);

        $model = $this->resolveModel($type)::findOrFail($content_id);

        $model->validationRequests()->create([
            'user_id' => auth()->id(),
            'description' => $request->input('description'),
        ]);
        return redirect()->back()->with('success', 'Created validation request.');
    }

    /**
     * Get the models' class based on the name.
     * @param string $type name of the model.
     * @return string class name.
     */
    protected function resolveModel(string $type): string
    {
        return match (strtolower($type)) {
            'article' => Article::class,
            'learnpath' => Learnpath::class,
            'course' => Course::class,
            'quiz' => Quiz::class,
            'department' => Department::class,
            'user' => User::class,
            default => abort(404, 'Invalid content type.'),
        };
    }
}
