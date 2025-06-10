<x-layouts.app>
    <div class="flex justify-center items-center min-h-screen">
        <div class="bg-white p-10 rounded-lg shadow-lg text-center w-1/2">
            <h1 class="text-3xl font-bold mb-4">{{ $quiz->title }}</h1>

            @if ($status === 'passed')
                <p class="text-green-600 text-xl font-semibold">
                    <span class="icon-[tabler--check]"></span>
                    You passed the quiz!
                </p>
            @else
                <p class="text-red-600 text-xl font-semibold">
                    <span class="icon-[tabler--check]"></span>
                    You failed the quiz.
                </p>
            @endif

            <a href="{{ route('quizzes.index') }}" class="mt-6 inline-block text-red-600 hover:underline">
                Back to Quizzes
            </a>
        </div>
    </div>
</x-layouts.app>
