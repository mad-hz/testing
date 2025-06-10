<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\HandlesValidationRequests;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    use HandlesValidationRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quizzes = Quiz::with('author')->get();
        return view('quizzes.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('quizzes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
        ]);

        $quiz = Quiz::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'author_id' => auth()->id(),
        ]);

        return redirect()->route('questions.create', $quiz)->with('success', 'Quiz created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz)
    {
        return view('quizzes.show', compact('quiz'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quiz $quiz)
    {
        return view('quizzes.edit', compact('quiz'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quiz $quiz)
    {
        $validated = $request->validate(array_merge([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ], $this->validationRequestRules()));

        $this->deleteValidationRequests($request, $quiz);

        $quiz->update([
            'title' => $validated['title'],
            'description' => $validated['description']
        ]);

        return redirect()->route('questions.edit', $quiz)->with('success', 'Quiz updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();

        return redirect()->route('quizzes.index')->with('success', "$quiz->title successfully deleted");
    }

    public function questions(Quiz $quiz)
    {
        return view('quizzes.questions', compact('quiz'));
    }

    public function result(Request $request, Quiz $quiz)
    {
        $answers = $request->input('answers', []);
        $status = 'passed';

        foreach ($quiz->questions()->get() as $question) {
            $userAnswer = trim(strtolower($answers[$question->id] ?? ''));
            $correctAnswer = trim(strtolower($question->answer));

            if ($correctAnswer !== $userAnswer) {
                $status = 'failed';
            }
        }

        return view('quizzes.result', compact('quiz', 'status'));
    }
}
