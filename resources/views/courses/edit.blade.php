<x-layouts.app>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">

        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Edit Course</h2>

        <div class="w-full sm:max-w-md px-6 py-6 bg-white shadow-md overflow-hidden sm:rounded-lg">

            <!-- Course Edit Form -->
            <form method="POST" action="{{ route('courses.update', $course) }}" class="mb-8">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div class="mb-4">
                    <x-input-label for="title" :value="__('Title')" />
                    <x-text-input
                        id="title"
                        class="block mt-1 w-full"
                        type="text"
                        name="title"
                        value="{{ old('title', $course->title) }}"
                        required
                        autofocus
                    />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <x-input-label for="description" :value="__('Description')" />
                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    >{{ old('description', $course->description) }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <!-- Credits -->
                <div class="mb-6">
                    <x-input-label for="credits" :value="__('Credits')" />
                    <x-text-input
                        id="credits"
                        class="block mt-1 w-full"
                        type="number"
                        name="credits"
                        value="{{ old('credits', $course->credits) }}"
                        required
                        min="0"
                    />
                    <x-input-error :messages="$errors->get('credits')" class="mt-2" />
                </div>
                <x-ui.validation-requests.select-validated :content="$course"/>
                <!-- Update Course Button -->
                <div class="flex items-center justify-end mb-10">
                    <x-primary-button>
                        {{ __('Update Course') }}
                    </x-primary-button>
                </div>
            </form>

            <!-- Add Resource Form -->
            <h3 class="text-xl font-semibold mb-4">Add Course Resource</h3>
            <form method="POST" action="{{ route('courses.resources.store', $course) }}" enctype="multipart/form-data" class="mb-8">
                @csrf

                <!-- Resource Type -->
                <div class="mb-4">
                    <x-input-label for="type" :value="__('Resource Type')" />
                    <select
                        id="type"
                        name="type"
                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        onchange="handleResourceTypeChange(this.value)"
                        required
                    >
                        <option value="" disabled selected>Select type</option>
                        <option value="video" {{ old('type') === 'video' ? 'selected' : '' }}>Video (URL)</option>
                        <option value="link" {{ old('type') === 'link' ? 'selected' : '' }}>Link (URL)</option>
                        <option value="document" {{ old('type') === 'document' ? 'selected' : '' }}>Document (Upload)</option>
                    </select>
                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                </div>

                <!-- URL input for video/link -->
                <div class="mb-4 hidden" id="urlInputContainer">
                    <x-input-label for="url" :value="__('URL')" />
                    <x-text-input
                        id="url"
                        type="url"
                        name="url"
                        value="{{ old('url') }}"
                        placeholder="https://example.com"
                    />
                    <x-input-error :messages="$errors->get('url')" class="mt-2" />
                </div>

                <!-- File input for document -->
                <div class="mb-4 hidden" id="fileInputContainer">
                    <x-input-label for="document" :value="__('Upload Document')" />
                    <input
                        type="file"
                        id="document"
                        name="document"
                        accept=".pdf,.doc,.docx"
                        class="block mt-1 w-full"
                    />
                    <x-input-error :messages="$errors->get('document')" class="mt-2" />
                </div>

                <div class="flex justify-end mb-10">
                    <x-primary-button>
                        Add Resource
                    </x-primary-button>
                </div>
            </form>

            <!-- List Existing Resources -->
            @if($course->resources->count() > 0)
                <h3 class="text-xl font-semibold mt-10 mb-4">Existing Resources</h3>
                <ul class="space-y-3">
                    @foreach($course->resources as $resource)
                        <li class="border p-3 rounded bg-gray-50">
                            <strong class="capitalize">{{ $resource->type }}</strong> -
                            @if($resource->type === 'document' && $resource->file_path)
                                <a href="{{ Storage::url($resource->file_path) }}" target="_blank" class="text-indigo-600 hover:underline">
                                    {{ $resource->filename ?? 'Download Document' }}
                                </a>
                            @elseif(in_array($resource->type, ['video', 'link']) && $resource->url)
                                <a href="{{ $resource->url }}" target="_blank" class="text-indigo-600 hover:underline">
                                    {{ $resource->url }}
                                </a>
                            @else
                                No link available
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif

            <!-- Cancel Button at the bottom -->
            <div class="flex justify-start mt-12">
                <a href="{{ route('courses.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Cancel
                </a>
            </div>
        </div>
    </div>

    <script>
        function handleResourceTypeChange(type) {
            const urlInput = document.getElementById('urlInputContainer');
            const fileInput = document.getElementById('fileInputContainer');

            if(type === 'document') {
                urlInput.classList.add('hidden');
                fileInput.classList.remove('hidden');
            } else if(type === 'video' || type === 'link') {
                fileInput.classList.add('hidden');
                urlInput.classList.remove('hidden');
            } else {
                urlInput.classList.add('hidden');
                fileInput.classList.add('hidden');
            }
        }

        // On page load, handle old value (e.g. after validation error)
        document.addEventListener('DOMContentLoaded', () => {
            const oldType = "{{ old('type') }}";
            if(oldType) {
                handleResourceTypeChange(oldType);
            }
        });
    </script>
</x-layouts.app>
