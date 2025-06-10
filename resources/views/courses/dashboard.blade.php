<x-layouts.app>
    <div x-data="{ view: 'card', showModal: false, deleteAction: null, courseTitle: '' }" class="w-full py-4">

        @if (session('success'))
            <div
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 4000)"
                x-show="show"
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 scale-90 -translate-y-2"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-500"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-90 -translate-y-2"
                class="m-4 mb-6 px-4 py-3 bg-green-100 text-green-800 border border-green-300 rounded-md shadow-md"
            >
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center m-4 mb-[84px] bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-semibold">Courses</h2>
            <div class="flex gap-4">
                <button class="btn btn-outline" :class="{ 'btn-primary': view === 'card' }" @click="view = 'card'">
                    <span class="icon-[tabler--layout-grid] mr-1"></span> Card View
                </button>
                <button class="btn btn-outline" :class="{ 'btn-primary': view === 'table' }" @click="view = 'table'">
                    <span class="icon-[tabler--table] mr-1"></span> Table View
                </button>
                <a href="{{ route('courses.create') }}" class="btn btn-error">Create Course</a>
            </div>
        </div>

        @if ($courses->isEmpty())
            <div class="text-center mt-12 text-gray-500">No courses available.</div>
        @else

            <!-- card view -->
            <div x-show="view === 'card'" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 px-4" x-cloak>
                @foreach ($courses as $course)
                    @php
                        $escapedTitle = addslashes($course->title);
                        $isEnrolled = in_array($course->id, $enrolledCourseIds);
                        $stepsCount = $course->steps->count();
                        $userCompletedSteps = auth()->user()->completedSteps->where('course_id', $course->id)->count();
                        $progress = $stepsCount > 0 ? round(($userCompletedSteps / $stepsCount) * 100, 2) : 0;
                        // Make sure $course->canEnroll is available from the controller
                        $canEnroll = $course->canEnroll ?? true; // default true if missing
                    @endphp

                    <div class="card group hover:shadow-lg transition-shadow duration-300 flex flex-col">
                        <figure class="overflow-hidden h-48">
                            <img src="{{ asset('assets/images/javascript-free_image.png') }}"
                                alt="{{ $course->title }}"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" />
                        </figure>
                        <div class="card-body flex flex-col flex-grow">
                            <h5 class="card-title text-lg font-semibold mb-2.5">{{ $course->title }}</h5>
                            <p class="mb-4 text-gray-600">{{ Str::limit($course->description, 100) }}</p>
                            <x-ui.validation-requests.card-label :content="$course"/>

                            <div class="flex flex-wrap gap-2 mt-auto">
                                <a href="{{ route('courses.show', $course) }}" class="btn btn-primary">
                                    <span class="icon-[tabler--eye] mr-1"></span> View
                                </a>


                                @if ($isEnrolled && $stepsCount > 0)
                                    <a href="{{ route('courses.progress', $course) }}" class="btn btn-info">
                                        <span class="icon-[tabler--progress] mr-1"></span> Continue
                                        <span class="ml-2 text-xs bg-white/20 px-2 py-0.5 rounded">{{ $progress }}%</span>
                                    </a>
                                @else
                                    @if ($canEnroll)
                                        <form action="{{ route('courses.enroll', $course) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success">
                                                <span class="icon-[tabler--user-plus] mr-1"></span> Enroll
                                            </button>
                                        </form>
                                    @else
                                        <button type="button" class="btn btn-success btn-disabled cursor-not-allowed" title="You do not meet the prerequisites for this course" disabled>
                                            <span class="icon-[tabler--user-plus] mr-1"></span> Enroll
                                        </button>
                                    @endif
                                @endif

                                <a href="{{ route('courses.edit', $course) }}" class="btn btn-warning">
                                    <span class="icon-[tabler--edit] mr-1"></span> Edit
                                </a>

                                <button
                                    @click="showModal = true; deleteAction = '{{ route('courses.destroy', $course) }}'; courseTitle = '{{ $escapedTitle }}'"
                                    class="btn btn-danger"
                                    type="button"
                                >
                                    <span class="icon-[tabler--trash] mr-1"></span> Delete
                                </button>

                                <button type="button"
                                    @click="navigator.clipboard.writeText('{{ route('courses.show', $course) }}').then(() => alert('Course link copied!'))"
                                    class="btn btn-secondary">
                                    <span class="icon-[tabler--share] mr-1"></span> Share
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>


            <!-- table view -->
            <div x-show="view === 'table'" x-cloak class="bg-white rounded-lg shadow-md p-6 mb-8 m-4">
                <div class="w-full overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($courses as $course)
                                @php
                                    $escapedTitle = addslashes($course->title);
                                    $isEnrolled = in_array($course->id, $enrolledCourseIds);
                                    $stepsCount = $course->steps->count();
                                    $userCompletedSteps = auth()->user()->completedSteps->where('course_id', $course->id)->count();
                                    $progress = $stepsCount > 0 ? round(($userCompletedSteps / $stepsCount) * 100, 2) : 0;
                                    $canEnroll = $course->canEnroll ?? true;
                                @endphp
                                <tr>
                                    <td>{{ $course->title }}</td>
                                    <td>{{ Str::limit($course->description, 60) }}</td>
                                    <td>{{ $course->created_at->format('Y-m-d') }}</td>

                                    <td class="flex flex-wrap gap-2">
                                        <a class="btn btn-circle btn-text btn-sm text-info hover:bg-info/10"
                                            href="{{ route('courses.show', $course) }}"
                                            aria-label="View {{ $course->title }}">
                                            <span class="icon-[tabler--eye] size-5"></span>
                                        </a>

                                        @if ($isEnrolled && $stepsCount > 0)
                                            <a href="{{ route('courses.progress', $course) }}"
                                                class="btn btn-circle btn-text btn-sm text-info hover:bg-info/10"
                                                aria-label="Continue {{ $course->title }}">
                                                <span class="icon-[tabler--progress] size-5"></span>
                                            </a>
                                        @else
                                            @if ($canEnroll)
                                                <form action="{{ route('courses.enroll', $course) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn btn-circle btn-text btn-sm text-success hover:bg-success/10"
                                                        aria-label="Enroll {{ $course->title }}">
                                                        <span class="icon-[tabler--user-plus] size-5"></span>
                                                    </button>
                                                </form>
                                            @else
                                                <button type="button" class="btn btn-circle btn-text btn-sm text-success cursor-not-allowed" title="You do not meet the prerequisites for this course" disabled aria-label="Enroll {{ $course->title }}">
                                                    <span class="icon-[tabler--user-plus] size-5"></span>
                                                </button>
                                            @endif
                                        @endif

                                        <a class="btn btn-circle btn-text btn-sm text-warning hover:bg-warning/10"
                                            href="{{ route('courses.edit', $course) }}"
                                            aria-label="Edit {{ $course->title }}">
                                            <span class="icon-[tabler--pencil] size-5"></span>
                                        </a>

                                        <button
                                            @click="showModal = true; deleteAction = '{{ route('courses.destroy', $course) }}'; courseTitle = '{{ $escapedTitle }}'"
                                            class="btn btn-circle btn-text btn-sm text-error hover:bg-error/10"
                                            aria-label="Delete {{ $course->title }}"
                                            type="button"
                                        >
                                            <span class="icon-[tabler--trash] size-5"></span>
                                        </button>

                                        <button type="button"
                                            @click="navigator.clipboard.writeText('{{ route('courses.show', $course) }}').then(() => alert('Course link copied!'))"
                                            class="btn btn-circle btn-text btn-sm hover:bg-gray-100"
                                            aria-label="Share {{ $course->title }}">
                                            <span class="icon-[tabler--share] size-5"></span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif


        <!-- delete modal -->
        <div
            x-show="showModal"
            x-cloak
            class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-75"
            @keydown.escape.window="showModal = false"
            tabindex="0"
        >
            <div class="bg-red-900 text-white rounded-lg p-6 w-full max-w-md" role="dialog" aria-modal="true" aria-labelledby="modal-title">
                <h3 id="modal-title" class="text-lg font-bold mb-4">Confirm Delete</h3>
                <p class="mb-6">
                    Are you sure you want to delete the course "<span x-text="courseTitle"></span>"?
                </p>
                <div class="flex justify-end gap-4">
                    <button @click="showModal = false" class="btn btn-secondary" type="button">Cancel</button>
                    <form :action="deleteAction" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-error">Delete</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-layouts.app>
