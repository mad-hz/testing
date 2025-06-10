<x-layouts.app>
    <div class="max-w-4xl mx-auto p-6 bg-white rounded shadow mt-6">

        <div class="mb-4">
            <a href="{{ route('courses.show', $course) }}" class="btn btn-secondary inline-flex items-center">
                <span class="icon-[tabler--arrow-left] mr-1"></span> Back to Course
            </a>
        </div>

        <h1 class="text-3xl font-bold mb-4">Progress for {{ $course->title }}</h1>

        <div class="mb-4">
            <p class="text-lg">You have completed <strong>{{ $completedSteps->count() }}</strong> of <strong>{{ $steps->count() }}</strong> steps.</p>
            <div class="w-full bg-gray-200 rounded h-6 mt-2">
                <div class="bg-green-500 h-6 rounded text-white text-center text-sm"
                     style="width: {{ $progress }}%">
                    {{ $progress }}%
                </div>
            </div>
        </div>

        <ul class="mt-6 space-y-3">
            @foreach ($steps as $step)
                <li class="border p-4 rounded shadow flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold">{{ $step->title }}</h3>
                    </div>
                    <div>
                        {!! $completedSteps->contains('id', $step->id) ? '✅' : '❌' !!}
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</x-layouts.app>
