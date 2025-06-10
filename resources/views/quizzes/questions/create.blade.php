<x-layouts.app>
    <div class="max-w-3xl mx-auto p-6 bg-white rounded shadow">
        <h1 class="text-2xl font-semibold mb-4">Add a Question to "{{ $quiz->title }}"</h1>

        @if(session('success'))
            <div class="text-green-600 mb-4">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('questions.store', $quiz) }}" class="space-y-4">
            @csrf

            <div>
                <label for="question" class="block font-medium">Question</label>
                <textarea name="question" id="question" rows="3"
                          class="w-full border px-4 py-2 rounded" required></textarea>
            </div>

            <div>
                <label for="correct_answer" class="block font-medium">Correct Answer</label>
                <input type="text" name="answer" id="answer"
                       class="w-full border px-4 py-2 rounded" required>
            </div>

            <button type="submit"
                    class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700">
                + Add Question
            </button>
            @if($quiz->questions->count() > 0)
                <a href="{{ route('quizzes.index') }}" class="ml-4 text-gray-600 underline">
                    Finish
                </a>
            @endif
        </form>
    </div>
</x-layouts.app>
