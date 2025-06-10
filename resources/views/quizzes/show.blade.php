<x-layouts.app>
    <div class="w-full py-4">
        <div class="flex justify-between items-center m-4 bg-white
         rounded-lg shadow-md p-4 mb-3">
            <section class="mb-2 flex gap-2">
                <x-ui.validation-requests.flag :content="$quiz"/>
                <h1 class="text-2xl font-bold max-w-2xl">{{ $quiz->title }}</h1>
            </section>
            <div class="w-1/4">
                <a href="{{ route('quizzes.index') }}">
                    <button class="bg-red-500 hover:bg-red-600 w-full h-10 font-semibold text-xl rounded text-white mb-3">
                        &larr; Back
                    </button>
                </a>
                <x-ui.action-button type="validation" modal="request-modal"/>
                <x-ui.validation-requests.request-modal content-type="quiz" :content="$quiz" />
                <p class="text-lg font-thin">Made by {{ $quiz->author->name }}</p>
            </div>
        </div>
        <div class="w-full h-1/2 py-5 px-8">
            <p class="font-normal">
                {!! nl2br(e($quiz->description)) !!}
            </p>
            <a href="{{ route('quizzes.questions', $quiz) }}">
                <button class="btn btn-error my-6">
                    Take quiz &rarr;
                </button>
            </a>
        </div>

    </div>
</x-layouts.app>
