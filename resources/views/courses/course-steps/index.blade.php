<x-layouts.app>
    <div class="max-w-5xl mx-auto p-6 bg-white rounded shadow mt-6">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Course: {{ $course->title }}</h1>

            <a href="{{ route('courses.show', $course) }}" class="btn btn-secondary inline-flex items-center">
                <span class="icon-[tabler--arrow-left] mr-1"></span> Go Back
            </a>
        </div>

        <h2 class="text-2xl font-semibold mb-4">Steps:</h2>

        @if ($steps->isEmpty())
            <p class="text-gray-600">No steps defined yet for this course.</p>
        @else
            <ul class="space-y-4">
                @foreach ($steps as $step)
                    <li class="border p-4 rounded shadow flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-semibold">{{ $step->title }}</h3>
                            <p class="text-gray-600">{{ $step->description }}</p>
                        </div>

                        <div class="flex items-center space-x-4">
                            <span class="text-2xl" title="{{ $step->completed ? 'Completed' : 'Not Completed' }}">
                                {!! $step->completed ? '✅' : '❌' !!}
                            </span>

                            <a href="{{ route('courses.course-steps.show', [$course, $step]) }}" class="btn btn-primary">
                                View Step
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</x-layouts.app>
