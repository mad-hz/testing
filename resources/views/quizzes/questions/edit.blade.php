<x-layouts.app>
    <div class="max-w-3xl mx-auto p-6 bg-white rounded shadow my-12">
        <h1 class="text-2xl font-semibold mb-4">Edit the questions from "{{ $quiz->title }}"</h1>

        @if(session('success'))
            <div class="text-green-600 mb-4">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('questions.update', $quiz) }}" class="space-y-4">
            @csrf
            @method('PATCH')

            @foreach($quiz->questions as $index => $question)
                <div>
                    <label for="question_{{ $question->id }}" class="block font-medium">
                        Question {{ $index + 1 }}
                    </label>
                    <textarea name="questions[{{ $question->id }}][question]"
                              id="question_{{ $question->id }}"
                              rows="3"
                              class="w-full border px-4 py-2 rounded"
                              required>{{ old("questions.{$question->id}.question", $question->question) }}</textarea>
                </div>

                <div>
                    <label for="answer_{{ $question->id }}" class="block font-medium">Correct Answer</label>
                    <input type="text"
                           name="questions[{{ $question->id }}][answer]"
                           id="answer_{{ $question->id }}"
                           class="w-full border px-4 py-2 rounded"
                           value="{{ old("questions.{$question->id}.answer", $question->answer) }}" required>
                </div>
            @endforeach
            <button type="submit"
                    class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700">
                Update Questions
            </button>
        </form>
    </div>
</x-layouts.app>
