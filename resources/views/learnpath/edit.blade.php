<x-layouts.app>
    <!-- Form -->
    <x-layouts.form
        title="Edit Learning Path"
        action="{{ route('learnpath.update', $learnpath->id) }}"
        method="PUT"
        submit-label="Update Path"
        icon="{{ old('icon', $learnpath->icon ?? 'tabler--route-square') }}"
    >
        <!-- Title -->
        <div>
            <x-input-label for="title" :value="__('Title*')" />
            <x-text-input
                id="title"
                name="title"
                type="text"
                class="block w-full max-w-md"
                placeholder="Enter the title of the path here..."
                :value="old('title', $learnpath->title)"
                required
            />
            <x-input-error :messages="$errors->get('title')" class="mt-1" />
        </div>

        <!-- Header -->
        <div>
            <x-input-label for="header" :value="__('Header*')" />
            <x-text-input
                id="header"
                name="header"
                type="text"
                class="block w-full max-w-md"
                placeholder="Enter a subtitle or header for the path..."
                :value="old('header', $learnpath->header)"
            />
            <x-input-error :messages="$errors->get('header')" class="mt-1" />
        </div>

        <!-- Course Selection -->
        <div
            x-data="{
                search: '',
                selectedCourses: @js(old('courses', $learnpath->courses->pluck('id')->toArray()))
            }"
            class="mt-6"
        >
            <x-input-label :value="__('Select Courses*')" />

            <!-- Search -->
            <div class="relative mt-2 mb-4">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 pointer-events-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z"/>
                    </svg>
                </span>
                <input
                    type="text"
                    x-model="search"
                    placeholder="Search courses..."
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-red-600 focus:border-red-600"
                />
            </div>

            <!-- Courses Table -->
            <div class="overflow-x-auto border rounded-lg shadow-sm h-60 overflow-y-auto">
                <table class="min-w-full bg-white text-sm text-left text-gray-700">
                    <thead class="bg-gray-100 text-xs uppercase text-gray-500">
                    <tr>
                        <th class="p-3 text-center">Select</th>
                        <th class="p-3">Title</th>
                        <th class="p-3">Description</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($courses as $course)
                        <tr
                            class="border-t hover:bg-gray-50"
                            x-show="search === '' || '{{ strtolower($course->title . ' ' . $course->description) }}'.includes(search.toLowerCase())"
                        >
                            <td class="p-3 text-center">
                                <input
                                    type="checkbox"
                                    :value="{{ $course->id }}"
                                    name="courses[]"
                                    :checked="selectedCourses.includes({{ $course->id }})"
                                    @change="if ($event.target.checked) { selectedCourses.push({{ $course->id }}) } else { selectedCourses = selectedCourses.filter(id => id !== {{ $course->id }}) }"
                                    class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-600"
                                />
                            </td>
                            <td class="p-3 font-medium">{{ $course->title }}</td>
                            <td class="p-3">{{ $course->description }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-4 text-center text-gray-500">
                                No courses found.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <x-input-error :messages="$errors->get('courses')" class="mt-2" />
        </div>

        <!-- Description -->
        <div>
            <x-input-label for="description" :value="__('Description*')" />
            <x-ui.wysiwyg
                name="description"
                height="240"
                class="block w-full max-w-2xl"
                placeholder="Enter the description for the learning path..."
                value="{{ old('description', $learnpath->description) }}"
            />
            <x-input-error :messages="$errors->get('description')" class="mt-1" />
        </div>

        <x-ui.validation-requests.select-validated :content="$learnpath"/>
    </x-layouts.form>
</x-layouts.app>
