<x-layouts.app>
    <div x-data="{
            showModal: false,
            deleteAction: '{{ route('courses.destroy', $course) }}',
            showPrereqModal: false
        }"
         class="max-w-5xl mx-auto p-6 bg-white rounded shadow mt-6">
        <div class="mb-6">
            <a href="{{ route('courses.dashboard') }}" class="btn btn-secondary inline-flex items-center">
                <span class="icon-[tabler--arrow-left] mr-1"></span> Back to Courses
            </a>
        </div>
        <section class="mb-2 flex gap-2">
            <x-ui.validation-requests.flag :content="$course"/>
            <h1 class="text-2xl font-bold max-w-2xl">{{ $course->title }}</h1>
        </section>

        <p class="mb-6 text-gray-700">{{ $course->description }}</p>

        <!-- COURSE RESOURCES SECTION -->
        <div class="mb-6 p-4 bg-blue-50 border border-blue-300 rounded">
            <h2 class="text-xl font-semibold mb-3">Course Resources</h2>

            @if ($course->resources && $course->resources->count() > 0)
                <ul class="list-disc list-inside text-gray-800 space-y-2">
                    @foreach ($course->resources as $resource)
                        <li>
                            @switch($resource->type)
                                @case('video')
                                    <span class="font-semibold">Video:</span>
                                    <a href="{{ $resource->url }}" target="_blank" rel="noopener" class="text-indigo-600 hover:underline">
                                        {{ $resource->url }}
                                    </a>
                                    @break

                                @case('link')
                                    <span class="font-semibold">Link:</span>
                                    <a href="{{ $resource->url }}" target="_blank" rel="noopener" class="text-indigo-600 hover:underline">
                                        {{ $resource->url }}
                                    </a>
                                    @break

                                @case('document')
                                    <span class="font-semibold">Document:</span>
                                    @if ($resource->file_path)
                                        <a href="{{ asset('storage/' . $resource->file_path) }}" target="_blank" class="text-indigo-600 hover:underline">
                                            {{ basename($resource->file_path) }}
                                        </a>
                                    @else
                                        <span class="italic text-gray-500">File not available</span>
                                    @endif
                                    @break
                                @default
                                    <span>Unknown resource type</span>
                            @endswitch
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-600 italic">No resources added for this course yet.</p>
            @endif
        </div>

        @if ($course->prerequisites->count() > 0)
            <div class="mb-6 p-4 bg-yellow-50 border border-yellow-300 rounded">
                <h2 class="text-xl font-semibold mb-2">Prerequisite Courses</h2>
                <ul class="list-disc list-inside text-gray-700">
                    @foreach ($course->prerequisites as $prereq)
                        <li>{{ $prereq->title }}</li>
                    @endforeach
                </ul>
            </div>
        @else
            <div class="mb-6 p-4 bg-green-50 border border-green-300 rounded text-green-800">
                This course has no prerequisites.
            </div>
        @endif

        <p class="mb-2"><strong>Credits:</strong> {{ $course->credits }}</p>

        <p class="mb-2"><strong>Created By:</strong> {{ $course->creator ? $course->creator->email : 'Unknown' }}</p>

        <p class="mb-4"><strong>Created At:</strong> {{ $course->created_at->format('F j, Y') }}</p>

        <div class="flex gap-4 mt-6 items-center">


            {{-- Enroll button with prerequisite check --}}
            @if (count($missingPrerequisites) > 0 && !in_array($course->id, $enrolledCourseIds))
                <button @click="showPrereqModal = true"
                    class="btn btn-success inline-flex items-center"
                    title="You must complete prerequisites before enrolling">
                    <span class="icon-[tabler--user-plus] mr-1"></span> Enroll
                </button>
            @else
                <form action="{{ route('courses.enroll', $course) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                        class="btn {{ in_array($course->id, $enrolledCourseIds) ? 'btn-error' : 'btn-success' }} inline-flex items-center">
                        <span class="icon-[tabler--user-plus] mr-1"></span>
                        {{ in_array($course->id, $enrolledCourseIds) ? 'Unenroll' : 'Enroll' }}
                    </button>
                </form>
            @endif


            <a href="{{ route('courses.edit', $course) }}" class="btn btn-warning inline-flex items-center">
                <span class="icon-[tabler--edit] mr-1"></span> Edit
            </a>

            <button @click="showModal = true" class="btn btn-error inline-flex items-center">
                <span class="icon-[tabler--trash] mr-1"></span> Delete
            </button>
            <x-ui.action-button type="validation" modal="request-modal"/>
            <x-ui.validation-requests.request-modal content-type="course" :content="$course" />
        </div>

        @if (in_array($course->id, $enrolledCourseIds))
            <!-- Course Content button without prereq check -->
            <a href="{{ route('courses.course-steps.index', $course) }}" class="btn btn-primary inline-flex items-center mt-4">
                <span class="icon-[tabler--play-circle] mr-1"></span> Course Content
            </a>

            <a href="{{ route('courses.progress', $course) }}" class="btn btn-info inline-flex items-center mt-2">
                <span class="icon-[tabler--chart-dots-3] mr-1"></span> View Course Progress
            </a>
        @else
            <button disabled class="btn btn-disabled inline-flex items-center mt-4 opacity-50 cursor-not-allowed">
                <span class="icon-[tabler--lock] mr-1"></span> Enroll to Begin Course
            </button>
        @endif

        {{-- Prerequisite Modal --}}
        <div x-show="showPrereqModal" x-cloak
            class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-75">
            <div class="bg-white rounded-lg p-6 max-w-md w-full text-gray-900">
                <h3 class="text-xl font-bold mb-4">Missing Prerequisite Courses</h3>
                <p class="mb-4">You must complete or enroll in the following course(s) before starting this one:</p>
                <ul class="list-disc list-inside mb-6">
                    @foreach ($missingPrerequisites as $missing)
                        <li>{{ $missing }}</li>
                    @endforeach
                </ul>
                <button @click="showPrereqModal = false" class="btn btn-secondary">Close</button>
            </div>
        </div>

        {{-- Delete confirmation modal --}}
        <div x-show="showModal" x-cloak
            class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-75">
            <div class="bg-red-900 text-white rounded-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-bold mb-4">Confirm Delete</h3>
                <p class="mb-6">Are you sure you want to delete the course <strong>{{ $course->title }}</strong>?</p>
                <div class="flex justify-end gap-4">
                    <button @click="showModal = false" class="btn btn-secondary">Cancel</button>
                    <form :action="deleteAction" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-error">Delete</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-layouts.app>
