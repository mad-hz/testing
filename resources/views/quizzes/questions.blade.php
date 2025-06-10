<x-layouts.app>
    <div class="flex justify-between items-center m-4 bg-white
         rounded-lg shadow-md p-4 mb-3">
        <h2 class="text-2xl font-semibold">{{ $quiz->title }}</h2>
    </div>
    <div class="w-full p-9">
        <form action="{{ route('quizzes.result', $quiz->id) }}" method="POST" class="space-y-6">
            @csrf

            @foreach($quiz->questions as $question)
                <div class="p-4 bg-gray-100 rounded shadow">
                    <label for="question_{{ $question->id }}" class="block text-lg font-medium mb-2">
                        {{ $question->question }}
                    </label>
                    <input
                        type="text"
                        name="answers[{{ $question->id }}]"
                        id="question_{{ $question->id }}"
                        class="w-full border border-gray-300 rounded p-2"
                        placeholder="Your answer..."
                    >
                </div>
            @endforeach

            <button type="submit" class="mt-6 bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700">
                Submit Answers
            </button>
        </form>
    </div>
</x-layouts.app>
