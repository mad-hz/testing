<x-layouts.app>
    <div class="max-w-4xl mx-auto p-6 bg-white rounded shadow mt-6">

        <div class="mb-6">
            <a href="{{ route('courses.course-steps.index', $course) }}" class="btn btn-secondary inline-flex items-center">
                <span class="icon-[tabler--arrow-left] mr-1"></span> Back to Steps
            </a>
        </div>

        <h1 class="text-3xl font-bold mb-2">{{ $step->title }}</h1>

        <p class="text-gray-600 mb-4">
            <strong>Order:</strong> {{ $step->order }} |
            <strong>Weight:</strong> {{ $step->weight }}
        </p>

        <div class="prose max-w-none">
            {!! \Illuminate\Support\Str::markdown($step->content) !!}
        </div>

        @auth
            <form method="POST" action="{{ route('courses.course-steps.complete', $step) }}" class="mt-6">
                @csrf
                <button type="submit" class="btn btn-success">
                    Mark Step as Complete
                </button>
            </form>
        @endauth

    </div>
</x-layouts.app>
