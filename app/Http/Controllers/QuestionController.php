<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;

class QuestionController extends Controller
{
    public function create(Quiz $quiz)
    {
        return view('quizzes.questions.create', compact('quiz'));
    }

    public function store(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);

        $quiz->questions()->create($validated);

        return redirect()->route('questions.create', $quiz)->with('success', 'Question added!');
    }

    public function edit(Quiz $quiz)
    {
        return view('quizzes.questions.edit', compact('quiz'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'questions' => 'required|array',
            'questions.*.question' => 'required|string',
            'questions.*.answer' => 'required|string',
        ]);

        foreach ($validated['questions'] as $id => $data) {
            $question = $quiz->questions()->find($id);
            if ($question) {
                $question->update($data);
            }
        }

        return redirect()->route('quizzes.index')->with('success', 'Quiz updated!');
    }
}
